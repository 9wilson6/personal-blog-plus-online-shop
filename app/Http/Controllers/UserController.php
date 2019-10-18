<?php

namespace App\Http\Controllers;

use App\Charts\DashboardChart;
use App\Comment;
use App\Http\Requests\UserUpdate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
#////////////////////////////////////DASHBOARD////////////////////////////////////////
    public  function dashboard(){
        $chart= new DashboardChart;
        $days=$this->generateDateRange(Carbon::now()->subDays(30), Carbon::now());
        $comments=[];
        foreach ($days as $day){
            $comments[]=Comment::whereDate('created_at', $day)->where('user_id', Auth::id())->count();
        }
        $chart->dataset('Comments', 'line', $comments);
        $chart->labels($days);
        return view('user.dashboard', compact('chart'));
    }
      # ///////////////////////////////////////////COMMENTS////////////////////////////
    public function newComment(Request $req){
    $comment= new Comment();
    $comment->post_id=$req['post_id'];
    $comment->content=$req['comment'];
    $comment->user_id=Auth::id();
    $comment->save();
return back();
    }
    private function generateDateRange(Carbon $start_date, Carbon $end_date){
        $dates=[];
        for ($date=$start_date; $date->lte($end_date); $date->addDay()){
            $dates[]=$date->format('Y-m-d');
        }
        return $dates;
    }
    public function deleteComment($id){
    $comment=Comment::where('id', $id)->where('user_id', Auth::id())->delete();

    return back();
    }
    public function  comments(){
        return view('user.comments');
    }
    public function profile(){
        return view('user.profile');
    }
           #/////////////////////////////////////POSTS////////////////////////////
    public function profilePost(UserUpdate $req){
    $user=Auth::user();
    $user->name=$req['name'];
    $user->email=$req['email'];
    $user->save();
    if ($req['password'] !=""){
        if (!(Hash::check($req['password'], Auth::user()->password))){
            return redirect()->back()->with('error', 'Current password did not match provided password');
        }
        if (strcmp($req['password'], $req['new_password'])==0){
            return redirect()->back()->with('error', 'New password cannot be same as current password');
        }
        $validate=$req->validate(
            [
                'password'=>'required',
                'new_password'=>'required|string|min:6|confirmed',
            ]);
        $user->password=bcrypt($req['new_password']);
        $user->save();
        return redirect()->back()->with('success','Password updated successfully');
    }
    return back();
    }
}
