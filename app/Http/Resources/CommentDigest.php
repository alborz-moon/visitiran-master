<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\EventComment;
use App\Models\LauncherComment;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentDigest extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = $this->user;
        $editUrl = '';
        $destroyUrl = '';

        if($this->resource instanceof LauncherComment) {
            $editUrl = route('launcher_comment.edit', ['launcher_comment' => $this->id]);
            $destroyUrl = route('launcher_comment.destroy', ['launcher_comment' => $this->id]);
        }
        else if($this->resource instanceof EventComment) {
            $editUrl = route('event_comment.edit', ['event_comment' => $this->id]);
            $destroyUrl = route('event_comment.destroy', ['event_comment' => $this->id]);
        }
        else if($this->resource instanceof Comment) {
            $editUrl = route('comment.edit', ['comment' => $this->id]);
            $destroyUrl = route('comment.destroy', ['comment' => $this->id]);
        }

        $name = "";
        if($user->first_name != null && $user->last_name != null)
            $name = $user->first_name . ' ' . $user->last_name;

        if(empty($name))
            $name = 'بدون نام';


        return [
            'id' => $this->id,
            'rate' => $this->rate,
            'status' => $this->status,
            'user' => $name,
            'phone' => $user->phone,
            'msg' => $this->msg,
            'created_at' => Controller::MiladyToShamsi3($this->created_at->timestamp),
            'editUrl' => $editUrl,
            'destroyUrl' => $destroyUrl
        ];
    }
}
