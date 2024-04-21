<?php
namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Util;
use PHPExcel; 
use PHPExcel_IOFactory;
class ExcelTool
{
    public static function ImportStudentForClass($prefix, $excel_file, $class_id)
    {
        //$excel_file = "aaa.xlsx";
       // $excel_file = "aaa.xlsx";
        //$objPHPExcel = PHPExcel_IOFactory::load(base_path($excel_file)); // load file ra object PHPExcel
        $objPHPExcel = PHPExcel_IOFactory::load($excel_file); // load file ra object PHPExcel
        //$objPHPExcel = PHPExcel_IOFactory::load(Storage::url($excel_file)); // load file ra object PHPExcel
        $workSheet = $objPHPExcel->setActiveSheetIndex(0); // Set sheet sẽ được đọc dữ liệu
        $highestRow    = $workSheet->getHighestRow(); // Lấy số row lớn nhất trong sheet
        $data = [];
        $last_name = "";
        $first_name = "";
        $pass = "12345678"; //Util::uniqueId(8);
        $tmp_date = null;
        $prefix = strtolower($prefix);
  

        for ($row = 2; $row <= $highestRow; $row++) { // For chạy từ 2 vì row 1 là title
            $last_name  = Util::removeWhiteSpace(ucwords($workSheet->getCellByColumnAndRow(0, $row)->getValue()));
            $first_name = Util::removeWhiteSpace(ucwords($workSheet->getCellByColumnAndRow(1, $row)->getValue()));
            $tmp_date   = Util::convertDate(Util::removeWhiteSpace(ucwords($workSheet->getCellByColumnAndRow(2, $row)->getValue())));
            $tmp_email = Util::genEmail($prefix, $first_name, $last_name, $tmp_date);

            $data[] = array(
                "last_name" => $last_name,
                "first_name" => $first_name,
                "date_of_birth" => $tmp_date,
                "sex" => intval(Util::removeWhiteSpace(ucwords($workSheet->getCellByColumnAndRow(3, $row)->getValue()))),
                "email" => $tmp_email,
                "password" => $pass,
                "phone_number" => Util::removeWhiteSpace(ucwords($workSheet->getCellByColumnAndRow(4, $row)->getValue())),
                "address" => Util::removeWhiteSpace(ucwords($workSheet->getCellByColumnAndRow(5, $row)->getValue())), 
                'status' => 1 ,
                'level' => 2 ,
                'created_at' => date(Util::$date_time_format),
            );
        }    
        return($data);
    }

    public static function ExportDataUser($data, $file_name){
        $objPHPExcel = new \PHPExcel();
        $folder = "public/excel_files";
       // foreach ($provinces as $key => $province) {
           $key = 0;
            $objPHPExcel->createSheet(); // tạo 1 sheet mới
            $activeSheet = $objPHPExcel->setActiveSheetIndex($key);
            $activeSheet->setTitle("Sheet 1"); // đặt tên sheet là tên tỉnh
            $activeSheet->setCellValue('A1', 'Họ Và Đệm')
                        ->setCellValue('B1', 'Tên')
                        ->setCellValue('C1', 'Ngày Sinh') 
                        ->setCellValue('D1', 'Giới Tính') 
                        ->setCellValue('E1', 'Số Điện Thoại') 
                        ->setCellValue('F1', 'Địa Chỉ') 
                        ->setCellValue('G1', 'Email') 
                        ->setCellValue('H1', 'Mật Khẩu') 
                        ->setCellValue('I1', 'Trạng Thái') ;
            $i = 2;
            $j = 2;
            foreach ($data as $key => $value) {
                $activeSheet->setCellValue("A$i", $value["last_name"]); 
                $activeSheet->setCellValue("B$i", $value["first_name"]); 
                $activeSheet->setCellValue("C$i", $value["date_of_birth"]); 
                $activeSheet->setCellValue("D$i", $value["sex"]); 
                $activeSheet->setCellValue("E$i", $value["phone_number"]); 
                $activeSheet->setCellValue("F$i", $value["address"]); 
                $activeSheet->setCellValue("G$i", $value["email"]); 
                $activeSheet->setCellValue("H$i", $value["password"]); 
                $activeSheet->setCellValue("I$i", $value["status"]); 
                $i = $i + 1;
            }
            //foreach ($province->districts as $district) {
            // for($step=0;$step<10;$step++){ 
            //     $activeSheet->setCellValue("A$i", "AAAAA" . ' ' . "BBBBBB"); // set tên quận/huyện
            //     //foreach ($district->wards as $ward) {
            //         $activeSheet->setCellValue("B$j", "CCCC" . ' ' . "DDD"); // tương ứng mỗi quận huyện set tên xã/phường
            //         $activeSheet->setCellValue("C$j", "EEEEEEE");
            //         $j++;
            //    // }
            //     $rowMerge = $j - 1;
            //     if ($i < $rowMerge) {
            //         $activeSheet->mergeCells("A$i:A$rowMerge"); // merge các cell có cùng 1 quận/huyện
            //     }
            //     $i = $j;
            // }
            
            foreach (range('A', 'I') as $columnId) {
                $activeSheet->getColumnDimension($columnId)->setAutoSize(true);
            }
       // }
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $path = storage_path('app/' . $folder . '/' . $file_name) ;// "public/" . $file_name;     
        $objWriter->save($path);
       // $objWriter->save(base_path($path));
        return($folder . '/' . $file_name);
    }

