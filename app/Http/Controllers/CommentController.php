<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentPublishRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\ChecksIsDataSecure;

class CommentController extends Controller
{
    use ChecksIsDataSecure;

    public function comment(CommentPublishRequest $request, $id)
    {
        $comment = new Comment;
        $comment->post_id = $id;
        $comment->text = $this->getSecureData($request->input('comment'));
        $comment->user_id = Auth::user()->id;
        $comment->save();

        return back();
    }

    public function deleteComment($id){
        Comment::find($id)->delete();
        return redirect()->back();
    }
}
