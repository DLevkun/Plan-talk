<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentPublishRequest;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\ChecksIsDataSecure;

class CommentController extends Controller
{
    use ChecksIsDataSecure;

    private $commentRepository;

    public function __construct()
    {
        $this->commentRepository = new CommentRepository();
    }

    public function comment(CommentPublishRequest $request, $id)
    {
        $comment = new Comment;
        $comment->post_id = $id;
        $comment->comment = $this->getSecureData($request->input('comment'));
        $comment->user_id = Auth::user()->id;
        $comment->save();

        return back();
    }

    public function deleteComment($id){
        $this->commentRepository->getOneById($id)->delete();
        return redirect()->back();
    }
}
