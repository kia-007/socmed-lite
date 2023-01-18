<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;

/* Warning
    *   The user being have follower if,
    *   their id on user column, vice versa.
    *   The point is when user following someone,
    *   his id will put on following column
*/

class FollowController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $dbFollower = Follow::with('FollowerDetail')->where('user', $id)->get();
        $dbFollowing = Follow::with('FollowingDetail')->where('following', $id)->get();
        $total_followers = count($dbFollower);
        $total_following = count($dbFollowing);
        $result = response()->json([
            "message" => "Fetch Follow Data is Successfully",
            "data" => [
                "total_followers" => $total_followers,
                "total_following" => $total_following,
                "detail_followers" => $dbFollower,
                "detail_following" => $dbFollowing
            ]
        ], 200);
        return $result;
    }

    public function store(Request $request)
    {
        $db = new Follow;
        $db->user = $request->user; // people who get follow
        $db->following = $request->following; // people who follow
        $whole_data = $db->getDirty();
        if($request->user != $request->following){

            $following_check = Follow::where('following', $request->following)
                ->where('user', $request->user)
                ->first();
            if($following_check == NULL){
                $sending = $db->save();
                if($sending){
                    $result = response()->json([
                        "message" => "Follow is Successfully",
                        "data" => $whole_data
                    ], 200);
                }else{
                    $result = response()->json([
                        "message" => "Follow is Failed",
                        "data" => []
                    ], 403);
                }
            }else{
                $result = response()->json([
                    "message" => "Can't Follow Twice",
                    "data" => []
                ], 403);
            }
        }else{
            $result = response()->json([
                "message" => "Can't Follow Your Own Account",
                "data" => []
            ], 403);
        }
        return $result;
    }

    public function destroy(Request $request)
    {
        $sending = Follow::where('following', $request->user)
            ->where('user', $request->unfollow)
            ->delete();
        if($sending){
            $result = response()->json([
                "message" => "Unfollow is Successfully",
                "data" => []
            ], 200);
        }else{
            $result = response()->json([
                "message" => "Unfollow is Failed",
                "data" => []
            ], 403);
        }
        return $result;
    }
}
