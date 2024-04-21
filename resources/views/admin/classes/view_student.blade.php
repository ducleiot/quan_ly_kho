@extends('admin.admin_master')
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
<?php
    //Hiển thị thông báo lỗi
?>
@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <strong>{{ Session::get('error') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
    </button>
</div>
@endif
<div class="container-fluid" style="background-color: #fff; padding: 1em;">

    <br />
    <div class="asi-table-container">
        <div class="table-responsive">
            <table id="grid-data" class="table table-condensed table-hover table-striped">
                <thead>
                    <tr>
                        <th data-column-id="id" data-identifier="true" data-type="numeric" data-visible="false">ID</th>
                        <th data-column-id="last_name" data-headerAlign="center" data-align="left"
                        data-style="min-width:150px;">Họ</th>

                        <th data-column-id="first_name" data-headerAlign="center" data-align="center"
                        data-style="min-width:150px;">Tên</th>

                        <th data-column-id="sex" data-formatter="sex" data-headerAlign="center" data-align="center"
                        data-style="min-width:150px;">Giới Tính</th>

                        <th data-column-id="email" data-headerAlign="center" data-align="center"
                        data-style="min-width:150px;">Email</th>
                        
                        <th data-column-id="class_name" data-headerAlign="center" data-align="center"
                        data-style="min-width:150px;">Lớp Học</th>

                        <th data-column-id="school_year_name" data-headerAlign="center" data-align="center"
                        data-style="min-width:150px;">Năm Học</th>

                        <th data-column-id="commands" data-formatter="commands" data-sortable="false"
                        data-headerAlign="center" data-align="center" data-style="min-width:150px;">Function</th>
                        
                        <th data-column-id="created_by" data-headerAlign="center" data-align="center"
                        data-style="min-width:200px;">Người Tạo</th>
                        
                        <th data-column-id="created_at" data-headerAlign="center" data-align="center"
                        data-style="min-width:200px;">Ngày Tạo</th>
                        
                        <th data-column-id="updated_by" data-headerAlign="center" data-align="center"
                        data-visible="false" data-style="min-width:200px;">Người Sửa</th>

                        <th data-column-id="updated_at" data-headerAlign="center" data-align="center"
                        data-visible="false" data-style="min-width:200px;">Ngày Sửa</th>
                        <th data-column-id="exam_id" data-visible="false" data-style="min-width:1px;"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="img01">
        <div id="caption"></div>
    </div>
</div>
<script>
// $("#header-page-name").html("Quản Lý Bài Kiểm Tra");
// $(".admin-sidebar").removeClass("active");
// $("#tab-question").addClass("active")
var rowIds = [];
$(document).ready(function() {
    var APP_URL = {!! json_encode(url('/')) !!}
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var grid = $("#grid-data").bootgrid({
        templates: {
            select: ""
        },
        buttons: [{
            name: "  Thêm",
            bclass: "add btn-primary fa fa-plus",
            css: "margin-top:0.1em;",
            onpress: "process_action_add"
        },
        {
            name: "  Upload Excel File",
            css: "margin-top:0.1em;",
            bclass: "delete btn-success fa fa-upload",
            onpress: "process_action_import"
        },
        {
            name: "  Export DS",
            css: "margin-top:0.1em;",
            bclass: "delete btn-info fa fa-download",
            onpress: "process_action_export"
        },
        {
            name: '<a href="{{ asset("public/Mau_DS_Hoc_Sinh.xlsx") }}">Download File Excel Mẫu</a>'
        }

        // {
        //     name: "  Xóa",
        //     css: "margin-top:0.1em;",
        //     bclass: "delete btn-danger fa fa-trash",
        //     onpress: "process_action_delete"
        // }
        ],
        ajax: true,
        selection: true,
        multiSelect: true,
        rowCount:-1,
        //rowSelect : true,
        post: function() {
            return {
                id: "b0df282a-0d67-40e5-8558-c9e93b7befed",
                class_id: <?php echo $class_id; ?>
            };
        },
        url: "{{ url('/admin/ql-lop-hoc/get_data_student') }}",
        formatters: {
            "commands": function(column, row) {
                // return "<button title='Sửa' type=\"button\" class=\"bootgrid-btn btn-xs btn-default command-edit\" data-row-id=\"" +
                // row.id + "\"><span class=\"fa fa-edit  \"></span></button> " +
                // "<button title='Xóa' type=\"button\" class=\"bootgrid-btn btn-xs btn-default command-delete\" data-row-id=\"" +
                // row.id + "\"><span class=\"fa fa-trash \"></span></button>"
                  
                return "<button title='Sửa' type=\"button\" class=\"bootgrid-btn btn-xs btn-default command-edit\" data-row-id=\"" +
                row.id + "\"><span class=\"fa fa-edit  \"></span></button> " +
                "<button title='Xóa' type=\"button\" class=\"bootgrid-btn btn-xs btn-default command-delete\" data-row-id=\"" +
                            row.id + "\"><span class=\"fa fa-trash \"></span></button>"

                    ;
                },

                "sex": function(column, row) {
                    if (row.sex == 1) {
                        return "Nam";
                    } else {
                       if (row.sex == 0) {
                            return "Nữ";
                        }else{
                            return "";
                        }
                    }

                },

                // "status": function(column, row) {
                //     if (row.status == 1) {
                //         return "<button title='Hủy Kích Hoạt' type=\"button\" class=\"bootgrid-btn btn-xs btn-default status-enable command-status\" data-row-id=\"" +
                //         row.id + "\"><span class=\"fa fa-check  \"></span></button> ";
                //     } else {
                //         return "<button title='Kích Hoạt' type=\"button\" class=\"bootgrid-btn btn-xs btn-default status-disable command-status\" data-row-id=\"" +
                //         row.id + "\"><span class=\"fa fa-times  \"></span></button> ";
                //     }
                // },

        }
    }).on("loaded.rs.jquery.bootgrid", function() {
        /* Executes after data is loaded and rendered */
        $("#grid-data .command-edit").on("click", function(e) {
            var id = $(this).data("row-id");
            var link = 'admin/ql-lop-hoc/' + id + '/cap-nhat-hs/<?php echo $class_id ?>';
            // window.location.href = link;

           
            var class_id = <?php echo $class_id; ?>;
            //var link = 'admin/ql-lop-hoc/' + id + '/cap-nhat-hs/' + class_id;
            //alert(class_id);
            var confirm_dialog = $.confirm({
                title: "Cập Nhật Thông Tin Học Sinh",
                //closeIcon: true,
                content: "URL:" + link,
                type: "blue",
                columnClass: "col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12",
                draggable: true,
                buttons: {
                    Save: {
                        text: "&nbsp;&nbsp;Lưu&nbsp;&nbsp;",
                        btnClass: "btn-blue",
                        action: function() {
                            // alert("lưu");
                            
                            var last_name = $.trim($("#last_name").val());
                            if(last_name==""){
                                $.alert({
                                    title: "<strong class='alert-msg-warning'>Thông Báo!</strong>",
                                    content: "Họ Và Tên Đệm không hợp lệ!",
                                    type: "yellow",
                                    autoClose: "OK|3000",
                                    buttons: {
                                        OK: function() {
                                        }
                                    },
                                    onOpenBefore: function() {
                                    //  $(".jconfirm-content").css("text-align", "center");
                                    },
                                    onDestroy: function() {
                                        $("#last_name").focus();
                                    },
                                });

                                return false;
                            }

                            var first_name = $.trim($("#first_name").val());
                            if(first_name==""){
                                $.alert({
                                    title: "<strong class='alert-msg-warning'>Thông Báo!</strong>",
                                    content: "Tên không hợp lệ!",
                                    type: "yellow",
                                    autoClose: "OK|3000",
                                    buttons: {
                                        OK: function() {
                                        }
                                    },
                                    onOpenBefore: function() {
                                    // $(".jconfirm-content").css("text-align", "center");
                                    },
                                    onDestroy: function() {
                                        $("#first_name").focus();
                                    },
                                });
                                return false;
                            }

                            var date_of_birth = $("#date_of_birth").val();
                            if(date_of_birth==""){
                                $.alert({
                                    title: "<strong class='alert-msg-warning'>Thông Báo!</strong>",
                                    content: "Ngày Sinh không hợp lệ!",
                                    type: "yellow",
                                    autoClose: "OK|3000",
                                    buttons: {
                                        OK: function() {
                                        }
                                    },
                                    onOpenBefore: function() {
                                    // $(".jconfirm-content").css("text-align", "center");
                                    },
                                    onDestroy: function() {
                                        $("#date_of_birth").focus();
                                    },
                                });
                                return false;
                            }

                            var email = $.trim($("#email").val());
                            if(email==""){
                                $.alert({
                                    title: "<strong class='alert-msg-warning'>Thông Báo!</strong>",
                                    content: "Email không hợp lệ!",
                                    type: "yellow",
                                    autoClose: "OK|3000",
                                    buttons: {
                                        OK: function() {
                                        }
                                    },
                                    onOpenBefore: function() {
                                    // $(".jconfirm-content").css("text-align", "center");
                                    },
                                    onDestroy: function() {
                                        $("#email").focus();
                                    },
                                });
                                return false;
                            }


                            var password = $.trim($("#password").val());
                            // if(password==""){
                            //     $.alert({
                            //         title: "<strong class='alert-msg-warning'>Thông Báo!</strong>",
                            //         content: "Mật Khẩu không hợp lệ!",
                            //         type: "yellow",
                            //         autoClose: "OK|3000",
                            //         buttons: {
                            //             OK: function() {
                            //             }
                            //         },
                            //         onOpenBefore: function() {
                            //         // $(".jconfirm-content").css("text-align", "center");
                            //         },
                            //         onDestroy: function() {
                            //             $("#password").focus();
                            //         },
                            //     });
                            //     return false;
                            // }

                            phone_number = $.trim($("#phone_number").val());
                            address = $.trim($("#address").val());
                            //sex = $("#sex").is(":checked")?1:0;
                            sex = 0;
                            if($('#sex').is(":checked")){
                                sex = 1;
                            }
                            status = $("#status").is(":checked")?1:0;

                            <?php $link_save = 'admin/ql-lop-hoc/cap-nhat-hs' ?>
                            var link_save = "{{ url($link_save) }}";
                            console.log(link_save);
                            
                            $.ajax({
                                url: "{{ url($link_save) }}",
                                data: {
                                    id:id,
                                    class_id:class_id,
                                    first_name: first_name,
                                    last_name: last_name,
                                    sex:sex,
                                    date_of_birth:date_of_birth,
                                    email:email,
                                    password:password,
                                    phone_number:phone_number,
                                    address:address,
                                    status:status
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
                                                
                                            },
                                           
                                        });
                                        $("#grid-data").bootgrid("reload");
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
                                             
                                            },
                                            onDestroy: function() {
                                              return false;
                                            }
                                        });
                                        return false;
                                        break;
                                    }
                                   return false;
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
                                        onDestroy: function() {
                                            $("#grid-data").bootgrid("reload");
                                        }
                                    });
                                }
                            });
                            return false;
                        }
                    },
                    Cancel: {
                        text: "Thoát",
                        btnClass: "btn-dark",
                        action: function() {
                            confirm_dialog.close();
                        }
                    },
                },
                onContentReady: function() {
                    // $(".jsconfirm-button-container").remove();
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
        $("#grid-data .command-delete").on("click", function(e) {
            //alert("You pressed delete on row: " + $(this).data("row-id"));
            var id = $(this).data("row-id");
            var name = "";
            current_row = $("#grid-data").bootgrid("getCurrentRows").filter(
                function(elem) {
                    return elem.id == parseInt(id);
                }
                );
            $.confirm({
                title: "Thông Báo!",
                content: "Bạn Muốn Xóa Dòng Này?",
                buttons: {
                    Yes: {
                        text: "Yes",
                        btnClass: "btn-blue",
                        action: function() {
                            delete_many_row([id]);
                        }
                    },
                    No: function() {
                    }
                },
                onOpenBefore: function() {
                    $(".jconfirm-content").css("text-align", "center");
                },
            })
        });
        $("#grid-data .command-status").on("click", function(e) {
            //alert("You pressed delete on row: " + $(this).data("row-id"));
            var id = $(this).data("row-id");
            current_row = $("#grid-data").bootgrid("getCurrentRows").filter(
                function(elem) {
                    return elem.id == parseInt(id);
                }
                );
            if (current_row.length > 0) {
                status = current_row[0].status;
                if (status == 1) {
                    msg = "Bạn muốn hủy kích hoạt?";
                } else {
                    msg = "Bạn muốn kích hoạt?";
                }
                $.confirm({
                    title: "Thông Báo!",
                    content: msg,
                    buttons: {
                        Yes: {
                            text: "Yes",
                            btnClass: "btn-blue",
                            action: function() {
                                change_status(id, status);
                            }
                        },
                        No: function() {
                        }
                    },
                    onOpenBefore: function() {
                        $(".jconfirm-content").css("text-align", "center");
                    },
                });
            }
        });
    });
}); // end-documentReady
function process_action_add() {
    
    <?php $link = 'admin/ql-lop-hoc/'. $class_id .'/them-hs' ?>

        var class_id = <?php echo $class_id; ?>;
        //alert(class_id);
        var confirm_dialog = $.confirm({
            title: "Thêm Học Sinh",
            //closeIcon: true,
            content: "URL:{{ url($link) }}",
            type: "blue",
            columnClass: "col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12",
            draggable: true,
            buttons: {
                Save: {
                    text: "&nbsp;&nbsp;Lưu&nbsp;&nbsp;",
                    btnClass: "btn-blue",
                    action: function() {
                        // alert("lưu");
                        
                        var last_name = $.trim($("#last_name").val());
                        if(last_name==""){
                            $.alert({
                                title: "<strong class='alert-msg-warning'>Thông Báo!</strong>",
                                content: "Họ Và Tên Đệm không hợp lệ!",
                                type: "yellow",
                                autoClose: "OK|3000",
                                buttons: {
                                    OK: function() {
                                    }
                                },
                                onOpenBefore: function() {
                                  //  $(".jconfirm-content").css("text-align", "center");
                                },
                                onDestroy: function() {
                                    $("#last_name").focus();
                                },
                            });

                            return false;
                        }

                        var first_name = $.trim($("#first_name").val());
                        if(first_name==""){
                            $.alert({
                                title: "<strong class='alert-msg-warning'>Thông Báo!</strong>",
                                content: "Tên không hợp lệ!",
                                type: "yellow",
                                autoClose: "OK|3000",
                                buttons: {
                                    OK: function() {
                                    }
                                },
                                onOpenBefore: function() {
                                   // $(".jconfirm-content").css("text-align", "center");
                                },
                                onDestroy: function() {
                                    $("#first_name").focus();
                                },
                            });
                            return false;
                        }

                        var date_of_birth = $("#date_of_birth").val();
                        if(date_of_birth==""){
                            $.alert({
                                title: "<strong class='alert-msg-warning'>Thông Báo!</strong>",
                                content: "Ngày Sinh không hợp lệ!",
                                type: "yellow",
                                autoClose: "OK|3000",
                                buttons: {
                                    OK: function() {
                                    }
                                },
                                onOpenBefore: function() {
                                   // $(".jconfirm-content").css("text-align", "center");
                                },
                                onDestroy: function() {
                                    $("#date_of_birth").focus();
                                },
                            });
                            return false;
                        }

                        var email = $.trim($("#email").val());
                        if(email==""){
                            $.alert({
                                title: "<strong class='alert-msg-warning'>Thông Báo!</strong>",
                                content: "Email không hợp lệ!",
                                type: "yellow",
                                autoClose: "OK|3000",
                                buttons: {
                                    OK: function() {
                                    }
                                },
                                onOpenBefore: function() {
                                   // $(".jconfirm-content").css("text-align", "center");
                                },
                                onDestroy: function() {
                                    $("#email").focus();
                                },
                            });
                            return false;
                        }


                        var password = $.trim($("#password").val());
                        if(password==""){
                            $.alert({
                                title: "<strong class='alert-msg-warning'>Thông Báo!</strong>",
                                content: "Mật Khẩu không hợp lệ!",
                                type: "yellow",
                                autoClose: "OK|3000",
                                buttons: {
                                    OK: function() {
                                    }
                                },
                                onOpenBefore: function() {
                                   // $(".jconfirm-content").css("text-align", "center");
                                },
                                onDestroy: function() {
                                    $("#password").focus();
                                },
                            });
                            return false;
                        }

                        phone_number = $.trim($("#phone_number").val());
                        address = $.trim($("#address").val());
                        sex = $("#sex").is(":checked")?1:0;
                        status = $("#status").is(":checked")?1:0;

                        <?php $link_save = 'admin/ql-lop-hoc/them-hs' ?>
                        var link_save = "{{ url($link_save) }}";
                       // console.log(link_save);
                        
                        $.ajax({
                            url: "{{ url($link_save) }}",
                            data: {
                                class_id:class_id,
                                first_name: first_name,
                                last_name: last_name,
                                sex:sex,
                                date_of_birth:date_of_birth,
                                email:email,
                                password:password,
                                phone_number:phone_number,
                                address:address,
                                status:status
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
                                          //  $(".jconfirm-content").css("text-align", "center");
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
                                        onDestroy: function() {
                                            return false;
                                        }
                                    });
                                    return false;
                                    break;
                                }
                                $("#grid-data").bootgrid("reload");
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
                                    onDestroy: function() {
                                        $("#grid-data").bootgrid("reload");
                                    }
                                });
                            }
                        });

                        return false;
                    
                    }
                },
                Cancel: {
                    text: "Thoát",
                    btnClass: "btn-dark",
                    action: function() {
                        confirm_dialog.close();
                    }
                },
            },
            onContentReady: function() {
                // $(".jsconfirm-button-container").remove();
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
}

