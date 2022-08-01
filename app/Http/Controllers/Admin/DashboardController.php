<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Confirmation;
use App\Models\User;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $confirmations = Confirmation::all();
        $users = User::where('role', '!=', 'ADMIN')->count();
        $revenue = 0;
        $transactions = Transaction::all()->count();
        foreach($confirmations as $confirmation){
            $revenue += $confirmation->transaction->total_price;
        }
        return view('pages.admin.dashboard', ['users' => $users, 'revenue' => $revenue, 'transactions' => $transactions]);
    }
}
