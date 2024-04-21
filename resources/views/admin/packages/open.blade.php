<div class="row " style="margin-top:0px; padding:0;">
    <div class="col-md-12 col-sm-12 col-xs-12 asi-playlist-open-from" id="asi-playlist-open-from">
        <form id="open-form">
            <div class="form-group required">
                <label for="name" class="">Loại Bao</label>
                <!--input type="text" class="form-control" id="name" name="name" value=""-->
                 <input type="text" class="form-control" id="name" name="name" placeholder="Loại Bao"
                            maxlength="255" required value="{{ $data!=null ? $data[0]->name : ''}}"
                            placeholder="{{ $data!=null ? $data[0]->name : '' }}" />
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

<style type="text/css">
.form-group.required label:after {
  content:" *";
  color:red;
}

</style>

