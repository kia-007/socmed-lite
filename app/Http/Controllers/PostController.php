<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use App\Models\Post;

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
}
