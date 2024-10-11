<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;


class BookController extends Controller
{

    // Phương thức cho người dùng
    public function index()
    {
        $books = Book::all(); // Lấy tất cả sách cho người dùng
        return view('books.index', compact('books')); // Trả về view dành cho người dùng
    }

    // Phương thức cho admin
    public function adminIndex()
    {
        $books = Book::all(); // Lấy tất cả sách cho admin
        return view('admin.books.index', compact('books')); // Trả về view dành cho admin
    }



    public function create()
    {
        return view('admin.books.create'); // Sử dụng view admin nếu muốn
    }


    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'book_code' => 'required|unique:books|max:255',
            'name' => 'required|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        // Tạo sách mới
        Book::create([
            'book_code' => $request->input('book_code'), // Đảm bảo bạn đã lấy giá trị từ form
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'quantity' => $request->input('quantity'),
            'price' => $request->input('price'),
            'created_at' => now(),
        ]);

        // Chuyển hướng về trang danh sách sách với thông báo thành công
        return redirect()->route('admin.books.index')->with('success', 'Sách đã được thêm thành công.');
    }

    public function addToCart(Request $request)
    {
        $book = Book::find($request->input('book_id')); // Tìm sách theo ID
        $cart = session('cart', []);

        // Kiểm tra xem sách đã tồn tại trong giỏ hàng chưa
        if (isset($cart[$book->id])) {
            $cart[$book->id]['quantity'] += $request->input('quantity'); // Tăng số lượng
        } else {
            $cart[$book->id] = [
                'name' => $book->name,
                'quantity' => $request->input('quantity'),
                'price' => $book->price,
                'subtotal' => $book->price * $request->input('quantity'),
            ];
        }

        // Cập nhật session giỏ hàng
        session(['cart' => $cart]);

        return redirect()->route('books.index')->with('success', 'Sách đã được thêm vào giỏ hàng.');
    }



    public function showCart()
    {
        $cart = session()->get('cart', []);

        return view('cart.index', compact('cart'));
    }

    public function checkout()
    {
        // Hiển thị thông tin thanh toán và chi tiết đơn hàng
        return view('checkout.index');
    }

    public function purchase(Request $request)
    {
        // Lấy danh sách sách từ session
        $cart = session('cart', []);

        // Tính tổng số tiền
        $totalAmount = 0;
        $purchasedBooks = [];

        foreach ($cart as $item) {
            $bookDetails = [
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['quantity'] * $item['price'],
            ];

            // Cộng dồn vào tổng số tiền
            $totalAmount += $bookDetails['subtotal'];
            $purchasedBooks[] = $bookDetails;
        }

        // Lưu thông tin đơn hàng vào session
        session(['purchased_books' => $purchasedBooks, 'total_amount' => $totalAmount]);

        // Chuyển hướng đến trang hiển thị chi tiết đơn hàng
        return redirect()->route('order.details');
    }
}
