<?php
//240429 create
// app/Models/Payment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['customer_id','sale_id','amount_paid', 'date_payment', 'status']; // Đảm bảo các trường cần fillable

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
