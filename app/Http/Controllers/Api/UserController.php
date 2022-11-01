<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File as RulesFile;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeImage(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return ["success" => 0, "msg" => "کاربر یافت نشد"];
        }
        $rules = [
            "file" =>  'required',
            RulesFile::types(['png', 'jpeg', 'jpg'])
                ->max(6 * 1024),
        ];
        $messages = [
            "file.required" => "فایل انتخاب نشده است",
        ];
        $validate = Validator::make($request->all(), $rules, $messages);
        if ($validate->fails()) {
            return ["success" => 0, "msg" => $validate->errors()->first()];
        }

        $extension = $request->file("file")->getClientOriginalExtension();

        $filenametostore = $user->id . '-' . time() . '.' . $extension;

        $img = Image::make($request->file("file"));

        // backup status
        $img->backup();

        // small
        $img->orientate()->encode($extension);
        File::put("users/" . $filenametostore, (string) $img);


        $user->image()->delete();
        if ($user->image()->create(["url" => env("APP_URL") . "/users/" . $filenametostore])) {
            return ["success" => 1];
        }
        return ["success" => 0, "msg" => "خطایی رخ داد لطفا بعدا تلاش کنید."];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return ["success" => 0, "msg" => "کاربر یافت نشد"];
        }
        $rules = [
            "name" => "required|farsi",
        ];
        $messages = [
            "name.required" => "نام و نام خانوادگی الزامی است",
            "name.farsi" => "تنها حروف فارسی مجاز می باشد",
        ];
        $validate = Validator::make($request->all(), $rules, $messages);
        if ($validate->fails()) {
            return ["success" => 0, "msg" => $validate->errors()->first()];
        }

        $user->name = $request->name;
        if ($user->save()) {
            return ["success" => 1];
        }
        return ["success" => 0, "msg" => "خطایی رخ داد لطفا بعدا تلاش کنید."];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
