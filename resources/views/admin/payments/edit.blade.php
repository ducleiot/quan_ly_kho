<!-- payments/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Cập nhật thanh toán</h1>
    <form action="{{ route('payments.update', $payment->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="amount">Số tiền thanh toán:</label>
            <input type="number" name="amount" id="amount" class="form-control" value="{{ $payment->amount }}">
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
@endsection
