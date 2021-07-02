<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Team;
use App\All;
use App\Queries\SearchTeams;
use App\Facades\SearchAllses;

use App\Services\All\Interfaces\AllDataAccessServiceInterface;

use App\Repositories\User\Interfaces\UserDataAccessRepositoryInterface;
use App\Services\User\Interfaces\UserDataAccessServiceInterface;

use App\Repositories\Team\Interfaces\TeamDataAccessRepositoryInterface;




class ResultController extends Controller
{


  private $UserDataAccessRepository;
  private $UserDataAccessService;
  private $AllDataAccessService;
  private $TeamDataAccessRepository;

  public function __construct(UserDataAccessRepositoryInterface $UserDataAccessRepository, UserDataAccessServiceInterface $UserDataAccessService,  AllDataAccessServiceInterface $AllDataAccessService, TeamDataAccessRepositoryInterface $TeamDataAccessRepository)
  {
    $this->UserDataAccessRepository = $UserDataAccessRepository;
    $this->UserDataAccessService = $UserDataAccessService;
    $this->AllDataAccessService = $AllDataAccessService;
    $this->TeamDataAccessRepository = $TeamDataAccessRepository;
  }




  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    // $myAccount = Auth::user();
    $myAccount = $this->UserDataAccessRepository->getAuthUser();

    // 検索された文字列からワイルドカードでteamsテーブルから検索してそのteam_idを配列で取ってくる
    // $team_ids = SearchTeams::get($request->team_string);
    $team_ids = $this->TeamDataAccessRepository->getTeamidsLikeTeamName($request->team_string);


    // $team_idsと検索されたera_idから適切なallsテーブルから該当するコレクションを取ってくる
    // $searchAlls = SearchAllses::getAllArray($request->era_id, $team_ids);
    $searchAlls = $this->AllDataAccessService->getAllCollectionEqualEraidTeamids($request->era_id, $team_ids);

    return view('myService.find')->with([
      'searchAlls' => $searchAlls,
      // ↓ 検索内容のvalue用と検索結果のdetails.blade.phpのback用(team_string)(era_id)
      'team_string' => $request->team_string,
      'era_id' => $request->era_id,
      // ↓ それぞれのアカウントが自分がフォローしているかどうかを調べるfollow_checkで使う
      'myAccount' => $myAccount,
    ]);
  }


  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(User $user, Request $request)
  {
    $identify_id = 'find';
    $his_id = $user->id;

    // $myAccount = Auth::user();
    $myAccount = $this->UserDataAccessRepository->getAuthUser();


    // どの人の詳細を表示させるかをuser_idで受け取ってその人をフォローしているかをbooleanで確認
    // $follow_check = $myAccount->followCheck($user_id);
    $follow_check = $this->UserDataAccessService->AuthUserFollowCheck($his_id);


    // どの人の詳細を表示させるかをuser_idで受け取ってその人のアカウントを取得
    // $hisAccount = User::find($user_id);
    $his_account = $this->UserDataAccessRepository->getHisAccount($his_id);


    return view('myService.details')->with([
      'identify_id' => $identify_id,
      'hisAccount' => $his_account,
      'follow_check' => $follow_check,
      'era_id' => $request->era_id,
      'team_string' => $request->team_string,
    ]);
  }
}
