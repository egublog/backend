<?php

namespace App\Repositories\User\Repositories;

use App\Repositories\User\Interfaces\UserDataRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\User;




class UserDataRepository implements UserDataRepositoryInterface
{

    public function getAuthUser()
    {

        return Auth::user();
        // $a = Auth::user();
        // dd(Auth::user()->with());
        // return User::find(Auth::id())->with('alls')->get();
        // return User::where('id', 1)->with('alls.team')->first();
    //    $a = User::where('id', Auth::id())->with('alls.team')->first()->alls->first()->team->team_name;
    //    $a = User::where('id', Auth::id())->with('alls.team')->first()->relations['alls'];
    //    dd($a);
    //    return response()->json([$a]);
        // dd($array);
        // return User::where('id', Auth::id())->with('alls.team')->first();
        return User::where('id', Auth::id())->with('eras.team')->first();
    }

    public function getAuthUserId()
    {
        return Auth::id();
    }

    public function getAuthUserAreaid()
    {
        return $this->getAuthUser()->area_id;
    }

    // public function getFriendsFollow($user)
    public function getAuthUserFriendsFollow()
    {
        // return $user->getFollow();
        // return $user->with('show_follow')->get();
        // return $user->show_follow()->get();
        // return User::where('id', $this->getAuthUserId())->show_follow()->get();
        return User::where('id', $this->getAuthUserId())->with('show_follow')->first()->show_follow;
    }

    // public function getFriendsFollower($user)
    public function getAuthUserFriendsFollower()
    {
        // ↓ 試行錯誤してwithとn+1問題理解した！
        // return $user->getFollower();
        // return $user->show_follower()->get();
        // return User::where('id', $this->getAuthUserId())->show_follower()->get();
        // return User::where('id', $this->getAuthUserId())->show_follower()->get();
        // return User::where('id', $this->getAuthUserId())->with('show_follower')->first()->show_follower()->get();
        // dd(User::where('id', $this->getAuthUserId())->with('show_follower')->first()->show_follower()->get());
        return User::where('id', $this->getAuthUserId())->with('show_follower')->first()->show_follower;
        // return Auth::with('show_follower')->user()->show_follower;
        // dd(User::where('id', $this->getAuthUserId())->with('show_follower')->first()->show_follower);
        // dd(1);
    }

    // public function getFollowHimFirst($user, $his_id)
    public function getAuthUserFollowHimFirst($his_id)
    {
        // return $user->show_follow()->where('receive_user_id', $his_id)->first();
        // return User::where('id', $this->getAuthUserId())->show_follow()->where('receive_user_id', $his_id)->first();
        return User::where('id', $this->getAuthUserId())->with('show_follow')->first()->show_follow->where('receive_user_id', $his_id)->first();
        // show_follow()->where('receive_user_id', $his_id)->first();
    }

    public function getHisAccount($his_id)
    {
        return User::find($his_id);
    }

    public function getAuthUserTeamName($era_id)
    {
        // return $this->getAuthUser()->alls()->where('era_id', $era_id)->first()->team->team_name;
//                 ↑ ここでダメなのは->getAuthUser()で一回Userモデルのインスタンスをとって来ているからそのインスタンスからさらに
//                    リレーションを繋げている（さらにこのgetAuthUser()の本家の方でwith()を使っていないし、この呼び出し方も動的プロパティじゃ無いから）

        // return $this->getAuthUser()->with('alls')->get()->alls->where('era_id', $era_id)->first()->team->team_name;
        // return User::find(1)->alls()->where('era_id', $era_id)->first()->team->team_name;
        // return User::find(1)->with('alls')->get()->alls->where('era_id', $era_id)->first()->team->team_name;
        // return $this->getAuthUser()->alls()->where('era_id', $era_id)->first()->team->team_name;
        
        // return User::where('id', $this->getAuthUserId())->alls()->where('era_id', $era_id)->first()->team->team_name;
        // return User::where('id', $this->getAuthUserId())->with('alls.team')->first()->alls->where('era_id', $era_id)->first()->team->team_name;
        return User::where('id', $this->getAuthUserId())->with('eras.team')->first()->eras->where('era_id', $era_id)->first()->team->team_name;
        // return User::where('id', $this->getAuthUserId())->with('alls')->first()->alls->where('era_id', $era_id)->with('team')->first()->team->team_name;
        // ↑↑ この上の二つは同じか?  でも最初にとっちゃった方が優しそう！  したのやり方じゃエラーになったから最初のでやるべし

        // それぞれのクエリはどのタイミングで実行されるのか 
        // $this->getAuthUser()->alls() このタイミングでもうn+1問題になっているのか
        // $this->getAuthUser()->alls()->get() このタイミングなのか
    }

