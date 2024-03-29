<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function add($post){
        $user=Auth::user();
        $isFavorite=$user->favorite_posts()
                    ->where('post_id',$post)->count();
        if($isFavorite==0){
            $user->favorite_posts()->attach($post);
            return redirect()->back()
                   ->with('successMsg','post added to favorite list');
        }else{
            $user->favorite_posts()->detach($post);
            return redirect()->back()
                   ->with('successMsg','post removed to favorite list');
        }
    }
}
