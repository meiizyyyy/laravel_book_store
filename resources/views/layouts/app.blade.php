<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Book Store</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('books.index') }}">Book Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    @auth
                        @if (auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.books.index') }}">Danh sách sách</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.books.create') }}">Thêm sách mới</a>
                            </li>
                            <li class="nav-item">
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    <button type="submit" class="nav-link btn btn-link">Đăng xuất</button>
                                </form>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('order.cart') }}">Giỏ hàng</a>
                        </li>
                        {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form> --}}
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('order.cart') }}">Giỏ hàng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('order.details') }}">Xem đơn hàng</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>



    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>

</html>
