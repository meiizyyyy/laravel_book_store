@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Giỏ Hàng</h1>

        @if (session('cart') && count(session('cart')) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Tên Sách</th>
                        <th>Số Lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                        <th>Hành Động</th> <!-- Thêm cột Hành Động -->
                    </tr>
                </thead>
                <tbody>
                    @foreach (session('cart') as $index => $item)
                        <!-- Thêm biến $index -->
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ number_format($item['price'], 2) }} VNĐ</td>
                            <td>{{ number_format($item['subtotal'], 2) }} VNĐ</td>
                            <td>
                                <form action="{{ route('order.remove', $index) }}" method="POST"> <!-- Thay đổi route -->
                                    @csrf
                                    @method('DELETE') <!-- Thêm phương thức DELETE -->
                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button> <!-- Nút xóa -->
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h3>Tổng Tiền: {{ number_format(array_sum(array_column(session('cart'), 'subtotal')), 2) }} VNĐ</h3>
            <!-- Thông báo lỗi nếu có -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('order.purchase') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="customer_name">Tên Khách Hàng</label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="customer_phone">Số Điện Thoại</label>
                    <input type="text" name="customer_phone" id="customer_phone" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="address">Địa Chỉ</label>
                    <input type="text" name="address" id="address" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="note">Ghi Chú</label>
                    <textarea name="note" id="note" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="payment_method">Phương Thức Thanh Toán</label>
                    <select name="payment_method" id="payment_method" class="form-control" required>
                        <option value="COD">Thanh Toán Khi Nhận Hàng</option>
                        <option value="online">Thanh Toán Trực Tuyến</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Xác Nhận Đặt Hàng</button>
            </form>
        @else
            <p>Giỏ hàng trống.</p>
        @endif
    </div>
@endsection
