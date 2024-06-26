
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
                        <form method="POST" action="{{ url('admin/ql-lop-hoc/'.$class_id.'/luu-moi-hs') }}" enctype="multipart/form-data">
                            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" id="class_id" name="class_id" value="{{ $class_id }}" />
                            <div class="form-group">
                                <label for="last_name" style="color:#0093ff; font-weight:bold;">Họ Và Tên Đệm</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Họ Và Đệm"
                                    maxlength="255" required value="@php echo Session::has('data')? Session::get('data')["last_name"] : ""; @endphp" />
                            </div>
                            <div class="form-group">
                                <label for="last_name" style="color:#0093ff; font-weight:bold;">Tên</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Tên"
                                    maxlength="255" required value="@php echo Session::has('data')? Session::get('data')["first_name"] : ""; @endphp" />
                            </div>
                            <div class="form-group">
                                <label for="sex"><input type="checkbox" class="" name="sex" id="sex"  @php echo Session::has('data')? Session::get('data')['sex']==1? 'checked="checked"': '' : 'checked="checked"' ; @endphp /><b> Giới Tính Nam</b></label><br />
                            </div>
                            <div class="form-group">
                                <label for="date_of_birth" style="color:#0093ff; font-weight:bold;">Ngày Sinh</label>
                                <input type="text"  class="form-control dc-date-time-picker" id="date_of_birth" name="date_of_birth" placeholder="Ngày Sinh"
                                    maxlength="255" required value="@php echo Session::has('data')? Session::get('data')["date_of_birth"] : ""; @endphp" />
                            </div>
                            <div class="form-group">
                                <label for="email" style="color:#0093ff; font-weight:bold;">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email"
                                    maxlength="255" required value="@php echo Session::has('data')? Session::get('data')["email"] : ""; @endphp" />
                            </div>
                            <div class="form-group">
                                <label for="password" style="color:#0093ff; font-weight:bold;">Mật Khẩu</label>
                                <input type="text" class="form-control" id="password" name="password" placeholder="Mật Khẩu"
                                    maxlength="20" required value="@php echo Session::has('data')? Session::get('data')["password"] : ""; @endphp" />
                            </div>
                            <div class="form-group">
                                <label for="phone_number" style="color:#0093ff; font-weight:bold;">Điện Thoại</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="phone_number"
                                    maxlength="255"  value="@php echo Session::has('data')? Session::get('data')["phone_number"] : ""; @endphp" />
                            </div>
                            <div class="form-group">
                                <label for="address" style="color:#0093ff; font-weight:bold;">Địa Chỉ</label>
                                <textarea class="form-control" id="address" name="address" placeholder="address">
                                    @php echo Session::has('data')? Session::get('data')["address"] : ""; @endphp
                                </textarea>
                               
                            </div>
                            <div class="form-group">
                                <label for="status"><input type="checkbox" class="" name="status" id="status" @php echo Session::has('data')? Session::get('data')['status']==1? 'checked="checked"': '' : 'checked="checked"' ; @endphp /><b> Kích hoạt</b></label><br />
                            </div>
                            {{-- <center><button type="submit" class="btn btn-info btn-save">Thêm</button></center> --}}
                        </form>
                    </div>            
        </div>
    </div>


<script>
 $(document).ready(function() {
   
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });          

            $('#date_of_birth').datetimepicker({
                locale: 'vi',
               // minDate: new Date(),
                format: "YYYY-MM-DD",
                showClose: true,
                showClear: true,
                ignoreReadonly: true,
            });
 });
</script>

