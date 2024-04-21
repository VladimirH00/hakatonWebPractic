<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthorizationException;
use App\Models\Ar\Team;
use App\Models\TeamAuth;
use Closure;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserTokenAuth
{
    /**
     * Проходит проверка аутентификации пользователя
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @return Response
     * @throws AuthorizationException
     */
    public function handle(Request $request, Closure $next)
    {
        $authorization = explode(' ', trim($request->header('Authorization')));
        $token = '';

        if (is_array($authorization) && count($authorization) > 1) {
            $token = $authorization[1];
        }

        if (!$token) {
            throw new AuthorizationException('Не авторизированное действие');
        }

        /** @var TeamAuth $teamToken */
        $teamToken = TeamAuth::query()
            ->where('token', $token)
            ->whereNull('deleted_at')
            ->first();
        if (!$teamToken) {
            throw new AuthorizationException('Не авторизированное действие');
        }

        $now = new DateTime("now");
        $expiresAt = new DateTime($teamToken->expires_at);

        $team = Team::query()
            ->find($teamToken->user_id);

        if (!$team) {
            throw new AuthorizationException('Не авторизированное действие');
        }

        if ($now > $expiresAt) {
            $teamToken->deleted_at = date('Y-m-d H:i:s');
            $teamToken->save();

            throw new AuthorizationException('token_expires');
        }

        Auth::login($team);

        return $next($request);
    }
}
