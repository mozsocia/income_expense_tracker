@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('Dashboard') }}</div>

          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif



            <div class="container">
              <h1>Income and Expenses</h1>

              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Category</th>
                    <th>Type</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($transactions->isEmpty())
                    <tr>
                      <td colspan="5">No transactions available. Please create income and expense data.
                        <br>
                        <a href="{{ route('expenses.create') }}" class="btn btn-sm btn-outline-primary mt-2 me-3">Add
                          Expense</a>

                        <a href="{{ route('incomes.create') }}" class="btn btn-sm btn-outline-primary mt-2">Add
                          Incomes</a>

                      </td>

                    </tr>
                  @else
                    @foreach ($transactions as $transaction)
                      <tr>
                        <td>{{ $transaction->date }}</td>
                        <td>{{ $transaction->description }}</td>
                        <td>{{ $transaction->amount }}</td>
                        <td>{{ $transaction->category }}</td>
                        <td>
                          @if ($transaction->type === 'Income')
                            <span class="badge bg-success">{{ $transaction->type }}</span>
                          @else
                            <span class="badge bg-danger">{{ $transaction->type }}</span>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  @endif

                </tbody>
              </table>

              <div class="mt-4">
                <h4>Total Amount: {{ $totalAmount }}</h4>
                <h5>Total Income: {{ $totalIncome }}</h5>
                <h5>Total Expense: {{ $totalExpense }}</h5>
                
            </div>

            </div>



          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
