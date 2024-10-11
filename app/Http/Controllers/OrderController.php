<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    // Thêm sách vào giỏ hàng
    public function addToCart(Request $request)
    {
        $bookId = $request->input('book_id');
        $quantity = $request->input('quantity');

        // Lấy thông tin sách từ database
        $book = Book::find($bookId);

        if ($book) {
            // Tạo thông tin sách để thêm vào giỏ hàng
            $cartItem = [
                'id' => $book->id,
                'name' => $book->name,
                'quantity' => $quantity,
                'price' => $book->price,
                'subtotal' => $book->price * $quantity,
                'book_code' => $book->book_code, // Thêm book_code vào giỏ hàng
            ];

            // Lưu vào session giỏ hàng
            $cart = session()->get('cart', []);
            $cart[] = $cartItem;
            session()->put('cart', $cart);
        } else {
            return redirect()->route('order.cart')->withErrors('Sách không tồn tại.');
        }

        return redirect()->route('order.cart')->with('success', 'Sách đã được thêm vào giỏ hàng.');
    }

    // Hiển thị giỏ hàng
    public function cart()
    {
        return view('order.cart');
    }

    // Xử lý thanh toán
    public function purchase(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'note' => 'nullable|string',
            'payment_method' => 'required|string',
        ]);

        // Kiểm tra xem giỏ hàng có tồn tại không
        $cart = session('cart');

        if (empty($cart)) {
            return redirect()->route('order.cart')->withErrors('Giỏ hàng trống. Vui lòng thêm sách vào giỏ hàng trước khi thanh toán.');
        }

        // Tính tổng tiền
        $totalAmount = array_sum(array_column($cart, 'subtotal'));

        // Tạo đơn hàng
        $order = Order::create([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'address' => $request->address,
            'note' => $request->note,
            'total_amount' => $totalAmount,
            'payment_method' => $request->payment_method,
        ]);

        // Thêm các mục vào OrderItems
        foreach ($cart as $item) {
            // Kiểm tra xem book_code có tồn tại không
            if (!isset($item['book_code'])) {
                return redirect()->route('order.cart')->withErrors('Lỗi: thông tin sách không đầy đủ.');
            }

            // Thêm mục vào OrderItems
            OrderItem::create([
                'order_id' => $order->id,
                'book_code' => $item['book_code'], // Đảm bảo book_code tồn tại
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Xóa giỏ hàng sau khi hoàn tất đơn hàng
        session()->forget('cart');

        // Chuyển hướng đến trang chi tiết đơn hàng
        return redirect()->route('order.details')->with([
            'success' => 'Đặt hàng thành công!',
            'purchased_books' => $cart, // Lưu giỏ hàng vào session
            'total_amount' => $totalAmount,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'address' => $request->address,
            'note' => $request->note,
        ]);
    }


    public function removeFromCart($index)
    {
        // Lấy giỏ hàng từ session
        $cart = session('cart');

        // Kiểm tra xem chỉ mục có tồn tại không
        if (isset($cart[$index])) {
            // Xóa sản phẩm khỏi giỏ hàng
            unset($cart[$index]);

            // Cập nhật lại giỏ hàng trong session
            session()->put('cart', array_values($cart)); // array_values để làm lại chỉ mục
        }

        return redirect()->route('order.cart')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }

    public function deleteOrder()
    {
        // Xóa thông tin đơn hàng khỏi session
        session()->forget(['purchased_books', 'total_amount', 'customer_name', 'customer_phone', 'address', 'note']);

        return redirect()->route('order.cart')->with('success', 'Đơn hàng đã được xóa.');
    }


    public function showOrderDetails()
    {
        // Lấy thông tin đơn hàng từ session hoặc database
        // Nếu bạn lưu thông tin đơn hàng vào session khi tạo đơn hàng
        $orderDetails = session('order_details');

        return view('order.details', compact('orderDetails'));
    }
}
