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
        $registrationData = $request->all();

        $validate = Validator::make($registrationData, [
            'username'  => 'required|max:255',
            'email'     => 'required|max:255',
            'password'  => 'required',
            'tanggal_lahir' => 'required',
            'telepon'     => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message'   => 'Validation Error',
                'data'      => null,
            ], 400);
        }

        $registrationData['password'] = bcrypt($request->password);

        $user = User::create($registrationData);

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

        $accessToken = $user->createToken('Authentication Token')->accessToken;

        return response()->json([
            'message'       => 'Authenticated',
            'data'          => $user,
            'token_type'    => 'Bearer',
            'access_token'  => $accessToken,
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
            'message'   => 'Empty',
            'user'      => null
        ], 400);
    }

    public function show()
    {

        //find user id by token

        $id_user = Auth::id();

        $user = User::find($id_user);


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
    public function update(Request $request)
    {
        $id = Auth::id();

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
