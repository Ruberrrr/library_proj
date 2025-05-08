<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $users = User::with('roles')->orderBy('id', 'asc')->get();

        return response()->json($users);
    }


    public function getUserInfo()
    {
        $user = Auth::user()->load('roles', 'permissions');

        return response()->json($user);
    }
    

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:50',
                'password' => 'required|string|min:8',
                'email' => 'required|email|unique:users,email',
                'role_id' => 'required|exists:roles,id',
            ]);
            
            $validatedData['password'] = Hash::make($validatedData['password']);
            
            $newUser = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
            ]);
            $role = Role::findOrFail($validatedData['role_id']);
            $newUser->assignRole($role->name);  

            return response()->json($newUser, 201);
        }
    }


    public function update(Request $request)
    {
        $admin = Auth::user();

        if ($admin->hasRole('admin')) {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'password' => 'required|string|min:8',
            ]);

            $user = User::find($validatedData['user_id']);
            $validatedData['password'] = Hash::make($validatedData['password']);

            if (!$user) {
                return response()->json(['message' => 'Пользователь не найден']);
            }
            
            $user->update(['password' => $validatedData['password']]);
            $user->save();

            return response()->json(['message' => 'Пароль обновлен'], 200);
        }
    }

    
    public function destroy($id)
    {
        $user = Auth::user();
        
        if ($user->hasRole('admin')) {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(null, 204);
        }
    }
}