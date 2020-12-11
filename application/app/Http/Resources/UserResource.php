<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'type' => 'user',
            'id' => (int)$this->id,
            'attributes' => [
                'name' => $this->name,
                'email' => $this->email,
                'group' => $this->user_group,
            ],
        ];
        return $data;
    }

}
