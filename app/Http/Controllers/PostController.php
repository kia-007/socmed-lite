<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function followers($id)
    {
        $data = Follow::where('following', $id)->get();
        $result = [];
        foreach($data as $value){
            array_push($result, $value->user);
        }
        return $result;
    }

    public function index(Request $request)
    {
        $id = $request->input('id');
        $following = $this->followers($id);
        $result = [];
        foreach($following as $value){
            array_push($result, Post::with([
                'UploadBy', 'Likers', 'Commentators', 'DetailLikers'
            ])->where('upload_by', $value)->get());
        }
        return $result;
    }

    public function store(Request $request)
    {
        $date_time = Carbon::now()->isoFormat('YYYY-MM-DD hh:mm:ss');
        if($request->description == NULL){
            $result = response()->json([
                "message" => "Failed, Description or Image can't Empty",
                "data" => []
            ], 403);
        }else{
            $images_path = [];
            foreach($request->file('images') as $value){
                $image_path = $value->store("images/posts/$request->user/$date_time", 'public');
                array_push($images_path, $image_path);
            }
            $db_post = new Post;
            $db_post->images = implode(",", $images_path); //deliminator by comma to separate array each other
            $db_post->description = $request->description;
            $db_post->captions = $request->captions;
            $db_post->upload_by = $request->user;
            $whole_data = $db_post->getDirty();
            $sending = $db_post->save();
            if($sending){
                $result = response()->json([
                    "message" => "Post Successfully",
                    "data" => $whole_data
                ], 200);
            }else{
                $result = response()->json([
                    "message" => "Post Failed",
                    "data" => []
                ], 403);
            }
        }
        return $result;
    }

    public function destroy(Request $request)
    {
        $sending = Post::where('id', $request->id)->delete();
        if($sending){
            $result = response()->json([
                "message" => "Delete post is Successfully",
                "data" => []
            ], 200);
        }else{
            $result = response()->json([
                "message" => "Delete post failed",
                "data" => []
            ], 403);
        }
        return $result;
    }
}
