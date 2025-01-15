<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\Financial\ReportingService;
use Carbon\Carbon;


use Illuminate\Http\Request;

class ReportController extends Controller
{
    //

    protected $reportingService;

    public function __construct(ReportingService $reportingService)
    {
        $this->reportingService = $reportingService;
    }

    public function profitLoss(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now());

        $report = $this->reportingService->generateProfitLossReport($startDate, $endDate);

        return view('financial.reports.profit-loss', compact('report'));
    }

    public function balanceSheet()
    {
        $report = $this->reportingService->generateBalanceSheet();
        return view('financial.reports.balance-sheet', compact('report'));
    }


public function exportBalanceSheet()
{
    // Retrieve the balance sheet data
    $report = $this->reportingService->generateBalanceSheet();

    // Load the Blade view and generate a PDF
    $pdf = Pdf::loadView('financial.reports.balance-sheet-pdf', compact('report'));

    // Return the PDF as a download
    return $pdf->download('balance-sheet.pdf');
}
}
