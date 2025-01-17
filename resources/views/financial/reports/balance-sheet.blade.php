@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Balance Sheet</h5>
                    <a href="{{ route('reports.exportBalanceSheet') }}" class="btn btn-success">
                        Export to PDF
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Account</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                                <tbody>
    @foreach ($report as $account => $amount)
        <tr>
            <td>{{ $account }}</td>
            <td>{{ number_format($amount->amount ?? $amount, 2) }}</td>  <!-- Ensure $amount is numeric -->
        </tr>
    @endforeach
</tbody>

<tfoot>
    <tr>
        <th>Total</th>
        <th>{{ number_format($report->sum(function($item) {
            return $item->amount ?? $item;  // If $item is a Carbon object, convert it to a numeric value
        }), 2) }}</th>
    </tr>
</tfoot>

                        </table>
                    </div>
                </div>
                <div class="card-footer text-muted text-end">
                    Generated on {{ now()->format('M d, Y h:i A') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
