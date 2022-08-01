<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminAccountController extends Controller
{
    public function index()
    {
        $admin = User::where('role', 'ADMIN')->first();
        return view('pages.admin.account.index', ['admin' => $admin]);
    }

    public function edit($id)
    {
        $admin = User::find($id);
        return view('pages.admin.account.edit', ['admin' => $admin]);
    }

    public function update(Request $request, $id)
    { 
        $validated = $request->validate([
            'email' => 'email|unique:users',
            'password' => 'confirmed|min:5',
            'photo' => 'image',
        ]);
        $data = $request->all(); 

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        if ($request->photo) {
            $data['photo'] = $data['photo']->store('users', 'public');
        } else {
            $data['photo'] = 'users/user-default.jpg';
        }

        $admin = User::findOrFail($id);
        $admin->update($data);
        return redirect()->route('account.index');
    }
}
