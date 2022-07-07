<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\EatsRequest;
use Auth;
use App\Eats;
use App\Comment;
use App\User;
use JD\Cloudder\Facades\Cloudder;

class EatsController extends Controller
{
    //一覧表示
    public function index() {
        
        $posts = Eats::all();

        return view('eats.index', compact('posts'));
    }

        //マイページ投稿一覧表示
        public function myPage() {

            $user_id = Auth::id();

            $posts = Eats::where('user_id', $user_id)->get();

            return view('eats.myPage', [
                'user_id' => $user_id,
                'posts' => $posts,
            ]);
        }

    //投稿内容作成
    public function create() {
        return view('eats.create');
    }

    //投稿の詳細
    public function show($id) {
        
        //Eatsモデルからどの投稿かIDを見つける
        $post = Eats::find($id);
        
        $comments = Comment::where('eats_id', $id)->get();
        
        return view('eats.show', compact('post', 'comments'));
    }

    //投稿
    public function store(EatsRequest $request) {
        
        //インスタンス作成
        $post = new Eats;
        $post -> title = $request -> title;
        $post -> body = $request -> body;
        $post -> user_id = Auth::id();

        if ($image = $request->file('image')) {
            $image_path = $image->getRealPath();
            Cloudder::upload($image_path, null);
            //直前にアップロードされた画像のpublicIdを取得する。
            $publicId = Cloudder::getPublicId();
            $logoUrl = Cloudder::secureShow($publicId, [
                'width'     => 200,
                'height'    => 200
            ]);
            $post->image_path = $logoUrl;
            $post->public_id  = $publicId;

        //インスタンスは保存しなければならない
        $post -> save();

        return redirect()->route('eats.index');
    }
    }

        //投稿の編集
        public function edit($id) {
        
            //Eatsモデルからどの投稿かIDを見つける
            $post = Eats::find($id);
            
            if (Auth::id() !== $post->user_id ) {
                return abort(404);
            }
            
            return view('eats.edit', compact('post'));
        }

    //投稿
    public function update(EatsRequest $request, $id) {
        
        //インスタンス作成
        $post = Eats::find($id);
        
        if (Auth::id() !== $post->user_id ) {
            return abort(404);
        }
        
        $post -> title = $request -> title;
        $post -> body = $request -> body;

        $post -> save();

        return redirect()->route('eats.index');
    }

            //投稿の削除
            public function destroy($id) {
        
                //Eatsモデルからどの投稿かIDを見つける
                $post = Eats::find($id);
                
                if (Auth::id() !== $post->user_id ) {
                    return abort(404);
                }

                if(isset($post->public_id)){
                    Cloudder::destroyImage($post->public_id);
                }
                
                $post->delete();
                
                return redirect()->route('eats.index');
            }

            //アカウントの編集
            public function userEdit()
            {
                $user = Auth::user();
                return view('eats.userEdit', ['user' => $user]);
            }

            //アカウント編集の更新
            public function userUpdate(Request $request)
            {      
                $user_form = $request->all();
                $user = Auth::user();
                
                unset($user_form['_token']);
                
                $user->fill($user_form)->save();
                
                return redirect()->route('eats.change');
            }

            //ログアウト機能
                public function userDelete() {
                    $user = Auth::user();
                    $user->delete();
                    Auth::logout();
                    return redirect(route('login'));
                }
}
