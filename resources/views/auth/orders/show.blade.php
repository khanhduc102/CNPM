@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chi tiết đơn hàng #{{ $order->id }}</h1>

    <p>Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</p>
    <p>Tổng tiền:  {{$order->total}} VNĐ</p>

    <table class="table">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
                <th>Hình ảnh</th> <!-- Cột hình ảnh -->
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product) <!-- Lặp qua các sản phẩm -->
                <tr>
                    <!-- Kiểm tra sự tồn tại của khóa 'title' và hiển thị tên sản phẩm -->
                    <td>{{ $product['title'] ?? 'Chưa có tên sản phẩm' }}</td> <!-- Tên sản phẩm -->

                    <!-- Kiểm tra sự tồn tại của khóa 'quantity' và hiển thị số lượng -->
                    <td>{{ $product['quantity'] ?? 0 }}</td> <!-- Số lượng -->

                    <!-- Kiểm tra sự tồn tại của khóa 'price' và hiển thị giá -->
                    <td>{{ number_format(floatval($product['price'] ?? 0), 0, ',', '.') }}₫</td> <!-- Giá -->

                    <!-- Thành tiền (kiểm tra sự tồn tại của 'quantity' và 'price' để tính thành tiền) -->
                    <td>{{ number_format(floatval(($product['quantity'] ?? 0) * ($product['price'] ?? 0)), 0, ',', '.') }}₫</td>

                    <!-- Thêm cột hình ảnh -->
                    <td>
                        @if(isset($product['image']) && !empty($product['image']))
                            <img src="{{ asset('temp/images/product/'.$product['image']) }}" alt="{{ $product['title'] }}" width="100">
                        @else
                            <img src="{{ asset('temp/images/product/.jpg') }}" alt="default image" width="100">
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

