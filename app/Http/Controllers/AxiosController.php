<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AxiosController extends Controller
{
    public function logout() {
        Auth::logout();
    }
}
