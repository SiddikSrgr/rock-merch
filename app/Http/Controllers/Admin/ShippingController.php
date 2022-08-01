<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Shipping;
use App\Models\Confirmation;

class ShippingController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $shipping = Shipping::query()->latest();

            return DataTables::of($shipping)
            ->editColumn('code', function ($shipping) {
                return '<a  href="' . route('transactions.show', $shipping->confirmation->transaction->id) . '">
                            '.$shipping->confirmation->transaction->code.'
                        </a>';
            })->editColumn('date', function ($shipping) {
                return date('Y-m-d H:i:s', strtotime($shipping->created_at) );
            })
            ->rawColumns(['code', 'date'])
            ->toJson();
        }
        return view('pages.admin.shipping.index');
    }

    public function create($id)
    { 
        $confirmation = Confirmation::find($id); 
        return view('pages.admin.shipping.create', ['confirmation' => $confirmation]);
    }

    public function store(Request $request)
    {
        $confirmation = Confirmation::findOrFail($request->confirmation_id);
        $confirmation->shipping_status = 1;
        $confirmation->save();
        $transaction = $confirmation->transaction->update([
            'resi' => $request->resi,
            'shipping_status' => 'SHIPPING'
        ]);
        Shipping::create($request->all());
        return redirect('admin/shippings');
    }
}
