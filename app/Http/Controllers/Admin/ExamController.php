<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Models\AltField;
use App\Models\Doctor;
use App\Models\DoctorImage;
use App\Models\DoctorSpecialty;
use App\Models\Exam;
use App\Models\TvTemp;
use App\Models\Language;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function saveQuestion(Request $request, Exam $exam)
    {
        $rules = [
            "file" => "required",
            "keys" => "required",

        ];
        $request->validate($rules);

        $exam->file()->delete();
        $exam->key()->delete();


        $extension = "pdf";
        $filenametostore = $exam->id . '.' . $extension;
        $uploadedFile = $request->file('file');
        $uploadedFile->move(public_path("exams/"), $filenametostore);
        if (
            $exam->file()->create(["url" => env("APP_URL") . "/exams/" . $filenametostore]) &&
            $exam->key()->create(["keys" => $request->keys])
        ) {
            return redirect()->back()->withSuccess("Questins uploaded successfully");
        }
        return redirect()->back()->withError("Something went wrong");
    }
    public function index(Request $request)
    {
        $search = "";
        $limit = 10;
        $query = Exam::orderBy("created_at", "desc");

        if ($request->search) {
            $search = $request->search;
            $query = $query
                ->where("title", "LIKE", "%{$request->search}%");
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        $exams = $query->paginate($limit);

        return view("admin.pages.exams.index", compact('exams', 'limit', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::orderBy("id", "desc")->get();
        return view('admin.pages.exams.create', compact( 'users'));
    }


    public function store(Request $request)
    {

        $rules = [
            "title" => "required",
            "type" => "required",
            "q_number" => "required",
            "q_time" => "required",
        ];
        $request->validate($rules);
        $request->merge([
            "is_active" => $request->is_active ? 1 : 0,
            "neg_score" => $request->neg_score ? 1 : 0,
            "description" => $request->description ?? "",
        ]);

        $insert = Exam::create($request->all());

        if ($insert) {

            foreach ($request->users ?? [] as $user) {
                $insert->users()->create(["user_id" => $user]);
            }

            return redirect()->route("admin.exams.edit", $insert->id)->withSuccess("Please upload questions!!!");
        }
        return redirect()->route("admin.exams.edit", $insert->id)->withError("Database Error");
    }


    public function changeStatus($e, Request $request)
    {


        $e = Exam::find($e);
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
    public function edit(Exam $exam)
    {

        $users = User::orderBy("id", "desc")->get();
        return view('admin.pages.exams.edit', compact('exam', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DoctorSpecialty  $DoctorSpecialty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        $rules = [
            "title" => "required",
            "type" => "required",
            "q_number" => "required",
            "q_time" => "required",
        ];
        $request->validate($rules);
        $request->merge([
            "is_active" => $request->is_active ? 1 : 0,
            "neg_score" => $request->neg_score ? 1 : 0,
            "description" => $request->description ?? "",
        ]);



        if ($exam->update($request->all())) {
            $exam->users()->delete();
            foreach ($request->users ?? [] as $user) {
                $exam->users()->create(["user_id" => $user]);
            }
            return redirect()->back()->withSuccess("Exam updated successfully");
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
        $e = Exam::find($e);
        if ($e->delete()) {
            return redirect()->route("admin.exams.index")->withSuccess("Specialty removed successfully");
        }
        return redirect()->route("admin.exams.index")->withError("Database Error");
    }
}
