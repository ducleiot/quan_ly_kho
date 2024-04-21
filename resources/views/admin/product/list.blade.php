@extends('admin.admin_master')
@section('content')
<?php //Hiển thị thông báo thành công?>
@if ( Session::has('success') )
	<div class="alert alert-success alert-dismissible" role="alert">
		<strong>{{ Session::get('success') }}</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			<span class="sr-only">Close</span>
		</button>
	</div>
@endif

<?php //Hiển thị thông báo lỗi?>
@if ( Session::has('error') )
	<div class="alert alert-danger alert-dismissible" role="alert">
		<strong>{{ Session::get('error') }}</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			<span class="sr-only">Close</span>
		</button>
	</div>
@endif


<div class="container-fluid" style="background-color: #fff; padding: 1em;">
    <div class="container">
        <h4 style="text-align:center; color:#0090d2; font-weight: bold;">DANH SÁCH SẢN PHẨM</h4>
    </div>
    <div class="asi-table-container">
        <div class="table-responsive">
            <table id="grid-data" class="table table-condensed table-hover table-striped">
                <thead>
                    <tr>
                        <th data-column-id="id" data-identifier="true" data-type="numeric" data-visible="false">ID</th>
                        <th data-column-id="name"  data-headerCssClass="eidColumn" >Tên SP</th>
                             <th data-column-id="commands"  data-formatter="commands" data-sortable="false"  data-headerAlign="center" data-align="center">Function</th>
                        <th data-column-id="product_type_name" >Loại SP</th>
                        {{-- <th data-column-id="package_name"   >Loại Bao</th>
                        <th data-column-id="color_name"   >Màu Bao</th>
                        <th data-column-id="quantity" >Số Lượng</th> --}}
                        <th data-column-id="unit" >ĐVT</th>
                        <th data-column-id="description" >Mô Tả</th>
                        <th data-column-id="status" data-formatter="status" >Trạng Thái</th>

                        <th data-column-id="created_by" data-visible="false">Người Tạo</th>
                        <th data-column-id="created_at" data-visible="false">Ngày Tạo</th>
                        <th data-column-id="updated_by" data-visible="false">Người Sửa</th>
                        <th data-column-id="updated_at" data-visible="false">Ngày Sửa</th>

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


<style type="text/css">
    .eidColumn
    {
        width: 380px !important;

    }
</style>

