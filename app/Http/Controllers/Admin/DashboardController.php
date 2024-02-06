<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

       $posts = Post::all();
       $popular_posts = Post::withCount('comments')
       						->withCount('favorite_to_users')
       						->orderBy('view_count','desc')
       						->orderBy('comments_count','desc')
       						->orderBy('favorite_to_users_count','desc')
       						->take(6)->get();

       $total_pending_posts = Post::where('is_approved',false)->count();
       $all_views = Post::sum('view_count');
       $author_count = User::where('role_id',2)->count();
       $new_authors_today = User::where('role_id',2)
       						->whereDate('created_at',Carbon::today())->count();

       $active_authors = User::where('role_id',2)
       						->withCount('posts')
       						->withCount('comments')
       						->withCount('favorite_posts')
       						->orderBy('posts_count','desc')
       						->orderBy('comments_count','desc')
       						->orderBy('favorite_posts_count','desc')
       						->take(10)->get();

       	$category_count = Category::all()->count();
       	$tag_count = Tag::all()->count();

    	return view('admin.dashboard',compact('posts','popular_posts','total_pending_posts','all_views','author_count','new_authors_today','active_authors','category_count','tag_count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
