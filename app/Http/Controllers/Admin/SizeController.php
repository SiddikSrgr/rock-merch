<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables; 
use App\Models\Size;

class SizeController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Size::query();

            return DataTables::of($query)
                ->addColumn( 
                    'action',
                    function ($item) {
                        return '<div class="row pl-3">
                                    <a class="btn btn-warning btn-sm mr-1"  href="' . route('size.edit', $item->id) . '"> Edit</a>
                                    <form action="' . route('size.destroy', $item->id) . '" method="POST">
                                        ' . method_field('delete') . csrf_field() . '
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return DeleteFunction()">Delete</button>
                                    </form>
                                </div>';
                    }
                )
                ->rawColumns(['action'])
                ->make(true);
        };
        return view('pages.admin.size.index');
    }

    public function create()
    {
        return view('pages.admin.size.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Size::create($data);
        return redirect()->route('size.index');
    }

    public function edit($id)
    {
        $item = Size::findOrFail($id);
        return view('pages.admin.size.edit', ['item' => $item]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $size = Size::findOrFail($id);
        $size->update($data);
        return redirect()->route('size.index');
    }

    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();
        return redirect()->route('size.index');
    }
}
