<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        return response()->json(['message'=>'User created successfully'], 201);
    }
    public function login (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json(['message'=>'invalid email'], 401);
        }
        return response()->json(['message'=>'Login successful'], 200);
    }

    public function show ($id) {
        return User::find($id);
    }

    public function update(Request $request, $id){
        $user = User::find($id);
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:8',
        ]);

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return response()->json($user, 200);
    }

    public function Delete($id){
        $user = User::find($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    public function search ($name) {
        return User::where('name', 'like', '%'.$name.'%')->get();
    }
    public function filter ($email) {
        return User::where('email', 'like', '%'.$email.'%')->get();
    }

}
