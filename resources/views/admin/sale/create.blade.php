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
            <p><a class="btn btn-primary" href="{{ url('admin/ql-ban-hang') }}">Về danh sách</a></p>
            <div class="card">
                <div class="card-header">
                    <h4>BÁN HÀNG</h4>
                </div>
                <div class="card-body">
                    <div class="col-xs-4 col-xs-offset-4">
                        <form method="POST" action="{{ url('admin/ql-ban-hang/create') }}"
                            enctype="multipart/form-data">
                            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group">
                                <label for="customer_id" style="color:#0093ff; font-weight:bold;">Khách Hàng</label>
                                    <select class="form-control" id="customer_id" name = "customer_id">
                                        <option value="">Xin Chọn Khách Hàng</option>
                                        @if(isset($data_customers) && count($data_customers) > 0)
                                            @if(isset($data) && $data!=null)
                                                @foreach ($data_customers as $key => $item)
                                                    @if($data[0]->customer_id == $item->id)
                                                        <option value="{{ $item->id }}" selected="selected">{{ $item->last_name . " " . $item->first_name }}</option>
                                                    @else
                                                        <option value="{{ $item->id }}">{{ $item->last_name . " " . $item->first_name }}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach ($data_customers as $key => $item)
                                                    <option value="{{ $item->id }}">{{ $item->last_name . " " . $item->first_name }}</option>
                                                @endforeach
                                            @endif
                                        @endif
                                    </select>

                            </div>

                              <div class="form-group">
                                <label for="employee_id" style="color:#0093ff; font-weight:bold;">Nhân Viên</label>
                                    <select class="form-control" id="employee_id" name = "employee_id">
                                        <option value="">Xin Chọn Nhân Viên</option>
                                        @if(isset($data_employees) && count($data_employees) > 0)
                                            @if(isset($data) && $data!=null)
                                                @foreach ($data_employees as $key => $item)
                                                    @if($data[0]->employee_id == $item->id)
                                                        <option value="{{ $item->id }}" selected="selected">{{ $item->last_name . " " . $item->first_name }}</option>
                                                    @else
                                                        <option value="{{ $item->id }}">{{ $item->last_name . " " . $item->first_name }}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach ($data_employees as $key => $item)
                                                    <option value="{{ $item->id }}">{{ $item->last_name . " " . $item->first_name }}</option>
                                                @endforeach
                                            @endif
                                        @endif
                                    </select>

                            </div>

                            <div class="form-group">
                                <label for="title" style="color:#0093ff; font-weight:bold;">Ngày Bán Hàng</label>
                                <input type="text" placeholder="dd-mm-yyyy" value="" class="form-control" id="date" name="date">
                            </div>


                            <div class="form-group">
                                <label for="note" style="color:#0093ff; font-weight:bold;">Ghi Chú</label>
                                <textarea type="text" class="form-control" id="note" name="note" placeholder="Ghi Chú"></textarea>
                            </div>


                            <div class="asi-table-container">
                                <div class="table-responsive">
                                    <div class="container" style="padding: 1em; 0.5em;">
                                        <span class="btn btn-primary" id="mc-btn-add-product">Thêm Sản Phẩm</span>
                                    </div>
                                    <table id="grid-data-add-question"
                                        class="grid-data table table-condensed table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th data-column-id="idx" data-style="max-width:20px;">#</th>
                                                <th data-column-id="product_name" data-style="min-width:400px;" data-visible="false">Sản Phẩm</th>
                                                <th data-column-id="mark" data-style="min-width:100px;" data-visible="false" data-headerAlign="center" data-align="right">Số Lượng</th>
                                                <th data-column-id="mark" data-style="min-width:100px;" data-visible="false" data-headerAlign="center" data-align="right">Loại Bao</th>
                                                <th data-column-id="mark" data-style="min-width:100px;" data-visible="false" data-headerAlign="center" data-align="right">ĐVT</th>
                                                <th data-column-id="mark" data-style="max-width:100px;" data-visible="false" data-headerAlign="center" data-align="right">Giá</th>
                                                <th data-column-id="mark" data-style="min-width:100px;" data-visible="false" data-headerAlign="center" data-align="right">Thành Tiền</th>
                                                <th data-column-id="commands" data-formatter="commands" data-sortable="false" data-headerAlign="center" data-align="center"
                                                    data-style="min-width:150px;">Function</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <center style="margin-top:1em;"><span id="btn_save_question" class="btn btn-info btn-block"
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

        var data = [];
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery('#date').datetimepicker({
                format: 'YYYY/MM/DD',
                minDate: "2020/01/01",
            });

            LoadSaleDatas(data);

            $("#btn_save_question").click(function() {
                console.log("btn_save_question");
                customer_id = $.trim($("#customer_id").val());
                employee_id = $.trim($("#employee_id").val());
                date = $("#date").val();
                note = $("#note").val();

                console.log({
                    customer_id: customer_id,
                    employee_id: employee_id,
                    date: date,
                    note: note,
                    data: data
                });

                if (customer_id=="" || $.isNumeric(customer_id)!=true ){
                    $.alert({
                        title: "<strong class='alert-msg-success'>Warning!</strong>",
                        content: "<p style='text-align:center;'>Xin chọn Khách Hàng!</p>",
                        type: "orange",
                        autoClose: "OK|3000",
                        buttons: {
                            OK: function() {

                            }
                        },
                        onOpenBefore: function() {
                        // $(".jconfirm-content").css("text-align","center");
                        },
                        onDestroy:function(){
                            $("#customer_id").focus();
                        }
                    });                   
                    return false;
                }


                if (employee_id=="" || $.isNumeric(employee_id)!=true ){
                    $.alert({
                        title: "<strong class='alert-msg-success'>Warning!</strong>",
                        content: "<p style='text-align:center;'>Xin chọn Nhân Viên!</p>",
                        type: "orange",
                        autoClose: "OK|3000",
                        buttons: {
                            OK: function() {

                            }
                        },
                        onOpenBefore: function() {
                        // $(".jconfirm-content").css("text-align","center");
                        },
                        onDestroy:function(){
                            $("#employee_id").focus();
                        }
                    });     
                    return false;
                }


                if (date==""){
                    $.alert({
                        title: "<strong class='alert-msg-success'>Warning!</strong>",
                        content: "<p style='text-align:center;'>Xin chọn Ngày Bán!</p>",
                        type: "orange",
                        autoClose: "OK|3000",
                        buttons: {
                            OK: function() {

                            }
                        },
                        onOpenBefore: function() {
                        // $(".jconfirm-content").css("text-align","center");
                        },
                        onDestroy:function(){
                            $("#date").focus();
                        }
                    });    

                    return false;
                }

                //if(data.length<=0){
                //    $.alert({
                //        title: "<strong class='alert-msg-success'>Warning!</strong>",
                //        content: "<p style='text-align:center;'>Xin chọn Thêm Sản Phẩm!</p>",
                        // type: "orange",
                //         autoClose: "OK|3000",
                //         buttons: {
                //             OK: function() {

                //             }
                //         },
                //         onOpenBefore: function() {
                //         // $(".jconfirm-content").css("text-align","center");
                //         },
                //         onDestroy:function(){
                //             $("#mc-btn-add-product").focus();
                //         }
                //     });   

                  
                //     return false;
                // }

               

                
                $.ajax({
                    url: "{{ url('/admin/ql-ban-hang/save') }}",
                    data: {
                        customer_id: customer_id,
                        employee_id: employee_id,
                        date: date,
                        note: note,
                        data: data
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
                                        OK: function() {

                                        }
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
                                        OK: function() {

                                        }
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
                            onDestroy: function() {

                            }
                        });
                    }
                });

            });

            $("#mc-btn-add-product").click(function() {
                question_data_edit = undefined;
                var confirm_dialog = $.confirm({
                    title: "Bán Hàng",
                    //closeIcon: true,
                    content: "URL:/admin/ql-ban-hang/them-hang",
                    type: "blue",
                    columnClass: "col-lg-12 col-lg-offset-0 col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0 col-xs-12",
                    draggable: true,
                    buttons: {
                        
                        Cancel: {
                            text: "Thoát",
                            btnClass: "btn-dark",
                            action: function() {
                                confirm_dialog.close();
                            }
                        },
                        Save: {
                            text: "&nbsp;&nbsp;Lưu&nbsp;&nbsp;",
                            btnClass: "btn-blue",
                            action: function() {
                                // alert("lưu");
                                var tmp = getData(data.length + 1);
                                if(tmp!=false){
                                    data = mergeData(tmp, data);
                                    //data.push(tmp);
                                    console.log(data);
                                    LoadSaleDatas(data);
                                    confirm_dialog.close();
                                }else{
                                    return false;
                                }
                            }
                        },
                    },
                    onContentReady: function() {
                        $(".jsconfirm-button-container").remove();
                        $(".jconfirm-buttons").css({
                            "width": "100%",
                            "text-align": "center"
                        })

                    },
                    contentLoaded: function(data, status, xhr) {
                        // when content is fetched
                        //alert('contentLoaded: ' + status);
                    },
                    onOpenBefore: function() {
                        //$(".jconfirm-buttons").addClass("jsconfirm-button-container")
                        // before the modal is displayed.
                        //alert('onOpenBefore');
                    },
                    onOpen: function() {
                        // after the modal is displayed.
                        //alert('onOpen');
                    },
                    onClose: function() {
                        // before the modal is hidden.
                        //alert('onClose');
                    },
                    onDestroy: function() {
                        // when the modal is removed from DOM
                        //alert('onDestroy');
                    },
                    onAction: function(btnName) {
                        // when a button is clicked, with the button name
                        //alert('onAction: ' + btnName);
                    },

                });
            });

            initFunction();

        });

        // function getDate(){
        //     var today = new Date();
        //     document.getElementById("date").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        // }


        $('.txt-float-value').keypress(function(event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        function mergeData(item, data){
            console.log("mergeData");
            console.log(data);
            console.log(item);
            // var product_type_id = $("#product_type_id").val();
            // var product_id = $("#product_id").val();
            // var package_id = $("#package_id").val();
            // var package_name = $("#package_id :selected").text();
            // var color_id = $("#color_id").val();
            // var color_name = $("#color_id :selected").text();
            // var name = $("#product_id :selected").text() ;
            // var qty = $("#quantity").val();
            // var unit = $("#unit").val();
            // var price = $("#price").val();

            var obj = data.find(o => o.product_id === item["product_id"] 
                                && o.package_id===item["package_id"]
                                && o.color_id===item["color_id"]
                                && o.price===item["price"]
            );
            console.log(obj);

            var idx = data.findIndex(o => o.product_id === item["product_id"] 
                                && o.package_id===item["package_id"]
                                && o.color_id===item["color_id"]
                                && o.price===item["price"]
            );
            console.log(idx);
            if(idx>-1 && typeof obj != "undefined"){
                obj["qty"] = +obj["qty"] + +item["qty"];
                data[idx] = obj;
            }else{
                data.push(item);
            }
            return(data);

        }

        function initFunction() {
            $(".command-delete").click(function() {
                var idx = $(this).parent().parent().data("idx");
                $.confirm({
                    title: 'Confirm!',
                    content:"Bạn muốn xoá dòng này?",
                    buttons: {
                        Yes:  {
                            text: "Yes",
                            btnClass: "btn-blue",
                            action: function() {
                                if (data.length > 0) {
                                    for (i = 0; i < data.length; i++) {
                                        if (data[i].idx == idx) {
                                            data.splice(i, 1);
                                            break;
                                        }
                                    }
                                }
                                $.each(data, function(key, value) {
                                    value.idx = key + 1;
                                });
                                LoadSaleDatas(data);
                            }
                        },
                        No: function () {

                        }
                    }
                });

            });

            $(".command-edit").click(function() {
                idx = $(this).parent().parent().data("idx");
                if (data.length > 0) {
                    question_data_edit= undefined;
                    question_data_edit = data.filter(function(object) {
                        if(object.idx == idx){
                            return object;
                        }
                    });
                    // alert(idx);
                    // console.log(question_data_edit);

                    var confirm_dialog_edit = $.confirm({
                        title: false,
                        content: "URL:/admin/ql-ban-hang/them-hang",
                        type: "blue",
                        columnClass: "col-lg-12 col-lg-offset-0 col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0 col-xs-12",
                        draggable: true,
                        buttons: {                          
                            Cancel: {
                                text: "Thoát",
                                btnClass: "btn-dark",
                                action: function() {
                                    confirm_dialog_edit.close();
                                }
                            },

                            Save: {
                                text: "Lưu",
                                btnClass: "btn-blue",
                                action: function() {
                                    var tmp = getData(question_data_edit[0]["idx"]);
                                     if(tmp!=false){
                                       //if(data.length)
                                        $.each(data, function(key, value) {
                                            if (value["idx"] == question_data_edit[0]["idx"])
                                            {
                                                data[key] = tmp;
                                            }
                                        });
                                        //data.push(tmp);
                                        console.log(data);
                                        LoadSaleDatas(data);
                                        //return false;
                                        confirm_dialog_edit.close();
                                    }else{
                                        return false;
                                    }

                                }
                            },
                        },
                        onContentReady: function() {
                            $(".jsconfirm-button-container").remove();

                            $(".jconfirm-buttons").css({
                                "width": "100%",
                                "text-align": "center"
                            });


                             $("#product_type_id").change(function() {
                                get_Products();
                            });


                            if(question_data_edit!= undefined && question_data_edit.length > 0){
                               // alert("get produc");
                               console.log(question_data_edit[0]["product_type_id"]);
                               $("#product_type_id").val(question_data_edit[0]["product_type_id"]).change();
                                //get_Products();
                                //$("#product_id").val(question_data_edit[0]["product_id"]);
                            }





                        },
                        contentLoaded: function(data, status, xhr) {
                            // when content is fetched
                            //alert('contentLoaded: ' + status);

                            //  if(question_data_edit!= undefined && question_data_edit.length > 0){
                            //    // alert("get produc");
                            //    console.log(question_data_edit[0]["product_type_id"]);
                            //     $("#product_type_id").val(question_data_edit[0]["product_type_id"]);
                            //     get_Products();
                            // }


                        },
                        onOpenBefore: function() {
                            //$(".jconfirm-buttons").addClass("jsconfirm-button-container")
                            // before the modal is displayed.
                            //alert('onOpenBefore');
                        },
                        onOpen: function() {
                            // after the modal is displayed.
                            //alert('onOpen');

                        },
                        onClose: function() {
                            // before the modal is hidden.
                            //alert('onClose');
                        },
                        onDestroy: function() {
                            // when the modal is removed from DOM
                            //alert('onDestroy');
                        },
                        onAction: function(btnName) {
                            // when a button is clicked, with the button name
                            //alert('onAction: ' + btnName);
                        },

                    });

                }


            });
        }


        function LoadSaleDatas(data) {
            row = "";
            $.each(data, function(key, value) {
                //if(value["question_type"]=="0"){
                row = row + "<tr data-idx=\"" + value["idx"] + "\">";
                row = row + "<td>" + value["idx"] + "</td>";

                row = row + "<td>";
                row = row + value["name"];
                row = row + "</td>";
                row = row + "<td>" + value["qty"] + "</td>";
                row = row + "<td>" + value["package_name"] + "</td>";
                row = row + "<td>" + value["unit"] + "</td>";
                row = row + "<td>" + value["price"] + "</td>";
                row = row + "<td>" + value["total"] + "</td>";
                row = row + "<td>";
                row = row +
                    "<button title=\"Xóa\" type=\"button\" class=\"bootgrid-btn btn-xs btn-default command-edit\" data-row-id=\"1\"><span class=\"fa fa-edit \"></span></button>";
                row = row +
                    "<button title=\"Xóa\" type=\"button\" class=\"bootgrid-btn btn-xs btn-default command-delete\" data-row-id=\"1\"><span class=\"fa fa-trash \"></span></button>";
                row = row + "</td>";
                row = row + "</tr>";
                //}
            });

            $("#grid-data-add-question tbody").html(row);

            initFunction();
        }

    </script>

@endsection
