<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::get();
        return response()->json([
            'message' => "Users retrived successfully!",
            'data' => $users
        ], 200);
    }
}
