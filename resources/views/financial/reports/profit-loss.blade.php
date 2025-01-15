@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Profit & Loss Statement</h5>
                    <div>
                        <form class="d-flex gap-2" method="GET">
                            <input type="date" name="start_date" class="form-control" 
                                   value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                            <input type="date" name="end_date" class="form-control"
                                   value="{{ request('end_date', now()->format('Y-m-d')) }}">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="2">Revenue</th>
                            </tr>
                            <tr>
                                <td>Total Revenue</td>
                                <td class="text-end">{{ number_format($report['revenue'], 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="2">Expenses</th>
                            </tr>
                            <tr>
                                <td>Total Expenses</td>
                                <td class="text-end">{{ number_format($report['expenses'], 2) }}</td>
                            </tr>
                            <tr class="table-primary">
                                <th>Net Income</th>
                                <th class="text-end">{{ number_format($report['net_income'], 2) }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>