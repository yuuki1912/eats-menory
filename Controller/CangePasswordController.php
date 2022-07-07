<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //バリデーション
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'new_password' => 'required|string|min:6|confirmed',
        ]);
    }

    //パスワードの編集
    public function pasEdit()
    {
        return view('eats.change')
            ->with('user', \Auth::user());
    }

    //パスワードの更新
    public function pasUpdate(Request $request)
    {
            // ID のチェック
    //（ここでエラーになることは通常では考えられない）
    if ($request->id != \Auth::user()->id) {
        return redirect('/eats/myPage/userEdit/change')
                ->with('warning', '致命的なエラーです');
        }
        $user = \Auth::user();
      // 現在のパスワードを確認
        if (!password_verify($request->current_password, $user->password)) {
        return redirect('/eats/myPage/userEdit/change')
                ->with('warning', 'パスワードが違います');
        }
      // Validation（6文字以上あるか，2つが一致しているかなどのチェック）
        $this->validator($request->all())->validate();
      // パスワードを保存
        $user->password = bcrypt($request->new_password);
        $user->save();
        return redirect('/eats/myPage')
            ->with('status', 'パスワードを変更しました');
    }
}
