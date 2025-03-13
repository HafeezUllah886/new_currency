@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Transactions</h3>
                    <button type="button" class="btn btn-primary btn-sm urdu" data-bs-toggle="modal" data-bs-target="#new">Create Account</button>
                </div>
                <div class="card-body">
                    <form id="form" method="post" action="{{ route('deposit_withdraw.store') }}">
                        @csrf
                    <div class="row">
                        
                        <div class="col-md-4">
                            <div class="row mb-2 g-0">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Account</label>
                                <div class="col-sm-10">
                                  <select name="accountID" required onchange="getBalance()" class="selectize" id="accountID" >
                                    <option value=""></option>
                                    @foreach ($accounts as $account)
                                        <option value="{{$account->id}}">{{$account->title}} | {{$account->type}}</option>
                                    @endforeach
                                  </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="row mb-2 g-0">
                                <div class="col-12">
                                  <input type="number" id="current_balance" class="form-control text-center" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row mb-2 g-1">
                                <div class="col-6">
                                    <input type="radio" class="btn-check d-none" name="type" value="Deposit" id="success-outlined" autocomplete="off" checked>
                                <label class="btn btn-outline-success w-100" for="success-outlined">Deposit</label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" class="btn-check d-none" name="type" value="Withdraw" id="danger-outlined" autocomplete="off">
                                <label class="btn btn-outline-danger w-100" for="danger-outlined">Withdraw</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row mb-2 g-0">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Date</label>
                                <div class="col-sm-10">
                                 <input type="date" value="{{date('Y-m-d')}}" class="form-control" name="date" id="date">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row mb-2 g-0">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Amount</label>
                                <div class="col-sm-10">
                                 <input type="number" value="" class="form-control" name="amount" id="amount">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="row mb-2 g-0">
                                <label for="inputEmail3" class="col-sm-1 col-form-label">Notes</label>
                                <div class="col-sm-11">
                                 <input type="text" class="form-control" name="notes" id="notes">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-1">
                            <div class="row mb-2 g-0">
                                <div class="col-sm-11">
                                    <button type="submit" class="btn btn-primary form-control" id="submit">Save</button>
                                </div>
                            </div>
                        </div>

                       
                    </div>
                </form>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="card-header pt-0 pb-0 bg-light"><h5>Deposit | PKR <span id="total_deposit"></span> | Dollar <span id="total_dollar_deposit"></span></h5></div>
                            <div class="card-body" style="max-height: 320px; overflow-y: scroll;">
                                <table class="table w-100 table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="p-1">Ref#</th>
                                            <th class="p-1">Account</th>
                                            <th class="p-1" style="max-width: 200px;">Notes</th>                                        
                                            <th class="p-1">Amount</th>
                                            <th class="p-1"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="depositsTable">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-header pt-0 pb-0 bg-light"><h5>Withdraw | PKR <span id="total_withdraw"></span> | Dollar <span id="total_dollar_withdraw"></span></h5></div>
                            <div class="card-body" style="max-height: 320px; overflow-y: scroll;">
                                <table class="table w-100 table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="p-1">Ref#</th>
                                            <th class="p-1">Account</th>
                                            <th class="p-1" style="max-width: 200px;">Notes</th>                                        
                                            <th class="p-1">Amount</th>
                                            <th class="p-1"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="withdrawsTable">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-header p-1 bg-light" >
                                <h4 class="urdu p-1" >Today Balance  | PKR <span id="today_balance" class="text-success"></span> | Dollar <span id="today_Dollar_balance" class="text-info"></span></h3>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-header p-1 bg-light">
                                <h4 class="urdu p-1" >Total Balance |  PKR <span id="total_balance" class="text-success"></span> |  Dollar <span id="total_Dollar_balance" class="text-info"></span></h3>
                            </div>
                        </div>
                       </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Default Modals -->
    <div id="new" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title urdu" id="myModalLabel">Create Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <form action="{{ route('account.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Account Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                            class="form-control">
                    </div>
                   <div class="form-group mt-2">
                        <label for="type">Type</label>
                        <select name="type" id="type" class="form-control urdu-sm">
                            <option class="urdu-sm" value="PKR">PKR</option>
                            <option class="urdu-sm" value="Dollar">Dollar</option>
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label for="contact">Contact Number</label>
                        <input type="text" name="contact" id="contact" value="{{ old('contact') }}"
                            class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light urdu-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary urdu-sm">Create</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="edit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">Edit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <form id="edit-form" action="{{url('depositwithdraw/update')}}" method="post">
            @csrf
            <input type="hidden" name="id" id="edit_id">
            <div class="modal-body">
                <div class="form-group">
                    <label for="type">Account</label>
                    <select name="account" id="edit_account" required class="form-control urdu form-control-sm">
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->title }} | {{$account->type}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label for="type">Type</label>
                    <select name="type" id="edit_type" class="form-control urdu form-control-sm">
                        <option value="Deposit">Deposit</option>
                        <option value="Withdraw">Withdraw</option>
                    </select>
                </div>
                
                    <div class="form-group  mt-2">
                        <label for="amount">Amount</label>
                        <input type="number" step="any" class="form-control" required min="1" name="amount" value="0" id="edit_amount">
                    </div>
                
                <div class="form-group mt-2">
                    <label>Date</label>
                    <input type="date" class="form-control" required name="date" value="{{ date('Y-m-d') }}" id="edit_date">
                </div>
                
                <div class="form-group mt-2">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="edit_notes" cols="30" class="form-control" rows="5"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
@endsection
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatable/datatable.bootstrap5.min.css') }}" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="{{ asset('assets/libs/datatable/responsive.bootstrap.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/libs/datatable/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/selectize/selectize.min.css') }}">
@endsection

@section('page-js')
    <script src="{{ asset('assets/libs/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/jszip.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

    <script src="{{ asset('assets/libs/selectize/selectize.min.js') }}"></script>
    <script>


        $(".selectize").selectize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#form").on('submit', function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
      type: 'POST',
      url: "{{ route('deposit_withdraw.store') }}",
      data: formData,
      success: function(data) {
        if(data.success){
            Toastify({
            text: data.success,
            className: "info",
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "center", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "linear-gradient(to right, #01CB3E, #96c93d)",
            }
            }).showToast();
            getDeposits();
            getWithdraws();
            getTodayTotal();
            totalBalance();
            getBalance();
        }
        else{
            Toastify({
            text: data.error,
            className: "info",
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "center", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "linear-gradient(to right, #FF5733, #E70000)",
            }
            }).showToast();
        }
      }
    }); 
  });

        function getBalance() {
    var selectedValue = $('#accountID').find(':selected').val();
    $('#amount').val(null);
    $('#notes').val(null);
    $.ajax({
      type: 'GET',
      url: "{{ url('accountbalance/') }}/" + selectedValue,
      dataType: 'json',
      success: function(data) {
        $('#current_balance').val(data.data);
      }
    });
  }

  function getDeposits() {
    var date = $('#date').val();
    $.ajax({
      type: 'GET',
      url: "{{ url('deposits/') }}/" + date,
      dataType: 'json',
      success: function(data) {
        $('#depositsTable').empty();
        data.data.forEach(function(item) {
            $('#depositsTable').append(`
            <tr class="border-primary">
            <td class="p-1">${item.refID}</td>
            <td class="p-1">${item.account}</td>
            <td class="p-1" style="width: 250px !important">${item.notes}</td>
            <td class="p-1">${item.amount}</td>
            <td class="p-1" style="width: 60px !important"><i class="ri-pencil-fill text-primary" onclick="edit(${item.id})"></i> / <a href="depositwithdraw/delete/${item.refID}"><i class="ri-delete-bin-fill text-danger"></i></a></td>
            </tr>
            `);
        });
        $('#total_deposit').text(data.totalPKR);
        $('#total_dollar_deposit').text(data.totalDollar);
      }
    });
  }
  
  function getWithdraws() {
    var date = $('#date').val();
    $.ajax({
      type: 'GET',
      url: "{{ url('withdraws/') }}/" + date,
      dataType: 'json',
      success: function(data) {
        $('#withdrawsTable').empty();
        data.data.forEach(function(item) {
            $('#withdrawsTable').append(`
              <tr class="border-primary">
            <td class="p-1">${item.refID}</td>
            <td class="p-1">${item.account}</td>
            <td class="p-1" style="width: 250px !important">${item.notes}</td>
            <td class="p-1">${item.amount}</td>
            <td class="p-1" style="width: 60px !important"><i class="ri-pencil-fill text-primary" onclick="edit(${item.id})"></i> / <a href="depositwithdraw/delete/${item.refID}"><i class="ri-delete-bin-fill text-danger"></i></a></td>
            </tr>
            `);
        });
        $('#total_withdraw').text(data.totalPKR);
        $('#total_dollar_withdraw').text(data.totalDollar);
      }
    });
  }

    getDeposits();
    getWithdraws();
    getTodayTotal();
    totalBalance();

  $("#date").on('change', function dateChanged() {
    getDeposits();
    getWithdraws();
    getTodayTotal();
    totalBalance();
  });

  function getTodayTotal() {
    var date = $('#date').val();
    $.ajax({
      type: 'GET',
      url: "{{ url('todaytotal/') }}/" + date,
      dataType: 'json',
      success: function(data) {
        $('#today_balance').text(data.PKR);
        $('#today_Dollar_balance').text(data.Dollar);
      }
    });
  }

  function totalBalance() {
    $.ajax({
      type: 'GET',
      url: "{{ url('totalbalance') }}",
      dataType: 'json',
      success: function(data) {
        $('#total_balance').text(data.PKR);
        $('#total_Dollar_balance').text(data.Dollar);
      }
    });
  }

  function edit(id)
  {
    $.ajax({
      type: 'GET',
      url: "{{ url('depositwithdraw/edit/') }}/" + id,
      dataType: 'json',
      success: function(data) {
        console.log(data);
        $('#edit_id').val(data.data.id);
        $('#edit_account').val(data.data.accountID);
        $('#edit_type').val(data.data.type);
        $('#edit_amount').val(data.data.amount);
        $('#edit_date').val(data.data.date);
        $('#edit_notes').val(data.data.notes);
        $("#edit").modal('show');
      },
      error: function(data) {
        console.log(data);
      }
    });
  }
    </script>
@endsection
