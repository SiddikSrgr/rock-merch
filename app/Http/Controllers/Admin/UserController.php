<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = User::where('role', '!=', 'ADMIN')->latest();

            return DataTables::of($query)
                ->addColumn( 
                    'action',
                    function ($item) {
                        return '<div class="row pl-3">
                                    <a class="btn btn-warning btn-sm mr-1"  href="' . route('user.edit', $item->id) . '"> Edit</a>
                                    <form action="' . route('user.destroy', $item->id) . '" method="POST">
                                        ' . method_field('delete') . csrf_field() . '
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return DeleteFunction()">Delete</button>
                                    </form>
                                </div>';
                    }
                )
                ->rawColumns(['action'])
                ->make(true);
        };
        return view('pages.admin.user.index');
    }

    public function create()
    {
        return view('pages.admin.user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'email|unique:users',
            'password' => 'confirmed|min:5',
            'photo' => 'image',
        ]);

        if ($request->photo) {
            $request->photo = $request->photo->store('users', 'public');
        } else {
            $request->photo = 'users/user-default.jpg';
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'photo' => $request->photo
        ]);
        return redirect()->route('user.index');
    }

    public function edit($id)
    {
        $item = User::findOrFail($id);
        return view('pages.admin.user.edit', ['item' => $item]);
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
        return redirect()->route('user.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index');
    }
}
