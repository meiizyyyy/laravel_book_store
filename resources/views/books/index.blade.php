@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Danh Sách Sách</h1>

        @if ($books->isEmpty())
            <p>Không có sách nào.</p>
        @else
            <div class="row">
                @foreach ($books as $book)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $book->name }}</h5>
                                <p class="card-text">{{ $book->description }}</p>
                                <p class="card-text">Giá: {{ number_format($book->price, 2) }} VNĐ</p>
                                <p class="card-text">Số Lượng: {{ $book->quantity }}</p>
                                <form action="{{ route('order.addToCart') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                                    <input type="number" name="quantity" value="1" min="1"
                                        max="{{ $book->quantity }}" required class="form-control d-inline"
                                        style="width: 60px; display: inline-block;">
                                    <button type="submit" class="btn btn-primary">Mua</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
