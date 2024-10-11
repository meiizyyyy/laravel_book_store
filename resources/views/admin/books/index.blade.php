@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Danh sách Sách</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tên sách</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td>{{ $book->name }}</td>
                        <td>{{ number_format($book->price, 2) }} VND</td>
                        <td>{{ $book->quantity }}</td>
                        <td>
                            {{-- <form action="{{ route('books.purchase') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <input type="number" name="quantity" min="1" max="{{ $book->quantity }}"
                                    value="1" required>
                                <button type="submit" class="btn btn-success btn-sm">Mua</button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
