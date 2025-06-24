@extends('layouts.main')
@section('content')
{{-- <style>
    .center {
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
}
    </style> --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">بحث عن المستفيدين</h3>
                    <div class="card-tools">
                        <a class="btn btn-info" href="{{ route('dashboard') }}" target="_blank">
                            الإحصائيات
                        </a>
                        <a class="btn btn-info" href="{{ route('last_update') }}" target="_blank">
                            أخر الحركات
                        </a>
                        <a class="btn btn-info" href="{{ route('upload_bulk_excel') }}" target="_blank">
                            استيراد ملف اكسل
                        </a>
                        <a class="btn btn-info" href="{{ route('food_coupons') }}" target="_blank">
                            أنواع الطرود
                        </a>
                        <a class="btn btn-info" href="{{ route('add_beneficiary') }}" target="_blank">
                            إضافة مستفيد
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group">
                        <form id="formSearch">
                            <div class="row">
                                <label class="col-1">رقم الهوية</label>
                                <div class="col-3">
                                    <input type="number" class="form-control" id="s_id_no">
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" placeholder="الاسم" id="s_name">
                                </div>
                                <button type="submit" class="btn btn-info col-1 ml-1"
                                    onclick="getBeneficiaries()">بحث</button>
                                <button type="reset" class="btn btn-default col-1">تفريغ</button>
                            </div>
                        </form>
                    </div>
                    <div id="resultDiv"></div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>


    </div>

@endsection
@push('scripts')
    <script>
        var Toast;
        $(function() {
            $('#formSearch').submit(function(e) {
                e.preventDefault();
                setChecked();
            });

            Toast = Swal.mixin({
                toast: true,
                position: 'top-start',
                showConfirmButton: false,
                timer: 3000
            });
        });

        function getBeneficiaries() {
            var datatable;
            var s_id_no = $('#s_id_no').val();
            var s_name = $('#s_name').val();
            var url = "{{ route('result_search') }}";

            $.ajax({
                url: url,
                type: 'text',
                method: 'get',
                data: {
                    's_id_no': s_id_no,
                    's_name': s_name
                },
            }).done(function(response) {
                $('#resultDiv').html(response);
            });

        }

        function setChecked() {
            var s_num_code = $('#s_num_code').val();
            if (s_num_code.length > 3) {
                checked(s_num_code);
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'أدخل رقم صحيح'
                });
            }

        }

        function checked(b_id) {
            let url = "{{ route('change_status') }}";
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    b_id: b_id,
                },
                success: function(response) {
                    console.log(response);
                    if (response.status != 'fail') {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response.message
                        });
                    }

                },
                error: function(response) {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                    console.log(response);
                },
            });
        }

        function CancelReceipt(receipt_id, num_code) {
            if (receipt_id) {
                let url = "{{ route('cancel_receipt') }}";
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        receipt_id: receipt_id,
                        num_code: num_code
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status != 'fail') {
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: response.message
                            });
                        }

                    },
                    error: function(response) {
                        Toast.fire({
                            icon: 'error',
                            title: response.message
                        });
                        console.log(response);
                    },
                });
            }
        }


    </script>
@endpush
