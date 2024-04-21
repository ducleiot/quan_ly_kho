<?php
namespace App;

use Illuminate\Support\Facades\DB;

class Util
{

    public static $time_zone = "Asia/Ho_Chi_Minh";
    public static $date_time_format = 'Y-m-d H:i:s';
    public static $gallery_folder = "local/public/upload/gallery";
    public static $answer_file_folder = "uploads/answer_files";
    public static $item_per_page = 10;
    public static $website_title = "ĐOÀN KHÁNH - Đại Lý Lương Thực";

    public static function currency_format($number, $suffix = 'đ') {
        if (!empty($number)) {
            return number_format($number, 0, ',', '.') . " {$suffix}";
        }
    }

    public static function quantity_format($number) {
        if (!empty($number)) {
            return number_format($number, 3, ',', '.');
        }
    }


    public static function GetFullName($table_name, $id){
        $res = "";
        try{
            $data = DB::table($table_name)->where("id",$id)->select(
                array(
                    DB::raw("CONCAT(last_name, ' ', first_name) as full_name")         
                )
            )->first();

            if($data){
                $res = $data->full_name;
            }
        } catch (\Exception $e) 
        {
            $res = "";
        }
        return $res;
    }

    public static function GetDataById($table_name, $id){
        $res = null;
        try{
            $data = DB::table($table_name)->where("id",$id)->select(
            )->first();

            if($data){
                $res = $data;
            }
        } catch (\Exception $e) 
        {
            $res = "";
        }
        return $res;
    }

    public static function processName($name){
        if($name!=null){
            $name = Util::my_ucwords(trim($name));
            $name = str_replace('  ', ' ', $name);
        }
        return $name;
    }


    public static function get_product_by_type ($type_id){
        try {
            $json = null;
            if ($type_id > 0) {
                    $arr_data = DB::table("products")
                    ->where('product_type_id', $type_id)
                    ->where('status', 1)
                    ->select("id", "name")
                    ->orderBy("name", "ASC")
                    ->distinct()
                    ->get();

                $json = $arr_data; 

                // foreach ($arr_data as $key => $item) {
                //     $json[] = array(
                //         "id" => $item->product_id,
                //         "name" => $item->product_name,
                //     );
                // }
            }
            return($json);
        } catch (\exception $ex) {
            return(null);
        }
    }

    public static function my_ucwords($str)
    {
        mb_internal_encoding('UTF-8');
        $string = $str;
        return Util::ucwords_specific( mb_strtolower($string, 'UTF-8'), "-'");
    }

    public static function ucwords_specific ($string, $delimiters = '', $encoding = NULL)
        {
        if ($encoding === NULL) { $encoding = mb_internal_encoding();}

        if (is_string($delimiters))
        {
        $delimiters = str_split( str_replace(' ', '', $delimiters));
        }

        $delimiters_pattern1 = array();
        $delimiters_replace1 = array();
        $delimiters_pattern2 = array();
        $delimiters_replace2 = array();
        foreach ($delimiters as $delimiter)
        {
        $uniqid = uniqid();
        $delimiters_pattern1[] = '/'. preg_quote($delimiter) .'/';
        $delimiters_replace1[] = $delimiter.$uniqid.' ';
        $delimiters_pattern2[] = '/'. preg_quote($delimiter.$uniqid.' ') .'/';
        $delimiters_replace2[] = $delimiter;
        }

        // $return_string = mb_strtolower($string, $encoding);
        $return_string = $string;
        $return_string = preg_replace($delimiters_pattern1, $delimiters_replace1, $return_string);

        $words = explode(' ', $return_string);

        foreach ($words as $index => $word)
        {
        $words[$index] = mb_strtoupper(mb_substr($word, 0, 1, $encoding), $encoding).mb_substr($word, 1, mb_strlen($word, $encoding), $encoding);
        }

        $return_string = implode(' ', $words);

        $return_string = preg_replace($delimiters_pattern2, $delimiters_replace2, $return_string);

        return $return_string;
        }



