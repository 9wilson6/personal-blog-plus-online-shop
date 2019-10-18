<?php

namespace App\Http\Controllers;

use App\Charts\DashboardChart;
use App\Comment;
use App\Http\Requests\CreatPost;
use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkRole:author');

    }
    public  function dashboard(){
        $posts=Post::where('user_id', Auth::id())->pluck('id')->toArray();

        $allComments=Comment::whereIn('post_id', $posts)->get();
        $todaysComments=$allComments->where('created_at', '>=', \Carbon\Carbon::today())->count();

        $chart= new DashboardChart;
        $days=$this->generateDateRange(Carbon::now()->subDays(30), Carbon::now());
        $posts = [];
        foreach ($days as $day){
            $posts[]=Post::whereDate('created_at', $day)->where('user_id', Auth::id())->count();
        }
        $chart->dataset('Posts', 'line', $posts);
        $chart->labels($days);

        return view('author.dashboard', compact('allComments', 'todaysComments', 'chart'));
    }
    private function generateDateRange(Carbon $start_date, Carbon $end_date){
        $dates=[];
        for ($date=$start_date; $date->lte($end_date); $date->addDay()){
            $dates[]=$date->format('Y-m-d');
        }
        return $dates;
    }
    public function  comments(){
        $posts=Post::where('user_id', Auth::id())->pluck('id')->toArray();
        $comments=Comment::whereIn('post_id', $posts)->get();
        return view('author.comments', compact('comments'));
    }
    public function posts(){
        return view('author.posts');
    }
    public  function newPost(){
        return view('author.newPost');
    }
    public function createPost(CreatPost $req){
        $post = new Post();
        $post->title=$req['title'];
        $post->content=$req['content'];
        $post->user_id=Auth::id();
        $post->save();
        return back()->with('success','Post was successfully created');
    }
    public  function postEdit($id){
    $post=Post::where('id', $id)->where('user_id', Auth::id())->first();
    return view('author.postEdit', compact('post'));
    }
    public function postEditPost(CreatPost $req,$id ){
    $post=Post::where('id', $id)->where('user_id', Auth::id())->first();
    $post->title=$req['title'];
    $post->content=$req['content'];
    $post->save();
    return back()->with('success', "Post Updated successfully");
    }
    public function postDelete($id){
    $post=Post::where('id', $id)->where('user_id', Auth::id())->first();
    $post->delete();
    return back();
    }
}
