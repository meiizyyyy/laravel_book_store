@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Chi Tiết Đơn Hàng</h1>
        <h3>Sách Đã Mua</h3>

        @if (session('purchased_books'))
            <table class="table">
                <thead>
                    <tr>
                        <th>Tên Sách</th>
                        <th>Số Lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (session('purchased_books') as $book)
                        <tr>
                            <td>{{ $book['name'] }}</td>
                            <td>{{ $book['quantity'] }}</td>
                            <td>{{ number_format($book['price'], 2) }} VNĐ</td>
                            <td>{{ number_format($book['subtotal'], 2) }} VNĐ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h3>Tổng Tiền: {{ number_format(session('total_amount'), 2) }} VNĐ</h3>

            <h3>Thông Tin Khách Hàng</h3>
            <p>Tên: {{ session('customer_name') }}</p>
            <p>SĐT: {{ session('customer_phone') }}</p>
            <p>Địa Chỉ: {{ session('address') }}</p>
            <p>Ghi Chú: {{ session('note') }}</p>

            <form action="{{ route('order.delete') }}" method="POST" style="margin-top: 20px;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Xóa Đơn Hàng</button>
            </form>
        @else
            <p>Không có thông tin đơn hàng.</p>
        @endif
    </div>
@endsection
