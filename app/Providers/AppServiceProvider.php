<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

         $employees =  DB::table('users')
                 ->select('*')
                 ->where("level", "=", 2)
                 ->orderBy("first_name", "ASC")
                 ->get();

        View::share('data_employees',  $employees); // <= Truyền dữ liệu


         $customers =  DB::table('customers')
         ->select('customers.*')
         ->orderBy("customers.first_name", "ASC")
         ->get();

        View::share('data_customers',  $customers); // <= Truyền dữ liệu


        $product_types =  DB::table('product_types')
         ->select('product_types.*')
         ->orderBy("product_types.name", "ASC")
         ->get();

        View::share('data_product_types',  $product_types); // <= Truyền dữ liệu


        $packages =  DB::table('packages')
         ->select('packages.*')
         ->orderBy("packages.name", "ASC")
         ->get();

        View::share('data_packages',  $packages); // <= Truyền dữ liệu


        $colors =  DB::table('colors')
         ->select('colors.*')
         ->orderBy("colors.name", "ASC")
         ->get();

        View::share('data_colors',  $colors); // <= Truyền dữ liệu


        //

       // View::share('company_info',  DB::table('contacts')->first()); // <= Truyền dữ liệu
         // View::share('subjects', DB::table('subjects')->where("status","=",1)->orderBy("name", "ASC")->get()); // <= Truyền dữ liệu
         // View::share('school_years', DB::table('school_years')->where("status","=",1)->orderBy("year_open", "DESC")->get()); // <= Truyền dữ liệu
         // View::share('teachers', DB::table('users')->where("status","=",1)->where("level","=",1)->orderBy("first_name", "ASC")->get()); // <= Truyền dữ liệu

        //  $user = auth()->user();
        //  var_dump($user);
        //  $subject_by_teacher =  DB::table('subjects')
        //  ->join('teacher_subject', 'subjects.id', '=', 'teacher_subject.subject_id')
        //  ->where("teacher_subject.subject_id", $user->id)
        //  ->select('subjects.*')
        //  ->get();

        //  View::share('subject_by_teacher', $subject_by_teacher); // <= Truyền dữ liệu

        //  view()->composer('dashboard::layouts.*', function ($view) {
        //     $view->with('user', auth()->user());
        // });

        //  $class_data = [];
        //  $school_year = DB::table('school_years')->where("status","=",1)->get();
        //  foreach($school_year as $item){

        //  }
    }

    // public function boot(Request $request)
    // {
    //     //

    //    // View::share('company_info',  DB::table('contacts')->first()); // <= Truyền dữ liệu
    //      View::share('subjects', DB::table('subjects')->where("status","=",1)->get()); // <= Truyền dữ liệu

    //      $user = $request->user();
    //      var_dump($user);
    //      $subject_by_teacher =  DB::table('subjects')
    //      ->join('teacher_subject', 'subjects.id', '=', 'teacher_subject.subject_id')
    //      ->where("teacher_subject.subject_id", $user->id)
    //      ->select('subjects.*')
    //      ->get();

    //      View::share('subject_by_teacher', $subject_by_teacher); // <= Truyền dữ liệu

    //     //  $class_data = [];
    //     //  $school_year = DB::table('school_years')->where("status","=",1)->get();
    //     //  foreach($school_year as $item){

    //     //  }
    // }


    
}
