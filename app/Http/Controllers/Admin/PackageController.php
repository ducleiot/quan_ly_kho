<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\User;
use App\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PackageController extends AdminController
{
    private $table_name = "packages";
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.'.$this->table_name.'.list')->with("aa", User::find(1));
    }
    public function find(Request $request)
    {
        $current = intval($request->input("current"));
        $rowCount = intval($request->input("rowCount"));
        $searchPhrase = $request->input("searchPhrase");
        $query = DB::table($this->table_name);
        //search
        if (!empty($searchPhrase)) {
            $query->where($this->table_name . ".name", "LIKE", '%' . $searchPhrase . "%")
            ;
        }
        //sort
        if (isset($request->sort) && is_array( $request->sort)) {
            foreach ($request->sort as $key => $value) {
                switch ($key) {
                    case "status":
                    $query->orderBy( $this->table_name . "." . $key, $value);
                    break;
                    case "name":
                    $query->orderBy( $this->table_name . "." . $key, $value);
                    break;
                }
            }
        } else {
            $query->orderBy($this->table_name . ".name", "asc")
            ->orderBy($this->table_name . ".id", "desc");
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
        $data = $query->get();
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
                    "description" => $item->description,
                    "status" => $item->status,
                    "created_at" => $item->created_at,
                    "updated_at" => $item->updated_at,
                    "created_by" => $created_by != null ? $created_by->last_name . " "  . $created_by->first_name : "",
                    "updated_by" => $updated_by != null ? $created_by->last_name . " "  . $created_by->first_name : "",
                );
            }
        }
        return response()->json($json);
    }

    public function open($id)
    {
        $getData = null;
        if($id > - 1)
        {
            $getData = DB::table($this->table_name)->where("id","=",$id)->get();
        }
        return view('admin.'.$this->table_name.'.open')->with('data',$getData);
    }


    public function save(Request $request)
    {
        try
        {
            $id =$request->input("id");
            $name =trim($request->input("name"));
            $description =trim($request->input("description"));
            $status = $request->input("status");

            $name =  Util::processName($name);

            $arr_data = array(
                'name' => $name,
                'description' => $description,
                'status' => $status
            );
             if($this->checkDataExists($arr_data, $id)){
                $response = array("result" => 0, "msg" => "Dữ liệu đã tồn tại!");
             }else{
                 if($id>-1){
                    $arr_data["updated_by"] = auth()->user()->id;
                    $arr_data["updated_at"] = date(Util::$date_time_format);
                    DB::table($this->table_name)
                        ->where('id', $id)
                        ->update($arr_data);
                       $response = array("result" => 1, "msg" => "Cập nhật thành công!");

               }else{
                    $arr_data["created_by"] = auth()->user()->id;
                    $arr_data["created_at"] = date(Util::$date_time_format);
                    DB::table($this->table_name)->insert(
                       $arr_data
                    );
                    $response = array("result" => 1, "msg" => "Thêm mới thành công!");
                }
            }

            return response()->json($response);
        }
        catch (exception $ex)
        {
            $response = array("result" => 0, "msg" => "Thêm thất bại!");
            return response()->json($response);
        }
    }

    public function checkDataExists($data, $id){
        $res = false;
        if($id>-1){
            if(DB::table($this->table_name)
                ->where('name', $data["name"])
                ->where('id',"!=", $id)
                ->exists())
            {
                $res = true;
            }
        }else{
            if(DB::table($this->table_name)
                ->where('name', $data["name"])
                ->exists())
            {
                $res = true;
            }
        }
        return($res);
    }

    public function destroy($id)
    {
        if($this->checkBeforeDelete($id)==0){
            $deleteData = DB::table($this->table_name)->where('id', $id)->delete();
            if ($deleteData) {
                Session::flash('success', 'Xóa thành công!');
            } else {
                Session::flash('error', 'Xóa thất bại!');
            }
        }else{
            Session::flash('error', 'Không thể xóa. Dữ liệu đã được dùng cho các chức năng khác!');
        }

        return redirect('admin/ql-mon-hoc');
    }

    public function status(Request $request)
    {
        try
        {
            $id = $request->input("id");
            $status = $request->input("status");
            if ($id != -1) {
                DB::table($this->table_name)->where('id', $id)
                ->update(['status' => $status]);
                $response = array("result" => 1, "msg" => "Cập Nhật thành công!");
            } else {
                $response = array("result" => 0, "msg" => "Không tim thấy dữ liệu!");
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
                if($this->checkBeforeDelete($item)==0){
                    $deleteData = DB::table($this->table_name)->where('id', $item)->delete();
                    if ($deleteData) {
                        $count += 1;
                    }
                }
            }
            if ($count == count($arr_id)) {
                $response = array("result" => 1, "msg" => "Xóa thành công!");
            } else {
                if ($count == 0) {
                    $response = array("result" => 0, "msg" => "Không thể xóa. Dữ liệu đã được dùng cho các chức năng khác!");
                } else {
                    $response = array("result" => 2, "msg" => "Một số dữ liệu không thể xóa được do đã được dùng cho các chức năng khác!");
                }
            }
            return response()->json($response);
        } catch (exception $ex) {
            $response = array("result" => 0, "msg" => "Xóa thất bại!");
            return response()->json($response);
        }
    }

    public function checkBeforeDelete($id)
    {
        try
        {
            $res = 0;
            if(DB::table("quantities")
                ->where('package_id', $id)
                ->exists()
            )
            {
                $res = $res + 1;
            }

            return($res);
        } catch (exception $ex) {
            return(-1);
        }
    }
}