function downloadURI(uri, name) 
{
    var link = document.createElement("a");
    // If you don't know the name or want to use
    // the webserver default set name = ''
    link.setAttribute('download', name);
    link.href = uri;
    document.body.appendChild(link);
    link.click();
    link.remove();
}
function process_action_export() {
    <?php $link = 'admin/ql-lop-hoc/export-ds-hs' ?>
    var class_id = <?php echo $class_id; ?>;
    $.ajax({
        url: "{{ url($link) }}",
        data: {
            class_id:class_id,            
        },
        dataType: "json",
        type: "POST",
        cache: false,
        cache: false,
        beforeSend: function() {
            $("body").addClass("loading");
        },
        complete: function() {
            $("body").removeClass("loading");
        },
        success: function(response) {
            console.log( response);

            if(response.file_name!=""){
                downloadURI(response.file_name , "file");
            }
            

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
                        //  $(".jconfirm-content").css("text-align", "center");
                        },
                    });
                    
                    
                    

                break;
                case 2:
                    $.alert({
                        title: "<strong class='alert-msg-success'>Warning!</strong>",
                        content: response.msg,
                        type: "orange",
                        autoClose: "OK|3000",
                        buttons: {
                            OK: function() {
                            }
                        },
                        onOpenBefore: function() {
                        //  $(".jconfirm-content").css("text-align", "center");
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
                        onDestroy: function() {
                            return false;
                        }
                    });
                    return false;
                break;
            }
            $("#grid-data").bootgrid("reload");
        },

        error: function(xhr, ajaxOptions, thrownError) {
            $.alert({
                title: "<strong class='alert-msg-error'>Error!</strong>",
                content: "Không kết nối được server!",
                type: "red",
                buttons: {
                    OK: function() {
                    //  location.reload();
                    }
                },
                onDestroy: function() {
                    $("#grid-data").bootgrid("reload");
                }
            });
        }
    });
}

