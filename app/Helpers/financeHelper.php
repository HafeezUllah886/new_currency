<?php

use App\Models\accounts;
use App\Models\ref;
use App\Models\transactions;

function createTransaction($accountID, $date, $cr, $db, $notes, $ref){
    transactions::create(
        [
            'accountID' => $accountID,
            'date' => $date,
            'cr' => $cr,
            'db' => $db,
            'notes' => $notes,
            'refID' => $ref,
        ]
    );

}

function getAccountBalance($id){
    $transactions  = transactions::where('accountID', $id);

    $cr = $transactions->sum('cr');
    $db = $transactions->sum('db');
    $balance = $cr - $db;

    return $balance;
}


function numberToWords($number)
{
    $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
    return ucfirst($f->format($number));
}


function spotBalanceBefore($id, $ref)
{
    $cr = transactions::where('accountID', $id)->where('refID', '<', $ref)->sum('cr');
    $db = transactions::where('accountID', $id)->where('refID', '<', $ref)->sum('db');
    return $balance = $cr - $db;
}

function spotBalance($id, $ref)
{
    $cr = transactions::where('accountID', $id)->where('refID', '<=', $ref)->sum('cr');
    $db = transactions::where('accountID', $id)->where('refID', '<=', $ref)->sum('db');
    return $balance = $cr - $db;
}

function todaytotal($date)
{
    $pkr_accounts = accounts::where('type', 'PKR')->pluck('id')->toArray();
    $dollar_accounts = accounts::where('type', 'Dollar')->pluck('id')->toArray();

    $pkr_cr  = transactions::whereDate('date', $date)->whereIn('accountID', $pkr_accounts)->sum('cr');
    $pkr_db  = transactions::whereDate('date', $date)->whereIn('accountID', $pkr_accounts)->sum('db');
    $pkr_balance = $pkr_cr - $pkr_db;

    $dollar_cr  = transactions::whereDate('date', $date)->whereIn('accountID', $dollar_accounts)->sum('cr');
    $dollar_db  = transactions::whereDate('date', $date)->whereIn('accountID', $dollar_accounts)->sum('db');
    $dollar_balance = $dollar_cr - $dollar_db;

    return ['PKR' => $pkr_balance, 'Dollar' => $dollar_balance];
}


function totalbalance()
{
    $pkr_accounts = accounts::where('type', 'PKR')->pluck('id')->toArray();
    $dollar_accounts = accounts::where('type', 'Dollar')->pluck('id')->toArray();

    $pkr_cr  = transactions::whereIn('accountID', $pkr_accounts)->sum('cr');
    $pkr_db  = transactions::whereIn('accountID', $pkr_accounts)->sum('db');
    $pkr_balance = $pkr_cr - $pkr_db;

    $dollar_cr  = transactions::whereIn('accountID', $dollar_accounts)->sum('cr');
    $dollar_db  = transactions::whereIn('accountID', $dollar_accounts)->sum('db');
    $dollar_balance = $dollar_cr - $dollar_db;

    return ['PKR' => $pkr_balance, 'Dollar' => $dollar_balance];
}

function prevBalance($date, $type)
{
    $accounts = accounts::where('type', $type)->pluck('id')->toArray();
    $transactions  = transactions::whereDate('date', '<' , $date)->whereIn('accountID', $accounts)->get();

    $balance = 0;
    foreach($transactions as $transaction)
    {
        if($transaction->cr > 0)
        {
            $balance += $transaction->cr;
        }
        if($transaction->db > 0)
        {
            $balance -= $transaction->db;
        }
    }
    return $balance;
}

