<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\accounts;
use Illuminate\Http\Request;

class BalanceSheetReportController extends Controller
{
    public function index()
    {
        return view('reports.balance_sheet.index');
    }

    public function data($type)
    {
        $accounts = accounts::where('type', $type)->get();
        foreach($accounts as $account)
        {
            $account->balance = getAccountBalance($account->id);
        }
       
        return view('reports.balance_sheet.details', compact('type', 'accounts'));
    }
}
