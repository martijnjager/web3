<?php

namespace App\Http\Controllers\Auth;

use App\Exports\UsersExport;
use App\Http\Requests\UserPost;
use App\Http\Requests\UserUpdate;
use App\Repository\UserRepository;
use App\Http\Controllers\Controller;
use App\Role;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    private $user;
    private $role;
    private $client;

    public function __construct(UserRepository $user, Role $roles, Client $client)
    {
        $this->user = $user;
        $this->role = $roles;
        $this->client = $client;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('all-user');

//        dd($this->client->get(route('api.users.index')));

//        dd($this->client->request('GET', 'http://localhost:8000/api/users'));
//        $users = $this->client->request('GET', 'http://localhost:8000/api/users');

        return view('auth.user.index')->with('users', $this->user->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-user');

        return view('auth.user.create')->with('roles', $this->role->getRoles());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserPost $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $this->user->store($data);

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->find($id);

        $this->authorize('update-user', $user);

//        dd(file_get_contents(route('api.users.edit', $id)));

//        $data = $this->client->get(route('api.users.edit', $id));

//        dd($data);

        return view('auth.user.edit', ['user' => $user, 'roles' => $this->role->getRoles()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdate $request, $id)
    {
        $data = $request->validated();

        if(isset($data['password']) && !is_null($data['password']))
            $data['password'] = Hash::make($data['password']);
        else
            unset($data['password']);

        $this->user->updateById($id, $data);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user->find($id)->delete();

        return redirect()->back();
    }

    public function export()
    {
        Session::flash('message', 'Users exported to excel file');

        return Excel::download(new UsersExport(), 'users.xlsx');
    }
}
