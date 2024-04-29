<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use App\Models\User;
use App\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Services\PayUService;
use App\Models\Sale;//240429

class SaleController extends AdminController
{
    private $table_name = "sales";
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.sale.list');
    }
    public function find(Request $request)
    {
        $current = intval($request->input("current"));
        $rowCount = intval($request->input("rowCount"));
        $searchPhrase = $request->input("searchPhrase");
        $query = DB::table($this->table_name . " as itm")
            ->select(
                array(
                    "itm.id",
                    "itm.date",
                    DB::raw("CONCAT(c.last_name, ' ', c.first_name) as customer_name"),
                    DB::raw("CONCAT(u.last_name, ' ', u.first_name) as employee_name"),
                    DB::raw(" (SELECT SUM(total) FROM `sale_details` WHERE sale_id = itm.id) as total"),
                    "itm.note",
                    "itm.pay_status",
                    "itm.created_at",
                    "itm.created_by",
                    "itm.updated_at",
                    "itm.updated_by"
                )
            )
            ->leftJoin("customers AS c", "c.id","=","itm.customer_id")
            ->leftJoin("users AS u", "u.id","=","itm.employee_id")
          ;
        //search
        if (!empty($searchPhrase)) {
            $query->where("c.first_name", "LIKE", '%' . $searchPhrase . "%")
            ->orWhere("u.first_name", "LIKE", '%' . $searchPhrase . "%")
            ->orWhere("c.last_name", "LIKE", '%' . $searchPhrase . "%")
            ->orWhere("u.last_name", "LIKE", '%' . $searchPhrase . "%")
            ;
        }
        //sort
        if (isset($request->sort) && is_array( $request->sort)) {
            foreach ($request->sort as $key => $value) {
                switch ($key) {
                    case "date":
                    $query->orderBy( "itm." . $key, $value);
                    break;
                    case "customer_name":
                    $query->orderBy( "c.first_name", $value);
                    break;
                }
            }
        } else {
            $query->orderBy("itm.date", "desc")
            ->orderBy("itm.id", "asc");
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
                    "customer_name" => $item->customer_name,
                    "employee_name" => $item->employee_name,
                    "date" => $item->date,
                    "note" => $item->note,
                    "total" => Util::currency_format($item->total),
                    "pay_status" => $item->pay_status,//240429
                    "created_at" => $item->created_at,
                    "updated_at" => $item->updated_at,
                    "created_by" => $created_by != null ? $created_by->last_name . " "  . $created_by->first_name : "",
                    "updated_by" => $updated_by != null ? $created_by->last_name . " "  . $created_by->first_name : "",
                );
            }
        }
        return response()->json($json);
    }


    public function save(Request $request)
    {

        $response = array();
        //Lấy giá trị slide đã nhập
        date_default_timezone_set(Util::$time_zone);
        $allRequest = $request->all();
        $customer_id = $allRequest['customer_id'];
        $employee_id = $allRequest['employee_id'];
        $note = $allRequest['note'];
        $date = $allRequest['date'];
        $data = $allRequest['data'];

        $employee_name = Util::GetFullName("users", $employee_id);
        $customer_name = Util::GetFullName("customers", $customer_id);

        // $user = Util::GetUserById($employee_id);
        // $employee_name = $user!=null? $user->last_name : "";

        // $user = User::GetUserById($customer_id);
        // $customer_name = $user!=null? $user->last_name : "";

        // echo $employee_name;

        //Gán giá trị vào array
        $dataInsertToDatabase = array(
            'customer_id' => $customer_id,
            'employee_id' => $employee_id,
            'customer_name' => $customer_name,
            'employee_name' => $employee_name,
            'note' => $note,
            'date' => $date,
            'created_by' => auth()->user()->id,
            'created_at' => date(Util::$date_time_format),
        );

        //Insert
        $id = DB::table($this->table_name)->insertGetId($dataInsertToDatabase);
        $insertData = DB::table($this->table_name)->where('id', $id)->get();
        $count_error_questions = 0;
        $count_error_details = 0;
        if (count($insertData) > 0) {
            foreach ($data as $key => $item) {
                $qty = doubleval($item["qty"]);
                $price = doubleval($item["price"]);

                $product = Util::GetDataById("products", $item["product_id"]);
                $product_name = $product!=null? $product->name : "";

                $package = Util::GetDataById("packages", $item["package_id"]);
                $package_name = $package!=null? $package->name : "";

                $color = Util::GetDataById("colors", $item["color_id"]);
                $color_name = $color!=null? $color->name : "";

                $detail = array(
                    "sale_id" => $id,
                    "product_id" => $item["product_id"],
                    "package_id" => $item["package_id"],
                    "color_id" => $item["color_id"],
                    "product_name" => $product_name,
                    "package_name" => $package_name,
                    "color_name" => $color_name,
                    "quantity" => $qty,
                    "unit" => $item["unit"],
                    "price" => $price,
                    "total" => ($qty*$price),
                    'created_by' => auth()->user()->id,
                    'created_at' => date(Util::$date_time_format)
                );
                $detail_id = DB::table("sale_details")->insertGetId($detail);
                if (count(DB::table("sale_details")->where('id', $detail_id)->get()) <= 0) {
                    $count_error_questions += 1;
                }

            } // end-foreach
            //Session::flash('success', 'Thêm mới thành công!');
            $response = array("result" => 1, "msg" => "Thêm mới thành công!");
        } else {
            //Session::flash('error', 'Thêm mới thất bại!');
            $response = array("result" => 0, "msg" => "Thêm mới thất bại!");
        }

        return response()->json($response);
        //Thực hiện chuyển trang
        //return redirect('admin/ql-bai-kiem-tra/create');
    }


    public function create()
    {
        return view('admin.sale.create');
    }


    public function viewDetails($id)
    {
       // \Log::info($id);

        if ($id) {
           
            $data =  DB::table("sale_details")
            ->where("sale_id", $id)
            ->select()
            ->get()
            ;

            $sale =  DB::table("sales")
            ->where("id", $id)
            ->select()
            ->get()
            ;

            return view("admin/sale/viewdetails")
            ->with("data", $data)
            ->with("sale", $sale)
            ;
        }
        return view("admin/sale/viewdetails")
        ;
    }

    public function addProduct(Request $request)
    {
        if ($request->has("data")) {
            $data = $request->input("data");
            return view("admin/sale/open")
            ->with("data", $data)
            ;
        }
        return view("admin/sale/open")
        ;
    }

    public function get_products(Request $request)
    {
        try {
            $json = array();
            $product_type_id = $request->input("product_type_id");
            if ($product_type_id > 0 ) {
                $arr_data = DB::table("products as itm")
                ->where('itm.product_type_id', $product_type_id)
                ->where('itm.status', 1)
                // ->select(array("itm.id as product_id", DB::raw("CONCAT (itm.name, ' - ', p.name, ' - ', c.name) as product_name")))
                ->select(  array("itm.id as product_id", "itm.name as product_name", "itm.unit as product_unit"))
                ->distinct()
                ->get();
                foreach ($arr_data as $key => $item) {
                    $json[] = array(
                        "id" => $item->product_id,
                        "name" => $item->product_name,
                        "unit" => $item->product_unit
                    );
                }

                $response = array("result" => 1, "data" => $json, "msg" => "");
            } else {
                $response = array("result" => 0, "data" => $json, "msg" => "Không tim thấy dữ liệu!");
            }
            return response()->json($response);
        } catch (\Exception $ex) {
            $response = array("result" => 0, "msg" => "Lỗi server!");
            return response()->json($response);
        }
    }


    public function get_product_info(Request $request)
    {
        try {
            $json = array();
            $product_id = $request->input("product_id");
            if ($product_id > 0 ) {
                $arr_data = DB::table("products as itm")
                            ->leftJoin("product_types AS t", "t.id","=","itm.product_type_id")
                            ->where('itm.id', $product_id)
                ->where('itm.status', 1)
                ->select(array("itm.id as product_id", "itm.name as product_name", "itm.product_type_id as product_type_id", "itm.description as description", "t.name as product_type_name","itm.unit as unit"
                                , "itm.created_at", "itm.updated_at", "itm.created_by", "itm.updated_by"
                            ))
                ->distinct()
                ->get();
                if(count($arr_data) == 1){
                    $item = $arr_data[0];
                    $created_by = User::find($item->created_by);
                    $updated_by = User::find($item->updated_by);
                    $json[] = array(
                        "id" => $item->product_id,
                        "name" => $item->product_name,
                        "description" => $item->description,
                        "unit" => $item->unit,
                        "product_type_id" => $item->product_type_id,
                        "product_type_name" => $item->product_type_name,
                        "created_at" => $item->created_at,
                        "updated_at" => $item->updated_at,
                        "created_by" => $created_by != null ? $created_by->last_name . " "  . $created_by->first_name : "",
                        "updated_by" => $updated_by != null ? $created_by->last_name . " "  . $created_by->first_name : "",
                    );
                }
                $response = array("result" => 1, "data" => $json, "msg" => "");
            } else {
                $response = array("result" => 0, "data" => $json, "msg" => "Không tim thấy dữ liệu!");
            }
            return response()->json($response);
        } catch (\Exception $ex) {
            $response = array("result" => 0, "msg" => "Lỗi server!");
            return response()->json($response);
        }
    }


    public function open($id)
    {
        $getData = null;
        if($id > - 1)
        {
            $getData = DB::table($this->table_name)->where("id","=",$id)->get();
        }
        return view('admin.sale.open')->with('data',$getData);
    }


    // public function save(Request $request)
    // {
    //     try
    //     {
    //         $id =$request->input("id");
    //         $name =trim($request->input("name"));
    //         $product_type_id =trim($request->input("product_type_id"));
    //         $package_id =trim($request->input("package_id"));
    //         $color_id =trim($request->input("color_id"));
    //         $quantity =trim($request->input("quantity"));
    //         $unit =trim($request->input("unit"));
    //         $description =trim($request->input("description"));
    //         $status = $request->input("status");

    //         $name =  Util::processName($name);

    //         $arr_data = array(
    //             'name' => $name,
    //             'product_type_id' => $product_type_id,
    //             'package_id' => $package_id,
    //             'color_id' => $color_id,
    //             'quantity' => $quantity,
    //             'unit' => $unit,
    //             'description' => $description,
    //             'status' => $status
    //         );
    //          if($this->checkDataExists($arr_data, $id)){
    //             $response = array("result" => 0, "msg" => "Dữ liệu đã tồn tại!");
    //          }else{
    //              if($id>-1){
    //                 $arr_data["updated_by"] = auth()->user()->id;
    //                 $arr_data["updated_at"] = date(Util::$date_time_format);
    //                 DB::table($this->table_name)
    //                     ->where('id', $id)
    //                     ->update($arr_data);
    //                    $response = array("result" => 1, "msg" => "Cập nhật thành công!");

    //            }else{
    //                 $arr_data["created_by"] = auth()->user()->id;
    //                 $arr_data["created_at"] = date(Util::$date_time_format);
    //                 DB::table($this->table_name)->insert(
    //                    $arr_data
    //                 );
    //                 $response = array("result" => 1, "msg" => "Thêm mới thành công!");
    //             }
    //         }

    //         return response()->json($response);
    //     }
    //     catch (exception $ex)
    //     {
    //         $response = array("result" => 0, "msg" => "Thêm thất bại!");
    //         return response()->json($response);
    //     }
    // }

    public function checkDataExists($data, $id){
        $res = false;
        if($id>-1){
            if(DB::table($this->table_name)
                ->where('name', $data["name"])
                ->where('product_type_id',"=", $data["product_type_id"])
                ->where('package_id',"=", $data["package_id"])
                ->where('color_id',"=", $data["color_id"])
                ->where('id',"!=", $id)
                ->exists())
            {
                $res = true;
            }
        }else{
            if(DB::table($this->table_name)
                ->where('name', $data["name"])
                ->where('product_type_id',"=", $data["product_type_id"])
                ->where('package_id',"=", $data["package_id"])
                ->where('color_id',"=", $data["color_id"])
                ->exists())
            {
                $res = true;
            }
        }
        return($res);
    }

    // public function destroy($id)
    // {
    //     if($this->checkBeforeDelete($id)==0){
    //         $deleteData = DB::table($this->table_name)->where('id', $id)->delete();
    //         if ($deleteData) {
    //             Session::flash('success', 'Xóa thành công!');
    //         } else {
    //             Session::flash('error', 'Xóa thất bại!');
    //         }
    //     }else{
    //         Session::flash('error', 'Không thể xóa. Dữ liệu đã được dùng cho các chức năng khác!');
    //     }

    //     return redirect('admin/ql-mon-hoc');
    // }

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
        } catch (\Exception $ex) {
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
                    $deleteDetails = DB::table("sale_details")->where('sale_id', $item)->delete();
                    $deletePay = DB::table("sale_pays")->where('sale_id', $item)->delete();
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
        } catch (\Exception $ex) {
            $response = array("result" => 0, "msg" => "Xóa thất bại!");
            return response()->json($response);
        }
    }

    public function checkBeforeDelete($id)
    {
        try
        {
            $res = 0;
            // if(DB::table("sale_details")
            //     ->where('product_id', $id)
            //     ->exists()
            // )
            // {
            //     $res = $res + 1;
            // }

            // if(DB::table("purchase_details")
            //     ->where('product_id', $id)
            //     ->exists()
            // )
            // {
            //     $res = $res + 1;
            // }
            return($res);
        } catch (\Exception $ex) {
            return(-1);
        }
    }
    public function pay(Request $request, $id)
    {
        /* 240429 tmp code
        $sale = Sale::findOrFail($id);
        $totalAmount = $sale->totalAmount();
        $paidAmount = $sale->totalPaidAmount();

        $amount = $request->input('amount');
        $remainingAmount = $totalAmount - $paidAmount;

        if ($amount >= $remainingAmount) {
            Payment::create([
                'sale_id' => $sale->id,
                'amount' => $remainingAmount,
            ]);

            $sale->update(['payment_status' => 'paid']);
        } else {
            Payment::create([
                'sale_id' => $sale->id,
                'amount' => $amount,
            ]);

            $remainingDebt = $remainingAmount - $amount;

            Debt::updateOrCreate(
                ['customer_id' => $sale->customer_id],
                ['amount' => $remainingDebt]
            );

            $sale->update(['payment_status' => 'debt']);
        }

        return redirect()->back()->with('success', 'Thanh toán thành công.');
        */
    }

}
