@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Thêm Sách Mới</h1>
        <form action="{{ route('admin.books.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="book_code" class="form-label">Mã sách:</label>
                <input type="text" class="form-control" id="book_code" name="book_code" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Tên sách:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả:</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Số lượng:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá:</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm sách</button>
        </form>
    </div>
@endsection
