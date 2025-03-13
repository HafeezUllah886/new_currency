@extends('layout.popups')
@section('content')
        <div class="row justify-content-center">
            <div class="col-xxl-9">
                <div class="card" id="demo">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end d-print-none p-2 mt-4">
                                <a href="javascript:window.print()" class="btn btn-success ml-4"><i class="ri-printer-line mr-4"></i> Print</a>
                            </div>
                            <div class="card-header border-bottom-dashed p-4">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h1>{{projectNameAuth()}}</h1>
                                    </div>
                                    <div class="flex-shrink-0 mt-sm-0 mt-3">
                                        <h3>{{$type}} Accounts Balance Sheet</h3>
                                    </div>
                                </div>
                            </div>
                            <!--end card-header-->
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Credit Accounts</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <th class="p-1 m-1">#</th>
                                            <th class="p-1 m-1">Account</th>
                                            <th class="p-1 m-1">Balance</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $ser = 0;
                                                $credit_balance = 0;
                                            @endphp
                                            @foreach ($accounts as $account)
                                                @if ($account->balance > 0)
                                                @php
                                                    $ser++;
                                                    $credit_balance += $account->balance;
                                                @endphp
                                                    <tr>
                                                        <td class="p-1 m-1">{{$ser}}</td>
                                                        <td class="p-1 m-1" style="width:70%;">{{$account->title}}</td>
                                                        <td class="p-1 m-1">{{number_format($account->balance,2)}}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <th colspan="2" class="text-end p-1 m-1">Total</th>
                                            <th class="p-1 m-1">{{number_format($credit_balance, 2)}}</th>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Debit Accounts</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <th class="p-1 m-1">#</th>
                                            <th class="p-1 m-1">Account</th>
                                            <th class="p-1 m-1">Balance</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $ser = 0;
                                                $debit_balance = 0;
                                            @endphp
                                            @foreach ($accounts as $account)
                                                @if ($account->balance < 0)
                                                @php
                                                    $ser++;
                                                    $debit_balance += $account->balance;
                                                @endphp
                                                    <tr>
                                                        <td class="p-1 m-1">{{$ser}}</td>
                                                        <td class="p-1 m-1" style="width:70%;">{{$account->title}}</td>
                                                        <td class="p-1 m-1">{{number_format($account->balance,2)}}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <th colspan="2" class="text-end p-1 m-1">Total</th>
                                            <th class="p-1 m-1">{{number_format($debit_balance, 2)}}</th>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <th>Total Credit</th>
                                            <th>Total Debit</th>
                                            <th>Balance</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{number_format($credit_balance,2)}}</td>
                                                <td>{{number_format($debit_balance,2)}}</td>
                                                <td>{{number_format($credit_balance + $debit_balance,2)}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->

@endsection



