<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;


class MyhomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        // $myId = Auth::id();

        // ここは登録して初めてのユーザーがきた時にusersテーブルのimageカラムに0を入れる
        // そうしないと確かエラーがでてしまう  (そのユーザが画像を登録してたら1が入る様になっている、登録していなっかったら0を入れる)
        // $myAccount = User::find($myId);
        $myAccount = Auth::user();
        // if ($myAccount->image == null) {
        //     $myAccount->image = 0;
        //     $myAccount->save();
        // }


        // 自分のプロフィール表示用に自分のアカウント情報を付ける (myAccount)
        // 自分の画像表示用にmyIdを付ける (myId)
        return view('myService.home')->with([
            'myAccount' => $myAccount,
            // 'myId' => $myId,
        ]);
    }

}
