<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ManagerController;
use App\Models\User;
use App\Util;
use App\ExcelTool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ClassesController extends ManagerController
{
    private $table_name = "classes";
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.classes.list')
        ;
    }

    public function find(Request $request)
    {
        $subject_id = intval($request->input("subject_id"));
        $school_year_id = intval($request->input("school_year_id"));
        $current = intval($request->input("current"));
        $rowCount = intval($request->input("rowCount"));
        $searchPhrase = $request->input("searchPhrase");
        $current_user = auth()->user();
        $data = null;

        if ( $current_user->level == 0 ) {
            // $query = DB::table($this->table_name)
            // ->join('teacher_class_subject', $this->table_name. '.id', '=', 'teacher_class_subject.class_id')
            // //->leftJoin('subjects', 'teacher_class_subject.subject_id', '=', 'subjects.id')
            // ->join('school_years', $this->table_name . '.school_year_id', '=', 'school_years.id')
            // ;

            $query = DB::table($this->table_name)
            ->join('teacher_class_subject', $this->table_name. '.id', '=', 'teacher_class_subject.class_id')
            //->leftJoin('subjects', 'teacher_class_subject.subject_id', '=', 'subjects.id')
            ->join('school_years', $this->table_name . '.school_year_id', '=', 'school_years.id')
            ;


            if($school_year_id!=""){
                $query->where($this->table_name . ".school_year_id", $school_year_id);
            }

            // if($subject_id!=""){
            //     $query->where("teacher_class_subject.subject_id", $subject_id);
            // }

            //$query->where($this->table_name . ".created_by", auth()->user()->id);

            //search
            if (!empty($searchPhrase)) {
                $query->where($this->table_name . ".name", "LIKE", '%' . $searchPhrase . "%")
                    //->orWhere("subjects.name", "LIKE", '%' . $searchPhrase . "%")
                    ->orWhere("school_years.name", "LIKE", '%' . $searchPhrase . "%");
            }

            //sort
            if (isset($request->sort) && is_array( $request->sort)) {
                foreach ($request->sort as $key => $value) { 
                    switch ($key) {
                        case "status":
                        $query->orderBy($this->table_name . $key, $value);
                        break;
                    }
                }
            } else {
                $query->orderBy($this->table_name . ".name", "asc")
                ->orderBy($this->table_name . ".created_at", "asc");
            }

            $data = $query->get();
            $total = count($data);
            if ($rowCount > 1 && $current <= $total) {
                $limit = $rowCount * ($current - 1);
                $query->limit($rowCount)->offset($limit);
            } else {
                // $query->limit($rowCount);
            }
            $data = $query->select( 'school_years.name as school_year_name', 'school_years.year_open as year_open', 'school_years.year_close as year_close', $this->table_name . '.id', $this->table_name . '.created_at', $this->table_name . '.created_by', $this->table_name . '.updated_at', $this->table_name . '.updated_by', $this->table_name . '.name as name', $this->table_name . '.status as status')
            ->get();
    

        }else{
            $select_class = DB::table("teacher_class_subject")->where("teacher_id",$current_user->id)->select("class_id")->get();
            $select_class = $select_class!=null?$select_class->pluck("class_id"):null;
            if($select_class!=null){
                $query = DB::table($this->table_name)
                ->join('teacher_class_subject', $this->table_name. '.id', '=', 'teacher_class_subject.class_id')
                //->leftJoin('subjects', 'teacher_class_subject.subject_id', '=', 'subjects.id')
                ->join('school_years', $this->table_name . '.school_year_id', '=', 'school_years.id')
                
                ;

                $query->whereIn($this->table_name . ".id", $select_class);

                if($school_year_id!=""){
                    $query->where($this->table_name . ".school_year_id", $school_year_id);
                }

                $query->where( "teacher_class_subject.teacher_id", $current_user->id);

                // if($subject_id!=""){
                //     $query->where("teacher_class_subject.subject_id", $subject_id);
                // }

                //$query->where($this->table_name . ".created_by", auth()->user()->id);

                //search
                if (!empty($searchPhrase)) {
                    $query->where($this->table_name . ".name", "LIKE", '%' . $searchPhrase . "%")
                        //->orWhere("subjects.name", "LIKE", '%' . $searchPhrase . "%")
                        ->orWhere("school_years.name", "LIKE", '%' . $searchPhrase . "%");
                }

                //sort
                if (isset($request->sort) && is_array( $request->sort)) {
                    foreach ($request->sort as $key => $value) { 
                        switch ($key) {
                            case "status":
                            $query->orderBy($this->table_name . $key, $value);
                            break;
                        }
                    }
                } else {
                    $query->orderBy($this->table_name . ".name", "asc")
                    ->orderBy($this->table_name . ".created_at", "asc");
                }

                $data = $query->get();
                $total = count($data);
                if ($rowCount > 1 && $current <= $total) {
                    $limit = $rowCount * ($current - 1);
                    $query->limit($rowCount)->offset($limit);
                } else {
                    // $query->limit($rowCount);
                }
                $data = $query->select( 'school_years.name as school_year_name', 'school_years.year_open as year_open', 'school_years.year_close as year_close', $this->table_name . '.id', $this->table_name . '.created_at', $this->table_name . '.created_by', $this->table_name . '.updated_at', $this->table_name . '.updated_by', $this->table_name . '.name as name', $this->table_name . '.status as status')
                ->get();
            }
    
        }

       
        $json = array(
            "current" => $current,
            "rowCount" => $rowCount,
            "total" => intval($total),
            "rows" => []
        );

        if (count($data) > 0) {
            foreach ($data as $key => $item) {
                //$roles  = Util::get_role_name($item->id);
                $created_by = User::find($item->created_by);
                $updated_by = User::find($item->updated_by);
                $json['rows'][] = array(
                    "id" => $item->id,
                    "name" => $item->name,
                    "school_year_name" => $item->school_year_name,                  
                    "status" => $item->status,
                    "created_at" => $item->created_at,
                    "updated_at" => $item->updated_at,
                    "created_by" => $created_by != null ? $created_by->last_name . " "  . $created_by->first_name : "",
                    "updated_by" => $updated_by != null ? $updated_by->last_name . " "  . $updated_by->first_name : "",
                );
            }
        }
        return response()->json($json);
    }

    public function create()
    {
        return view('admin.classes.create');
    }

    public function store(Request $request)
    {

        //Kiểm tra giá trị slogan_title, slogan_value
        $this->validate($request,
            [
                //Kiểm tra giá trị rỗng
                'school_year_id' => 'required',
                'name' => 'required',
            ],
            [
                //Tùy chỉnh hiển thị thông báo
                'school_year_id.required' => 'Bạn chưa chọn thông tin Năm Học!',
                'name.required' => 'Bạn chưa nhập thông tin Tên Lớp!',
            ]
        );

        //Lấy giá trị slide đã nhập
        date_default_timezone_set(Util::$time_zone);

        $school_year_id = intval( $request->school_year_id);
        $name = $request->name;
        $status = (($request->status) == 'on') ? 1 : 0;

        $dataInsertToDatabase = array(
            'name' => $name,
            'school_year_id' => $school_year_id,
            'status' => $status,
            'created_by' => auth()->user()->id,
            'created_at' => date(Util::$date_time_format),
        );


        if($this->checkDataExists($dataInsertToDatabase, null)==true){
            Session::flash('error', 'Lớp Học này đã tồn tại!');
            Session::flash('data', $dataInsertToDatabase);
        }else{
            if(auth()->user()->level==0){
                //Insert vào database
                $id = DB::table($this->table_name)->insertGetId($dataInsertToDatabase);
                $insertData = DB::table($this->table_name)->where('id', $id)->get();
                //echo($insertData);
                if (count($insertData) > 0) {
                    Session::flash('success', 'Thêm mới thành công!');
                } else {
                    Session::flash('error', 'Thêm mới thất bại!');
                    Session::flash('data', $dataInsertToDatabase);
                }
            }else{
                Session::flash('error', 'Bạn không có quyền này!');
                Session::flash('data', $dataInsertToDatabase);
            }
        }
        //Thực hiện chuyển trang
        return redirect('admin/ql-lop-hoc/them-moi');
    }

    public function checkDataExists($data, $id){
        $res = false;
        if($id!=null){
            if(DB::table($this->table_name)
                ->where('school_year_id', $data["school_year_id"])
                ->where('name', $data["name"])
                ->where('id',"!=", $id)
                ->exists())
            {
                $res = true;
            }
        }else{
            if(DB::table($this->table_name)
                ->where('school_year_id', $data["school_year_id"])
                ->where('name', $data["name"])
                ->exists())
            {
                $res = true;
            }
        }
        return($res);
    }

    public function edit($id)
    {
        $getData = DB::table($this->table_name)->select('id', 'name', 'school_year_id', 'status')->where('id', $id)->get();
        return view('admin.classes.edit')->with('getDataById', $getData);
    }

    public function update(Request $request)
    {
        //Cap nhat sua hoc sinh
        date_default_timezone_set("Asia/Ho_Chi_Minh");

        //Kiểm tra giá trị tenhocsinh, sodienthoai, khoi
        $this->validate($request,
            [
                //Kiểm tra giá trị rỗng
                'school_year_id' => 'required',
                'name' => 'required',
            ],
            [
                //Tùy chỉnh hiển thị thông báo
                'school_year_id.required' => 'Bạn chưa chọn thông tin Năm Học!',
                'name.required' => 'Bạn chưa nhập thông tin Tên Lớp!',
            ]
        );

        $id = $request->id;
        $school_year_id = intval( $request->school_year_id);
        $name = $request->name;
        $status = (($request->status) == 'on') ? 1 : 0;

        $updateData = array(
            'name' => $name,
            'school_year_id' => $school_year_id,
            'status' => $status,
            'updated_by' => auth()->user()->id,
            'updated_at' => date('Y-m-d H:i:s'),
        );



        if($this->checkDataExists($updateData, $request->id)){
            Session::flash('error', 'Lớp Học này đã tồn tại!');
            Session::flash('data', $updateData);
        }else{
            if(auth()->user()->level==0){
                $res = DB::table($this->table_name)->where('id', $id)
                ->update($updateData);
                  //Kiểm tra lệnh update để trả về một thông báo
                if ($res) {
                    Session::flash('success', 'Cập nhật thông tin thành công!');
                } else {
                    Session::flash('error', 'Cập nhật thông tin thất bại!');
                    Session::flash('data', $updateData);
                }
            }else{
                Session::flash('error', 'Bạn không có quyền này!');
                Session::flash('data', $dataInsertToDatabase);
            }
           
        }
        //Thực hiện chuyển trang
        return redirect('admin/ql-lop-hoc/' . $request->id . '/cap-nhat');
    }

    public function destroy($id)
    {
        if(auth()->user()->level==0){
            $deleteData = DB::table($this->table_name)->where('id', $id)->delete();

            //Kiểm tra lệnh delete để trả về một thông báo
            if ($deleteData) {
                Session::flash('success', 'Xóa thành công!');
            } else {
                Session::flash('error', 'Xóa thất bại!');
            }
        }else{
            Session::flash('error', 'Bạn không có quyền này!');
            Session::flash('data', $dataInsertToDatabase);
        }
        //Thực hiện câu lệnh xóa với giá trị id = $id trả về
      

        //Thực hiện chuyển trang
        return redirect('admin/ql-lop-hoc');
    }

    public function status(Request $request)
    {
        try
        {
            if(auth()->user()->level==0){
                $id = $request->input("id");
                $status = $request->input("status");
                if ($id != -1) {
                    DB::table($this->table_name)->where('id', $id)
                    ->update(['status' => $status]);
                    $response = array("result" => 1, "msg" => "Cập Nhật thành công!");
                } else {
                    $response = array("result" => 0, "msg" => "Không tim thấy dữ liệu!");
                }
            }else{
                $response = array("result" => 0, "msg" => "Bạn không có quyền này!");
            }   
            return response()->json($response);
        } catch (exception $ex) {
            $response = array("result" => 0, "msg" => "Lỗi server!");
            return response()->json($response);
        }
    }

    public function delete(Request $request)
    {
        try
        {
            $arr_id = $request->input("id");
            $count = 0;
            foreach ($arr_id as $key => $item) {

                //Thực hiện câu lệnh xóa với giá trị id = $id trả về
                $deleteData = DB::table($this->table_name)->where('id', $item)->delete();

                //Kiểm tra lệnh delete để trả về một thông báo
                if ($deleteData) {
                    $count += 1;
                }
            }

            if ($count == count($arr_id)) {
                $response = array("result" => 1, "msg" => "Xóa thành công!");
            } else {
                if ($count == 0) {
                    $response = array("result" => 0, "msg" => "Xóa thất bại!");
                } else {
                    $response = array("result" => 2, "msg" => "Một số dữ liệu không xóa được do lỗi server. Xin vui lòng thực hiện lại!");
                }
            }

            return response()->json($response);

        } catch (exception $ex) {
            $response = array("result" => 0, "msg" => "Xóa thất bại!");
            return response()->json($response);
        }
    }


    public function find_student(Request $request)
    {
        $class_id = intval($request->input("class_id"));
        $current = intval($request->input("current"));
        $rowCount = intval($request->input("rowCount"));
        $searchPhrase = $request->input("searchPhrase");

        $query = DB::table("student_class")
                    ->leftJoin('users', 'student_class.student_id', '=', 'users.id')
                    ->leftJoin('classes', 'student_class.class_id', '=', 'classes.id')
                    ->leftJoin('school_years', 'classes.school_year_id', '=', 'school_years.id');


        $query->where("student_class.class_id", $class_id);

        //search
        if (!empty($searchPhrase)) {
            $query->where("users.first_name", "LIKE", '%' . $searchPhrase . "%")
                ->orWhere("users.last_name", "LIKE", '%' . $searchPhrase . "%")
                ;
        }

        //sort
        if (isset($request->sort) && is_array( $request->sort)) {

            foreach ($request->sort as $key => $value) {
                switch ($key) {
                    case "first_name":
                    $query->orderBy("users." . $key, $value);
                    break;
                }
            }
        } else {
            $query->orderBy( "users.first_name", "asc")
                ->orderBy("student_class.id", "asc")
            ;
        }

        // print_r((string)$query);exit;

        $data = $query->get();
        $total = count($data);
        if ($rowCount > 1 && $current <= $total) {
            $limit = $rowCount * ($current - 1);
            $query->limit($rowCount)->offset($limit);
        } else {
            // $query->limit($rowCount);
        }
        $data = $query->select("student_class.*",  "users.id as user_id",  "users.email", "users.sex","users.first_name", "users.last_name", "classes.name as class_name", "school_years.name as school_year_name", "school_years.year_open", "school_years.year_close")
        ->get();

        $json = array(
            "current" => $current,
            "rowCount" => $rowCount,
            "total" => intval($total),
            "rows" => []
        );

        if (count($data) > 0) {
            foreach ($data as $key => $item) {
                //$roles  = Util::get_role_name($item->id);
                $created_by = User::find($item->created_by);
                $updated_by = User::find($item->updated_by);
                $json['rows'][] = array(
                    "id" => $item->user_id,
                    "first_name" => $item->first_name,
                    "last_name" => $item->last_name,
                    "sex" => $item->sex,
                    "email" => $item->email,
                    "class_name" => $item->class_name,
                    "school_year_name" => $item->school_year_name,
                    "created_at" => $item->created_at,
                    "updated_at" => $item->updated_at,
                    "created_by" => $created_by != null ? $created_by->last_name . " "  . $created_by->first_name : "",
                    "updated_by" => $updated_by != null ? $updated_by->last_name . " "  . $updated_by->first_name : "",
                );
            }
        }
        return response()->json($json);
    }

    public function view_student($class_id)
    {
        // $getData = DB::table("student_class")
        //             ->leftJoin('users', 'student_class.student_id', '=', 'users.id')
        //             ->leftJoin('classes', 'student_class.class_id', '=', 'classes.id')
        //             ->leftJoin('school_years', 'classes.school_year_id', '=', 'school_years.id')
        //             ->where("student_class.class_id",$id)
        //             ->select('student_class.*', "users.id as user_id", "users.sex","users.first_name", "users.last_name", "classes.name as class_name",, "school_years.name as school_year_name" "school_years.year_open", "school_years.year_close")->where('student_class.class_id', $class_id)
        //             ->orderBy("users.first_name", "asc")
        //             ->orderBy("users.id", "asc")
        //             ->get();
        return view('admin.classes.view_student')->with('class_id', $class_id);
    }

    public function create_student($class_id)
    {
        //Hiển thị trang thêm slide
        return view('admin.classes.create_student')
        ->with('class_id', $class_id)
        ;
    }

    public function create_student_new($class_id)
    {
        //Hiển thị trang thêm slide
        return view('admin.classes.create_student_new')
        ->with('class_id', $class_id)
        ;
    }

    public function upload_student_new($class_id)
    {
        //Hiển thị trang thêm slide
        return view('admin.classes.upload_student')
        ->with('class_id', $class_id)
        ;
    }




    public function store_student(Request $request)
    {
        //Kiểm tra giá trị slogan_title, slogan_value
        $this->validate($request,
            [
                //Kiểm tra giá trị rỗng
                'last_name' => 'required',
                'first_name' => 'required',
                'date_of_birth' => 'required',
                'email' => 'required',
                'password' => 'required',
            ],
            [
                //Tùy chỉnh hiển thị thông báo
                'last_name.required' => 'Bạn chưa nhập Họ Và Tên Đệm!',
                'first_name.required' => 'Bạn chưa nhập Tên!',
                'email.required' => 'Bạn chưa nhập Email!',
                'password.required' => 'Bạn chưa nhập Mật Khẩu!',
                'date_of_birth.required' => 'Bạn chưa nhập Ngày Sinh!',
            ]
        );
        //Lấy giá trị slide đã nhập
        date_default_timezone_set(Util::$time_zone);
        $class_id = $request->class_id;
        $last_name = trim($request->last_name);
        $first_name = trim($request->first_name);
        $phone_number = $request->phone_number;
        $date_of_birth = $request->date_of_birth;
        $email = $request->email;
        $address = $request->address;
        $password = Hash::make($request->password);
        $sex = $request->sex;
        $status = $request->status;
            //Gán giá trị vào array
        $dataInsertToDatabase = array(
            'last_name' => Util::removeWhiteSpace(ucwords($last_name)),
            'first_name' => Util::removeWhiteSpace(ucwords($first_name)),
            'date_of_birth' => $date_of_birth,
            'sex' => $sex,
            'email' => $email,
            'password' => $password,
            'phone_number' => $phone_number,
            'address' => $address,
            'status' => $status ,
            'level' => 2 ,
            'created_at' => date(Util::$date_time_format),
        );

        if(Util::checkEmailExists($dataInsertToDatabase["email"], null) == true){
            Session::flash('error', 'Email này đã tồn tại trong hệ thống!');
            Session::flash('data', $dataInsertToDatabase);
        }else{

            if($this->checkDataExistsStudent($dataInsertToDatabase, null)==true){
                $insertData = DB::table("users")
                    ->where('last_name', $dataInsertToDatabase["last_name"])
                    ->where('first_name', $dataInsertToDatabase["first_name"])
                    ->where('sex', $dataInsertToDatabase["sex"])
                    ->where('date_of_birth', $dataInsertToDatabase["date_of_birth"])
                    //->where('id',"!=", $id)
                    ->first();

            //$insertData = DB::table("users")->where('id', $id)->get();

                //echo($insertData);
                if ($insertData) {

                    $tmp_id = DB::table("student_class")->insertGetId(
                        array("student_id" => $insertData->id, "class_id" => $class_id, "created_at" =>  date(Util::$date_time_format), "created_by" => auth()->user()->id)
                    );

                    $dataupdate = array(
                        'email' => $email,
                        'password' => $password,
                        'phone_number' => $phone_number,
                        'address' => $address,
                        'status' => $status ,
                        'level' => 2 ,
                        'updated_at' => date(Util::$date_time_format),
                    );

                    DB::table("users")->where('id', $insertData->id)
                    ->update($dataupdate);

                    Session::flash('success', 'Thêm mới thành công!');
                } else {
                    Session::flash('error', 'Thêm mới thất bại!');
                    Session::flash('data', $dataInsertToDatabase);
                }

                Session::flash('error', 'Học Sinh này đã tồn tại!');
                Session::flash('data', $dataInsertToDatabase);

            }else{
                    //Insert vào database
                $id = DB::table("users")->insertGetId($dataInsertToDatabase);
                $insertData = DB::table("users")->where('id', $id)->get();
                    //echo($insertData);
                if (count($insertData) > 0) {
                    $tmp_id = DB::table("student_class")->insertGetId(
                        array("student_id" => $id, "class_id" => $class_id, "created_at" =>  date(Util::$date_time_format), "created_by" => auth()->user()->id)
                    );
                    Session::flash('success', 'Thêm mới thành công!');
                } else {
                    Session::flash('error', 'Thêm mới thất bại!');
                    Session::flash('data', $dataInsertToDatabase);
                }
            }
        }
        return redirect('admin/ql-lop-hoc/'.$class_id.'/ds-hoc-sinh');
    }

    public function store_student_new(Request $request)
    {
        //Kiểm tra giá trị slogan_title, slogan_value
        // $this->validate($request,
        //     [
        //         //Kiểm tra giá trị rỗng
        //         'last_name' => 'required',
        //         'first_name' => 'required',
        //         'date_of_birth' => 'required',
        //         'email' => 'required',
        //         'password' => 'required',
        //     ],
        //     [
        //         //Tùy chỉnh hiển thị thông báo
        //         'last_name.required' => 'Bạn chưa nhập Họ Và Tên Đệm!',
        //         'first_name.required' => 'Bạn chưa nhập Tên!',
        //         'email.required' => 'Bạn chưa nhập Email!',
        //         'password.required' => 'Bạn chưa nhập Mật Khẩu!',
        //         'date_of_birth.required' => 'Bạn chưa nhập Ngày Sinh!',
        //     ]
        // );
        //Lấy giá trị slide đã nhập
        date_default_timezone_set(Util::$time_zone);
        $class_id = $request->class_id;
        $last_name = trim($request->last_name);
        $first_name = trim($request->first_name);
        $phone_number = $request->phone_number;
        $date_of_birth = $request->date_of_birth;
        $email = $request->email;
        $address = $request->address;
        $password = Hash::make($request->password);
         $sex = $request->sex;
        $status = $request->status;
            //Gán giá trị vào array
        $dataInsertToDatabase = array(
            'last_name' => Util::removeWhiteSpace(ucwords($last_name)),
            'first_name' => Util::removeWhiteSpace(ucwords($first_name)),
            'date_of_birth' => $date_of_birth,
            'sex' => $sex,
            'email' => $email,
            'password' => $password,
            'phone_number' => $phone_number,
            'address' => $address,
            'status' => $status ,
            'level' => 2 ,
            'created_at' => date(Util::$date_time_format),
        );

        if(Util::checkEmailExists($dataInsertToDatabase["email"], null) == true){
            $response = array("result" => 0, "msg" => "Email này đã tồn tại trong hệ thống!");
            return response()->json($response);
        }else{

            if($this->checkDataExistsStudent($dataInsertToDatabase, null)==true){
                $insertData = DB::table("users")
                    ->where('last_name', $dataInsertToDatabase["last_name"])
                    ->where('first_name', $dataInsertToDatabase["first_name"])
                    ->where('sex', $dataInsertToDatabase["sex"])
                    ->where('date_of_birth', $dataInsertToDatabase["date_of_birth"])
                    //->where('id',"!=", $id)
                    ->first();

                //$insertData = DB::table("users")->where('id', $id)->get();

                //echo($insertData);
                if ($insertData) {
                    $tmp_id = DB::table("student_class")->insertGetId(
                        array("student_id" => $insertData->id, "class_id" => $class_id, "created_at" =>  date(Util::$date_time_format), "created_by" => auth()->user()->id)
                    );

                    $dataupdate = array(
                        'email' => $email,
                        'password' => $password,
                        'phone_number' => $phone_number,
                        'address' => $address,
                        'status' => $status ,
                        'level' => 2 ,
                        'updated_at' => date(Util::$date_time_format),
                    );

                    DB::table("users")->where('id', $insertData->id)
                    ->update($dataupdate);

                   // Session::flash('success', 'Thêm mới thành công!');
                    $response = array("result" => 1, "msg" => "Thêm mới thành công!");
                    return response()->json($response);
                } else {
                    //Session::flash('error', 'Thêm mới thất bại!');
                    //Session::flash('data', $dataInsertToDatabase);
                    $response = array("result" => 0, "msg" => "Thêm mới thất bại!");
                    return response()->json($response);
                }

                // Session::flash('error', 'Học Sinh này đã tồn tại!');
                // Session::flash('data', $dataInsertToDatabase);

            }else{
                    //Insert vào database
                $id = DB::table("users")->insertGetId($dataInsertToDatabase);
                $insertData = DB::table("users")->where('id', $id)->get();
                    //echo($insertData);
                if (count($insertData) > 0) {
                    $tmp_id = DB::table("student_class")->insertGetId(
                        array("student_id" => $id, "class_id" => $class_id, "created_at" =>  date(Util::$date_time_format), "created_by" => auth()->user()->id)
                    );
                    $response = array("result" => 1, "msg" => "Thêm mới thành công!");
                    return response()->json($response);
                } else {
                    $response = array("result" => 0, "msg" => "Thêm mới thất bại!");
                    return response()->json($response);
                }
            }
        }
       // return redirect('admin/ql-lop-hoc/'.$class_id.'/ds-hoc-sinh');
    }

    public function upload_student(Request $request)
    {       
        date_default_timezone_set(Util::$time_zone);
        $class_id = $request->class_id;
        $school_name = $request->school_name;
        $path = "nil";
        $data = null;
        $folder = "public/excel_files";
        $count_add_success = 0;
        $data_correct = [];
        $data_incorrect = [];
        $arr_download_files = [];
        $res = 0;
        $path_report_file_success = "user_report_success.xlsx";
        $path_report_file_error = "user_report_error.xlsx";
        $report_file_success = null;
        $report_file_error = null;
        $arr_data_add = [];

        if($request->hasFile('excel_file')){
            $current_date_time = date("Ymd_hms");
            $path_report_file_success = pathinfo($request->file('excel_file')->getClientOriginalName(), PATHINFO_FILENAME) ."_report_success_" . $current_date_time . ".xlsx";
            $path_report_file_error = pathinfo($request->file('excel_file')->getClientOriginalName(), PATHINFO_FILENAME) ."_report_error_" . $current_date_time . ".xlsx";
            $path = $request->file('excel_file')->store($folder);   
            if(Storage::exists($path)){
                $tmp = Storage::path($folder . "/" . basename($path));             
                $data = ExcelTool::ImportStudentForClass($school_name, $tmp, $class_id);
                if($data!= null && count($data) > 0){
                    foreach ($data as $key => $value) {
                        if(Util::checkEmailExists($value["email"], null) == true){
                            $insertData = DB::table("users")
                            ->where('email', $value["email"])
                            ->first();

                            if ($insertData) {
                                $checkClass = DB::table("student_class")
                                ->where('class_id', $class_id)
                                ->where('student_id', $insertData->id)                                  
                                ->first();
                                
                                if($checkClass){
                                    $dataupdate = array(   
                                        'last_name' => $value["last_name"],
                                        'first_name' => $value["first_name"],      
                                        'date_of_birth' => $value["date_of_birth"],      
                                        'sex' => $value["sex"],      
                                        'password' => Hash::make($value["password"]),
                                        'phone_number' => $value["phone_number"],
                                        'address' => $value["address"],
                                        'status' => $value["status"] ,
                                        'level' => 2 ,
                                        'updated_at' => date(Util::$date_time_format),
                                    );
                
                                    DB::table("users")->where('id', $insertData->id)
                                    ->update($dataupdate);
                                    $value["status"]="Tài khoản này đã tồn tại nên chỉ cập nhật lại thông tin";
                                    $arr_data_add[] = $value;
                                    $count_add_success = $count_add_success + 1;
                                }else{
                                    $tmp_id = DB::table("student_class")->insertGetId(
                                        array("student_id" => $insertData->id, "class_id" => $class_id, "created_at" =>  date(Util::$date_time_format), "created_by" => auth()->user()->id)
                                    );
                
                                    $dataupdate = array(
                                        //'email' => $value["email"],
                                        'last_name' => $value["last_name"],
                                        'first_name' => $value["first_name"],
                                        'date_of_birth' => $value["date_of_birth"],
                                        'sex' => $value["sex"],   
                                        'password' => Hash::make($value["password"]),
                                        'phone_number' => $value["phone_number"],
                                        'address' => $value["address"],
                                        'status' => $value["status"] ,
                                        'level' => 2 ,
                                        'updated_at' => date(Util::$date_time_format),
                                    );
                
                                    DB::table("users")->where('id', $insertData->id)
                                    ->update($dataupdate);
                                    $value["status"]="Tài khoản này đã tồn tại nên chỉ cập nhật lại thông tin";
                                    $arr_data_add[] = $value;
                                    $count_add_success = $count_add_success + 1;
                                }


                            }

                            //$data_incorrect[] = $value;
                        }else{
                            $dataInsert = array(
                                'last_name' => $value["last_name"],
                                'first_name' => $value["first_name"],
                                'date_of_birth' => $value["date_of_birth"],
                                'email' => $value["email"],
                                'sex' => $value["sex"],   
                                'password' => Hash::make($value["password"]),
                                'phone_number' => $value["phone_number"],
                                'address' => $value["address"],
                                'status' => $value["status"] ,
                                'level' => 2 ,
                                'updated_at' => date(Util::$date_time_format),
                            );

                            $id = DB::table("users")->insertGetId($dataInsert);
                            $insertData = DB::table("users")->where('id', $id)->get();
                                //echo($insertData);
                            if (count($insertData) > 0) {
                                $tmp_id = DB::table("student_class")->insertGetId(
                                    array("student_id" => $id, "class_id" => $class_id, "created_at" =>  date(Util::$date_time_format), "created_by" => auth()->user()->id)
                                );
                                $count_add_success = $count_add_success + 1;
                                $value["status"]="Tài khoản này được thêm mới";
                                $arr_data_add[] = $value;
                            }
                        }
                    }                
                }
            }
        }
        $msg="";
        if($count_add_success > 0){
            if($count_add_success == count($data)){
                $res = 1;
                $msg = "Add user thành công!";
            }else{
                $res = 2;
                $msg = "Add user thành công. Tuy nhiên có vài user không thể add được!";
            }

        }else{
            $res = 0;
            $msg = "Add user thất bại!";
        }

        if(count($arr_data_add) > 0){
            $report_file_success = ExcelTool::ExportDataUser($arr_data_add, $path_report_file_success);
        }

      
        if(Storage::exists($report_file_success)){          
            $arr_download_files[] = url("download_add_user/" . $path_report_file_success);// Storage::path($report_file_success); //$path_report_file_success;
        }

       
        $response = array("result" => $res, "msg" =>$msg, "arr_files" => $arr_download_files);
        return response()->json($response);
    }
    
    public function export_student(Request $request){
        date_default_timezone_set(Util::$time_zone);
        $class_id = $request->class_id;
        $file_name = "";
        $data = DB::table("student_class")
        ->leftJoin('classes', 'classes.id', '=', 'student_class.class_id')
        ->leftJoin('users', 'users.id', '=', 'student_class.student_id')
        ->where('class_id', $class_id)  
        ->select("users.*",  "classes.name as class_name")
        ->get();
        $res = 0;
        $msg = "";
        if(count($data) > 0){            
            $arr = ExcelTool::ExportDataUserOfClass($data);
            if(Storage::exists($arr["path"])){          
                $file_name = url("download_add_user/" . $arr["file_name"]); // Storage::path($report_file_success); //$path_report_file_success;
                $msg = "Export thành công!";
                $res = 1;
            }else{
                $res = 2;    
                $msg = "Export thất bại. Xin vui lòng thử lại!";
            }
          
        }else{
            $res = 0;
            $msg = "Danh sách trống!";
        }

        $response = array("result" => $res, "msg" =>$msg, "file_name" => $file_name);
        return response()->json($response);
          
    }

    public function upload_student_old(Request $request)
    {
       
        date_default_timezone_set(Util::$time_zone);
        $class_id = $request->class_id;
        $data = json_decode($request->data);
        //$data = $request->data;
        //foreach ($data as $key => $value) {
        $arr = [];
        $arr_email = [];
        foreach($data as $obj){
        // echo $obj->name;
        $last_name = Util::removeWhiteSpace(ucwords($obj->Last_Name));
        $first_name = Util::removeWhiteSpace(ucwords($obj->First_Name));
        $tmp_date = Util::convertDate($obj->Date_Of_Birth);
        $tmp_sex = intval($obj->Sex);
       // $tmp_email = Util::genEmail("nxt.", $first_name, $last_name, $tmp_date);
       foreach($data->entries as $row) {
            foreach($row as $key => $val) {
                $ar[] = $key;
                //echo $key . ': ' . $val;
                //echo '<br>';
            }
        }
    
        $arr[] = array( 
            'last_name' => $last_name,
            'first_name' => $first_name ,
            'date_of_birth' => $tmp_date,
            'sex' => $tmp_sex,
           // 'phone_number' => array_keys(json_decode($obj, true)),//Util::removeWhiteSpace($obj->Phone_Number),                
        //    'email' => $tmp_email,                
            'address' => Util::removeWhiteSpace($obj->Address),
            'password' => Hash::make($request->password),
            'status' => 1,

        );
            // $last_name = Util::removeWhiteSpace(ucwords($obj["Last_Name"]));
            // $first_name = Util::removeWhiteSpace(ucwords($obj["First_Name"]));
            // $tmp_date = Util::convertDate($obj["Date_Of_Birth"]);
            // $tmp_sex = intval($obj["Sex"]);
            // $tmp_email = Util::genEmail("nxt.", $first_name, $last_name, $tmp_date);
            // $arr[] = array( 
            //     'last_name' => $last_name,
            //     'first_name' => $first_name ,
            //     'date_of_birth' => $tmp_date,
            //     'sex' => $tmp_sex,
            //   //  'phone_number' => Util::removeWhiteSpace($obj["Phone"]),                
            //     'email' => $tmp_email,                
            //     'address' => Util::removeWhiteSpace(ucwords($obj["Address"])),
            //     'password' => Hash::make($request->password),
            //     'status' => 1,

            // );

            // $phone_number = $request->phone_number;
            // $date_of_birth = $request->date_of_birth;
            // $email = $request->email;
            // $address = $request->address;
            // $password = Hash::make($request->password);
            // $sex = (($request->status) == 'on') ? 1 : 0;
            // $status = (($request->status) == 'on') ? 1 : 0;
            //     //Gán giá trị vào array
        }

        $response = array("result" => 1, "msg" => $ar);
        return response()->json($response);
        
        $dataInsertToDatabase = array(
            'last_name' => Util::removeWhiteSpace(ucwords($last_name)),
            'first_name' => Util::removeWhiteSpace(ucwords($first_name)),
            'date_of_birth' => $date_of_birth,
            'sex' => $sex,
            'email' => $email,
            'password' => $password,
            'phone_number' => $phone_number,
            'address' => $address,
            'status' => $status ,
            'level' => 2 ,
            'created_at' => date(Util::$date_time_format),
        );

        if(Util::checkEmailExists($dataInsertToDatabase["email"], null) == true){
            $response = array("result" => 0, "msg" => "Email này đã tồn tại trong hệ thống!");
            return response()->json($response);
        }else{

            if($this->checkDataExistsStudent($dataInsertToDatabase, null)==true){
                $insertData = DB::table("users")
                    ->where('last_name', $dataInsertToDatabase["last_name"])
                    ->where('first_name', $dataInsertToDatabase["first_name"])
                    ->where('sex', $dataInsertToDatabase["sex"])
                    ->where('date_of_birth', $dataInsertToDatabase["date_of_birth"])
                    //->where('id',"!=", $id)
                    ->first();

                //$insertData = DB::table("users")->where('id', $id)->get();

                //echo($insertData);
                if ($insertData) {
                    $tmp_id = DB::table("student_class")->insertGetId(
                        array("student_id" => $insertData->id, "class_id" => $class_id, "created_at" =>  date(Util::$date_time_format), "created_by" => auth()->user()->id)
                    );

                    $dataupdate = array(
                        'email' => $email,
                        'password' => $password,
                        'phone_number' => $phone_number,
                        'address' => $address,
                        'status' => $status ,
                        'level' => 2 ,
                        'updated_at' => date(Util::$date_time_format),
                    );

                    DB::table("users")->where('id', $insertData->id)
                    ->update($dataupdate);

                   // Session::flash('success', 'Thêm mới thành công!');
                    $response = array("result" => 1, "msg" => "Thêm mới thành công!");
                    return response()->json($response);
                } else {
                    //Session::flash('error', 'Thêm mới thất bại!');
                    //Session::flash('data', $dataInsertToDatabase);
                    $response = array("result" => 0, "msg" => "Thêm mới thất bại!");
                    return response()->json($response);
                }

                // Session::flash('error', 'Học Sinh này đã tồn tại!');
                // Session::flash('data', $dataInsertToDatabase);

            }else{
                    //Insert vào database
                $id = DB::table("users")->insertGetId($dataInsertToDatabase);
                $insertData = DB::table("users")->where('id', $id)->get();
                    //echo($insertData);
                if (count($insertData) > 0) {
                    $tmp_id = DB::table("student_class")->insertGetId(
                        array("student_id" => $id, "class_id" => $class_id, "created_at" =>  date(Util::$date_time_format), "created_by" => auth()->user()->id)
                    );
                    $response = array("result" => 1, "msg" => "Thêm mới thành công!");
                    return response()->json($response);
                } else {
                    $response = array("result" => 0, "msg" => "Thêm mới thất bại!");
                    return response()->json($response);
                }
            }
        }
       // return redirect('admin/ql-lop-hoc/'.$class_id.'/ds-hoc-sinh');
    }


    public function edit_student($id, $class_id)
    {
        //Lấy dữ liệu từ Database với các trường được lấy và với điều kiện id = $id
        $getData = DB::table("users")->select('id', 'last_name', 'first_name' , 'sex' , 'email', 'phone_number' , 'last_name' , 'date_of_birth', "address",  'status')->where('id', $id)->get();
        //Gọi đến file edit.blade.php trong thư mục "resources/views/slide" với giá trị gửi đi tên getSlideById = $getData
        return view('admin.classes.edit_student')
        ->with('getDataById', $getData)
        ->with('class_id', $class_id)
        ;
    }

    public function edit_student_new($id, $class_id)
    {
        //Lấy dữ liệu từ Database với các trường được lấy và với điều kiện id = $id
        $getData = DB::table("users")->select('id', 'last_name', 'first_name' , 'sex' , 'email', 'phone_number' , 'last_name' , 'date_of_birth', "address",  'status')->where('id', $id)->get();
        //Gọi đến file edit.blade.php trong thư mục "resources/views/slide" với giá trị gửi đi tên getSlideById = $getData
        return view('admin.classes.edit_student_new')
        ->with('getDataById', $getData)
        ->with('class_id', $class_id)
        ;
    }

    public function update_student_new(Request $request)
    {
        //Cap nhat sua hoc sinh
        date_default_timezone_set("Asia/Ho_Chi_Minh");
      
        $class_id = $request->class_id;
        $id = $request->id;
        $last_name = Util::removeWhiteSpace(ucwords($request->last_name));
        $first_name = Util::removeWhiteSpace(ucwords($request->first_name));
        $phone_number = $request->phone_number;
        $date_of_birth = $request->date_of_birth;
        $email = $request->email;
        $password = Hash::make($request->password);
        $address = $request->address;
        $sex = $request->sex;
        $status = $request->status;
            //Gán giá trị vào array
        if(trim($request->password)!=""){
            $updateData = array(
                'last_name' => $last_name,
                'first_name' => $first_name,
                'date_of_birth' => $date_of_birth,
                'sex' => $sex,
                'email' => $email,
                'password' => $password,
                'phone_number' => $phone_number,
                'address' => $address,
                'status' => $status ,
                'level' => 2 ,
                'updated_at' => date(Util::$date_time_format),
            );
    
        }else{
            $updateData = array(
                'last_name' => $last_name,
                'first_name' => $first_name,
                'date_of_birth' => $date_of_birth,
                'sex' => $sex,
                'email' => $email,              
                'phone_number' => $phone_number,
                'address' => $address,
                'status' => $status ,
                'level' => 2 ,
                'updated_at' => date(Util::$date_time_format),
            );    
        }
       
        if(Util::checkEmailExists($updateData["email"], $id) == true){
            $response = array("result" => 0, "msg" => "Email này đã tồn tại trong hệ thống!");
            return response()->json($response);
        }else{
            if($this->checkDataExistsStudent($updateData, $id)){
                // Session::flash('error', 'Học Sinh này đã tồn tại!');
                // Session::flash('data', $updateData);
                $response = array("result" => 0, "msg" => "Học Sinh này đã tồn tại!");
                return response()->json($response);
            }else{
                $res = DB::table("users")->where('id', $id)
                ->update($updateData);
                    //Kiểm tra lệnh update để trả về một thông báo
                if ($res) {
                    //Session::flash('success', 'Cập nhật thông tin thành công!');
                    $response = array("result" => 1, "msg" => "Cập nhật thành công!");
                    return response()->json($response);
                } else {
                    // Session::flash('error', 'Cập nhật thông tin thất bại!');
                    // Session::flash('data', $updateData);
                    $response = array("result" => 0, "msg" => "Cập nhật thất bại!");
                    return response()->json($response);
                }
            }
        }
            //Thực hiện chuyển trang
       // return redirect('admin/ql-lop-hoc/'. $id .'/cap-nhat-hs/' . $class_id);
    }


    public function update_student(Request $request)
    {
        //Cap nhat sua hoc sinh
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        //Kiểm tra giá trị tenhocsinh, sodienthoai, khoi
        $this->validate($request,
            [
                //Kiểm tra giá trị rỗng
                'last_name' => 'required',
                'first_name' => 'required',
                'date_of_birth' => 'required',
                'email' => 'required',
               // 'password' => 'required',
            ],
            [
                //Tùy chỉnh hiển thị thông báo
                'last_name.required' => 'Bạn chưa nhập Họ Và Tên Đệm!',
                'first_name.required' => 'Bạn chưa nhập Tên!',
                'email.required' => 'Bạn chưa nhập Email!',
                //'password.required' => 'Bạn chưa nhập Mật Khẩu!',
                'date_of_birth.required' => 'Bạn chưa nhập Ngày Sinh!',
            ]
        );
        $class_id = $request->class_id;
        $id = $request->id;
        $last_name = Util::removeWhiteSpace(ucwords($request->last_name));
        $first_name = Util::removeWhiteSpace(ucwords($request->first_name));
        $phone_number = $request->phone_number;
        $date_of_birth = $request->date_of_birth;
        $email = $request->email;
        $password = Hash::make($request->password);
        $address = $request->address;
         $sex = $request->sex;
        $status = $request->status;
            //Gán giá trị vào array
        if(trim($request->password)!=""){
            $updateData = array(
                'last_name' => $last_name,
                'first_name' => $first_name,
                'date_of_birth' => $date_of_birth,
                'sex' => $sex,
                'email' => $email,
                'password' => $password,
                'phone_number' => $phone_number,
                'address' => $address,
                'status' => $status ,
                'level' => 2 ,
                'updated_at' => date(Util::$date_time_format),
            );
    
        }else{
            $updateData = array(
                'last_name' => $last_name,
                'first_name' => $first_name,
                'date_of_birth' => $date_of_birth,
                'sex' => $sex,
                'email' => $email,              
                'phone_number' => $phone_number,
                'address' => $address,
                'status' => $status ,
                'level' => 2 ,
                'updated_at' => date(Util::$date_time_format),
            );    
        }
       
        if(Util::checkEmailExists($dataInsertToDatabase["email"], null) == true){
            Session::flash('error', 'Email này đã tồn tại trong hệ thống!');
            Session::flash('data', $updateData);
        }else{
            if($this->checkDataExistsStudent($updateData, $id)){
                Session::flash('error', 'Học Sinh này đã tồn tại!');
                Session::flash('data', $updateData);
            }else{
                $res = DB::table("users")->where('id', $id)
                ->update($updateData);
                    //Kiểm tra lệnh update để trả về một thông báo
                if ($res) {
                    Session::flash('success', 'Cập nhật thông tin thành công!');
                } else {
                    Session::flash('error', 'Cập nhật thông tin thất bại!');
                    Session::flash('data', $updateData);
                }
            }
        }
            //Thực hiện chuyển trang
        return redirect('admin/ql-lop-hoc/'. $id .'/cap-nhat-hs/' . $class_id);
    }


    public function checkDataExistsStudent($data, $id){
        $res = false;
        if($id!=null){
            if(DB::table("users")
                ->where('last_name', $data["last_name"])
                ->where('first_name', $data["first_name"])
                ->where('sex', $data["sex"])
                ->where('date_of_birth', $data["date_of_birth"])
                ->where('id',"!=", $id)
                ->exists())
            {
                $res = true;
            }
        }else{
            if(DB::table("users")
                ->where('last_name', $data["last_name"])
                ->where('first_name', $data["first_name"])
                ->where('sex', $data["sex"])
                ->where('date_of_birth', $data["date_of_birth"])
                ->where('id',"!=", $id)
                ->exists())
            {
                $res = true;
            }
        }
        return($res);
    }

    

    public function destroy_student(Request $request)
    {
        try
        {
            $id = $request->input("id");
            if ($id != -1) {
                $deleteData = DB::table("student_class")->where('student_id', $id)->delete();
                $response = array("result" => 1, "msg" => "Xóa thành công!");
            } else {
                $response = array("result" => 0, "msg" => "Không tim thấy dữ liệu!");
            }
            return response()->json($response);
        } catch (exception $ex) {
            $response = array("result" => 0, "msg" => "Lỗi server!");
            return response()->json($response);
        }
    }

    // public function destroy_student($id)
    // {
    //     //Thực hiện câu lệnh xóa với giá trị id = $id trả về
        
    //     $deleteData = DB::table("student_class")->where('student_id', $id)->delete();

    //     //Kiểm tra lệnh delete để trả về một thông báo
    //     if ($deleteData) {
    //         Session::flash('success', 'Xóa thành công!');
    //     } else {
    //         Session::flash('error', 'Xóa thất bại!');
    //     }

    //     //Thực hiện chuyển trang
    //     return redirect('admin/ql-lop-hoc');
    // }

    // public function checkBeforeDeleteClass($id)
    // {
    //     try
    //     {
    //         $res = 0;
    //         if(DB::table("answers")
    //             ->where('student_id', $id)
    //             ->exists()
    //         )
    //         {
    //             $res = $res + 1;
    //         }

    //         if(DB::table("answers")
    //         ->where('exam_id', $id)
    //         ->exists()
    //         )
    //         {
    //             $res = $res + 1;
    //         }

    //         return($res);
    //     } catch (exception $ex) {
    //         return(-1);
    //     }
    // }


}
