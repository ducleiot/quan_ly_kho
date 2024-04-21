<div class="row " style="margin-top:0px; padding:0;">
    <div class="col-md-12 col-sm-12 col-xs-12 asi-playlist-open-from" id="asi-playlist-open-from">
        <form id="open-form">
        
            <div class="form-group required">
                <label for="product_type_id" class="">Loại Sản Phẩm</label>
                <select class="form-control" id="product_type_id" name = "product_type_id">
                    <option value="">Xin Chọn Loại SP</option>
                    @if(isset($data_product_types) && count($data_product_types) > 0)
                        @if($data!=null)
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
                <label for="product_id" class="">Sản Phẩm</label>
                <select class="form-control" id="product_id" name = "product_id">
                    <option value="">Xin Chọn Loại SP</option>
                    @if(isset($data_products) && count($data_products) > 0)
                        @if($data!=null)
                            @foreach ($data_products as $key => $item)
                                @if($data[0]->product_id == $item->id)
                                    <option value="{{ $item->id }}" selected="selected">{{ $item->name }}</option>
                                @else
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endif
                            @endforeach
                        @else
                            @foreach ($data_products as $key => $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        @endif
                    @endif
                </select>

            </div>
           <div class="form-group required">
                <label for="package_id" class="">Loại Bao</label>
                <select class="form-control" id="package_id" name = "package_id">
                    <option value="">Xin Chọn Loại Bao</option>
                    @if(isset($data_packages) && count($data_packages) > 0)
                        @if($data!=null)
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
                <label for="color_id" class="">Màu Bao</label>
                <select class="form-control" id="color_id" name = "color_id">
                    <option value="">Xin Chọn Màu Bao</option>
                        @if(isset($data_colors) && count($data_colors) > 0)
                            @if($data!=null)
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
                <label for="name" class="">Số Lượng (Kg)</label>
                <input type="text" class="form-control allow_decimal" id="quantity" name="quantity" placeholder="Số Lượng"
                maxlength="255" required value="{{ $data!=null ? $data[0]->quantity : ''}}"
                placeholder="{{ $data!=null ? $data[0]->quantity : '' }}" />
            </div>

        

        </form>
    </div>
</div>

<script type="text/javascript">
      $(document).ready(function(){    

        $("#product_type_id").change(function() {
            get_Product();
        });
        //get_Product();


        $(".allow_decimal").on("input", function(evt) {
           var self = $(this);
           self.val(self.val().replace(/[^0-9\.]/g, ''));
           if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57))
           {
             evt.preventDefault();
           }
         });
    });

    function get_Product() {
        var type_id = $("#product_type_id").val();

        if (type_id != "" && type_id > 0 ) {
            $.ajax({
                url: "{{ url('/admin/ql-san-pham/get_product') }}",
                data: {
                    type_id: type_id
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
                            $('#product_id').append('<option value="">Xin chọn sản phẩm</option>');
                            $.each(response.data, function(i, item) {
                                console.log(response.data[i].name);
                                $('#product_id').append('<option value="' + response.data[i].id + '">' +
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
            $("#product_id").empty();
            $('#product_id').append('<option value="">Xin chọn sản phẩm</option>');
        }
    }

</script>

<style type="text/css">
    .form-group.required label:after {
      content:" *";
      color:red;
  }

</style>

