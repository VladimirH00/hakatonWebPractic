<?php


namespace App\Http\Controllers;


use App\Extensions\DataProviders\FormatterResponse;
use App\Extensions\DataProviders\Providers\ArrayDataProvider;
use App\Http\Requests\StoreRegisterRequest;
use App\Models\Ar\Team;
use App\Models\TeamAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeamsController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSlides(Request $request)
    {
        $data = Team::query()
            ->select(['slug', 'icon_path'])
            ->get();

        foreach ($data as $row) {
            $row->icon_path = Storage::disk('icons')->url($row->icon_path);
        }

        $arrayDataProvider = new ArrayDataProvider($data->toArray());

        return response()->json(FormatterResponse::format($arrayDataProvider));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $login = $request->post('login');
        $password = $request->post('password');

        $team = Team::query()
            ->where('login', $login)
            ->first();

        if (!$team || !Hash::check($password, $team->password)) {
            return response()->json(['msg' => 'Неверный логин или пароль'],400);
        }

        $token = new TeamAuth();
        $token->team_id = $team->id;
        $token->token = Str::random(60);
        $token->expires_at = date("Y-m-d H:i:s", strtotime("+1 month"));
        $token->created_at = date('Y-m-d H:i:s', time());
        $token->save();

        $arrayDataProvider = new ArrayDataProvider([
            'token' => $token->token
        ]);

        return response()->json(FormatterResponse::format($arrayDataProvider));
    }

    public function register(StoreRegisterRequest $request)
    {
        $fileName = $request->file('icon')->getClientOriginalName();
        $request->file('icon')->storeAs($request->get('slug'), $fileName, 'icons');

        $team = new Team();
        $team->name = $request->get('name');
        $team->slug = $request->get('slug');
        $team->email = $request->get('email');
        $team->login = $request->get('login');
        $team->password = Hash::make($request->get('password'));
        $team->icon_path = $request->get('slug') . "/$fileName";

        $team->save();

        $arrayDataProvider = new ArrayDataProvider([
            'msg' => 'Подтвердите Эл. почту'
        ]);

        return response()->json(FormatterResponse::format($arrayDataProvider), 201);
    }
}
