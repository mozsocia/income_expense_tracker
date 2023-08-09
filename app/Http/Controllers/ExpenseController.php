<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = auth()->user()->expenses;
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required',
            'date' => 'required|date',
            'category' => 'required',
        ]);

        auth()->user()->expenses()->create($data);
        return redirect()->route('expenses.index')->with('success', 'Expense created successfully.');
    }

    public function edit(Expense $expense)
    {
        if ($expense->user_id != Auth::id()) {
            return redirect()->route('expenses.index')->with('error', 'Unauthorized.');
        }
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        if ($expense->user_id != Auth::id()) {
            return redirect()->route('expenses.index')->with('error', 'Unauthorized.');
        }
        $data = $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required',
            'date' => 'required|date',
            'category' => 'required',
        ]);


        $expense->update($data);
        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->user_id != Auth::id()) {
            return redirect()->route('expenses.index')->with('error', 'Unauthorized.');
        }
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
