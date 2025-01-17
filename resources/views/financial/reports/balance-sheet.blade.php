@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Balance Sheet</h4>
                    <div>
                        <form class="d-flex gap-2" method="GET">
                            <input type="date" name="as_of_date" class="form-control" value="{{ request('as_of_date', now()->format('Y-m-d')) }}">
                            <button type="submit" class="btn btn-primary">View</button>
                            <a href="{{ route('reports.exportBalanceSheet', ['as_of_date' => request('as_of_date')]) }}" class="btn btn-secondary">Export PDF</a>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr class="table-primary">
                                <th colspan="2">Assets</th>
                            </tr>
                            <tr class="table-secondary">
                                <th colspan="2">Current Assets</th>
                            </tr>
                            @foreach($data['assets']['current_assets'] as $key => $value)
                            <tr>
                                <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                <td class="text-end">${{ number_format($value, 2) }}</td>
                            </tr>
                            @endforeach

                            <tr class="table-secondary">
                                <th colspan="2">Fixed Assets</th>
                            </tr>
                            @foreach($data['assets']['fixed_assets'] as $key => $value)
                            <tr>
                                <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                <td class="text-end">${{ number_format($value, 2) }}</td>
                            </tr>
                            @endforeach
                            
                            <tr class="table-primary">
                                <th>Total Assets</th>
                                <th class="text-end">${{ number_format($data['total_assets'], 2) }}</th>
                            </tr>

                            <tr class="table-primary">
                                <th colspan="2">Liabilities</th>
                            </tr>
                            <tr class="table-secondary">
                                <th colspan="2">Current Liabilities</th>
                            </tr>
                            @foreach($data['liabilities']['current_liabilities'] as $key => $value)
                            <tr>
                                <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                <td class="text-end">${{ number_format($value, 2) }}</td>
                            </tr>
                            @endforeach

                            <tr class="table-success">
                                <th>Total Equity</th>
                                <th class="text-end">${{ number_format($data['equity'], 2) }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection