@extends('layout.app')
@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>View Balance Sheet</h3>
                </div>
                <div class="card-body">
                    <div class="form-group mt-2">
                        <label for="type">Type</label>
                        <select name="type" id="type" class="form-control">
                            <option value="PKR">PKR Accounts</option>
                            <option value="Dollar">Dollar Accounts</option>
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <button class="btn btn-success w-100" id="viewBtn">View Report</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('page-js')

    <script>

        $("#viewBtn").on("click", function (){
            var type = $("#type").find(":selected").val();
            var url = "{{ route('reportBalanceSheetData', ['type' => ':type']) }}"
        .replace(':type', type);
            window.open(url, "_blank", "width=1000,height=800");
        });
    </script>
@endsection
