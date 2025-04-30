<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'password' => 'required|string|min:6',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::findOrFail($validated['user_id']);
        $user = User::update($validatedData);
        $user->save();

        return response()->json($user, 201);
    }
}
