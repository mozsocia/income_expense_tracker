<!-- resources/views/incomes/index.blade.php -->

@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>Your Incomes</h1>
    <a href="{{ route('incomes.create') }}" class="btn btn-primary mb-3">Add Incomes</a>

    <div class="row">
      <!-- Category Filter Form -->
      <form action="{{ route('incomes.index') }}" method="GET" class="mb-3 col">
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
      <form action="{{ route('incomes.index') }}" method="GET" class="col">
        <div class="input-group mb-3">
          <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
          <span class="input-group-text">to</span>
          <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
          <button type="submit" class="btn btn-outline-secondary">Filter</button>
        </div>
      </form>

    </div>

    <a href="{{ route('incomes.index') }}" class="btn btn-outline-secondary mt-1 mb-3">Clear Filter</a>


    <table class="table data-table">
      <thead>
        <tr>
          <th>Date</th>
          <th>Description</th>
          <th>Amount</th>
          <th>Category</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @if ($incomes->isEmpty())
          <tr>
            <td colspan="5">No data available. Please create data.</td>
          </tr>
        @else
          @foreach ($incomes as $income)
            <tr>
              <td>{{ $income->date }}</td>
              <td>{{ $income->description }}</td>
              <td>{{ $income->amount }}</td>
              <td>{{ $income->category }}</td>
              <td>
                <a href="{{ route('incomes.edit', $income->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('incomes.destroy', $income->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm('Are you sure you want to delete this income record?')">Delete</button>
                </form>
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>

  </div>


@endsection
