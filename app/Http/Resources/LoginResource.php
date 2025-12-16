<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user = $this->resource['user'];

        return [
            'user_id'       => $user->id,
            'username'      => $user->username,
            'email'         => $user->email,
            'role'          => $user->getRoleNames()->first(),
            'tokenType'     => 'Bearer',
            'token'         => $this->resource['token'],
            'expires_at'    => now()->addDays(7)->toDateTimeString(),
            'created_at'    => $user->created_at->format('Y-m-d H:i'),
            'updated_at'    => $user->updated_at->format('Y-m-d H:i'),
        ];
    }
}
