<div class="row " style="margin-top:0px; padding:0;">
    <div class="col-md-12 col-sm-12 col-xs-12 asi-playlist-open-from" id="asi-playlist-open-from">
        <form id="open-form">
            <div class="form-group required">
                <label for="name" class="">Sản Phẩm</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Sản Phẩm"
                maxlength="255" required value="{{ $data!=null ? $data[0]->name : ''}}"
                placeholder="{{ $data!=null ? $data[0]->name : '' }}" />
            </div>
            <div class="form-group required">
                <label for="name" class="">Loại Sản Phẩm</label>
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
          {{--   <div class="form-group required">
                <label for="name" class="">Loại Bao</label>
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
                <label for="name" class="">Màu Bao</label>
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
                <label for="name" class="">Số Lượng</label>
                <input type="text" class="form-control allow_decimal" id="quantity" name="quantity" placeholder="Số Lượng"
                maxlength="255" required value="{{ $data!=null ? $data[0]->quantity : ''}}"
                placeholder="{{ $data!=null ? $data[0]->quantity : '' }}" />
            </div> --}}

            <div class="form-group required">
                <label for="name" class="">ĐVT</label>
                <input type="text" class="form-control" id="unit" name="unit" placeholder="ĐVT"
                maxlength="255" required value="{{ $data!=null ? $data[0]->unit : ''}}"
                placeholder="{{ $data!=null ? $data[0]->unit : '' }}" />
            </div>

            <div class="form-group">
                <label for="name" class="">Mô Tả</label>
                <textarea  class="form-control" id="description" name="description" placeholder="Mô Tả">{{ $data!=null ? $data[0]->description : ""}}</textarea>

            </div>

            <div class="form-group" style="margin-bottom: 0px;">
                <label for="name" class="asi-require-field">Kích Hoạt:</label>
                <input type="checkbox" name="status" id="status" {{$data!=null? $data[0]->status==1? "checked": "" : "checked"}}>
            </div>

        </form>
    </div>
</div>

<script type="text/javascript">
      $(document).ready(function(){
        $(".allow_decimal").on("input", function(evt) {
           var self = $(this);
           self.val(self.val().replace(/[^0-9\.]/g, ''));
           if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57))
           {
             evt.preventDefault();
           }
         });
    });

</script>

<style type="text/css">
    .form-group.required label:after {
      content:" *";
      color:red;
  }

</style>

