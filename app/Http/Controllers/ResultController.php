<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Team;
use App\All;
use App\Queries\SearchTeams;
use App\Facades\SearchAllses;

use App\Services\All\Interfaces\AllDataServiceInterface;

use App\Repositories\User\Interfaces\UserDataRepositoryInterface;
use App\Services\User\Interfaces\UserDataServiceInterface;

use App\Repositories\Team\Interfaces\TeamDataRepositoryInterface;




class ResultController extends Controller
{
  private $UserDataRepository;
  private $UserDataService;
  private $AllDataService;
  private $TeamDataRepository;

  public function __construct(UserDataRepositoryInterface $UserDataRepository, UserDataServiceInterface $UserDataService,  AllDataServiceInterface $AllDataService, TeamDataRepositoryInterface $TeamDataRepository)
  {
    $this->UserDataRepository = $UserDataRepository;
    $this->UserDataService = $UserDataService;
    $this->AllDataService = $AllDataService;
    $this->TeamDataRepository = $TeamDataRepository;
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $myAccount = $this->UserDataRepository->getAuthUser();

    // 検索された文字列からワイルドカードでteamsテーブルから検索してそのteam_idを配列で取ってくる
    $team_ids = $this->TeamDataRepository->getTeamidsLikeTeamName($request->team_string);

    // $team_idsと検索されたera_idから適切なallsテーブルから該当するコレクションを取ってくる
    $searchAlls = $this->AllDataService->getAllCollectionEqualEraidTeamids($request->era_id, $team_ids);
    // ↑ バリデーションとかフロントとかで制御してもいいけどこの$request->era_idが変な値だったら例外を吐く処理を追加する！
    //    ↑ いやでも変なの来たらただデータが見つからないだけだから大丈夫かも空のコレクションがくるだけ！

    return view('myService.find')->with([
      'searchAlls' => $searchAlls,
      // ↓ それぞれのアカウントが自分がフォローしているかどうかを調べるfollow_checkで使う
      'myAccount' => $myAccount,
      // ↓ 検索内容のvalue用と検索結果のdetails.blade.phpのback用(team_string)(era_id)
      'team_string' => $request->team_string,
      'era_id' => $request->era_id,
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
    // ↑                 ↑ ここのurlは /results/{user} なので例えば現在いない /results/100 とかを
    //                      入力されたら404エラーが返るし /results/aiu とかやっても 404が返る
    $identify_id = 'find';
    $his_id = $user->id;

    // どの人の詳細を表示させるかをuser_idで受け取ってその人をフォローしているかをbooleanで確認
    $follow_check = $this->UserDataService->AuthUserFollowCheck($his_id);

    // どの人の詳細を表示させるかをuser_idで受け取ってその人のアカウントを取得
    $his_account = $this->UserDataRepository->getHisAccount($his_id);
    // ↑ クリーンアーキテクチャの観点は無視するとLaravelのインプリシットバインディングをそのまま
    // 使えばいいやん‼️ ↓
    // $his_account = $user;

    // dd($his_account, $user);
    // dd($user);

    return view('myService.details')->with([
      'identify_id' => $identify_id,
      'hisAccount' => $his_account,
      'follow_check' => $follow_check,
      'era_id' => $request->era_id,
      // ↑ 
      'team_string' => $request->team_string,
    ]);
  }
}
