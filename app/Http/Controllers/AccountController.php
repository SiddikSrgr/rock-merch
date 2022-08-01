<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\User;

class AccountController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id);
        return view('pages.account', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'email' => 'email|unique:users', 
            'password' => 'confirmed|min:5',
        ]); 
        $data = $request->all(); 

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
            unset($data['password_confirmation']);
        }
        $user = User::find($id);
        $user->update($data);
        return redirect('/account')->with(['message' => 'Account berhasil diupdate']);
    }

    public function updatePhoto(Request $request, $id)
    {
        $validated = $request->validate([
            'photo' => 'image',
        ]);
        $user = User::find($id);
        $user->update([
            'photo' => $request->photo->store('users', 'public')
        ]);
        return redirect('/account')->with(['message' => 'Photo berhasil diupdate']);
    }

    public function destroy($id) 
    {
        $user = User::findOrFail($id);
        $user->update(['photo' => 'users/user-default.jpg']);
        return redirect('/account')->with(['message' => 'Photo berhasil dihapus']);
    }
}
