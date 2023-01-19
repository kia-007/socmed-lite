<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $db_like = new Like;
        $db_like->user_like = $request->input('user');
        $db_like->post_like = $request->input('content');
        $whole_data = $db_like->getDirty();
        $sending = $db_like->save();
        if($sending){
            $result = response()->json([
                "message" => "Like is Successfully",
                "data" => $whole_data
            ], 200);
        }else{
            $result = response()->json([
                "message" => "Like is failed",
                "data" => []
            ], 403);
        }
        return $result;
    }

    public function destroy(Request $request)
    {
        $sending = Like::where('id', $request->id)->delete();
        if($sending){
            $result = response()->json([
                "message" => "unlike is Successfully",
                "data" => []
            ], 200);
        }else{
            $result = response()->json([
                "message" => "unlike failed",
                "data" => []
            ], 403);
        }
        return $result;
    }
}
