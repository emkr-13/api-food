<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Register

    public function register(Request $request)
    {
        $regis = $request->all();

        $validate = Validator::make($regis, [
            'username'  => 'required|max:255',
            'password'  => 'required',
            'email'     => 'required|max:255',
            'tanggal_lahir' => 'required',
            'telepon'     => 'required',
        ]);


        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }


        $regis['password'] = bcrypt($request->password);

        $user = User::create($regis);

        return response([
            'message'   => 'Register Success',
            'data'      => $user
        ], 201);
    }
    // Login

    public function login(Request $request)
    {
        $loginData = $request->all();

        $validate = Validator::make($loginData, [
            'username'  => 'required|max:255',
            'password'  => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        if (!Auth::attempt($loginData)) {
            return response()->json([
                'message'   => 'Invalid Credentials',
                'data'      => null,
            ], 401);
        }

        /** @var \App\Models\MyUserModel $user **/
        $user = Auth::user();

        return response()->json([
            'message'       => 'Authenticated',
            'data'          => $user,

        ]);
    }

    //get all user
    public function index()
    {
        $users = User::all();

        if (count($users) > 0) {
            return response()->json([
                'message'   => 'Retrieve All Success',
                'data'      => $users
            ], 200);
        }

        return response()->json([
            'message'   => 'Kosong',
            'user'      => null
        ], 400);
    }

    public function show($id)
    {

        //find user id by token


        $user = User::find($id);


        if (!is_null($user)) {
            return response()->json([
                'message'   => 'Retrieve User Success',
                'data'      => $user
            ], 200);
        }

        return response()->json([
            'message'   => 'User Not Found',
            'user'      => null
        ], 404);
    }



    //update data
    public function update(Request $request,$id)
    {
        

        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'message'   => 'User Not Found',
                'user'      => null
            ], 404);
        }

        $updateData = $request->all();

        //update all except password
        $validate = Validator::make($updateData, [
            'username'  => 'required|max:255',
            'email'     => 'required|max:255',
            'tanggal_lahir' => 'required',
            'telepon'     => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], 400);
        }

        $user->update([
            'username'  => $request->username,
            'email'     => $request->email,
            'tanggal_lahir' => $request->tanggal_lahir,
            'telepon'     => $request->telepon,
        ]);


        return response()->json([
            'message'   => 'User Update Success',
            'data'      => $user
        ], 200);
    }

    //delete data
    public function destroy($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'message'   => 'User Not Found',
                'user'      => null
            ], 404);
        }

        return response()->json([
            'message'   => 'User Deleted',
            'data'      => $user
        ], 200);
    }


    //logout using bearer token
    public function logout(Request $request)
    {

        $request->user()->token()->revoke();

        return response()->json([
            'message'   => 'Logout Success',
            'data'      => null
        ], 200);
    }
}
