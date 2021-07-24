@extends('layouts.default')

@section('css', '/css/myService/profile.css')

@section('content')

<main>

    <section class="profile">
        <div class="profile-top">
            <a class="back" href="{{ route('myhomes.index') }}">&lt; back</a>
            <h2 class="profile-tit">プロフィールを編集</h2>
        </div>
        <div class="profile-inner">
            <div class="profile-img">
                <p class="profile-img-tit">プロフィール写真</p>
                @error('image')
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @enderror
                @if (isset($image_success))
                <div class="alert alert-success">
                    {{ $image_success }}
                </div>
                @endif
                <div class="profile-img-content">
                    @if ($viewModel->myAccount->image === null)
                    <img src="https://banana2.s3-ap-northeast-1.amazonaws.com/test/E7F5CC7C-E1B0-4630-99B8-DDD050E8E99E_1_105_c.jpeg" alt="">
                    @else
                    <img src="{{ $viewModel->myAccount->image }}">
                    @endif
                </div>
                <form method="POST" action="{{ route('images.update', ['user' => $viewModel->myAccount->id]) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="file" name="image" id="inputImage">
                    <input type="submit" value="登録する" disabled id="btnImage">
                    <!-- でここにputかpatchかpostかで処理を追加する！！ -->
                    @method('PUT')
                </form>

            </div>
            <form action="{{ route('profiles.update', ['user' => $viewModel->myAccount->id]) }}" method="post">
                {{ csrf_field() }}
                <!-- でここにputかpatchかpostかで処理を追加する！！ -->
                @method('PUT')
                <div class="profile-content">
                    <p class="profile-content-tit">プロフィール設定</p>
                    <dl class="profile-def">
                        <div class="profile-box">
                            @error('user_name')
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->get('user_name') as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @enderror
                            @if (isset($profile_success))
                            <div class="alert alert-success">
                                {{ $profile_success }}
                            </div>
                            @endif
                            <label>
                                <dt class="profile-dtit">名前</dt>
                                <dd class="profile-data">
                                    @if($viewModel->myAccount->user_name)
                                    <input class="" id="name" name="user_name" value="{{ old('user_name', $viewModel->myAccount->user_name) }}">
                                    @else
                                    <input class="" id="name" name="user_name" value="{{ old('user_name') }}">
                                    @endif
                                </dd>
                            </label>
                        </div>
                        <div class="profile-box">
                            @error('age')
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->get('age') as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @enderror
                            <label>
                                <dt class="profile-dtit">年齢</dt>
                                <dd class="profile-data">
                                    @if($viewModel->myAccount->age)
                                    <input class="" id="age" name="age" type='number' value="{{ old('age', $viewModel->myAccount->age) }}">
                                    @else
                                    <input class="" id="age" name="age" type='number' value="{{ old('age') }}">
                                    @endif
                                </dd>
                            </label>
                        </div>

                        @foreach($viewModel->myAccount->eras as $era)
                        <div class="profile-wrap">
                            <div class="profile-box">
                                @error($era->era_team_head)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->get($era->era_team_head) as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @enderror
                                <label>
                                    <dt class="profile-dtit">{{ $era->era_name_head }}</dt>
                                    <dd class="profile-data">
                                        @if($era->team_name == '未設定です。')
                                        <input type="text" name="{{ $era->era_team_head }}" value="" placeholder="未設定です。">
                                        @else
                                        <input type="text" name="{{ $era->era_team_head }}" value="{{ old($era->era_team_head, $era->team_name ) }}">
                                        @endif
                                    </dd>
                                </label>
                            </div>
                            <div class="profile-box">
                                <label>
                                    <dt class="profile-dtit">ポジション</dt>
                                    <dd class="profile-data">
                                        <select class="" id="elementary-position" name="{{ $era->era_position_head }}">
                                            <option value="1" @if($era->position_id=='1' ) selected @endif>GK</option>
                                            <option value="2" @if($era->position_id=='2' ) selected @endif>DF</option>
                                            <option value="3" @if($era->position_id=='3' ) selected @endif>MF</option>
                                            <option value="4" @if($era->position_id=='4' ) selected @endif>FW</option>
                                        </select>
                                    </dd>
                                </label>
                            </div>
                        </div>
                        @endforeach
                        <div class="profile-box mt">
                            @error('introduction')
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->get('introduction') as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @enderror
                            <label>
                                <dt class="profile-dtit">自己紹介</dt>
                                <dd class="profile-data">
                                    @if($viewModel->myAccount->introduction)
                                    <textarea id="introduction" name="introduction">{{ old('introduction', $viewModel->myAccount->introduction ) }}</textarea>
                                    @else
                                    <textarea id="introduction" name="introduction">{{ old('introduction') }}</textarea>
                                    @endif
                                </dd>
                            </label>
                        </div>
                        <div class="profile-box">
                            <label>
                                <dt class="profile-dtit">住んでいる地域</dt>
                                <dd class="profile-data">
                                    <select class="col-8" id="area" name="area_id">
                                        @foreach($viewModel->areas as $key => $area)
                                        <option value="<?php echo $key ?>" @if($viewModel->myAccount->area_id==$key) selected @endif>{{ $area }}</option>
                                        @endforeach
                                    </select>
                                </dd>
                            </label>
                        </div>
                    </dl>
                    <div class="profile-button">
                        <input class="btn btn-primary d-block mx-auto" type="submit" value="設定完了">
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- /.profile -->


</main>



@endsection