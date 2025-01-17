@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Profit & Loss Statement</h4>
                    <div>
                        <form class="d-flex gap-2" method="GET">
                            <input type="date" name="start_date" class="form-control" value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date', now()->format('Y-m-d')) }}">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr class="table-primary">
                                <th colspan="2">Revenue</th>
                            </tr>
                            @foreach($data['revenue'] as $key => $value)
                            <tr>
                                <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                <td class="text-end">${{ number_format($value, 2) }}</td>
                            </tr>
                            @endforeach
                            <tr class="table-secondary">
                                <th>Total Revenue</th>
                                <th class="text-end">${{ number_format($data['total_revenue'], 2) }}</th>
                            </tr>

                            <tr class="table-primary">
                                <th colspan="2">Expenses</th>
                            </tr>
                            @foreach($data['expenses'] as $key => $value)
                            <tr>
                                <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                <td class="text-end">${{ number_format($value, 2) }}</td>
                            </tr>
                            @endforeach
                            <tr class="table-secondary">
                                <th>Total Expenses</th>
                                <th class="text-end">${{ number_format($data['total_expenses'], 2) }}</th>
                            </tr>

                            <tr class="table-success">
                                <th>Net Profit</th>
                                <th class="text-end">${{ number_format($data['net_profit'], 2) }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection