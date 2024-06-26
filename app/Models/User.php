<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       // 'name',
      //  'id',
        'email',
        'password',
        'level',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    private static function GetUserById($id){
        $data = DB::table("users")->where("id",$id)->first();
        if($data){
            return($data);
        }else{
            return null;
        }
    }

    
    public static function GetFullName($id){
        $res = "";
       // try{
            $data = DB::table("users")->where("id",$id)->select(
                array(
                    DB::raw("CONCAT(last_name, ' ', first_name) as full_name")         
                )
            )->first();

            if($data){
                $res = $data->full_name;
            }
        // } catch (Exception $e) {
        // {
        //     $res = "";
        // }
        return $res;
    }

    
}
