@extends('layouts.app')

@section('content')
    <h1>Thêm Sách Mới</h1>
    <form action="{{ route('books.store') }}" method="POST">
        @csrf
        <label for="book_code">Mã sách:</label>
        <input type="text" id="book_code" name="book_code" required><br>

        <label for="name">Tên sách:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="description">Mô tả:</label>
        <textarea id="description" name="description"></textarea><br>

        <label for="quantity">Số lượng:</label>
        <input type="number" id="quantity" name="quantity" required><br>

        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" step="0.01" required><br>

        <button type="submit">Thêm sách</button>
    </form>
@endsection