    public static function ExportDataUserOfClass($data){
        date_default_timezone_set(Util::$time_zone);
        $objPHPExcel = new \PHPExcel();
        $folder = "public/excel_files";
        $file_name = "";
        $current_date_time = date("Ymd_hms");
       // foreach ($provinces as $key => $province) {
           $key = 0;
            $objPHPExcel->createSheet(); // tạo 1 sheet mới
            $activeSheet = $objPHPExcel->setActiveSheetIndex($key);
            $activeSheet->setTitle("Sheet 1"); // đặt tên sheet là tên tỉnh

            $activeSheet->setCellValue('A1', 'Họ Và Đệm')
                        ->setCellValue('B1', 'Tên')
                        ->setCellValue('C1', 'Ngày Sinh') 
                        ->setCellValue('D1', 'Giới Tính') 
                        ->setCellValue('E1', 'Số Điện Thoại') 
                        ->setCellValue('F1', 'Địa Chỉ') 
                        ->setCellValue('G1', 'Email') ;
            $i = 2;
            $j = 2;
            foreach ($data as $key => $value) {
                $temp_date = date('d/m/Y', strtotime($value->date_of_birth));

                $activeSheet->setCellValue("A$i", $value->last_name); 
                $activeSheet->setCellValue("B$i", $value->first_name); 
                $activeSheet->setCellValue("C$i", $temp_date); 
                $activeSheet->setCellValue("D$i", $value->sex); 
                $activeSheet->setCellValue("E$i", $value->phone_number); 
                $activeSheet->setCellValue("F$i", $value->address); 
                $activeSheet->setCellValue("G$i", $value->email); 
                $i = $i + 1;
                if($file_name==""){
                    $file_name = "DSHS_" . $value->class_name. "_" . $current_date_time .".xlsx";
                }
            }
           
            foreach (range('A', 'G') as $columnId) {
                $activeSheet->getColumnDimension($columnId)->setAutoSize(true);
            }
       // }
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $path = storage_path('app/' . $folder . '/' . $file_name) ;// "public/" . $file_name;     
        $objWriter->save($path);
       // $objWriter->save(base_path($path));
        return(array("path" => $folder . "/" . $file_name, "file_name" => $file_name));
    }

    public static function ExportData(){
        $objPHPExcel = new \PHPExcel();
    
       // foreach ($provinces as $key => $province) {
           $key = 0;
            $objPHPExcel->createSheet(); // tạo 1 sheet mới
            $activeSheet = $objPHPExcel->setActiveSheetIndex($key);
            $activeSheet->setTitle("DUC"); // đặt tên sheet là tên tỉnh
            $activeSheet->setCellValue('A1', 'Quận/Huyện')
                ->setCellValue('B1', 'Xã/Phường')
                ->setCellValue('C1', 'Kinh độ, vĩ độ'); // set title cho dòng đầu tiên
            $i = 2;
            $j = 2;
            //foreach ($province->districts as $district) {
            for($step=0;$step<10;$step++){ 
                $activeSheet->setCellValue("A$i", "AAAAA" . ' ' . "BBBBBB"); // set tên quận/huyện
                //foreach ($district->wards as $ward) {
                    $activeSheet->setCellValue("B$j", "CCCC" . ' ' . "DDD"); // tương ứng mỗi quận huyện set tên xã/phường
                    $activeSheet->setCellValue("C$j", "EEEEEEE");
                    $j++;
               // }
                $rowMerge = $j - 1;
                if ($i < $rowMerge) {
                    $activeSheet->mergeCells("A$i:A$rowMerge"); // merge các cell có cùng 1 quận/huyện
                }
                $i = $j;
            }
            
            foreach (range('A', 'C') as $columnId) {
                $activeSheet->getColumnDimension($columnId)->setAutoSize(true);
            }
       // }
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save(base_path('result.xlsx'));
    }
}