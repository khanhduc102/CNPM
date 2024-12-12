@extends('admin.main')

@section('contents')
    <div class="container">
        <h1>Xác nhận Đơn Hàng #{{ $order->id }}</h1>

        <p><strong>Người dùng:</strong> {{ $order->user->name }}</p>
        <p><strong>Tổng tiền:</strong> {{ number_format($order->total) }} VNĐ</p>

        <!-- Hiển thị sản phẩm trong đơn hàng -->
        <h6>Sản phẩm trong đơn hàng:</h6>
        <ul>
            @php
                $products = json_decode($order->products, true);
            @endphp
            @foreach ($products as $product)
                <li>
                    <p><strong>Tên sản phẩm:</strong> {{ $product['title'] }}</p>
                    <p><strong>Giá:</strong> {{ number_format($product['price'], 0, ',', '.') }} VNĐ</p>
                    <p><strong>Số lượng:</strong> {{ $product['quantity'] }}</p>
                    <p><strong>Tổng giá:</strong> {{ number_format($product['subtotal'], 0, ',', '.') }} VNĐ</p>
                </li>
            @endforeach
        </ul>

        <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-success">Xác nhận đơn hàng</button>
        </form>

        <a href="{{ route('admin.orders.index') }}" class="btn btn-danger">Hủy bỏ</a>
    </div>
@endsection
