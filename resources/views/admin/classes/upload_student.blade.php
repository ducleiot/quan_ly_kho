
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
    <div class="col-md-12">
                <div class="col-xs-8 col-xs-offset-2">
                    <form method="POST" action="{{ url('admin/ql-lop-hoc/'.$class_id.'/upload-moi-hs') }}" enctype="multipart/form-data">
                        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" id="class_id" name="class_id" value="{{ $class_id }}" />
                        <div class="form-group">
                            <label for="last_name" style="color:#0093ff; font-weight:bold;">Tên trường</label>
                            <input type="text" class="form-control" id="school_name" name="school_name" placeholder="Tên trường"
                                maxlength="255" required value="" onkeypress="return /[0-9a-z._]/i.test(event.key)"/>
                            <label for="last_name" style="color:#000000; font-weight:normal; margin-bottom: 0 !important;">( Ví dụ: huongtra. )</label>
                        </div>
                        <div class="form-group">
                            <label for="last_name" style="color:#0093ff; font-weight:bold;">Chọn Excel File</label>
                            <input class="form-control" type="file" id="upload_excel" accept=".xls,.xlsx"  >
                        </div>
                        <div class="col-md-12">
                            <pre id="jsondata"></pre>
                        </div>
                        {{-- <center><button type="submit" class="btn btn-info btn-save">Thêm</button></center> --}}
                    </form>
                </div>            
    </div>
</div>

<style>
#school_name {
    text-transform: lowercase;
}
</style>

<script>
$(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });          

      
});
</script>

