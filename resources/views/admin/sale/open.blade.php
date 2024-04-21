<div class="row " style="margin-top:0px; padding:0;">
    <div class="col-md-12 col-sm-12 col-xs-12 asi-playlist-open-from" id="asi-playlist-open-from">
        <form id="open-form">
              <div class="form-group required">
                <label for="name" class="">Loại Sản Phẩm</label>
                <select class="form-control" id="product_type_id" name = "product_type_id">
                    <option value="">Xin Chọn Loại SP</option>
                    @if(isset($data_product_types) && count($data_product_types) > 0)
                        @if(isset($data) && $data!=null)
                            @foreach ($data_product_types as $key => $item)
                                @if($data[0]->product_type_id == $item->id)
                                    <option value="{{ $item->id }}" selected="selected">{{ $item->name }}</option>
                                @else
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endif
                            @endforeach
                        @else
                            @foreach ($data_product_types as $key => $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        @endif
                    @endif
                </select>
            </div>

            <div class="form-group required">
                <label for="name" class="">Sản Phẩm </label>
                <select class="form-control" id="product_id" name = "product_id">
                    <option value="">Xin Chọn Sản Phẩm</option>
                  {{--   @if(isset($data_product_types) && count($data_product_types) > 0)
                        @if(isset($data) && $data!=null)
                            @foreach ($data_product_types as $key => $item)
                                @if($data[0]->product_type_id == $item->id)
                                    <option value="{{ $item->id }}" selected="selected">{{ $item->name }}</option>
                                @else
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endif
                            @endforeach
                        @else
                            @foreach ($data_product_types as $key => $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        @endif
                    @endif --}}
                </select>
            </div>

            <div class="form-group required">
                <label for="name" class="">Loại Bao</label>
                <select class="form-control" id="package_id" name = "package_id">
                    <option value="">Xin Chọn Loại Bao</option>
                    @if(isset($data_packages) && count($data_packages) > 0)
                        @if(isset($data) && $data!=null)
                            @foreach ($data_packages as $key => $item)
                                @if($data[0]->package_id == $item->id)
                                    <option value="{{ $item->id }}" selected="selected">{{ $item->name }}</option>
                                @else
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endif
                            @endforeach
                        @else
                            @foreach ($data_packages as $key => $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        @endif
                    @endif
                </select>
            </div>

            <div class="form-group required">
                <label for="name" class="">Màu Bao</label>
                <select class="form-control" id="color_id" name = "color_id">
                    <option value="">Xin Chọn Màu Bao</option>
                    @if(isset($data_colors) && count($data_colors) > 0)
                        @if(isset($data) && $data!=null)
                            @foreach ($data_colors as $key => $item)
                                @if($data[0]->color_id == $item->id)
                                    <option value="{{ $item->id }}" selected="selected">{{ $item->name }}</option>
                                @else
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endif
                            @endforeach
                        @else
                            @foreach ($data_colors as $key => $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        @endif
                    @endif
                </select>
            </div>

            <div class="form-group required">
                <label for="name" class="allow_decimal">Số Lượng</label>
                <input type="text" maxLength="12" class="form-control allow_decimal" id="quantity" name="quantity" placeholder="Số Lượng"
                maxlength="255" required value="{{isset($data)? $data!=null ? $data[0]->quantity : '' : ""}}"
                placeholder="{{ isset($data)? $data!=null ? $data[0]->quantity : '' : ''}}" />
            </div>

            <div class="form-group required">
                <label for="name" class="">ĐVT</label>
                <input type="text" class="form-control" id="unit" name="unit" placeholder="ĐVT"
                maxlength="255" required value="{{isset($data)? $data!=null ? $data[0]->unit : '' : ''}}"
                placeholder="{{ isset($data)? $data!=null ? $data[0]->unit : '' : '' }}" />
            </div>

            <div class="form-group required">
                <label for="name" class="allow_decimal">Giá Bán</label>
                <input type="text" maxLength="12"  class="form-control allow_decimal" id="price" name="price" placeholder="Giá Bán"
                maxlength="255" required value="{{isset($data)? $data!=null ? $data[0]->price : '' : ""}}"
                placeholder="{{ isset($data)? $data!=null ? $data[0]->price : '' : ''}}" />
            </div>

            <div class="form-group">
                <label for="name" class="">Mô Tả</label>
                <textarea  class="form-control" id="description" name="description" placeholder="Mô Tả">{{isset($data)? $data!=null ? $data[0]->description : "" : ""}}</textarea>

            </div>

        </form>
    </div>
</div>

<script type="text/javascript">
      $(document).ready(function(){

        // if(question_data_edit!= undefined){
        //     $("#produc_type_id").val(question_data_edit["product_type_id"]);
        // }

         $("#product_type_id").change(function() {
            get_Products();
        });

        $("#product_id").change(function() {
            get_ProductInfo();
        });


        $(".allow_decimal").on("input", function(evt) {
           var self = $(this);
           self.val(self.val().replace(/[^0-9\.]/g, ''));
           if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57))
           {
             evt.preventDefault();
           }
         });
    });


    function get_ProductInfo() {
        var product_id = $("#product_id").val();
        if (product_id > 0) {
            $.ajax({
                url: "{{ url('/admin/ql-ban-hang/get_product_info') }}",
                data: {
                    product_id: product_id
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
                            console.log(response.data.length);
                            if(response.data.length == 1 ){
                                $("#unit").val(response.data[0]["unit"]);
                            }
                           
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


                    // if(question_data_edit!=undefined && question_data_edit.length > 0){
                    //     console.log("OKOKOK");
                    //     $("#quantity").val(question_data_edit[0]["qty"]);
                    //     $("#unit").val(question_data_edit[0]["unit"]);
                    //     $("#price").val(question_data_edit[0]["price"]);
                    //     $("#product_id").val(question_data_edit[0]["product_id"]);
                    //     $("#package_id").val(question_data_edit[0]["package_id"]);
                    //     $("#color_id").val(question_data_edit[0]["color_id"]);
                    // }else{
                    //     console.log("adkljaskldjaskldasjkld");
                    // }


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
            $("#unit").val("");
            
        }
    }

    function get_Products() {
        var product_type_id = $("#product_type_id").val();
        if (product_type_id > 0) {
            $.ajax({
                url: "{{ url('/admin/ql-ban-hang/get_products') }}",
                data: {
                    product_type_id: product_type_id
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
                            $("#product_id").empty();
                            $('#product_id').append('<option value="">Xin Chọn Sản Phẩm</option>');
                            $.each(response.data, function(i, item) {
                                console.log(response.data[i].name);
                                $('#product_id').append('<option value="' + response.data[i].id +
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


                    if(question_data_edit!=undefined && question_data_edit.length > 0){
                        console.log("OKOKOK");
                        $("#quantity").val(question_data_edit[0]["qty"]);
                        $("#unit").val(question_data_edit[0]["unit"]);
                        $("#price").val(question_data_edit[0]["price"]);
                        $("#product_id").val(question_data_edit[0]["product_id"]);
                        $("#package_id").val(question_data_edit[0]["package_id"]);
                        $("#color_id").val(question_data_edit[0]["color_id"]);
                    }else{
                        console.log("adkljaskldjaskldasjkld");
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
            $("#product_id").empty();
            $('#product_id').append('<option value="">Xin Chọn Sản Phẩm</option>');
        }
    }


    function getData(idx) {
        var product_type_id = $("#product_type_id").val();
        var product_id = $("#product_id").val();
        var package_id = $("#package_id").val();
        var package_name = $("#package_id :selected").text();
        var color_id = $("#color_id").val();
        var color_name = $("#color_id :selected").text();
        var name = $("#product_id :selected").text() ;
        var qty = $("#quantity").val();
        var unit = $("#unit").val();
        var price = $("#price").val();

        if(product_type_id=="" || $.isNumeric(product_type_id)!=true ){
            $.alert({
                title: "<strong class='alert-msg-success'>Warning!</strong>",
                content: "<p style='text-align:center;'>Xin chọn Loại sản phẩm!</p>",
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
                    $("#product_type_id").focus();
                }
            });

            return false;
        }


        if(product_id=="" || $.isNumeric(product_id)!=true ){
            $.alert({
                title: "<strong class='alert-msg-success'>Warning!</strong>",
                content: "<p style='text-align:center;'>Xin chọn Sản phẩm!</p>",
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
                    $("#product_id").focus();
                }
            });

            return false;
        }
        

        if(package_id==""|| $.isNumeric(package_id)!=true ){
            $.alert({
                title: "<strong class='alert-msg-success'>Warning!</strong>",
                content: "<p style='text-align:center;'>Xin chọn Loại bao!</p>",
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
                    $("#package_id").focus();
                }
            });

            return false;
        }

        if(color_id==""|| $.isNumeric(color_id)!=true ){
            $.alert({
                title: "<strong class='alert-msg-success'>Warning!</strong>",
                content: "<p style='text-align:center;'>Xin chọn Màu bao!</p>",
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
                    $("#color_id").focus();
                }
            });

            return false;
        }

        if($.isNumeric(qty) == false){
            $.alert({
                title: "<strong class='alert-msg-success'>Warning!</strong>",
                content: "<p style='text-align:center;'>Số Lượng không hợp lệ!</p>",
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
                    $("#quantity").focus();
                }
            });

            return false;
        }

        if($.isNumeric(price) == false){
            $.alert({
                title: "<strong class='alert-msg-success'>Warning!</strong>",
                content: "<p style='text-align:center;'>Giá không hợp lệ!</p>",
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
                    $("#price").focus();
                }
            });

            return false;
        }

        var data = {
            sale_detail_id: null,
            idx: idx,
            product_type_id: product_type_id,
            product_id: product_id,
            package_id: package_id,
            package_name: package_name,
            color_id: color_id,
            color_name: color_name,
            name: name,
            qty: qty,
            unit: unit,
            price: price,
            total: qty*price
        };
        console.log(data);
        return (data);
}


</script>

<style type="text/css">
    .form-group.required label:after {
      content:" *";
      color:red;
  }

</style>

