<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Bookmark;
use App\Models\Post;
use App\Http\Controllers\Controller;

class BookmarkController extends Controller
{
    public function bookmarkstore(Request $request)
    {


        $bookmark = new Bookmark();
        $bookmark->user_id = $request->user()->id;
        $bookmark->article_id = $request->post_id;
        $bookmark->save();

        return redirect()->back()->with('success', 'ブックマークに追加しました。');
    }

    public function bookmarkindex()
    {
        $bookmarks = $bookmarks =  Post::whereIn('id', function ($query) {
            $query->select('article_id')->from('bookmarks')
                ->where('user_id', Auth::user()->id);
        })->paginate(2); 
        return view('/bookmark/bookmarkindex', compact('bookmarks'));
        
    }
}
