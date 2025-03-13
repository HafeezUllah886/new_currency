<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\transactions;
use Illuminate\Http\Request;

class ledgerReportController extends Controller
{
    public function index()
    {
        return view('reports.ledger.index');
    }

    public function data($from, $to , $type)
    {

        $accounts = accounts::where('type', $type)->pluck('id');
       
        $transactions = transactions::with('account')->whereBetween('date', [$from, $to])->whereIn('accountID', $accounts)->get();

        return view('reports.ledger.details', compact('from', 'to', 'type', 'transactions'));
    }
}
