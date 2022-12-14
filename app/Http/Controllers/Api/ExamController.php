<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Sms;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExamReport;
use App\Http\Resources\ExamResource;
use App\Models\Admin;
use App\Models\Exam;
use App\Models\ExamSession;
use App\Models\Expert;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File as RulesFile;
use Intervention\Image\Facades\Image;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exams = auth()->user()?->exams()->where("is_active", 1)->whereHas('sessions', function ($query) {
            return $query->where('user_id', auth()->user()->id) && $query->where('completed', "=", 0);
        })->get() ?? [];
        if (count($exams) == 0) {
            $exams = auth()->user()?->exams()->where("is_active", 1)->get() ?? [];
        }

        return ["success" => 1, "data" =>  ExamResource::collection($exams)];
    }
    public function sessionAssessment()
    {
        ExamSession::get()->each(function ($item) {
            if ($item->completed == 1) {
                if (!$item->report) {
                    $r = Report::Create(["user_id" => $item->user->id, "exam_session_id" => $item->id, "exam_id" => $item->exam->id]);
                    $phone = $item->user->expert()->first()->phone;
                    Sms::notifyAdmin($phone, $item->user->name, $item->exam->title, "https://api.drsho1.ir/admin/exam-results/" . $r->id);
                }
            }
        });
    }

    public function examReports()
    {
        ///**important */
        $this->sessionAssessment();
        ////***** */
        $reports = auth()->user()->reports()->orderBy("id", "desc")->get();
        if ($reports) {
            return ["success" => 1, "data" => ExamReport::collection($reports)];
        }
        return ["success" => 0, "msg" => "?????????? ???????? ??????????"];
    }
    public function getReport(Report $report)
    {

        if ($report) {
            return ["success" => 1, "data" => ExamReport::make($report)];
        }
        return ["success" => 0, "msg" => "?????????? ???????? ??????????"];
    }
    public function finishExam(Exam $exam)
    {

        $examSession = $exam->sessions()->where("completed", "!=", 1)->where(["user_id" => auth()->user()->id])->first();
        if ($examSession) {


            if ($examSession->completed != 1) {
                if ($examSession->update(["completed" => 1])) {
                    $r = Report::create(["user_id" => auth()->user()->id, "exam_session_id" => $examSession->id, "exam_id" => $exam->id]);
                    $phone = $examSession->user->expert()->first()->phone;
                    Sms::notifyAdmin($phone, auth()->user()->name, $examSession->exam->title, "https://api.drsho1.ir/admin/exam-results/" . $r->id);
                    return ["success" => 1];
                }
            }
        }
        return ["success" => 0];
    }
    public function submitAnswer(Exam $exam, Request $request)
    {
        $examSession = $exam->sessions()->where("completed", "!=", 1)->where(["user_id" => auth()->user()->id])->first();
        if ($examSession) {
            $m = false;

            if (!$request->a) {
                $m = $examSession->answers()->where("q", $request->q)->delete();
            } else {
                $m = $examSession->answers()->updateOrCreate(["q" => $request->q, "exam_session_id" => $examSession->id], ["q" => $request->q, "a" => $request->a]);
            }
            if ($m) {
                return ["success" => 1];
            }
        }
        return ["success" => 0];
    }


    public function pdf($hash)
    {
        $file = public_path() . DIRECTORY_SEPARATOR . 'exams' . DIRECTORY_SEPARATOR . "$hash.pdf";

        header('Access-Control-Allow-Origin', '*');
        header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS, HEAD');
        return Response::make(
            file_get_contents($file),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $hash . '"'
            ]

        );
    }
    public function init($exam)
    {
        $exam = auth()->user()?->exams()->where(["exams.id" => $exam, "is_active" => 1])->first();
        if (!$exam) {
            return ["success" => 0, "msg" => "?????????? ???????? ??????"];
        }
        if ($exam->sessions()->where(["user_id" => auth()->user()->id, "completed" => 1])->first()) {
            return ["success" => 0, "msg" => "?????? ???????? ???? ?????? ?????????? ???????? ???????? ??????"];
        }
        if (!$exam->file || count($exam->key->keys) == 0) {
            return ["success" => 1, "ready" => 0, "msg" => "?????????? ?????????? ???????? ???????? ???? ?????????? ?????? ?????????? ????????"];
        }

        if ($exam->sessions()->where(["user_id" => auth()->user()->id, "completed" => 0])->first()) {
            //resume exam
        } else {
            //init
            if ($exam->sessions()->create(["user_id" => auth()->user()->id, "started_at" => time(), "ends_in" => time() + 60 * $exam->q_time, "q_time" => $exam->q_time])) {
                return ["success" => 1, "ready" => 1, "data" =>  ExamResource::make($exam)];
            }
        }
    }
    public function get($exam)
    {
        $exam = auth()->user()?->exams()->where(["exams.id" => $exam, "is_active" => 1])->first();
        if (!$exam) {
            return ["success" => 0, "msg" => "?????????? ???????? ??????"];
        }
        if ($exam->sessions()->where(["user_id" => auth()->user()->id, "completed" => 1])->first()) {
            return ["success" => 0, "msg" => "?????? ???????? ???? ?????? ?????????? ???????? ???????? ??????"];
        }
        if (!$exam->file || count($exam->key->keys) == 0) {
            return ["success" => 1, "ready" => 0, "msg" => "?????????? ?????????? ???????? ???????? ???? ?????????? ?????? ?????????? ????????"];
        }

        return ["success" => 1, "ready" => 1, "data" =>  ExamResource::make($exam)];
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
            return ["success" => 0, "msg" => "?????????? ???????? ??????"];
        }
        $rules = [
            "file" =>  'required',
            RulesFile::types(['png', 'jpeg', 'jpg'])
                ->max(6 * 1024),
        ];
        $messages = [
            "file.required" => "???????? ???????????? ???????? ??????",
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
        return ["success" => 0, "msg" => "?????????? ???? ?????? ???????? ???????? ???????? ????????."];
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
            return ["success" => 0, "msg" => "?????????? ???????? ??????"];
        }
        $rules = [
            "name" => "required|farsi",
        ];
        $messages = [
            "name.required" => "?????? ?? ?????? ???????????????? ???????????? ??????",
            "name.farsi" => "???????? ???????? ?????????? ???????? ???? ????????",
        ];
        $validate = Validator::make($request->all(), $rules, $messages);
        if ($validate->fails()) {
            return ["success" => 0, "msg" => $validate->errors()->first()];
        }

        $user->name = $request->name;
        if ($user->save()) {
            return ["success" => 1];
        }
        return ["success" => 0, "msg" => "?????????? ???? ?????? ???????? ???????? ???????? ????????."];
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
