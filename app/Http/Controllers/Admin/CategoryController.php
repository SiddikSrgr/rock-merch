<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Category::query();

            return DataTables::of($query)
                ->addColumn( 
                    'action', 
                    function ($item) {
                        return '<div class="row pl-3">
                                    <a class="btn btn-warning btn-sm mr-1"  href="' . route('category.edit', $item->id) . '"> Edit</a>
                                    <form action="' . route('category.destroy', $item->id) . '" method="POST">
                                        ' . method_field('delete') . csrf_field() . '
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return DeleteFunction()">Delete</button>
                                    </form>
                                </div>';
                    }
                )
                ->editColumn('photo', function ($item) {
                    return $item->photo ? '<img src="' . asset('storage/'. $item->photo) . '" style="max-height: 48px;" />' : '';
                })
                ->rawColumns(['action', 'photo'])
                ->make(true);
        };
        return view('pages.admin.category.index');
    }

    public function create()
    {
        return view('pages.admin.category.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['photo'] = $request->file('photo')->store('category' , 'public');
        Category::create($data);
        return redirect()->route('category.index');
    }

    public function edit($id)
    {
        $item = Category::findOrFail($id);
        return view('pages.admin.category.edit', ['item' => $item]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->file('photo')) {
            $data['photo'] = $request->file('photo')->store('category' , 'public');
        } else {
            unset($data['photo']);
        }

        $category = Category::findOrFail($id);
        $category->update($data);
        return redirect()->route('category.index');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('category.index');
    }
} 
