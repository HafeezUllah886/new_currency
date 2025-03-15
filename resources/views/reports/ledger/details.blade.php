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
                                        <h3>Ledger Report</h3>
                                    </div>
                                </div>
                            </div>
                            <!--end card-header-->
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-lg-3 col-4">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">From</p>
                                        <h5 class="fs-14 mb-0">{{ date('d M Y', strtotime($from)) }}</h5>
                                    </div>
                                    <div class="col-lg-3 col-4">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">To</p>
                                        <h5 class="fs-14 mb-0">{{ date('d M Y', strtotime($to)) }}</h5>
                                    </div>
                                    <div class="col-lg-3 col-4">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">Type</p>
                                        <h5 class="fs-14 mb-0">{{ $type }}</h5>
                                    </div>
                                    <div class="col-lg-3 col-4">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">Previous Balance</p>
                                        @php
                                            $previous_balance = prevBalance($from, $type);
                                        @endphp
                                        <h5 class="fs-14 mb-0"><span id="total-amount">{{ number_format($previous_balance,2) }}</span></h5>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <!--end card-body-->
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-stripped text-center table-nowrap align-middle mb-0">
                                        <thead>
                                            <tr class="table-active">
                                                <th scope="col" class="p-1 m-1" style="width: 50px;">#</th>
                                                <th scope="col" class="p-1 m-1" style="width: 50px;">RefID</th>
                                                <th scope="col" class="text-start p-1 m-1">Account</th>
                                                <th scope="col" class="p-1 m-1">Date</th>
                                                <th scope="col" class="text-start p-1 m-1">Notes</th>
                                                <th scope="col" class="text-center text-success p-1 m-1">Take</th>
                                                <th scope="col" class="text-center text-danger p-1 m-1">Give</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                        @foreach ($transactions as $key => $trans)
                                            <tr>
                                                <td class="p-1 m-1">{{ $key+1 }}</td>
                                                <td class="p-1 m-1">{{ $trans->refID }}</td>
                                                <td class="text-start p-1 m-1">{{ $trans->account->title }}</td>
                                                <td class="p-1 m-1">{{ date('d M Y', strtotime($trans->date)) }}</td>
                                                <td class="text-start p-1 m-1">{!! $trans->notes !!}</td>
                                                <td class="text-center text-success p-1 m-1">{{ number_format($trans->cr,2) }}</td>
                                                <td class="text-center text-danger p-1 m-1">{{ number_format($trans->db,2) }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                @php
                                                    $total_cr = $transactions->sum('cr');
                                                    $total_db = $transactions->sum('db');
                                                    $balance = $total_cr - $total_db;
                                                @endphp
                                                <th colspan="5" class="text-end p-1 m-1">Total</th>
                                                <th class="text-center p-1 m-1">{{number_format($total_cr, 2)}}</th>
                                                <th class="text-center p-1 m-1">{{number_format($total_db, 2)}}</th>
                                            </tr>
                                            <tr>
                                                <th colspan="5" class="text-end p-1 m-1">Take - Give</th>
                                                <th class="text-center p-1 m-1" colspan="2">{{number_format($balance, 2)}}</th>
                                            </tr>
                                            <tr>
                                                <th colspan="5" class="text-end p-1 m-1">Balance till {{date('d M Y', strtotime($to))}}</th>
                                                <th class="text-center p-1 m-1" colspan="2">{{number_format($previous_balance + $balance, 2)}}</th>
                                            </tr>
                                        </tfoot>
                                    </table><!--end table-->
                                </div>

                            </div>
                            <!--end card-body-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->

@endsection



