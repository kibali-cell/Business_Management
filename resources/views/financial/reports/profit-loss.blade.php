@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <h4 class="mb-0">Profit & Loss Statement</h4>
                        </div>
                        <div class="col-md-8">
                            <form method="GET" class="row g-2 justify-content-md-end">
                                <div class="col-sm-auto">
                                    <input type="date" 
                                           name="start_date" 
                                           class="form-control form-control-sm" 
                                           value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                                </div>
                                <div class="col-sm-auto">
                                    <input type="date" 
                                           name="end_date" 
                                           class="form-control form-control-sm" 
                                           value="{{ request('end_date', now()->format('Y-m-d')) }}">
                                </div>
                                <div class="col-sm-auto">
                                    <button type="submit" class="btn btn-primary btn-sm w-100">Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead>
                                <tr class="table-primary">
                                    <th class="fw-bold" style="min-width: 200px">Revenue</th>
                                    <th class="text-end" style="min-width: 150px"></th>
                                </tr>
                            </thead>
                            <tbody>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection