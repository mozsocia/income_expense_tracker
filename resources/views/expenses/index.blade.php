@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>Expense List</h1>
    <a href="{{ route('expenses.create') }}" class="btn btn-primary mb-3">Add Expense</a>
    <table class="table">
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
