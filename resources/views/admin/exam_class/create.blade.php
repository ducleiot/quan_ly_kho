@extends('admin.admin_master')
@section('title', 'Thêm mới Bài Kiểm Tra')
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <strong>{{ Session::get('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
        </div>

    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <strong>{{ Session::get('error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-10">
            <p><a class="btn btn-primary" href="{{ url('admin/cau-hinh-bai-kiem-tra') }}">Về danh sách</a></p>
            <div class="card">
                <div class="card-header">
                    <h4>Thêm Cấu Hình Bài Kiểm Tra</h4>
                </div>
                <div class="card-body">
                    <div class="col-xs-4 col-xs-offset-4">
                        <form method="POST" action="{{ url('admin/cau-hinh-bai-kiem-tra/create') }}"
                            enctype="multipart/form-data">
                            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group">
                                <label for="school_year_id" style="color:#0093ff; font-weight:bold;">Năm Học</label>
                                <select class="form-control" id="school_year_id" name="school_year_id"
                                    style="color:#0093ff;">
                                    <!-- <option value="-1">Tất cả</option> -->
                                    @isset($school_years)
                                        @foreach ($school_years as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="subject_id" style="color:#0093ff; font-weight:bold;">Môn Học</label>
                                <select class="form-control" id="subject_id" name="subject_id" style="color:#0093ff;">
                                    @isset($subjects)
                                        <option value="-1" selected>Xin chọn môn học</option>
                                        @foreach ($subjects as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="class_id" style="color:#0093ff; font-weight:bold;">Lớp Học</label>
                                <select class="form-control" id="class_id" name="class_id" style="color:#0093ff;">
                                    <option value="-1" selected>Xin chọn lớp học</option>
                                    <!-- @isset($subjects)
                                                @foreach ($subjects as $item) <option value="{{ $item->id }}">{{ $item->name }}</option> @endforeach
                                        @endisset -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exam_id" style="color:#0093ff; font-weight:bold;">Bài Kiểm Tra</label>
                                <select class="form-control" id="exam_id" name="exam_id" style="color:#0093ff;">
                                    <option value="-1" selected>Xin chọn bài kiểm tra</option>
                                    <!-- @isset($subjects)
                                                @foreach ($subjects as $item) <option value="{{ $item->id }}">{{ $item->name }}</option> @endforeach
                                        @endisset -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="time_open" style="color:#0093ff; font-weight:bold;">Thời Gian Mở Bài KT</label>
                                <input type="text" class="form-control dc-date-time-picker" id="time_open" name="time_open"
                                    readonly="true" placeholder="Thời Gian Mở Bài KT" style="color:#0093ff;" />
                            </div>
                            <div class="form-group">
                                <label for="time_close" style="color:#0093ff; font-weight:bold;">Thời Gian Đóng Bài
                                    KT</label>
                                <input type="text" class="form-control dc-date-time-picker" id="time_close" readonly
                                    name="time_close" placeholder="Thời Gian Đóng Bài KT" style="color:#0093ff;" />
                            </div>
                            <div class="form-group">
                                <label for="time_close" style="color:#0093ff; font-weight:bold;">Thời Gian Làm Bài
                                    KT</label>
                                <div class="form-row">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <input type="number" class="form-control" min="1" id="time_limit" name="time_limit"
                                            placeholder="Thời Gian Làm Bài KT" style="color:#0093ff;" />
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label for="">(Phút)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="is_assessment"><input type="checkbox" class="" name="is_assessment"
                                        id="is_assessment"><b style="color:#0093ff;"> Có Đánh Giá Ngang
                                        Hàng</b></label><br />
                            </div>
                            <div class="form-group">
                                <label for="time_close" style="color:#0093ff; font-weight:bold;">Số Lượng Bài KT 1 Người
                                    Đánh Giá</label>
                                <div class="form-row">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <input type="number" class="form-control" min="1" id="assessment_quantity"
                                            name="assessment_quantity" placeholder="Số Lượng Đánh Giá"
                                            style="color:#0093ff;" />
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label for="">(Bài KT)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" style="color:#0093ff; font-weight:bold;">Hệ Số Đánh Giá</label>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"  style="text-align:center;">
                                            <label for="">Hệ Số 1</label>
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                            <input type=number step=0.01 id="ratio_1" name="ratio_1"
                                                class="form-control pa_ratio" placeholder="Hệ Số 1" value="0.6">
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"  style="text-align:center;">
                                            <label for="">Hệ Số 2</label>
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                            <input type=number step=0.01 id="ratio_2" name="ratio_2"
                                                class="form-control pa_ratio" placeholder="Hệ Số 2" value="0.2">
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="text-align:center;">
                                            <label for="">Hệ Số 3</label>
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                            <input type=number step=0.01 id="ratio_3" name="ratio_3"
                                                class="form-control pa_ratio" placeholder="Hệ Số 3" value="0.2">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="time_pa_open" style="color:#0093ff; font-weight:bold;">Thời Gian Mở Đánh
                                    Giá</label>
                                <input type="text" class="form-control dc-date-time-picker" id="time_pa_open"
                                    name="time_pa_open" readonly="true" placeholder="Thời Gian Mở Bài KT"
                                    style="color:#0093ff;" />
                            </div>
                            <div class="form-group">
                                <label for="time_pa_close" style="color:#0093ff; font-weight:bold;">Thời Gian Đóng Đánh
                                    Giá</label>
                                <input type="text" class="form-control dc-date-time-picker" id="time_pa_close" readonly
                                    name="time_pa_close" placeholder="Thời Gian Đóng Bài KT" style="color:#0093ff;" />
                            </div>


                            <div class="form-group">
                                <label for="status"><input type="checkbox" class="" name="status" id="status"
                                        checked="checked"><b style="color:#0093ff;"> Kích hoạt</b></label><br />
                            </div>
                            <center style="margin-top:1em;"><span id="btn_save_exam_class" class="btn btn-info btn-block"
                                    style="width:50%;">Lưu</span></center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        button.command-delete {
            color: #ff0000;
        }

        button.command-edit {
            color: #b5017f;
        }

        button.command-up {
            color: #00ad3b;
        }

        button.command-down {
            color: #d5a000;
        }

    </style>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.pa_ratio').keypress(function(event) {
                if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event
                        .which > 57)) {
                    event.preventDefault();
                }
            });


            $("#time_limit").on("keypress keyup blur", function(event) {
                $(this).val($(this).val().replace(/[^\d].+/, ""));
                if ((event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            });

            $('#time_open').datetimepicker({
                locale: 'vi',
                minDate: new Date(),
                format: "YYYY-MM-DD HH:mm:00",
                showClose: true,
                showClear: true,
                ignoreReadonly: true,
            });
            
            $('#time_close').datetimepicker({
                locale: 'vi',
                minDate: new Date(),
                format: "YYYY-MM-DD HH:mm:00",
                showClose: true,
                showClear: true,
                ignoreReadonly: true,
            });

            $('#time_pa_open').datetimepicker({
                locale: 'vi',
                minDate: new Date(),
                format: "YYYY-MM-DD HH:mm:00",
                showClose: true,
                showClear: true,
                ignoreReadonly: true,
            });
            $('#time_pa_close').datetimepicker({
                locale: 'vi',
                minDate: new Date(),
                format: "YYYY-MM-DD HH:mm:00",
                showClose: true,
                showClear: true,
                ignoreReadonly: true,
            });

            $("#school_year_id").change(function() {
                get_Class();
            });
            $("#subject_id").change(function() {
                get_Class();
                get_Exam();
            });
            $("#btn_save_exam_class").click(function() {
                school_year_id = $("#school_year_id").val();
                subject_id = $("#subject_id").val();
                class_id = $("#class_id").val();
                exam_id = $("#exam_id").val();
                time_open = $("#time_open").val();
                time_close = $("#time_close").val();
                time_limit = $("#time_limit").val();
                time_pa_open = $("#time_pa_open").val();
                time_pa_close = $("#time_pa_close").val();
                ratio_1 = $("#ratio_1").val();
                ratio_2 = $("#ratio_2").val();
                ratio_3 = $("#ratio_3").val();
                is_assessment = $("#is_assessment").is(":checked");
                assessment_quantity = $("#assessment_quantity").val();
                status = $("#status").is(":checked");
                console.log(time_open);
                console.log(time_close);
                if (subject_id == -1) {
                    $.alert({
                        title: "<strong class='alert-msg-success'>Warning!</strong>",
                        content: "Xin vui lòng chọn Môn Học",
                        type: "orange",
                        autoClose: "OK|3000",
                        buttons: {
                            OK: function() {}
                        },
                        onOpenBefore: function() {
                            $(".jconfirm-content").css("text-align",
                                "center");
                        },
                        onClose: function() {
                            $("#subject_id").focus();
                        },
                    });
                    return;
                }
                if (class_id == -1) {
                    $.alert({
                        title: "<strong class='alert-msg-success'>Warning!</strong>",
                        content: "Xin vui lòng chọn Lớp Học",
                        type: "orange",
                        autoClose: "OK|3000",
                        buttons: {
                            OK: function() {}
                        },
                        onOpenBefore: function() {
                            $(".jconfirm-content").css("text-align",
                                "center");
                        },
                        onClose: function() {
                            $("#class_id").focus();
                        },
                    });
                    return;
                }
                if (exam_id == -1) {
                    $.alert({
                        title: "<strong class='alert-msg-success'>Warning!</strong>",
                        content: "Xin vui lòng chọn Bài Kiểm Tra",
                        type: "orange",
                        autoClose: "OK|3000",
                        buttons: {
                            OK: function() {}
                        },
                        onOpenBefore: function() {
                            $(".jconfirm-content").css("text-align",
                                "center");
                        },
                        onClose: function() {
                            $("#exam_id").focus();
                        },
                    });
                    return;
                }

                if (trim(time_open) == "") {
                    $.alert({
                        title: "<strong class='alert-msg-success'>Warning!</strong>",
                        content: "Xin vui lòng chọn Thời Gian Mở Bài Kiểm Tra",
                        type: "orange",
                        autoClose: "OK|3000",
                        buttons: {
                            OK: function() {}
                        },
                        onOpenBefore: function() {
                            $(".jconfirm-content").css("text-align",
                                "center");
                        },
                        onClose: function() {
                            $("#time_open").focus();
                        },
                    });
                    return;
                }

                 if (trim(time_close) == "") {
                    $.alert({
                        title: "<strong class='alert-msg-success'>Warning!</strong>",
                        content: "Xin vui lòng chọn Thời Gian Đóng Bài Kiểm Tra",
                        type: "orange",
                        autoClose: "OK|3000",
                        buttons: {
                            OK: function() {}
                        },
                        onOpenBefore: function() {
                            $(".jconfirm-content").css("text-align",
                                "center");
                        },
                        onClose: function() {
                            $("#time_close").focus();
                        },
                    });
                    return;
                }

                if (new Date(time_close) < new Date(time_open)) {
                    $.alert({
                        title: "<strong class='alert-msg-success'>Warning!</strong>",
                        content: "Thời gian Mở/Đóng không hợp lệ",
                        type: "orange",
                        autoClose: "OK|3000",
                        buttons: {
                            OK: function() {}
                        },
                        onOpenBefore: function() {
                            $(".jconfirm-content").css("text-align",
                                "center");
                        },
                    });
                    return;
                }


                if (new Date(time_pa_close) < new Date(time_pa_open)) {
                    $.alert({
                        title: "<strong class='alert-msg-success'>Warning!</strong>",
                        content: "Thời gian Mở/Đóng Đánh Giá không hợp lệ",
                        type: "orange",
                        autoClose: "OK|3000",
                        buttons: {
                            OK: function() {}
                        },
                        onOpenBefore: function() {
                            $(".jconfirm-content").css("text-align",
                                "center");
                        },
                    });
                    return;
                }


                // if (new Date(time_close) > new Date(time_pa_open)) {
                //     $.alert({
                //         title: "<strong class='alert-msg-success'>Warning!</strong>",
                //         content: "Thời gian Mở Đánh Giá không hợp lệ",
                //         type: "orange",
                //         autoClose: "OK|3000",
                //         buttons: {
                //             OK: function() {}
                //         },
                //         onOpenBefore: function() {
                //             $(".jconfirm-content").css("text-align",
                //                 "center");
                //         },
                //     });
                //     return;
                // }

                $.ajax({
                    url: "{{ url('/admin/cau-hinh-bai-kiem-tra/luu-moi') }}",
                    data: {
                        school_year_id: school_year_id,
                        subject_id: subject_id,
                        class_id: class_id,
                        exam_id: exam_id,
                        time_open: time_open,
                        time_close: time_close,
                        time_pa_open: time_pa_open,
                        time_pa_close: time_pa_close,
                        time_limit: time_limit,
                        ratio_1: ratio_1,
                        ratio_2: ratio_2,
                        ratio_3: ratio_3,
                        status: status,
                        is_assessment:is_assessment,
                        assessment_quantity: assessment_quantity,
                    },
                    dataType: "json",
                    type: "POST",
                    cache: false,
                    beforeSend: function() {
                        $("body").addClass("loading");
                    },
                    complete: function() {
                        $("body").removeClass("loading");
                    },
                    success: function(response) {
                        switch (response.result) {
                            case 1:
                                $.alert({
                                    title: "<strong class='alert-msg-success'>Success!</strong>",
                                    content: response.msg,
                                    type: "green",
                                    autoClose: "OK|3000",
                                    buttons: {
                                        OK: function() {}
                                    },
                                    onOpenBefore: function() {
                                        $(".jconfirm-content").css("text-align",
                                            "center");
                                    },
                                });
                                break;
                            default:
                                $.alert({
                                    title: "<strong class='alert-msg-eror'>Error!</strong>",
                                    content: response.msg,
                                    type: "red",
                                    autoClose: "OK|3000",
                                    buttons: {
                                        OK: function() {}
                                    },
                                    onOpenBefore: function() {
                                        //$(".jconfirm-content").css("text-align", "center");
                                    },
                                });
                                break;
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        $.alert({
                            title: "<strong class='alert-msg-error'>Error!</strong>",
                            content: "Không kết nối được server!",
                            type: "red",
                            buttons: {
                                OK: function() {
                                    // location.reload();
                                }
                            },
                            onDestroy: function() {}
                        });
                    }
                });
            });

        });

        function get_Class() {
            var school_year_id = $("#school_year_id").val();
            var subject_id = $("#subject_id").val();
            if (school_year_id > 0 && subject_id > 0) {
                $.ajax({
                    url: "{{ url('/admin/cau-hinh-bai-kiem-tra/get_class') }}",
                    data: {
                        school_year_id: school_year_id,
                        subject_id: subject_id
                    },
                    dataType: "json",
                    type: "POST",
                    cache: false,
                    beforeSend: function() {
                        $("body").addClass("loading");
                    },
                    complete: function() {
                        $("body").removeClass("loading");
                    },
                    success: function(response) {
                        switch (response.result) {
                            case 1:
                                console.log(response.data);
                                $("#class_id").empty();
                                $('#class_id').append('<option value="-1">Xin chọn lớp</option>');
                                $.each(response.data, function(i, item) {
                                    console.log(response.data[i].name);
                                    $('#class_id').append('<option value="' + response.data[i].id +
                                        '">' +
                                        response.data[i].name + '</option>');
                                });
                                break;
                            default:
                                $.alert({
                                    title: "<strong class='alert-msg-eror'>Error!</strong>",
                                    content: response.msg,
                                    type: "red",
                                    autoClose: "OK|3000",
                                    buttons: {
                                        OK: function() {}
                                    },
                                    onOpenBefore: function() {
                                        $(".jconfirm-content").css("text-align", "center");
                                    },
                                });
                                break;
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        $.alert({
                            title: "<strong class='alert-msg-error'>Error!</strong>",
                            content: "Không kết nối được server!",
                            type: "red",
                            buttons: {
                                OK: function() {
                                    location.reload();
                                }
                            },
                            onDestroy: function() {}
                        });
                    }
                });
            } else {
                $("#class_id").empty();
                $('#class_id').append('<option value="-1">Xin chọn lớp</option>');
            }
        }

        function get_Exam() {
            var subject_id = $("#subject_id").val();
            if (subject_id > 0) {
                $.ajax({
                    url: "{{ url('/admin/cau-hinh-bai-kiem-tra/get_exam') }}",
                    data: {
                        subject_id: subject_id
                    },
                    dataType: "json",
                    type: "POST",
                    cache: false,
                    beforeSend: function() {
                        $("body").addClass("loading");
                    },
                    complete: function() {
                        $("body").removeClass("loading");
                    },
                    success: function(response) {
                        switch (response.result) {
                            case 1:
                                console.log(response.data);
                                $("#exam_id").empty();
                                $('#exam_id').append('<option value="-1">Xin chọn bài kiểm tra</option>');
                                $.each(response.data, function(i, item) {
                                    console.log(response.data[i].title);
                                    $('#exam_id').append('<option value="' + response.data[i].id +
                                        '">' +
                                        response.data[i].title + '</option>');
                                });
                                break;
                            default:
                                $.alert({
                                    title: "<strong class='alert-msg-eror'>Error!</strong>",
                                    content: response.msg,
                                    type: "red",
                                    autoClose: "OK|3000",
                                    buttons: {
                                        OK: function() {}
                                    },
                                    onOpenBefore: function() {
                                        $(".jconfirm-content").css("text-align", "center");
                                    },
                                });
                                break;
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        $.alert({
                            title: "<strong class='alert-msg-error'>Error!</strong>",
                            content: "Không kết nối được server!",
                            type: "red",
                            buttons: {
                                OK: function() {
                                    // location.reload();
                                }
                            },
                            onDestroy: function() {}
                        });
                    }
                });
            } else {
                $("#exam_id").empty();
                $('#exam_id').append('<option value="-1">Xin chọn bài kiểm tra</option>');
            }
        }
    </script>
@endsection
