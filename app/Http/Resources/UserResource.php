<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class UserResource extends JsonResource
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
            "name" => $this->name,
            "id" => $this->id,
            "dashboard_msg" => Cache::get("dashboard_msg", ""),
            "phone" => $this->phone,
            "image" => $this->image?->url ?? env("APP_URL") . "/profile/" . ($this->sex == 0 ? "male":"female") . "-" .(( $this->id % 6 )  + 1). ".png",
        ];
    }
}
