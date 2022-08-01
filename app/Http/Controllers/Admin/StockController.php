<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Yajra\DataTables\DataTables;
use App\Models\Stock;
use App\Models\Size;

class StockController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $stock = Stock::with(['product', 'size']);

            return DataTables::of($stock)
            ->addColumn('product', function (Stock $stock) {
                return $stock->product->name;
            })
            ->addColumn('size', function (Stock $stock) {
                return $stock->size->name;
            })
            ->addColumn(  
                'action',
                function ($stock) {
                    return '<div class="row pl-3">
                                <a class="btn btn-warning btn-sm mr-1"  href="' . route('stock.edit', $stock->id) . '"> Edit</a>
                                <form action="' . route('stock.destroy', $stock->id) . '" method="POST">
                                    ' . method_field('delete') . csrf_field() . '
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return DeleteFunction()">Delete</button>
                                </form>
                            </div>';
                }
            )
            ->toJson();
        };
        return view('pages.admin.stock.index');
    }

    public function create()
    {
        $products = Product::all();
        $sizes = Size::all();
        return view('pages.admin.stock.create', ['products' => $products, 'sizes' => $sizes]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Stock::create($data);
        return redirect()->route('stock.index');
    }

    public function edit($id)
    {
        $item = Stock::findOrFail($id);
        $products = Product::all();
        $sizes = Size::all();
        return view('pages.admin.stock.edit', ['item' => $item, 'products' => $products, 'sizes' => $sizes]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $stock = Stock::findOrFail($id);
        $stock->update($data);
        return redirect()->route('stock.index');
    }

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();
        return redirect()->route('stock.index');
    }
}
