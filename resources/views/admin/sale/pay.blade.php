<!-- sales/pay.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Thanh toán đơn hàng</h1>
    <p>Tổng tiền đơn hàng: {{ $sale->totalAmount() }}</p>
    <form action="{{ route('sales.pay', $sale->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="amount">Nhập số tiền thanh toán:</label>
            <input type="number" name="amount" id="amount" class="form-control" min="0" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-primary">Thanh toán</button>
    </form>
@endsection
