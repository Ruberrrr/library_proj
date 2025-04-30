<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class getUserInfo extends Controller
{
    public function getUserInfo()
{
    $user = Auth::user();
    return response()->json($user);
}
}