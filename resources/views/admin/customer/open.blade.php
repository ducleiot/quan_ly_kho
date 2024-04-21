<div class="row " style="margin-top:0px; padding:0;">
    <div class="col-md-12 col-sm-12 col-xs-12 asi-playlist-open-from" id="asi-playlist-open-from">
        <form id="open-form">
            <div class="form-group required">
                <label for="name" class="">Họ Tên Khách Hàng</label>
                <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Khách Hàng"
                maxlength="255" required value="{{ $data!=null ? $data[0]->last_name . " " . $data[0]->first_name  : ''}}"
                placeholder="{{ $data!=null ? $data[0]->last_name . " " . $data[0]->first_name : '' }}" />
            </div>

             <div class="form-group required">
                <label for="address" class="">Địa Chỉ</label>
                <textarea  class="form-control" id="address" name="address" placeholder="Địa Chỉ">{{ $data!=null ? $data[0]->address : ""}}</textarea>

            </div>

            <div class="form-group required">
                <label for="name" class="">Số ĐT</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Số ĐT"
                maxlength="255" required value="{{ $data!=null ? $data[0]->phone  : ''}}"
                placeholder="{{ $data!=null ? $data[0]->phone : '' }}" />
            </div>

            <div class="form-group">
                <label for="name" class="">TK Ngân Hàng</label>
                <textarea  class="form-control" id="bank" name="bank" placeholder="TK Ngân Hàng">{{ $data!=null ? $data[0]->bank : ""}}</textarea>

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
    //   $(document).ready(function(){
    //     $(".allow_decimal").on("input", function(evt) {
    //        var self = $(this);
    //        self.val(self.val().replace(/[^0-9\.]/g, ''));
    //        if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57))
    //        {
    //          evt.preventDefault();
    //        }
    //      });
    // });

</script>

<style type="text/css">
    .form-group.required label:after {
      content:" *";
      color:red;
  }

</style>

