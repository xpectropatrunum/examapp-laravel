<?php

namespace App\Jobs;

use App\Helpers\Sms;
use App\Models\Admin;
use App\Models\ExamSession;
use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class endedExam implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $delay;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($delay)
    {
        $this->delay = $delay;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        sleep($this->delay);
        ExamSession::get()->each(function($item){
            if($item->completed == 1){
                if(!$item->report){
                    $r = Report::Create(["user_id" => $item->user->id, "exam_session_id" => $item->id, "exam_id" => $item->exam->id]);
                    $phone = $item->user->expert()->first()->phone;
                    Sms::notifyAdmin($phone, $item->user->name, $item->exam->title, "https://api.drsho1.ir/admin/exam-results/" . $r->id);
                }
              
            }
        });
        
   
    }
}
