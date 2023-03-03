<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'body',
        'publish_flg',
        'view_counter',
        'favorite_counter',
        'delete_flg',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getAllpostsById($user_id)
    {
        $result = $this->where('user_id', $user_id)->with('category')->get();
        return $result;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

     /**
     * 投稿データを全て取得し、最新更新日時順にソート。総合トップ画面に表示する記事はステータス「公開」(publish_flg=1)のみ
     */
    public function getPostsSortByLatestUpdate()
    {
        $result = $this->where([
            ['publish_flg', 1],
            ['delete_flg', 0],
        ])
                       ->orderBy('updated_at', 'DESC')
                       ->with('user')
                       ->with('category')
                       ->get();
        return $result;
    }

    /**
     * カテゴリーごとの記事を全て取得
     * 
     * @param int $category_id カテゴリーID
     */
    public function getPostByCategoryId($category_id)
    {
        $result = $this->where([
            ['category_id', $category_id],
            ['delete_flg', 0],
        ])
                       ->get();
        return $result;
    }

    public function insertPostToSaveDraft($user_id, $request)
    {
        $result = $this->create([
            'user_id'          => $user_id,
            'category_id'      => $request->category,
            'title'            => $request->title,
            'body'             => $request->body,
            'publish_flg'      => 0,
            'view_counter'     => 0,
            'favorite_counter' => 0,
            'delete_flg'       => 0,
        ]);
        return $result;
    }

    public function insertPostToRelease($user_id, $request)
    {
        $result = $this->create([
            'user_id'          => $user_id,
            'category_id'      => $request->category,
            'title'            => $request->title,
            'body'             => $request->body,
            'publish_flg'      => 1,
            'view_counter'     => 0,
            'favorite_counter' => 0,
            'delete_flg'       => 0,
        ]);
        return $result;
    }

    public function insertPostToReservationRelease($user_id, $request)
    {
        $result = $this->create([
            'user_id'          => $user_id,
            'category_id'      => $request->category,
            'title'            => $request->title,
            'body'             => $request->body,
            'publish_flg'      => 2,
            'view_counter'     => 0,
            'favorite_counter' => 0,
            'delete_flg'       => 0,
        ]);
        return $result;
    }

    public function
    feachPostDateByPostId($post_id)
    {
        $result = $this->find($post_id);
        return $result;
    }

    /**
     * 記事の更新処理
     * 下書き保存=>publish_flg=0
     * リクエストされたデータをもとにpostデータを更新する
     *
     * @param array $post 投稿データ
     * @return object $result App\Models\Post
     */
    public function updatePostToSaveDraft($request, $post)
    {
        $result = $post->fill([
            'category_id'      => $request->category,
            'title'            => $request->title,
            'body'             => $request->body,
            'publish_flg'      => 0,
        ]);

        $result->save();

        return $result;
    }

    /**
     * 記事の更新処理
     * 公開=>publish_flg=1
     * リクエストされたデータをもとにpostデータを更新する
     *
     * @param array $post 投稿データ
     * @return object $result App\Models\Post
     */
    public function updatePostToRelease($request, $post)
    {
        $result = $post->fill([
            'category_id'      => $request->category,
            'title'            => $request->title,
            'body'             => $request->body,
            'publish_flg'      => 1,
        ]);

        $result->save();

        return $result;
    }

    /**
     * 記事の更新処理
     * 公開予約=>publish_flg=0
     * リクエストされたデータをもとにpostデータを更新する
     *
     * @param array $post 投稿データ
     * @return object $result App\Models\Post
     */
    public function updatePostToReservationRelease($request, $post)
    {
        $result = $post->fill([
            'category_id'      => $request->category,
            'title'            => $request->title,
            'body'             => $request->body,
            'publish_flg'      => 2,
        ]);

        $result->save();

        return $result;
    }

    /**
     * ユーザーIDに紐づいた投稿リストを全て取得する
     *
     * @param int $user_id ユーザーID
     * @return Post
     */
    public function getAllPostsByUserId($user_id)
    {
        $result = $this->where([
            ['user_id', $user_id],
            ['delete_flg', 0],
        ])
                       ->with('category')
                       ->orderBy('updated_at', 'DESC')
                       ->get();
        return $result;
    }

     /**
     * ゴミ箱一覧の記事を取得
     *
     * @param int $user_id ユーザーID
     * @return object $result App\Models\Post
     */
    public function getTrashPostLists($user_id)
    {
        $result = $this->where([
                            ['user_id', $user_id],
                            ['delete_flg', 1],
                        ])
                        ->get();

        return $result;
    }

     /**
     * 記事の論理削除(ゴミ箱に移動)
     *
     * @param array $post 投稿データ
     * @return object $result App\Models\Post
     */
    public function moveTrashPostData($post)
    {
        $result = $post->fill([
            'publish_flg' => 0,
            'delete_flg' => 1
        ]);
        $result->save();
        return $result;
    }

    /**
     * 記事の復元
     *
     * @param array $post 投稿データ
     * @return object $result App\Models\Post
     */
    public function restorePostData($post)
    {
        $result = $post->fill([
            'publish_flg' => 0,
            'delete_flg' => 0
        ]);
        $result->save();
        return $result;
    }

    /**
     * 記事の削除
     *
     * @param array $post 投稿データ
     * @return object $result App\Models\Post
     */
    public function deletePostData($post)
    {
        $result = $post->delete();
        return $result;
    }

    /**
     * 下書き保存の記事一覧を取得
     *
     * @param int $user_id ログイン中のユーザーID
     * @return object $result App\Models\Post
     */
    public function getSaveDraftPosts($user_id)
    {
        $result = $this->where([
                            ['user_id', $user_id],
                            ['publish_flg', 0],
                            ['delete_flg', 0]
                        ])
                        ->orderBy('updated_at', 'DESC')
                        ->get();
        return $result;
    }

    /**
     * 公開中の記事一覧を取得
     *
     * @param int $user_id ログイン中のユーザーID
     * @return object $result App\Models\Post
     */
    public function getReleasePosts($user_id)
    {
        $result = $this->where([
                            ['user_id', $user_id],
                            ['publish_flg', 1],
                            ['delete_flg', 0]
                        ])
                        ->orderBy('updated_at', 'DESC')
                        ->get();
        return $result;
    }

     /**
     * 予約公開の記事一覧を取得
     *
     * @param int $user_id ログイン中のユーザーID
     * @return object $result App\Models\Post
     */
    public function getReservationReleasePosts($user_id)
    {
        $result = $this->where([
                            ['user_id', $user_id],
                            ['publish_flg', 2],
                            ['delete_flg', 0]
                        ])
                        ->orderBy('updated_at', 'DESC')
                        ->get();
        return $result;
    }

    public function boolmark_posts(){
       return $this->hasMany(Bookmark::class);
}

}