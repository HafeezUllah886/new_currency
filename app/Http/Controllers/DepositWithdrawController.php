<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\deposit_withdraw;
use App\Models\transactions;
use App\Models\transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepositWithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trans = deposit_withdraw::orderBy('id', 'desc')->get();
        $accounts = accounts::orderby('type', 'asc')->orderby('title', 'asc')->get();

        return view('Finance.deposit_withdraw.index', compact('trans', 'accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try
        {
            DB::beginTransaction();
            $ref = getRef();
            $amount = $request->amount;
            deposit_withdraw::create(
                [
                    'accountID' => $request->accountID,
                    'date' => $request->date,
                    'type' => $request->type,
                    'amount' => $amount,
                    'notes' => $request->notes,
                    'refID' => $ref
                ]
            );

            if($request->type == 'Deposit')
            {
                createTransaction($request->accountID, $request->date, $amount, 0, $request->notes, $ref);
            }
            else
            {
                createTransaction($request->accountID, $request->date, 0, $amount, $request->notes, $ref);
            }

            DB::commit();
            return ['success' => "Transaction Created"];
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            return ['error' => $e->getMessage()];
        }
    }

    public function deposits($date)
    {
        $deposits = deposit_withdraw::whereDate('date', $date)->where('type', 'Deposit')->orderBy('id', 'desc')->get();
        $data = [];
        foreach ($deposits as $deposit)
        {
            $data[] = [
                'id' => $deposit->id,
                'account' => accounts::find($deposit->accountID)->title,
                'amount' => number_format($deposit->amount),
                'notes' => $deposit->notes,
                'refID' => $deposit->refID
            ];
        }
        dashboard();
        $pkr_accounts = accounts::where('type', 'PKR')->pluck('id')->toArray();
        $dollar_accounts = accounts::where('type', 'Dollar')->pluck('id')->toArray();

        $totalPKR = deposit_withdraw::whereDate('date', $date)->whereIn('accountID', $pkr_accounts)->where('type', 'Deposit')->sum('amount');
        $totalDollar = deposit_withdraw::whereDate('date', $date)->whereIn('accountID', $dollar_accounts)->where('type', 'Deposit')->sum('amount');
        return response()->json(['data' => $data , 'totalPKR' => number_format($totalPKR), 'totalDollar' => number_format($totalDollar)]);
    }
    public function withdraws($date)
    {
        $withdraws = deposit_withdraw::whereDate('date', $date)->where('type', 'Withdraw')->orderBy('id', 'desc')->get();
        $data = [];
        foreach ($withdraws as $withdraw)
        {
            $data[] = [
                'id' => $withdraw->id,
                'account' => accounts::find($withdraw->accountID)->title,
                'amount' => number_format($withdraw->amount),
                'notes' => $withdraw->notes,
                'refID' => $withdraw->refID
            ];
        }
        dashboard();

        $pkr_accounts = accounts::where('type', 'PKR')->pluck('id')->toArray();
        $dollar_accounts = accounts::where('type', 'Dollar')->pluck('id')->toArray();

        $totalPKR = deposit_withdraw::whereDate('date', $date)->whereIn('accountID', $pkr_accounts)->where('type', 'Withdraw')->sum('amount');
        $totalDollar = deposit_withdraw::whereDate('date', $date)->whereIn('accountID', $dollar_accounts)->where('type', 'Withdraw')->sum('amount');
        return response()->json(['data' => $data , 'totalPKR' => number_format($totalPKR), 'totalDollar' => number_format($totalDollar)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(deposit_withdraw $deposit_withdraw)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $transaction = deposit_withdraw::find($id);
        return response()->json(['data' => $transaction]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try
        {
            DB::beginTransaction();
            $trans = deposit_withdraw::find($request->id);
            transactions::where('refID', $trans->refID)->delete();
            $trans->update(
                [
                    'accountID' => $request->account,
                    'date' => $request->date,
                    'type' => $request->type,
                    'amount' => $request->amount,
                    'notes' => $request->notes,
                ]
            );

            if($request->type == 'Deposit')
            {
                createTransaction($request->account, $request->date, $request->amount, 0, $request->notes, $trans->refID);
            }
            else
            {
                createTransaction($request->account, $request->date, 0, $request->amount, $request->notes, $trans->refID);
            }

            DB::commit();
            return redirect()->back()->with('success', "Transaction Updated");
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete($ref)
    {
        try
        {
            DB::beginTransaction();
            deposit_withdraw::where('refID', $ref)->delete();
            transfer::where('refID', $ref)->delete();
            transactions::where('refID', $ref)->delete();
            DB::commit();
            session()->forget('confirmed_password');
            return redirect()->route('deposit_withdraw.index')->with('success', "Transaction Deleted");
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            session()->forget('confirmed_password');
            return redirect()->route('deposit_withdraw.index')->with('error', $e->getMessage());
        }
    }
}
