<?php

namespace App\Http\Controllers\Author;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\NewAuthorPost;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PostControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts=Auth::User()->posts()->latest()->get();
        return view('author.post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=Category::all();
        $tags=Tag::all();
        return view('author.post.create',compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg',
            'categories' => 'required',
            'tags' => 'required',
            'body' => 'required'
        ]);

        // Get Form Image
        $image = $request->file('image');
        $slug = str_slug($request->title);
        if (isset($image)) {

            // Make Unique Name for Image
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();


            // Check Post Dir is exists

            if (!Storage::disk('public')->exists('post')) {
                Storage::disk('public')->makeDirectory('post');
            }


            // Resize Image for post and upload
            $post = Image::make($image)->resize(1600, 1066)->stream();
            Storage::disk('public')->put('post/' . $imageName, $post);
        } else {
            $imageName = 'default.png';
        }

        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->image = $imageName;
        $post->body = $request->body;
        if (isset($request->status)) {
            $post->status = true;
        } else {
            $post->status = false;
        }
        $post->is_approved = false;
        $post->save();

        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);

        //send notification from admin
        // $users=User::where('role_id','1')->get();
        // Notification::send($users,new NewAuthorPost($post));

        return redirect()->route('author.post.index')
            ->with('successMsg', 'post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        if(Gate::allows('author-post-show',$post)){
            return view('author.post.show',compact('post'));
        }else{
            return redirect()->route('author.post.index');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        //return view('author.post.edit',compact('post','categories','tags'));
        if(Gate::allows('author-post-edit',$post)){
            return view('author.post.edit', compact('post', 'categories', 'tags'));
        }else{
            return redirect()->route('author.post.index');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if ($post->user_id != Auth::id()) {
            return redirect()->back();
           }
              $this->validate($request,[
               'title' => 'required',
               'image' => 'image',
               'categories' => 'required',
               'tags' => 'required',
               'body' => 'required',

              ]);

        // Get Form Image
             $image = $request->file('image');
             $slug = str_slug($request->title);
             if (isset($image)) {

                // Make Unique Name for Image
               $currentDate = Carbon::now()->toDateString();
       $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();


             // Check Category Dir is exists

                 if (!Storage::disk('public')->exists('post')) {
                    Storage::disk('public')->makeDirectory('post');
                 }

              // Delete old post image
             if(Storage::disk('public')->exists('post/'.$post->image)){
               Storage::disk('public')->delete('post/'.$post->image);

             }

                 // Resize Image for category and upload
                 $postImage = Image::make($image)->resize(1600,1066)->stream();
                 Storage::disk('public')->put('post/'.$imageName,$postImage);

        }else{
         $imageName = $post->image;
        }


       $post->user_id = Auth::id();
       $post->title = $request->title;
       $post->slug = $slug;
       $post->image = $imageName;
       $post->body = $request->body;
       if (isset($request->status)) {
         $post->status = true;
       }else{
         $post->status = false;
       }
       $post->is_approved = false;
       $post->save();

       $post->categories()->sync($request->categories);
       $post->tags()->sync($request->tags);
       return redirect(route('author.post.index'))->with('successMsg', 'Author Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {

        if(Gate::allows('author-post-destroy',$post)){
            if (Storage::disk('public')->exists('post/'.$post->image)) {
                Storage::disk('public')->delete('post/'.$post->image);
             }
             $post->categories()->detach();
             $post->tags()->detach();
             $post->delete();
             return redirect(route('author.post.index'))->with('alertMsg', 'post deleted Successfully');
        }else{
            return redirect()->route('author.post.index');
        }

    }
}
