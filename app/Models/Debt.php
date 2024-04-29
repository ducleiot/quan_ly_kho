<?php
//240429 create
// app/Models/Debt.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $fillable = ['customer_id','sale_id','amount_owed, amount_paid','date_create', 'status']; // Đảm bảo các trường cần fillable

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