    public function getAuthUserPositionId($era_id)
    {
        // return $this->getAuthUser()->alls()->where('era_id', $era_id)->first()->position_id;
        // return User::where('id', $this->getAuthUserId())->alls()->where('era_id', $era_id)->first()->position_id;
        // return User::where('id', $this->getAuthUserId())->with('alls')->first()->alls->where('era_id', $era_id)->first()->position_id;
        return User::where('id', $this->getAuthUserId())->with('eras')->first()->eras->where('era_id', $era_id)->first()->position_id;
    }

    public function getAuthUserFollowerForActivity()
    {
        // return $this->getAuthUser()->show_follower_activity()->get();
        return User::where('id', $this->getAuthUserId())->with('show_follower_activity')->first()->show_follower_activity;
    }


    
    
    
    
    
    
    
    public function saveAuthUserAreaid($area_id)
    {
        $myAccount = $this->getAuthUser();
        $myAccount->area_id = $area_id;
        $myAccount->save();
    }
    
    public function saveAuthUserDataColumn($request, $column_name)
    {
        $myAccount = $this->getAuthUser();
        $myAccount->$column_name = $request->$column_name;
        $myAccount->save();
    }
    
  public function saveAuthUserImagePathToUsersTable($path)
  {
      $myAccount = $this->getAuthUser();
      $myAccount->image = Storage::disk('s3')->url($path);
      $myAccount->save();
    }
    
    public function saveAuthUserFollow($his_id)
    {
        // $this->getAuthUser()->followAttach($his_id);
        $this->getAuthUser()->show_follow()->attach($his_id);
        // User::where('id', $this->getAuthUserId())->with('show_follow')->first()->show_follow->attach($his_id);
        // ↑  基本的にリポジトリでは他のリポジトリを跨ぐ依存する様な書き方はしないと言われた

        // それぞれのクエリはどのタイミングで実行されるのか 
        // $this->getAuthUser()->alls() このタイミングでもうn+1問題になっているのか
        // $this->getAuthUser()->alls()->get() このタイミングなのか
    }
    public function deleteAuthUserFollow($his_id)
    {
        // $this->getAuthUser()->followDetach($his_id);
        $this->getAuthUser()->show_follow()->detach($his_id);
        // User::where('id', $this->getAuthUserId())->with('show_follow')->first()->show_follow->detach($his_id);
    }
    
    
    public function getAreaArray()
    {
        return $prefs = [
            '1' => '北海道',
            '2' => '青森県',
            '3' => '岩手県',
            '4' => '宮城県',
            '5' => '秋田県',
            '6' => '山形県',
            '7' => '福島県',
            '8' => '茨城県',
            '9' => '栃木県',
            '10' => '群馬県',
            '11' => '埼玉県',
            '12' => '千葉県',
            '13' => '東京都',
            '14' => '神奈川県',
            '15' => '新潟県',
            '16' => '富山県',
            '17' => '石川県',
            '18' => '福井県',
            '19' => '山梨県',
            '20' => '長野県',
            '21' => '岐阜県',
            '22' => '静岡県',
            '23' => '愛知県',
            '24' => '三重県',
            '25' => '滋賀県',
            '26' => '京都府',
            '27' => '大阪府',
            '28' => '兵庫県',
            '29' => '奈良県',
            '30' => '和歌山県',
            '31' => '鳥取県',
            '32' => '島根県',
            '33' => '岡山県',
            '34' => '広島県',
            '35' => '山口県',
            '36' => '徳島県',
            '37' => '香川県',
            '38' => '愛媛県',
            '39' => '高知県',
            '40' => '福岡県',
            '41' => '佐賀県',
            '42' => '長崎県',
            '43' => '熊本県',
            '44' => '大分県',
            '45' => '宮崎県',
            '46' => '鹿児島県',
            '47' => '沖縄県',
            '48' => '海外',
            '49' => 'その他',
            '50' => '未設定です',
        ];
    
    }

}    
