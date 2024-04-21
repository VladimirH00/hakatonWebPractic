<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Класс исключения при не авторизированных действиях
 */
class AuthorizationException extends AbstractBaseException
{

    /**
     * Преобразовать исключение в HTTP-ответ.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function render(Request $request)
    {
        return response()->json(['msg' => $this->message], 401);
    }
}
