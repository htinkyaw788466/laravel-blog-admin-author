<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = User::authors()
            ->withCount('posts')
            ->withCount('favorite_posts')
            ->withCount('comments')
            ->get();
        return view('admin.authors', compact('authors'));
    }


    public function destroy($id)
    {
        $author = User::findOrFail($id)->delete();
        return redirect()->back()->with('successMsg', 'Your Author is deleted Successfully');
    }
}
