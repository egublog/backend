<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\Interfaces\UserDataRepositoryInterface;



class FollowController extends Controller
{
    private $UserDataRepository;


  public function __construct(UserDataRepositoryInterface $UserDataRepository)
  {
    $this->UserDataRepository = $UserDataRepository;
  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //                   ↑ 多分ここも$user_idを取るだけだったらUser $userにしてインプリシットバインディングにした方がいい！

        // フォローする followsテーブルに自分のidと相手のidを追加する
        $this->UserDataRepository->saveAuthUserFollow($request->user_id);
        // $this->getAuthUser()->show_follow()->attach($his_id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        // フォローを外す followsテーブルに自分のidと相手のidを削除する
        $this->UserDataRepository->deleteAuthUserFollow($user_id);
        // $this->getAuthUser()->show_follow()->detach($his_id);

    }
}
