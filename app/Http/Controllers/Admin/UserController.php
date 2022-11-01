<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorSpecialty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(User $user, Request $request)
    {

        if ($user->update(["is_active" => $request->enable])) {
            return "1";
        }
        return "0";
    }
    public function index(Request $request)
    {
        $search = "";
        $limit = 10;


        $query = User::query();
        if ($request->search) {
            $searching_for = $request->search;
            $search = $request->search;
            $query = $query
                ->where("name", "LIKE", "%{$search}%")
                ->orWhere("phone", "LIKE", "%{$search}%");
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        $items = $query->paginate($limit);



        return view('admin.pages.users.index', compact('items', 'search', 'limit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.users.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            "name" => "required|farsi",
            "password" => "required",
            "sex" => "required",
            "phone" => "required|phone|unique:users,phone",
        ];
        $request->validate($rules);
     

        $request->merge(["password" =>  Hash::make($request->password)]);
   
        $request->merge(["is_active" => $request->is_active ? 1 : 0]);
      
        $new = User::create($request->all());
  
        if($new){
            return redirect(route("admin.users.index"))->withSuccess("User created successfully");
        }
        return redirect(route("admin.users.index"))->withError("Database Error");
    }

    public function update(User $user, Request $request)
    {
        
        $rules = [
            "name" => "required|farsi",
            "phone" => "required|phone|unique:users,phone,{$user->id}",
        ];
        $request->validate($rules);
     
        if($request->password){
            $request->merge(["password" =>  Hash::make($request->password)]);
        }else{
            $request->request->remove('password');
        }
        $request->merge(["is_active" => $request->is_active ? 1 : 0]);
      
        $update = $user->update($request->all());
  
        if($update){
            return redirect()->back()->withSuccess("User updated successfully");
        }
        return redirect()->back()->withError("Database Error");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DoctorSpecialty  $tvTemp
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DoctorSpecialty  $DoctorSpecialty
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            return redirect()->back()->withSuccess("Item deleted successfully");
        }
        return redirect()->back()->withError("Something went wrong");
    }

    public function edit(User $user)
    {
        return view('admin.pages.users.edit', compact('user'));
    }
}
