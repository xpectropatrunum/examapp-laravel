<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       
        $session = $this->sessions()->where("user_id", auth()->user()->id)->first();
        return [
            "id" => $this->id,
            "title" => $this->title,
            "type" => $this->type,
            "description" => $this->description,
            "remained" =>  $session?->ends_in - time(),
            "q_number" => $this->q_number,
            "q_time" => $this->q_time,
            "neg_score" => $this->neg_score,
            "image" => $this->image,
            "is_active" => $this->is_active,
            "file" => $this->file?->url,
            "file_raw" => env("APP_URL") . "/exams/" . md5($this->id .  "drsho1") . ".pdf",
            "completed" =>  $session?->completed ? 1 : 0,
            "session" => ExamSessionResource::make($session),
            "resumable" => ! $session?->completed  &&  $session
        
        ];
    }
}