function process_action_import() {
    let selectedFile;
    console.log(window.XLSX);
    let data=[{
        "name":"jayanth",
        "data":"scd",
        "abc":"sdef"
    }]

    <?php $link = 'admin/ql-lop-hoc/'. $class_id .'/upload-hs' ?>

        var class_id = <?php echo $class_id; ?>;
        //alert(class_id);
        var confirm_dialog = $.confirm({
            title: "Upload Học Sinh",
            //closeIcon: true,
            content: "URL:{{ url($link) }}",
            type: "blue",
            columnClass: "col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12",
            draggable: true,
            buttons: {
                Save: {
                    text: "&nbsp;&nbsp;Upload&nbsp;&nbsp;",
                    btnClass: "btn-blue",
                    action: function() {
                        // alert("import");                      
                        var school_name = $.trim($("#school_name").val());
                        
                        if(school_name==""){
                            $.alert({
                                title: "<strong class='alert-msg-error'>Error!</strong>",
                                content: "Tên Trường không được trống!",
                                type: "red",
                                buttons: {
                                    OK: function() {
                                        //  location.reload();
                                    }
                                },
                                onDestroy: function() {
                                    $("#school_name").focus();
                                }
                            });

                            return false;
                        }
                        // XLSX.utils.json_to_sheet(data, 'out.xlsx');
                        if(selectedFile){
                            let fileReader = new FileReader();
                            fileReader.readAsBinaryString(selectedFile);
                            fileReader.onload = (event)=>{
                                let data = event.target.result;
                                let workbook = XLSX.read(data,{type:"binary"});
                                console.log(workbook);
                                let rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[workbook.SheetNames[0]]);
                            //  console.log(rowObject);
                                if(rowObject.length > 0){
                                    <?php $link_save = 'admin/ql-lop-hoc/upload-ds-hs' ?>
                                    var link_save = "{{ url($link_save) }}";

                                    var file_data = $('#upload_excel').prop('files')[0];   
                                    var form_data = new FormData();                  
                                    form_data.append('excel_file', file_data);
                                    form_data.append('class_id', class_id);
                                    form_data.append('school_name', school_name);

                                    $.ajax({
                                        url: "{{ url($link_save) }}",
                                        data: form_data,
                                        contentType:false,
                                        cache:false,
                                        processData:false,
                                    // dataType: "json",
                                        type: "POST",
                                        cache: false,
                                        beforeSend: function() {
                                            $("body").addClass("loading");
                                        },
                                        complete: function() {
                                            $("body").removeClass("loading");
                                        },
                                        success: function(response) {
                                            // console.log( response.arr_files);

                                            $.each( response.arr_files , function( key, value ) {
                                               // console.log( key + ": " + value );
                                                downloadURI(value , "file");
                                            });

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
                                                        //  $(".jconfirm-content").css("text-align", "center");
                                                        },
                                                    });
                                                    
                                                  
                                                  

                                                break;
                                                case 2:
                                                    $.alert({
                                                        title: "<strong class='alert-msg-success'>Warning!</strong>",
                                                        content: response.msg,
                                                        type: "orange",
                                                        autoClose: "OK|3000",
                                                        buttons: {
                                                            OK: function() {
                                                            }
                                                        },
                                                        onOpenBefore: function() {
                                                        //  $(".jconfirm-content").css("text-align", "center");
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
                                                        onDestroy: function() {
                                                            return false;
                                                        }
                                                    });
                                                    return false;
                                                break;
                                            }
                                            $("#grid-data").bootgrid("reload");
                                        },
                                        error: function(xhr, ajaxOptions, thrownError) {
                                            $.alert({
                                                title: "<strong class='alert-msg-error'>Error!</strong>",
                                                content: "Không kết nối được server!",
                                                type: "red",
                                                buttons: {
                                                    OK: function() {
                                                    //  location.reload();
                                                    }
                                                },
                                                onDestroy: function() {
                                                    $("#grid-data").bootgrid("reload");
                                                }
                                            });
                                        }
                                    });
                                    

                                }else
                                {
                                    $.alert({
                                        title: "<strong class='alert-msg-error'>Error!</strong>",
                                        content: "Excel file không hợp lệ!",
                                        type: "red",
                                        buttons: {
                                            OK: function() {
                                                //  location.reload();
                                            }
                                        },
                                        onDestroy: function() {
                                            $("#excel_file").focus();
                                        }
                                    });

                                    return false;
                                }                            
                            }
                        }else{
                            $.alert({
                                title: "<strong class='alert-msg-error'>Error!</strong>",
                                content: "Xin chọn Excel file!",
                                type: "red",
                                buttons: {
                                    OK: function() {
                                        //  location.reload();
                                    }
                                },
                                onDestroy: function() {
                                    $("#excel_file").focus();
                                }
                            });

                            return false;
                        }
                           
                      
                       // console.log(link_save);
                        
                        // $.ajax({
                        //     url: "{{ url($link_save) }}",
                        //     data: {
                        //         class_id:class_id,
                        //         first_name: first_name,
                        //         last_name: last_name,
                        //         sex:sex,
                        //         date_of_birth:date_of_birth,
                        //         email:email,
                        //         password:password,
                        //         phone_number:phone_number,
                        //         address:address,
                        //         status:status
                        //     },
                        //     dataType: "json",
                        //     type: "POST",
                        //     cache: false,
                        //     beforeSend: function() {
                        //         $("body").addClass("loading");
                        //     },
                        //     complete: function() {
                        //         $("body").removeClass("loading");
                        //     },
                        //     success: function(response) {
                        //         switch (response.result) {
                        //             case 1:
                        //             $.alert({
                        //                 title: "<strong class='alert-msg-success'>Success!</strong>",
                        //                 content: response.msg,
                        //                 type: "green",
                        //                 autoClose: "OK|3000",
                        //                 buttons: {
                        //                     OK: function() {
                        //                     }
                        //                 },
                        //                 onOpenBefore: function() {
                        //                   //  $(".jconfirm-content").css("text-align", "center");
                        //                 },
                        //             });
                        //             break;
                        //             default:
                        //             $.alert({
                        //                 title: "<strong class='alert-msg-eror'>Error!</strong>",
                        //                 content: response.msg,
                        //                 type: "red",
                        //                 autoClose: "OK|3000",
                        //                 buttons: {
                        //                     OK: function() {

                        //                     }
                        //                 },
                        //                 onOpenBefore: function() {
                        //                     //$(".jconfirm-content").css("text-align", "center");
                        //                 },
                        //                 onDestroy: function() {
                        //                     return false;
                        //                 }
                        //             });
                        //             return false;
                        //             break;
                        //         }
                        //         $("#grid-data").bootgrid("reload");
                        //     },
                        //     error: function(xhr, ajaxOptions, thrownError) {
                        //         $.alert({
                        //             title: "<strong class='alert-msg-error'>Error!</strong>",
                        //             content: "Không kết nối được server!",
                        //             type: "red",
                        //             buttons: {
                        //                 OK: function() {
                        //                     location.reload();
                        //                 }
                        //             },
                        //             onDestroy: function() {
                        //                 $("#grid-data").bootgrid("reload");
                        //             }
                        //         });
                        //     }
                        // });

                        return false;
                    
                    }
                },
                Cancel: {
                    text: "Thoát",
                    btnClass: "btn-dark",
                    action: function() {
                        confirm_dialog.close();
                    }
                },
            },
            onContentReady: function() {
                // $(".jsconfirm-button-container").remove();
                $(".jconfirm-buttons").css({
                    "width": "100%",
                    "text-align": "center"
                })

                document.getElementById('upload_excel').addEventListener("change", (event) => {
                                selectedFile = event.target.files[0];
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
}


function process_action_delete() {
    var arr_id = $("#grid-data").bootgrid("getSelectedRows");
    console.log(arr_id);
    if (arr_id.length > 0) {
        if (arr_id.length > 1) {
            content = "<p style='text-align:center;'>Bạn muốn xóa những dòng đã chọn?</p>";
        } else {
            content = "<p style='text-align:center;'>Bạn muốn xóa dòng này?</p>";
        }
        $.confirm({
            title: "Bạn Có Chắc!",
            content: content,
            buttons: {
                Yes: {
                    text: "Yes",
                    btnClass: "btn-blue",
                    action: function() {
                        delete_many_row(arr_id);
                    }
                },
                No: function() {}
            },
            onOpenBefore: function() {
                $(".jconfirm-content").css("text-align", "center");
            },
        })
    } else {
        $.alert({
            title: "<strong class='alert-msg-warning'>Thông Báo!</strong>",
            content: "Xin chọn dòng dữ liệu cần xóa!",
            type: "yellow",
            autoClose: "OK|3000",
            buttons: {
                OK: function() {
                }
            },
            onOpenBefore: function() {
                $(".jconfirm-content").css("text-align", "center");
            },
        });
    }
}
/*
Delete many template
*/
function delete_many_row(arr_id) {
    <?php $link_delete = 'admin/ql-lop-hoc/'. $class_id .'/xoa-hs' ?>
    $.ajax({
        url: "{{ url($link_delete) }}",
        data: {
            id: arr_id
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
                        $(".jconfirm-content").css("text-align", "center");
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
                        $(".jconfirm-content").css("text-align", "center");
                    },
                });
                break;
            }
            $("#grid-data").bootgrid("reload");
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
                onDestroy: function() {
                    $("#grid-data").bootgrid("reload");
                }
            });
        }
    });
}
function change_status(id, status) {
    new_status = status == 1 ? 0 : 1;
    $.ajax({
        url: "{{ url('/admin/ql-lop-hoc/status') }}",
        data: {
            id: id,
            status: new_status
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
                    content: "<p class='text-center'>" + response.msg + "</p>",
                    type: "green",
                    autoClose: "OK|3000",
                    buttons: {
                        OK: function() {
                            return true;
                        }
                    },
                    onDestroy: function() {
                        return true;
                    }
                });
                break;
                default:
                $.alert({
                    title: "<strong class='alert-msg-eror'>Error!</strong>",
                    content: "<p class='text-center'>" + response.msg + "</p>",
                    type: "red",
                    autoClose: "OK|3000",
                    buttons: {
                        OK: function() {}
                    },
                    onDestroy: function() {
                        return false;
                    }
                });
                break;
            }
            $("#grid-data").bootgrid("reload");
        },
        error: function(xhr, ajaxOptions, thrownError) {
            $.alert({
                title: "<strong class='alert-msg-error'>Error!</strong>",
                content: "<p class='text-center'>Connect to server fail. Please reload page and try again!</p>",
                type: "red",
                autoClose: "OK|3000",
                buttons: {
                    OK: function() {
                        // location.reload();
                    }
                },
                onDestroy: function() {
                    // location.reload();
                },
            });
            $("#grid-data").bootgrid("reload");
        }
    });
    return false;
}
</script>
<style>
#grid-data tbody tr:hover {
    color: #3147f7 !important;
    background-color: rgba(0, 141, 168, 0.08) !important;
}
</style>
@endsection
