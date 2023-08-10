<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $incomes = $user->incomes();

        if ($request->has('category_filter')) {
            $categoryFilter = $request->input('category_filter');
            if ($categoryFilter) {
                $incomes->where('category', $categoryFilter);
            }
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            if ($startDate && $endDate) {
                $incomes->whereBetween('date', [$startDate, $endDate]);
            }
        }

        $incomes = $incomes->get();
        $categories = $user->incomes()->pluck('category')->unique();

        return view('incomes.index', compact('incomes', 'categories'));

    }

    public function create()
    {
        return view('incomes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required|string',
            'date' => 'required|date',
            'category' => 'required|string',
        ]);

        auth()->user()->incomes()->create($data);

        return redirect()->route('incomes.index')->with('success', 'Income created successfully.');
    }

    public function edit(Income $income)
    {
        if ($income->user_id != Auth::id()) {
            return redirect()->route('incomes.index')->with('error', 'Unauthorized.');
        }

        return view('incomes.edit', compact('income'));
    }

    public function update(Request $request, Income $income)
    {
        if ($income->user_id != Auth::id()) {
            return redirect()->route('incomes.index')->with('error', 'Unauthorized.');
        }

        $data = $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required|string',
            'date' => 'required|date',
            'category' => 'required|string',
        ]);

        $income->update($data);

        return redirect()->route('incomes.index')->with('success', 'Income updated successfully.');
    }

    public function destroy(Income $income)
    {
        if ($income->user_id != Auth::id()) {
            return redirect()->route('incomes.index')->with('error', 'Unauthorized.');
        }

        $income->delete();

        return redirect()->route('incomes.index')->with('success', 'Income deleted successfully.');
    }
}
