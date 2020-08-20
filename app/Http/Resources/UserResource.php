<?php

namespace App\Http\Resources;

use App\Message;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $to = [
            ['to_id', auth()->user()->id],
            ['from_id', $this->id]
        ];
        
        $message = Message::where([
            ['from_id', auth()->user()->id],
            ['to_id', $this->id]
        ])->orWhere($to)->latest()->first();

        $count = Message::where($to)->whereNull('read_at')->count();
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'avatar' => $this->avatar,
            'from_id' => $message->from_id ?? '',
            'to_id' => $message->to_id ?? '',
            'content' => $message->content ?? '',
            'count' => $count
        ];
    }
}
