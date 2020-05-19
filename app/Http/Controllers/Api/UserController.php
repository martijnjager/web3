<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\User as UserSingleResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = new UserResource(User::all());

        return response($users, 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $request
     * @return \Illuminate\Http\Response
     */
    public function store(array $request)
    {
        $user = new User();
        $user->store($request);

        return response()->json([
            "message" => "User updated successfully"
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(User::whereId($id)->exists()) {
            $user = new UserSingleResource(User::find($id));
            return response($user, 200);
        }

        return response()->json([
            'message' => 'User not found'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param array $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(array $request, $id)
    {
        if(User::whereId($id)->exists()) {
            $user = User::find($id);

            if(array_key_exists($request['password']))
                $request['password'] = bcrypt($request['password']);

            $user->store($request);

            return response()->json([
                "message" => "user updated successfully"
            ], 200);
        }

        return response()->json([
            "message" => "User not found"
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(User::whereId($id)->exists()) {
            $user = User::find($id);
            $user->delete();

            return response()->json([
                "message" => "user deleted"
            ], 202);
        }

        return response()->json([
            "message" => "User not found"
        ], 404);
    }
}
