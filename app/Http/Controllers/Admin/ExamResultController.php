<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Sms;
use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\ExamReport;
use App\Models\AltField;
use App\Models\Doctor;
use App\Models\DoctorImage;
use App\Models\DoctorSpecialty;
use App\Models\Exam;
use App\Models\TvTemp;
use App\Models\Language;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ExamResultController extends Controller
{

    public function index(Request $request)
    {
        $search = "";
        $limit = 10;
        $query = Report::orderBy("created_at", "desc");
        if (auth()->guard("expert")->check()) {
            $query = Report::orderBy("created_at", "desc")->whereHas("user", function ($m) {
                return $m->whereHas("expert", function ($mn) {
                    return $mn->where("experts.id", auth()->guard("expert")->user()->id);
                });
            });
        }
        if ($request->search) {
            $search = $request->search;
            $query = $query->whereHas("user", function ($m) use ($search) {
                return $m->where("name", "LIKE", "%{$search}%");
            })->orWhereHas("exam", function ($m) use ($search) {
                return $m->where("title", "LIKE", "%{$search}%");
            });
        }
        if ($request->uid) {
            $uid = $request->uid;
            $query = $query->whereHas("user", function ($m) use ($uid) {
                return $m->where("id", "LIKE", "%{$uid}%");
            });
        }
        if ($request->limit) {
            $limit = $request->limit;
        }
        $reports = $query->paginate($limit);
        return view("admin.pages.exam-results.index", compact('reports', 'limit', 'search'));
    }


    public function show($id)
    {
        $report = Report::where("id", $id)->first();
        if (auth()->guard("expert")->check()) {
            if ($report->user->id != auth()->guard("expert")->user()->id) {
                abort(404);
            }
        }

        if (!$report) {
            abort(404);
        }

        return view("admin.pages.exam-results.show", compact('report'));
    }
}
