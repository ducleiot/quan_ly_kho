<?php
//240429 create
// app/Models/Sale.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{

    protected $fillable = ['customer_id', 'payment_status', 'employee_id', 'customer_name', 'employee_name', 'date','note','pay_status']; 
    // Đảm bảo các trường cần fillable

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
