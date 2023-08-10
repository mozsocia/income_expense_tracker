@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>Expense List</h1>
    <a href="{{ route('expenses.create') }}" class="btn btn-primary mb-3">Add Expense</a>

    <div class="row">

    <!-- Category Filter Form -->
    <form action="{{ route('expenses.index') }}" method="GET" class="mb-3 col">
      <div class="input-group">
        <select class="form-select" name="category_filter">
          <option value="">All Categories</option>
          @foreach ($categories as $category)
            <option value="{{ $category }}" {{ request('category_filter') === $category ? 'selected' : '' }}>
              {{ $category }}</option>
          @endforeach
        </select>
        <button type="submit" class="btn btn-outline-secondary">Filter</button>
      </div>
    </form>
    

    <!-- Date Range Filter Form -->
    <form action="{{ route('expenses.index') }}" method="GET" class="col">
      <div class="input-group mb-3">
        <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
        <span class="input-group-text">to</span>
        <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
        <button type="submit" class="btn btn-outline-secondary">Filter</button>
      </div>
    </form>

  </div>

    <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary mt-1 mb-3">Clear Filter</a> 

    <table class="table data-table">
      <thead>
        <tr>
          <th>Amount</th>
          <th>Description</th>
          <th>Date</th>
          <th>Category</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @if ($expenses->isEmpty())
          <tr>
            <td colspan="5">No data available. Please create data.</td>
          </tr>
        @else
          @foreach ($expenses as $expense)
            <tr>
              <td>{{ $expense->amount }}</td>
              <td>{{ $expense->description }}</td>
              <td>{{ $expense->date }}</td>
              <td>{{ $expense->category }}</td>
              <td>
                <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm('Are you sure?')">Delete</button>
                </form>
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
  </div>
@endsection
