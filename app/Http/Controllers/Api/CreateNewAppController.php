<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateNewAppRequest;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CreateNewAppController extends Controller
{
    public function index(Request $request)
    {
        // Настройщик отправляет запрос с логином, паролем, именем устройства, типом устройства
        // При правильных данных пользователю отдаётся токе

//        User::create([
//            "name" => "test",
//            "email" => "test@mail.ru",
//            "password" => Hash::make("333999"),
//            "email_verified_at" => Carbon::now()
//        ]);

//        $user = Auth::attempt([
//            "email" => "test@mail.ru",
//            "password" => "333999"
//        ], true);
//        Auth::login($request->user(), true);

//        $token = $request->user()->createToken($request->token_name);
//

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        Auth::guard('web')->attempt($credentials);

        $request->session()->regenerate();

        return 200;
    }
}
