<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Http;

class CheckOngkirController extends Controller
{
    protected $API_KEY = 'a83a011b65ac191151038b2bfce9e640'; 

    public function provinces()
    {
        return Province::all();
    }
 
    public function cities($id)
    {
        return City::where('province_id', $id)->get();
    }

    public function checkOngkir(Request $request)
    {
        $response = Http::withHeaders([
            'key' => $this->API_KEY
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin'            => $request->origin,
            'destination'       => $request->destination,
            'weight'            => $request->weight,
            'courier'           => $request->courier
        ]);

        $ongkir = $response['rajaongkir']['results'];

        return response()->json([
            'success' => true,
            'message' => 'Result Cost Ongkir',
            'data'    => $ongkir    
        ]);
    }
}