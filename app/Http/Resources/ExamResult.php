<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ExamResult extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $correct = 0;
        $false = 0;
       
        $keys = $this->exam->key->keys;
        $answers = $this->answers;
        foreach($answers as $item){
            if($keys[$item->q -1] ==  $item->a){
                $correct += 1;
            }else{
                $false += 1;
            }
        }

        $percentage = round((($correct * 3) - ($this->exam->neg_score ? $false : 0)) / ($this->exam->q_number * 3), 4);
        
        return [
            "c" => $correct,
            "f" => $false,
            "a" => $this->exam->q_number,
            "p" => $percentage,
            "keys" =>  $keys
        ];
    }
}
