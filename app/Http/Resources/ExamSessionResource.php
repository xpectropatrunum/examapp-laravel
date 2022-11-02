<?php

namespace App\Http\Resources;

use App\Models\ExamSessionAnswer;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $time = strtotime($this->report->created_at) - $this->started_at;
       
        return [
            "id" => $this->id,
            "ends_in" => $this->ends_in,
            "started_at" => $this->started_at,
            "elapsed_time" =>  $time >= $this->exam->q_time * 60 ? $this->exam->q_time * 60 :  $time ,
            "answers" => ExamSessionAnswerResource::collection($this->answers()->get())->pluck("a", "q"),
           
        ];
    }
}
