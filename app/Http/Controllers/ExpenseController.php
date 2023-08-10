<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $expenses = $user->expenses();

        if ($request->has('category_filter')) {
            $categoryFilter = $request->input('category_filter');
            if ($categoryFilter) {
                $expenses->where('category', $categoryFilter);
            }
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            if ($startDate && $endDate) {
                $expenses->whereBetween('date', [$startDate, $endDate]);
            }
        }

        $expenses = $expenses->get();
        $categories = $user->expenses()->pluck('category')->unique();

        return view('expenses.index', compact('expenses', 'categories'));
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
