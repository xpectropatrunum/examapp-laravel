<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Sms;
use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Models\AltField;
use App\Models\Doctor;
use App\Models\DoctorImage;
use App\Models\DoctorSpecialty;
use App\Models\Exam;
use App\Models\Expert;
use App\Models\TvTemp;
use App\Models\Language;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class ExpertController extends Controller
{

    public function index(Request $request)
    {
        $search = "";
        $limit = 10;
        $query = Expert::orderBy("created_at", "desc");

        if ($request->search) {
            $search = $request->search;
            $query = $query
                ->where("name", "LIKE", "%{$request->search}%")
                ->orWhere("phone", "LIKE", "%{$request->search}%");
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        $experts = $query->paginate($limit);

        return view("admin.pages.experts.index", compact('experts', 'limit', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::orderBy("id", "desc")->get();
        return view('admin.pages.experts.create', compact('users'));
    }


    public function store(Request $request)
    {

        $rules = [
            "name" => "required|farsi",
            "phone" => "required|phone",
            "password" => "required",
            
        ];
        $request->validate($rules);
        $request->merge([
            "is_active" => $request->is_active ? 1 : 0,
            "password" => Hash::make($request->password),
        ]);

        $insert = Expert::create($request->all());

        if ($insert) {

           

            foreach ($request->users ?? [] as $user) {
                if($insert->expertUser()->updateOrCreate(["user_id" => $user])){
                    $user = User::find($user);
                }
            }

            return redirect()->route("admin.experts.index")->withSuccess("Created successfully!");
        }
        return redirect()->route("admin.experts.index")->withError("Database Error");
    }


    public function changeStatus($e, Request $request)
    {


        $e = Expert::find($e);
        if ($e->update(["is_active" => $request->enable ? 1 : 0])) {
            return "1";
        }
        return "0";
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DoctorSpecialty  $DoctorSpecialty
     * @return \Illuminate\Http\Response
     */
    public function edit(Expert $expert)
    {

        $users = User::orderBy("id", "desc")->get();
        return view('admin.pages.experts.edit', compact('expert', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DoctorSpecialty  $DoctorSpecialty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expert $expert)
    {
        
        $rules = [
            "name" => "required|farsi",
            "phone" => "required|phone",
            
        ];
        $request->validate($rules);
        $request->merge([
            "is_active" => $request->is_active ? 1 : 0,
        ]);
        if($request->password){
            $request->merge([
                "password" => Hash::make($request->password),
            ]);
        }else{
            $request->request->remove('password');

        }

        if ($expert->update($request->all())) {
          
          
            if(!$request->users){
                $expert->expertUser()->delete();
            }else{
                $all_users = $expert->expertUser()->get()->each(function($query) use($request){
                    if(!in_array($query->user_id, $request->users)){
                        $query->delete();
                    }
                });
            }
            foreach ($request->users ?? [] as $user) {
                if(!$expert->users()->where("user_id", $user)->first()){
                    if($expert->users()->create(["user_id" => $user])){
                        $user = User::find($user);
                    }
                }
               
            }
            return redirect()->back()->withSuccess("Expert updated successfully");
        }
        return redirect()->back()->withError("Database Error");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DoctorSpecialty  $tvTemp
     * @return \Illuminate\Http\Response
     */
    public function destroy($e)
    {
        $e = Expert::find($e);
        if ($e->delete()) {
            return redirect()->route("admin.experts.index")->withSuccess("Specialty removed successfully");
        }
        return redirect()->route("admin.experts.index")->withError("Database Error");
    }
}
