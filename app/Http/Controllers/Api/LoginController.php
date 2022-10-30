<?php

namespace App\Http\Controllers\Api;

use App\Helper\Sms;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class LoginController extends Controller
{
    public function check(Request $request)
    {
        $rules = [
            "phone" => "required|digits:11"
        ];
        $messages = [
            "phone.required" => "شماره موبایل را وارد نمایید",
            "phone.digits" => "شماره موبایل را صحیح وارد کنید",
        ];
        $request->validate($rules, $messages);
        $user = User::where(["phone" => $request->phone, "is_active" => 1])->first();
        if ($user) {
            return Response::json(["success" => 1, "action" => 0, "phone" => $request->phone]);
        }
        // if ($this->initRegisteration($request->phone)) {
        //     return Response::json(["success" => 1, "action" => 1, "phone" => $request->phone]);
        // }
        return Response::json(["success" => 0, "msg" => "این شماره در سیستم موجود نیست"]);
    }
    public function attempt(Request $request)
    {
        $rules = [
            "phone" => "required|digits:11",
            "password" => "required",
        ];
        $messages = [
            "phone.required" => "شماره موبایل را وارد نمایید",
            "phone.digits" => "شماره موبایل را صحیح وارد کنید",
        ];
        $request->validate($rules, $messages);
        if (!$token = auth()->attempt($request->all())) {
        return Response::json(["success" => 0, "msg" => "اطلاعات کاربری نادرست است"], 401);

        }
        return Response::json(["success" => 1, "token" => $token,]);

    }

    
    public function initRegisteration($phone)
    {
        $code = rand(999, 9999);
        if (Sms::send($phone, $code)) {
            return User::updateOrCreate(["phone" => $phone], ["password" => Hash::make("drs"), "name" => "", "phone" => $phone, "code" => $code, "code_expiry" => time() + 60]);
        }
        return 0;
    }
    public function resendCode(Request $request)
    {
        $phone = $request->phone;
        $user = User::where(["phone" => $phone, "is_active" => 0])->first();
        if ($user->code_expiry > time()) {
            return Response::json(["success" => 0, "msg" => $user->code_expiry - time() . " ثانیه صبر کنید"]);
        }
        $code = rand(999, 9999);
        if (Sms::send($phone, $code)) {
            $user->update(["code" => $code, "code_expiry" => time() + 60]);
            return Response::json(["success" => 1]);
        }
        return Response::json(["success" => 0, "msg" => "خطایی رخ داد"]);
    }
    public function finish(Request $request)
    {
        $rules = [
            "phone" => "required|digits:11",
            "password" => "required|min:6",
            "confirm_password" => "required|min:6|same:password",
        ];
        $request->validate($rules);
        $phone = $request->phone;
        $user = User::where(["phone" => $phone, "is_active" => 0])->first();
        if (!$user) {
            return Response::json(["success" => 0, "msg" => "کاربر یافت نشد"]);
        }


        if ($user->update(["name" => $request->name, "password" => Hash::make($request->password), "is_active" => 1])) {
            $token = auth()->guard("api")->login($user);
            return Response::json(["success" => 1, "token" =>  $token, "msg" => "تبریک! ثبت نام شما با موفقیت انجام شد."]);
        }
        return Response::json(["success" => 0, "msg" => "خطایی رخ داد"]);
    }
    public function verify(Request $request)
    {
        $rules = [
            "phone" => "required|digits:11",
            "code" => "required|digits:4",
        ];
        $messages = [
            "phone.required" => "شماره موبایل را وارد نمایید",
            "phone.digits" => "شماره موبایل را صحیح وارد کنید",
            "code.required" => "کد را وارد نمایید",
            "code.digits" => "کد را صحیح وارد کنید",
        ];
        $request->validate($rules, $messages);
        $user = User::where("phone", $request->phone)->first();
        if ($request->code != $user->code) {
            return Response::json(["success" => 1, "action" => 1, "phone" => $request->phone]);
        }

        return Response::json(["success" => 0, "msg" => "کد نادرست است"]);
    }
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
    public function user()
    {
        if(auth()->user()){
            return auth()->user();
        }
        return response()->json(["success" => 0, "msg" => "not found"]);
    }
    public function logout()
    {
        if(auth()->logout()){
            return ["success" => 1];

        }
        return ["success" => 0];
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
