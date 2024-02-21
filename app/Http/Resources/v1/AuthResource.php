<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'email'     => $this->email,
            'type'      => $this->type,
            'master_id' => $this->master_id,
            'token'     => [
                'type'      => 'Bearer',
                'token'     => $this->createToken('token')->plainTextToken
            ],
        ];
    }
}
