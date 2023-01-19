<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $db_comment = new Comment;
        $db_comment->user_comment = $request->input('user');
        $db_comment->post_comment = $request->input('content');
        $db_comment->description = $request->input('comment');
        $whole_data = $db_comment->getDirty();
        $sending = $db_comment->save();
        if($sending){
            $result = response()->json([
                "message" => "Comment is Successfully",
                "data" => $whole_data
            ], 200);
        }else{
            $result = response()->json([
                "message" => "Comment is failed",
                "data" => []
            ], 403);
        }
        return $result;
    }

    public function destroy(Request $request)
    {
        $sending = Comment::where('id', $request->id)->delete();
        if($sending){
            $result = response()->json([
                "message" => "unComment is Successfully",
                "data" => []
            ], 200);
        }else{
            $result = response()->json([
                "message" => "unComment failed",
                "data" => []
            ], 403);
        }
        return $result;
    }
}