        public static function get_client_ip() {
            $ipaddress = '';
            if (isset($_SERVER['HTTP_CLIENT_IP']))
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if(isset($_SERVER['HTTP_X_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            else if(isset($_SERVER['HTTP_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            else if(isset($_SERVER['REMOTE_ADDR']))
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            else
                $ipaddress = 'UNKNOWN';
            return $ipaddress;
        }

        public static  function getUserIpAddr()
        {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) //if from shared
            {
                return $_SERVER['HTTP_CLIENT_IP'];
            }
            else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //if from a proxy
            {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else
            {
                return $_SERVER['REMOTE_ADDR'];
            }
        }


        public static function checkEmailExists($email, $id){
        $res = false;
        if($id!=null){
            if(DB::table("users")
                ->where('email', $email)
                ->where('id',"!=", $id)
                ->exists())
            {
                $res = true;
            }
        }else{
            if(DB::table("users")
                ->where('email', $email)
                ->where('id',"!=", $id)
                ->exists())
            {
                $res = true;
            }
        }
        return($res);
    }

    public static function SaveLoginInfo(){
        try
        {
            $user = auth()->user();
            if($user){
                date_default_timezone_set(Util::$time_zone);
                $data = array(
                    "user_id" => $user->id,
                    "email" => $user->email,
                    "time_login" => date(Util::$date_time_format)
                );
                $id = DB::table("log_login_logout")->insertGetId($data);
            }
        } catch (\Exception $e) {
                //echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public static function removeWhiteSpace($text)
    {
        $text = preg_replace('/[\t\n\r\0\x0B]/', '', $text);
        $text = preg_replace('/([\s])\1+/', ' ', $text);
        $text = trim($text);
        return $text;
    }

    public static function utf8convert($str)
    {

        if (!$str) {
            return false;
        }

        $utf8 = array(

            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

            'd' => 'đ|Đ',

            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

            'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',

            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

            'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',

        );

        foreach ($utf8 as $ascii => $uni) {
            $str = preg_replace("/($uni)/i", $ascii, $str);
        }

        return $str;

    }

    public static function utf8tourl($text)
    {

        $text = strtolower(Util::utf8convert($text));

        $text = str_replace("ß", "ss", $text);

        $text = str_replace("%", "", $text);

        $text = preg_replace("/[^_a-zA-Z0-9 -] /", "", $text);

        $text = str_replace(array('%20', ' '), '-', $text);

        $text = str_replace("----", "-", $text);

        $text = str_replace("---", "-", $text);

        $text = str_replace("--", "-", $text);

        return $text;

    }

    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    public static function getAllImagesInFolder($path, $page, $quantity)
    {
        $images = glob("$path/*.{jpg,png,jpeg,bmp,JPG,PNG,JPEG,BMP}", GLOB_BRACE);
        if (count($images) % $quantity > 0) {
            $total_page = (count($images) / $quantity) + 1;
        } else {
            $total_page = count($images) / $quantity;
        }

        if ($page <= $total_page) {
            $selectedFiles = array_slice($images, ($page - 1) * $quantity, $quantity);
        } else {
            $selectedFiles = array();
        }
        return array("data" => $selectedFiles, "page" => $page, "total_page" => $total_page);
    }


    public static function Compare_Datetime ($val1, $val2){
            // $val1 = '2014-03-18 10:34:09.939';
            // $val2 = '2014-03-19 10:35:10.940';

            //$res = (intval(abs((new \DateTime($val1))->getTimestamp() - (new \DateTime($val2))->getTimestamp()) / 60));
        $res = (intval(abs((new \DateTime($val1))->getTimestamp() - (new \DateTime($val2))->getTimestamp())));
        return($res);
    }

    /**
     * @param array $columnNames
     * @param array $rows
     * @param string $fileName
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public static function getCsv($columnNames, $rows, $fileName = 'file.csv') {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . $fileName,
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
        $callback = function() use ($columnNames, $rows ) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columnNames);
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public static function someOtherControllerFunction() {
        $rows = [['a','b','c'],[1,2,3]];//replace this with your own array of arrays
        $columnNames = ['blah', 'yada', 'hmm'];//replace this with your own array of string column headers        
        return Util::getCsv($columnNames, $rows);
    }

    public static function uploadAnswerFile($original_pic, $user_id){
          //$original_pic = $request->file('original_pic');

        $file_extension=$original_pic->getClientOriginalExtension();
        $file_real_name=$original_pic->getClientOriginalName();
        $filename = time() . "_" . $user_id . "_" . $file_real_name . '.' . $file_extension;

            # upload original image
        Storage::put(Util::$answer_file_folder . '/' . $filename, (string) file_get_contents($original_pic), 'public');

            // # croped image from request.
            // $image_parts = explode(";base64,", $request->input('article_image'));
            // $image_base64 = base64_decode($image_parts[1]);

            // Storage::put('ArticlesImages/croped/' . $filename, (string) $image_base64, 'public');

            // # get image from s3 or local storage.
            // $image_get = Storage::get('ArticlesImages/croped/' . $filename);

            // # resize 50 by 50 1x
            // $image_50_50 = Image::make($image_get)
            //         ->resize(340, 227)
            //         ->encode($file_extension, 80);

            // Storage::put('ArticlesImages/1x/' . $filename, (string) $image_50_50, 'public');

        $file_url = Storage::url(Util::$answer_file_folder . '/' . $filename);
        return(array("file_path" => $file_url, "file_name"=>$filename));
    }

    public static function uniqueId($len = 8){
        $better_token = md5(uniqid(rand(), true));
        $rem = strlen($better_token)-$len;
        $unique_code = substr($better_token, 0, -$rem);
        $uniqueid = $unique_code;
        return $uniqueid;
    }

    public static function unique_id($l = 8) {
        return substr(md5(uniqid(mt_rand(), true)), 0, $l);
    }

    public static function convertDate($str_Date){
        $date = str_replace('/', '-', $str_Date);
        return(date('Y-m-d', strtotime($date)));
    }

    public static function genEmail($prefix, $first_name, $last_name, $date_of_birth){
        $prefix = strtolower($prefix);
        $first_name = strtolower(Util::utf8convert($first_name));
        $last_name = strtolower(Util::utf8convert($last_name));
        $date_of_birth = str_replace('-', '', $date_of_birth);
        $arr = explode(" ", $last_name);
        $str = "";
        foreach ($arr as $key => $value) {
            $str = $str . substr($value, 0, 1);
        }
        $str = $prefix . $str . $first_name . "_" . $date_of_birth . "@pa.com";

        return($str);
    }

}
