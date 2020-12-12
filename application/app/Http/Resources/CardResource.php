<?php

namespace App\Http\Resources;

use App\Models\Track;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $tracks = Track::whereIn("id", explode(",", $this->tracks))->get();
        $data = [
            "type" => "round",
            "id" => (int) $this->id,
            "attributes" => [
                "roundId" => $this->round_id,
                "user" => $this->user,
                "tracks" => $tracks,
            ],
        ];
        return $data;
    }
}
