<?php
//240429 create
// app/Http/Controllers/PaymentController.php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Debt;
use App\Models\Sale;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, $saleId)
    {
        // Lấy thông tin đơn hàng
        $sale = Sale::findOrFail($saleId);

        // Tính toán số tiền còn thiếu
        $remainingAmount = $sale->totalAmount() - $sale->totalPaidAmount();

        // Kiểm tra số tiền thanh toán
        if ($request->input('amount') >= $remainingAmount) {
            // Tạo bản ghi thanh toán
            Payment::create([
                'sale_id' => $sale->id,
                'amount' => $remainingAmount,
            ]);

            // Cập nhật trạng thái thanh toán của đơn hàng là đã thanh toán
            $sale->update(['payment_status' => 'paid']);
        } else {
            // Tạo bản ghi thanh toán không đủ số tiền
            Payment::create([
                'sale_id' => $sale->id,
                'amount' => $request->input('amount'),
            ]);

            // Tính toán số tiền nợ còn lại
            $remainingDebt = $remainingAmount - $request->input('amount');

            // Tạo hoặc cập nhật bản ghi nợ
            Debt::updateOrCreate(
                ['sale_id' => $sale->id],
                ['amount' => $remainingDebt]
            );

            // Cập nhật trạng thái thanh toán của đơn hàng là nợ
            $sale->update(['payment_status' => 'debt']);
        }

        // Thực hiện chuyển hướng hoặc thông báo thành công tùy thuộc vào yêu cầu của bạn
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        return view('payments.edit', compact('payment'));
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update([
            'amount' => $request->input('amount'),
        ]);

        // Thực hiện chuyển hướng hoặc thông báo thành công tùy thuộc vào yêu cầu của bạn
    }
}
