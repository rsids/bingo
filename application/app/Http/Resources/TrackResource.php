<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            "type" => "track",
            "id" => (int) $this->id,
            "attributes" => [
                "artist" => $this->artist,
                "song" => $this->song,
                "played" => $this->played,
            ],
        ];
        return $data;
    }
}
