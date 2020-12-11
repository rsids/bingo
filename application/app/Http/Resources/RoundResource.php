<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class RoundResource extends JsonResource
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
            'type' => 'round',
            'id' => (int)$this->id,
            'attributes' => [
                'title' => $this->title,
                'tracks' => $this->tracks->sortBy('artist')->values()->all()
            ],
        ];
        return $data;
    }

}
