<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController
{
    public function index()
    {
        return new UsersResource(User::orderBy("name")->get());
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->index();
    }

    public function store(Request $request)
    {
        $users = $request->get("users");
        collect($users)->each(function ($usr) use ($request) {
            $user = new User();
            $user->name = $usr["name"];
            $user->email = $usr["email"];
            $user->password = "42";
            $user->user_group = $request->get("group");
            $user->save();
        });

        return $this->index();
    }
}
