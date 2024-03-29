<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'description'   => $this->description,
            'status'        => $this->status,
            'start_date'    => $this->start_date,
            'end_date'      => $this->end_date,
            'finish_date'   => $this->finish_date,
            'user'          => $this->user_id,
            'responsible'   => $this->responsible,
        ];
    }
}
