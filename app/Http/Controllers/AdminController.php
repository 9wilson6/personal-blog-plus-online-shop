<?php

namespace App\Http\Controllers;

use App\Charts\DashboardChart;
use App\Comment;
use App\Facade\PayPal;
use App\Http\Requests\CreatPost;
use App\Http\Requests\UserUpdate;
use App\Post;
use App\Product;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkRole:admin');

    }

    public  function dashboard(){
        $chart= new DashboardChart;
        $days=$this->generateDateRange(Carbon::now()->subDays(30), Carbon::now());
        $posts = [];
        foreach ($days as $day){
            $posts[]=Post::whereDate('created_at', $day)->count();
        }
        $chart->dataset('Posts', 'line', $posts);
        $chart->labels($days);
    return view('admin.dashboard', compact('chart'));
    }
    private function generateDateRange(Carbon $start_date, Carbon $end_date){
        $dates=[];
        for ($date=$start_date; $date->lte($end_date); $date->addDay()){
            $dates[]=$date->format('Y-m-d');
        }
        return $dates;
    }
    public  function users(){
        $users=User::all();
        return view('admin.users', compact('users'));
    }
    public function editUser($id){
        $user=User::where('id', $id)->first();
    return view('admin.editUser', compact('user'));
    }
    public function deleteUsers($id){
        $user=User::where('id', $id);
        $user->delete();
        return back();
    }
    public function updateUser(UserUpdate $req, $id){
      $user=User::where('id', $id)->first();
      $user->name=$req['name'];
      $user->email=$req['email'];
      if ($req['admin']==1){
          $user->admin=1;
          $user->author=0;
      }elseif ($req['author']==1){
          $user->admin=0;
          $user->author=1;
      }

      $user->save();
      return back()->with('success', 'User Updated successfully');
    }
    public function  comments(){
        $comments=Comment::all();
        return view('admin.comments', compact('comments'));
    }
    public function posts(){
        $posts=Post::all();
        return view('admin.posts', compact('posts'));
    }

    public  function postEdit($id){
    $post=Post::where('id', $id)->first();
    return view('admin.editPost', compact('post'));
    }
    public  function postEditPost(CreatPost $req, $id){
        $post=Post::where('id', $id)->first();
        $post->title=$req['title'];
        $post->content=$req['content'];
        $post->save();
        return back()->with('success', "Post Updated successfully");
    }
    public function deletePost($id){
        $post=Post::where('id', $id)->first();
        $post->delete();
        return back();
    }
    public function deleteComment($id){
    $comment=Comment::where('id', $id)->first();
    $comment->delete();
    return back();

    }
public function products(){
        $products=Product::all();
    return view('admin.products' , compact('products'));
}
public function adminProducts(){

    return view('admin.products');
}

public function  postNewProduct(Request $req){
$this->validate($req, [
'title'=>'required|string',
    'thumbnail'=>'required|file',
    'description'=>'required',
    'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/'
]);
$product= new Product();
$product->title=$req['title'];
$product->description=$req['description'];
$product->price=$req['price'];
 $thumbnail=$req->file('thumbnail');
 $filename=$thumbnail->getClientOriginalName();
 #$fileextension=$thumbnail->getClientOriginalExtension();
    $thumbnail->move('product-images', $filename);
    $product->thumbnail='product-images/' . $filename;
$product->save();
return back();
}
public function newProduct(){
return view('admin.newProduct');
}
public function editProduct($id){
$product=Product::findOrFail($id);
return view('admin.editProduct', compact('product'));
}
public function updateEditedProduct(Request $req, $id){

    $this->validate($req, [
        'title'=>'required|string',
        'thumbnail'=>'file',
        'description'=>'required',
        'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/'
    ]);
    $product=Product::findOrFail($id);
    $product->title=$req['title'];
    $product->description=$req['description'];
    $product->price=$req['price'];
    if ($req->hasFile('thumbnail')){
        $thumbnail=$req->file('thumbnail');
        $filename=$thumbnail->getClientOriginalName();
        #$fileextension=$thumbnail->getClientOriginalExtension();
        $thumbnail->move('product-images', $filename);
        $product->thumbnail='product-images/' . $filename;
    }

    $product->save();
    return back();
}
public function deleteProduct(Request $req, $id){
$product=Product::findOrFail($id)->delete();
return back();
}
}
