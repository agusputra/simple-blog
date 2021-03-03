<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Enums\ROLE_TYPE;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with('roles')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create($request->only(['email', 'name', 'password']));
        $role = Role::where('name', ROLE_TYPE::user)->first();

        $user->roles()->sync([$role->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return User::with('roles')->find($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('users')->ignore($user)
            ],
            'password' => 'sometimes|required|min:6'
        ]);

        $data = $request->only(['email', 'name', 'password']);

        $user->fill($data)->save();

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }

    public function me()
    {
        return auth()->user()->load('roles');
    }

    public function syncRoles(Request $request, User $user)
    {
        $this->authorize('syncRoles', User::class);

        $request->validate([
            'role_ids' => 'required|array'
        ]);

        $user->roles()->sync(request('role_ids'));
    }
}
