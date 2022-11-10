<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use Illuminate\Http\Resources\Json\ResourceCollection;
class ExamReport extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    
    public function toArray($request)
    {

        return [
            "id" => $this->id,
            "created_at" => $this->created_at,
            "user" => UserResource::make($this->user),
            "exam" => ExamResource::make($this->exam),
            "result" => ExamResult::make($this->session),
            "answer" => $this->exam->answer_file?->url,
        ];
    }
}
