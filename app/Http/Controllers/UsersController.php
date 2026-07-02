<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UsersController extends Controller
{
    public function index(Request $request): Response
    {
        abort_unless($request->user()?->can('users.manage'), 403);

        $users = User::with('roles')
            ->get()
            ->map(fn ($u) => [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'roles' => $u->roles->pluck('name')->toArray(),
            ]);

        return Inertia::render('Users/Index', [
            'users' => $users,
        ]);
    }
}