<script>
  
  
  // $("#header-page-name").html("Quản Lý Bài Kiểm Tra");
    
    // $(".admin-sidebar").removeClass("active");
    // $("#tab-question").addClass("active")


    var rowIds = [];
    $(document).ready(function(){

        $.ajaxSetup({
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		   
	    var grid = $("#grid-data").bootgrid({
	        templates : { select : ""},
	        buttons: [{
                        name: "  Thêm",
                        bclass: "add btn-primary fa fa-plus",
                        onpress: "process_action_add"
                    },
                    {
                        name: "  Xóa",
                        bclass: "delete btn-danger fa fa-trash",
                        onpress: "process_action_delete"
                    }


	        ],
	        ajax        : true,
          	selection   : true,
    		multiSelect : true,
	        //rowSelect : true,
	        post : function ()
	        {
	            return {
	                id : "b0df282a-0d67-40e5-8558-c9e93b7befed"
	            };
	        },
	        url        : "{{ url('/admin/ql-san-pham/get_data') }}" ,
	        formatters : {
	            "commands" : function(column, row)
	            {
	              
                    return "<button title='Sửa' type=\"button\" class=\"bootgrid-btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-edit  \"></span></button> " +
	                       "<button title='Xóa' type=\"button\" class=\"bootgrid-btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-trash \"></span></button>";
	                
	            },
	            "status" : function(column, row){
	             	if(row.status==1){
	             		return "<button title='Hủy Kích Hoạt' type=\"button\" class=\"bootgrid-btn btn-xs btn-default status-enable command-status\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-check  \"></span></button> ";
	             	}else{
						return "<button title='Kích Hoạt' type=\"button\" class=\"bootgrid-btn btn-xs btn-default status-disable command-status\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-times  \"></span></button> ";
	             	}
	            },
	           "image_url" : function(column, row){
                    // return "<img onclick='MymodalImage(this);' alt='"+row.slogan_title+"' src='/local/public/upload/slide/"+ row.image_url +"' style='cursor: zoom-in;' width='60'/>";
                     return "<img onclick='MymodalImage(this);' alt='"+row.slogan_title+"' src='"+ row.image_url +"' style='cursor: zoom-in;' width='60'/>";
               },
	        }
	   }).on("loaded.rs.jquery.bootgrid", function(){
        	/* Executes after data is loaded and rendered */
            $("#grid-data .command-edit").on("click", function(e){
                var id   = $(this).data("row-id");
                open(id);
        });


	   $("#grid-data .command-delete").on("click", function(e)
        {
            //alert("You pressed delete on row: " + $(this).data("row-id"));
            var id       = $(this).data("row-id");
            var name     = "";
            current_row  = $("#grid-data").bootgrid("getCurrentRows").filter(
                function ( elem ) {
				   return elem.id == parseInt(id);
			    }
            );

            // if(current_row.length > 0){
            //     name = current_row[0].name;
            // }

            $.confirm({
                title:   "Thông Báo!",
                content: "Bạn Muốn Xóa Dòng Này?",
                buttons: {
                        Yes: {
                            text:     "Yes",
                            btnClass: "btn-blue",
                            action: function () {
                                delete_many_row([id]);
                            }
                        },
                        No:function(){

                        }
                },
                onOpenBefore: function () {
                  $(".jconfirm-content").css("text-align","center");
                },
            })
        });

  $("#grid-data .command-status").on("click", function(e)
        {
            //alert("You pressed delete on row: " + $(this).data("row-id"));
            var id   = $(this).data("row-id");
        
            current_row  = $("#grid-data").bootgrid("getCurrentRows").filter(
                    function ( elem ) {
					   return elem.id == parseInt(id);
				    }
            );

            if(current_row.length > 0){
                status = current_row[0].status;
            if(status == 1){
            	msg = "Bạn muốn hủy kích hoạt?";
            }else{
            	msg = "Bạn muốn kích hoạt?";
            }

	            $.confirm({
	                title:   "Thông Báo!",
	                content: msg,
	                buttons: {
	                        Yes: {
	                            text:     "Yes",
	                            btnClass: "btn-blue",
	                            action: function () {
	                                change_status(id, status);
	                            }
	                        },
	                        No:function(){

	                        }
	                },
	                onOpenBefore: function () {
	                  $(".jconfirm-content").css("text-align","center");
	                },
	            });
			}

        });

    });
});

// function process_action_add(){
//     window.location.href = "{{ url('admin/ql-mon-hoc/create') }}";
// }

function process_action_add(){
    open(-1);
}


function open(id){
    var name = "Thêm Mới";
    var link = 'admin/ql-san-pham/' + id + 'open';
    form =  $.confirm({
        title:       name,
        content:     "URL:{{ url('/admin/ql-san-pham/open') }}" + "/" + id,
        type:        "blue",
        columnClass: "col-lg-8 col-lg-offset-2  col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12",
        draggable:   true,
        buttons: {

            CloseForm:{
                text:     "Thoát",
                btnClass: "btn",
                action: function () {
                    form.close();
                }
            },
             formSubmit: {
                text:     "Lưu",
                btnClass: "btn-blue",
                action: function () {
                    save(id);
                    return false;
                }
            },

        },
        onDestroy:function(){
            $("#grid-data").bootgrid("reload");
        },
    });
}


function save(id){
    var name = $.trim($("#name").val());
    if (name==""){
        $.confirm({
            title:   "Warning",
            content: "<p class='text-center'Tên Sản Phẩm không được trống!</p>",
            type:    "orange",
            buttons:{
                Yes: {
                    text:     "OK",
                    btnClass: "btn-blue",
                    action:   function () {
                    }
                }
            },
            onDestroy:function(){
                $("#name").focus();
                return false;
            }
        });
        return false;
    }

    var product_type_id = ($("#product_type_id").val());
    if (product_type_id==""){
        $.confirm({
            title:   "Warning",
            content: "<p class='text-center'Xin chọn loại sản phẩm!</p>",
            type:    "orange",
            buttons:{
                Yes: {
                    text:     "OK",
                    btnClass: "btn-blue",
                    action:   function () {
                    }
                }
            },
            onDestroy:function(){
                $("#product_type_id").focus();
                return false;
            }
        });
        return false;
    }

    // var  package_id = ($("#package_id").val());
    // if (package_id==""){
    //     $.confirm({
    //         title:   "Warning",
    //         content: "<p class='text-center'Xin chọn loại bao!</p>",
    //         type:    "orange",
    //         buttons:{
    //             Yes: {
    //                 text:     "OK",
    //                 btnClass: "btn-blue",
    //                 action:   function () {
    //                 }
    //             }
    //         },
    //         onDestroy:function(){
    //             $("#package_id").focus();
    //             return false;
    //         }
    //     });
    //     return false;
    // }

    // var color_id = ($("#color_id").val());
    // if (color_id==""){
    //     $.confirm({
    //         title:   "Warning",
    //         content: "<p class='text-center'Xin chọn màu bao!</p>",
    //         type:    "orange",
    //         buttons:{
    //             Yes: {
    //                 text:     "OK",
    //                 btnClass: "btn-blue",
    //                 action:   function () {
    //                 }
    //             }
    //         },
    //         onDestroy:function(){
    //             $("#color_id").focus();
    //             return false;
    //         }
    //     });
    //     return false;
    // }

    // var qty = $.trim($("#quantity").val());
    // if (qty==""){
    //     $.confirm({
    //         title:   "Warning",
    //         content: "<p class='text-center'Xin nhập số lượng!</p>",
    //         type:    "orange",
    //         buttons:{
    //             Yes: {
    //                 text:     "OK",
    //                 btnClass: "btn-blue",
    //                 action:   function () {
    //                 }
    //             }
    //         },
    //         onDestroy:function(){
    //             $("#quantity").focus();
    //             return false;
    //         }
    //     });
    //     return false;
    // }

  var unit = $.trim($("#unit").val());
    if (unit==""){
        $.confirm({
            title:   "Warning",
            content: "<p class='text-center'Xin nhập ĐVT!</p>",
            type:    "orange",
            buttons:{
                Yes: {
                    text:     "OK",
                    btnClass: "btn-blue",
                    action:   function () {
                    }
                }
            },
            onDestroy:function(){
                $("#unit").focus();
                return false;
            }
        });
        return false;
    }

    var desc = $.trim($("#description").val());

    var status = $('#status').is(":checked") == true ? 1: 0;

    $.ajax({
        url:"{{ url('/admin/ql-san-pham/save') }}",
        data: {
            id: id,
            name: name,
            product_type_id:product_type_id,
            // package_id:package_id,
            // color_id:color_id,
            // quantity:qty,
            unit:unit,
            description: desc,
            status: status
        },
        dataType: "json",
        type:     "POST",
        cache:    false,
        beforeSend: function() {
            $("body").addClass("loading");
        },
        complete: function() {
            $("body").removeClass("loading");
        },
        success: function(response) {
            switch(response.result){
                case 1:
                    $.alert({
                        title:     "<strong class='alert-msg-success'>Success!</strong>",
                        content:   "<p class='text-center'>" + response.msg + "</p>",
                        type:      "green",
                        autoClose: "OK|3000",
                        buttons: {
                            OK: function () {
                                 return true;
                            }
                        },
                        onDestroy: function(){
                            if(form!=null){
                                form.close();
                            }
                            return true;
                        }
                    });
                break;
                default:
                    $.alert({
                        title:     "<strong class='alert-msg-eror'>Error!</strong>",
                        content:   "<p class='text-center'>" + response.msg + "</p>",
                        type:      "red",
                        autoClose: "OK|3000",
                        buttons: {
                            OK: function () {
                            }
                        },
                        onDestroy:function(){
                            return false;
                        }
                    });
                break;
            }
            $("#grid-data").bootgrid("reload");
        },
        error: function (xhr, ajaxOptions, thrownError) {
            $.alert({
                title:     "<strong class='alert-msg-error'>Error!</strong>",
                content:   "<p class='text-center'>Connect to server fail. Please reload page and try again!</p>",
                type:      "red",
                autoClose: "OK|3000",
                buttons: {
                    OK: function () {
                    // location.reload();
                    }
                },
                onDestroy:function(){
                // location.reload();
                },
            });
            $("#grid-data").bootgrid("reload");
        }
    });
 return false;
}


function process_action_delete(){
    var arr_id = $("#grid-data").bootgrid("getSelectedRows");
    console.log(arr_id);

    if(arr_id.length>0){
        if(arr_id.length > 1){
            content = "<p style='text-align:center;'>Bạn muốn xóa những dòng đã chọn?</p>";
        }else{
            content = "<p style='text-align:center;'>Bạn muốn xóa dòng này?</p>";
        }
        $.confirm({
            title:   "Bạn Có Chắc!",
            content: content,
            buttons: {
                Yes: {
                    text:     "Yes",
                    btnClass: "btn-blue",
                    action: function () {
                        delete_many_row(arr_id);
                    }
                },
                No:function(){
                }
            },
            onOpenBefore: function () {
                $(".jconfirm-content").css("text-align","center");
            },
        })
    }else{
	   $.alert({
            title:     "<strong class='alert-msg-warning'>Thông Báo!</strong>",
            content:   "Xin chọn dòng dữ liệu cần xóa!",
            type:      "yellow",
            autoClose: "OK|3000",
            buttons: {
                OK: function () {

                }
            },
            onOpenBefore: function () {
              $(".jconfirm-content").css("text-align","center");
            },
      });
    }
}

/*
Delete many template
*/
function delete_many_row(arr_id){
    $.ajax({
        url: "{{ url('/admin/ql-san-pham/delete') }}",
        data: {
                id: arr_id
            },
        dataType: "json",
        type:     "POST",
        cache:    false,
     	beforeSend: function() {
            $("body").addClass("loading");
        },
        complete: function() {
            $("body").removeClass("loading");
        },
        success: function(response) {
            switch(response.result){
                case 1:
                     $.alert({
                            title:     "<strong class='alert-msg-success'>Success!</strong>",
                            content:   response.msg,
                            type:      "green",
                            autoClose: "OK|3000",
                            buttons: {
                                OK: function () {

                                }
                            },
                            onOpenBefore: function () {
                                $(".jconfirm-content").css("text-align", "center");
                            },
                      });
                break;
                    default:
                          $.alert({
                                title:     "<strong class='alert-msg-eror'>Error!</strong>",
                                content:   response.msg,
                                type:      "red",
                                autoClose: "OK|3000",
                                buttons: {
                                    OK: function () {

                                    }
                                },
                                onOpenBefore: function () {
                                  $(".jconfirm-content").css("text-align","center");
                                },
                          });

                    break;
                }
                $("#grid-data").bootgrid("reload");
            
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
            $.alert({
                title:   "<strong class='alert-msg-error'>Error!</strong>",
                content: "Không kết nối được server!",
                type:    "red",
                buttons: {
                    OK: function () {
                        location.reload();
                    }
                },
                onDestroy:function(){
                     $("#grid-data").bootgrid("reload");
                }
            });
        }
    });
}

function change_status(id, status){
    
 	new_status = status == 1 ? 0: 1;
   
    $.ajax({
        url        : "{{ url('/admin/ql-san-pham/status') }}",
        data       : {id: id, status: new_status},
        dataType   : "json",
        type       : "POST",
        cache      : false,
        beforeSend : function() {
            $("body").addClass("loading");
        },
        complete: function() {
            $("body").removeClass("loading");
        },
        success: function(response) {
            switch(response.result){
                case 1:
                    $.alert({
                        title:     "<strong class='alert-msg-success'>Success!</strong>",
                        content:   "<p class='text-center'>" + response.msg + "</p>",
                        type:      "green",
                        autoClose: "OK|3000",
                        buttons: {
                            OK: function () {
                                 return true;
                            }
                        },
                        onDestroy: function(){
                            return true;
                        }
                    });
                break;
                default:
                    $.alert({
                        title:     "<strong class='alert-msg-eror'>Error!</strong>",
                        content:   "<p class='text-center'>" + response.msg + "</p>",
                        type:      "red",
                        autoClose: "OK|3000",
                        buttons: {
                            OK: function () {
                            }
                        },
                        onDestroy:function(){
                            return false;
                        }
                    });
                break;
            }
            $("#grid-data").bootgrid("reload");
        },
        error: function (xhr, ajaxOptions, thrownError) {
            $.alert({
                title:     "<strong class='alert-msg-error'>Error!</strong>",
                content:   "<p class='text-center'>Connect to server fail. Please reload page and try again!</p>",
                type:      "red",
                autoClose: "OK|3000",
                buttons: {
                    OK: function () {
                    // location.reload();
                    }
                },
                onDestroy:function(){
                // location.reload();
                },
            });
            $("#grid-data").bootgrid("reload");
        }
    });
 return false;
}
 
</script>

<style type="text/css">
    .bootgrid-footer  ul.pagination > li > a.button
{
    color: #212529 !important;

    border:1px solid #dae0e5 !important;
    padding: 0.5em !important;
    cursor: pointer !important;
    border-radius: 3px !important;
}

.bootgrid-footer  ul.pagination > li
{
    padding: 0.2em !important;
}
</style>

@endsection
