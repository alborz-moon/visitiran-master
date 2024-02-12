@extends('layouts.structure')
@section('content')
    <main class="page-content TopParentBannerMoveOnTop">
        <div class="container">
            <div class="row mb-5">
                @include('event.launcher.launcher-menu')
                <div class="col-xl-9 col-lg-8 col-md-7">
                    <div class="alert alert-warning alert-dismissible fade show mb-5 d-flex align-items-center spaceBetween"
                        role="alert">
                        <div>
                            در حال حاضر حساب کاربری شما غیر فعال است. پس از بررسی مدارک و تایید از سوی ادمین حساب شما فعال
                            خواهد شد.
                        </div>
                        <a href="#" class="btn btn-sm btn-primary mx-3">تیکت ها</a>
                    </div>
                    <div class="ui-box bg-white mb-5 boxShadow">
                        <div class="ui-box-title"><span>اطلاعات مالی</span><span>&nbsp;</span> <span
                                class="fontSize12 colorBlack">شماره شبا حتما باید به نام
                                برگزار کننده بوده و بدون IR وارد شود</span></div>
                        <div class="ui-box-content">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class="py-2">
                                        <div class="fs-7 text-dark">شماره شبا</div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <input id="shabaNo" type="text" class="form-control" style="direction: rtl"
                                                placeholder="شماره شبا">
                                            <button class="btn btn-circle btn-outline-light hidden"
                                                data-remodal-target="personal-info-fullname-modal"><i
                                                    class="ri-ball-pen-fill"></i></button>
                                        </div>
                                        <div class="fs-6 fw-bold text-muted"></div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button id="addShabaNo" class="btn btn-sm btn-primary px-3">افزودن</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ui-box bg-white mb-5">
                        <div class="ui-box-title align-items-center justify-content-between">
                            شماره حساب های موجود
                        </div>
                        <div class="ui-box-content">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>شماره</th>
                                            <th>شماره شبا</th>
                                            <th>پیش فرض</th>
                                            <th>وضعیت</th>
                                            <th>تاریخ ایجاد</th>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bankAccounts">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
@stop


@section('extraJS')
    @parent
    <script>
        let totalRows = 0;
        $(document).ready(function() {
            $.ajax({
                type: 'get',
                url: '{{ route('launcher_bank_accounts.index') }}',
                headers: {
                    'accept': 'application/json'
                },
                success: function(res) {
                    if (res.status === "ok") {
                        var html = '';
                        totalRows = res.data.length;
                        for (let i = 0; i < res.data.length; i++) {
                            html += addNewRow(i, res.data[i]);
                        }
                        $("#bankAccounts").empty().append(html);

                        function selectBtn() {
                            for (i = 0; i > res.data.length; i++) {
                                $("#choose").addClass('btn-light')
                            }
                        }
                    }
                }
            });
        });

        function deleteShaba(idx, bankId) {
            $.ajax({
                type: 'delete',
                url: '{{ route('launcher_bank_accounts.destroy') }}' + "/" + bankId,
                headers: {
                    'accept': 'application/json'
                },
                success: function(res) {
                    if (res.status === "ok") {
                        $("#delete_row_" + idx).remove();
                    }
                }
            });
        };

        function changeDefault(idx, bankId) {
            $.ajax({
                type: 'post',
                url: '{{ route('launcher_bank_accounts.update') }}' + '/' + bankId,
                data: {
                    is_default: 1
                },
                headers: {
                    'accept': 'application/json'
                },
                success: function(res) {
                    if (res.status === "ok") {
                        $(".is_dafult_bank_account").removeClass('btn-success').addClass('btn-light');
                        $("#choose_default_" + idx).addClass('btn-success').removeClass('btn-light');
                    }
                }
            });
        }

        function addNewRow(i, data) {
            let html = '<tr id="delete_row_' + i + '">';
            html += '<td class="fa-num">' + (i + 1) + '</td>';
            html += '<td class="fa-num">' + data.shaba_no + '</td>';
            html += '<td>';
            if (data.is_default)
                html += '<button id="choose_default_' + i +
                '" class="is_dafult_bank_account btn btn-circle btn-success my-1"><i class="ri-check-fill"></i></button>';
            else
            html += '<button onclick="changeDefault(\'' + i + '\', \'' + data.id + '\')" id="choose_default_' + i +
                '" class="is_dafult_bank_account btn btn-circle btn-light my-1"><i class="ri-check-fill"></i></button>';
            html += '</td>';
            if (data.status === 'pending') {
                html += '<td class="fa-num"><span class="badge bg-primary rounded-pill"> درحال بررسی</span></td>';
            } else if (data.status === 'rejected') {
                html += '<td class="fa-num"><span class="badge bg-danger rounded-pill">رد شده</span></td>';
            } else {
                html += '<td class="fa-num"><span class="badge bg-success rounded-pill">تایید شده</span></td>';
            }
            html += '<td class="fa-num">' + data.created_at + '</td>';
            html += '<td>';
            
            html += '<button onclick="deleteShaba(\'' + i + '\', \'' + data.id +
                '\')" class="btn btn-circle btn-danger my-1"><i class="ri-close-line"></i></button>';
            html += '</td>';
            html += '</tr>';
            return html;
        }

        $('#addShabaNo').on('click', function() {

            var shabaNo = $('#shabaNo').val();

            $.ajax({
                type: 'post',
                url: '{{ route('launcher_bank_accounts.store') }}',
                data: {
                    shaba_no: shabaNo
                },
                success: function(res) {
                    if (res.status === "ok") {
                        showSuccess("اضافه شد");
                        $("#bankAccounts").append(addNewRow(totalRows, res.data));
                        totalRows++;
                    } else
                        showErr(res.msg);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {

                    var errs = XMLHttpRequest.responseJSON.errors;

                    if (errs instanceof Object) {
                        var errsText = '';

                        Object.keys(errs).forEach(function(key) {
                            errsText += key + " : " + errs[key];
                        });
                        showErr(errsText);
                    } else {
                        var errsText = '';

                        for (let i = 0; i < errs.length; i++)
                            errsText += errs[i].value;

                        showErr(errsText);
                    }
                }
            });
        });
    </script>
@stop
