<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Product::query();

            return DataTables::of($query)
                ->addColumn( 
                    'action',
                    function ($item) {
                        return '<div class="row pl-3">
                                    <a class="btn btn-warning btn-sm mr-1"  href="' . route('product.edit', $item->id) . '"> Edit</a>
                                    <form action="' . route('product.destroy', $item->id) . '" method="POST">
                                        ' . method_field('delete') . csrf_field() . '
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return DeleteFunction()">Delete</button>
                                    </form>
                                </div>';
                    }
                )
                ->rawColumns(['action'])
                ->make(true);
        };
        return view('pages.admin.product.index');
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.admin.product.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $product = Product::create($data);

        foreach ($request->file('photos') as $photo) {
            ProductGallery::create([
                'product_id' => $product->id,
                'photo' => $photo->store('product', 'public')
            ]);
        }
        return redirect()->route('product.index');
    }

    public function edit($id)
    {
        $categories = Category::all();
        $product = Product::findOrFail($id);
        return view('pages.admin.product.edit', [
            'product' => $product, 
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $product = Product::findOrFail($id);
        $product->update($data);
        return redirect()->route('product.index');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index');
    }
    
}
