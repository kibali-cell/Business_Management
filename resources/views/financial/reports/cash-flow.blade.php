
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Cash Flow Statement</h4>
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
                                <th colspan="2">Operating Activities</th>
                            </tr>
                            <tr class="table-secondary">
                                <th colspan="2">Cash Inflows</th>
                            </tr>
                            @foreach($data['operating_activities']['inflows'] as $key => $value)
                            <tr>
                                <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                <td class="text-end">${{ number_format($value, 2) }}</td>
                            </tr>
                            @endforeach

                            <tr class="table-secondary">
                                <th colspan="2">Cash Outflows</th>
                            </tr>
                            @foreach($data['operating_activities']['outflows'] as $key => $value)
                            <tr>
                                <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                <td class="text-end">${{ number_format($value, 2) }}</td>
                            </tr>
                            @endforeach

                            <tr class="table-success">
                                <th>Net Operating Cash Flow</th>
                                <th class="text-end">${{ number_format($data['net_operating_cash'], 2) }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection