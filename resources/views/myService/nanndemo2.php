<template v-for="account in talkListsAccounts" :key="account.myId">
              <!-- <form
            class="results-wrap"
            action="{{ route('talk_users.contents.index', ['user' => account.id]) }}"
            method="get"
          > -->
              <!-- ↑　これは削除するやつ代わりは↓ -->
              <div v-on:click="userChange(userId)" class="results-wrap">
                <!-- {{ csrf_field() }} -->
                <label>
                  <li class="results-item">
                    <div class="results-head">
                      <div class="results-img">
                        <!-- @if (account.image === null) -->
                        <!-- ↑ ↓ 上をしたに適用　上は消すやつ -->

                        <img
                          v-if="account.image === null"
                          src="https://banana2.s3-ap-northeast-1.amazonaws.com/test/E7F5CC7C-E1B0-4630-99B8-DDD050E8E99E_1_105_c.jpeg"
                          alt=""
                        />
                        <!-- @else -->
                        <!-- ↑ ↓ 上をしたに適用　上は消すやつ -->

                        <img v-else src="{{ account.image }}" />
                        <!-- @endif -->
                        <!-- ↑ 消す -->
                      </div>
                    </div>
                    <div class="results-body">
                      <div class="results-body-first">
                        <p class="results-body-first-name">
                          {{ account.name }}
                        </p>
                        <!-- @if(account.user_name) -->
                        <!-- ↑ ↓ 上をしたに適用　上は消すやつ -->
                        <p
                          v-if="account.user_name"
                          class="results-body-first-truename"
                        >
                          {{ account.user_name }}
                        </p>
                        <!-- @endif -->
                      </div>
                    </div>
                  </li>
                  <!-- <input
                name="identify_id"
                type="hidden"
                value="{{ $identify_id }}"
              /> -->
                  <!-- <input class="button" type="submit" value="" /> -->
                </label>
                <!-- </form> -->
                <!-- ↑　これは削除するやつ代わりは↓ -->
              </div>
              <!-- @endforelse @endif -->
              <!-- ↑ ↓ 上をしたに適用　上は消すやつ -->
            </template>