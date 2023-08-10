<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $incomes = Income::where('user_id', Auth::id())->orderBy('created_at', 'asc')->get();
        $expenses = Expense::where('user_id', Auth::id())->orderBy('created_at', 'asc')->get();
    
        $transactions = collect($incomes)->map(function ($item) {
            $item['type'] = 'Income';
            return $item;
        })->merge(collect($expenses)->map(function ($item) {
            $item['type'] = 'Expense';
            return $item;
        }))->sortBy('created_at');

        $totalIncome = $incomes->sum('amount');
        $totalExpense = $expenses->sum('amount');

        $totalAmount = $transactions->sum(function ($transaction) {
            return $transaction->type === 'Income' ? $transaction->amount : -$transaction->amount;
        });
    
    
        return view('home', compact('transactions', 'totalIncome', 'totalExpense', 'totalAmount'));
    }
}
