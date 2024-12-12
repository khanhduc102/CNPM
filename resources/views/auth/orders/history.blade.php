@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lịch sử đơn hàng của bạn</h1>

    @if ($orders->isEmpty())
        <p>Bạn chưa có đơn hàng nào.</p>
    @else
        <div class="list-group">
            @foreach ($orders as $order)
                <div class="list-group-item">
                    <h5>Đơn hàng #{{ $order->id }}</h5>
                    <p><strong>Người dùng:</strong> {{ $order->user->name }}</p>
                    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Tổng tiền:</strong> {{$order->total}} VNĐ</p>
                    
                    <!-- Hiển thị trạng thái đơn hàng -->
                    <p><strong>Trạng thái:</strong>
                        @switch($order->status)
                            @case('pending')
                                <span class="badge bg-warning">Chờ xử lý</span>
                                @break
                            @case('confirmed')
                                <span class="badge bg-success">Đã xác nhận</span>
                                @break
                            @case('shipped')
                                <span class="badge bg-primary">Đã giao hàng</span>
                                @break
                            @case('completed')
                                <span class="badge bg-info">Hoàn thành</span>
                                @break
                            @default
                                <span class="badge bg-secondary">Chưa xác định</span>
                        @endswitch
                    </p>

                    <h6>Sản phẩm trong đơn hàng:</h6>
                    <ul>
                        @php
                            $products = json_decode($order->products, true);
                        @endphp
                        @foreach ($products as $product)
                           <li>
                                <p><strong>Tên sản phẩm:</strong> {{ $product['title'] ?? 'Chưa có tên sản phẩm' }}</p>
                                <p><strong>Giá:</strong> {{ number_format($product['price'] ?? 0, 0, ',', '.') }} VNĐ</p>
                                <p><strong>Số lượng:</strong> {{ $product['quantity'] ?? 0 }}</p>
                                <p><strong>Tổng giá:</strong> {{ number_format($product['subtotal'] ?? 0, 0, ',', '.') }} VNĐ</p>
                            </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('auth.orders.show', $order->id) }}" class="btn btn-primary">Xem chi tiết</a>

                    <!-- Form Xóa đơn hàng -->
                    <form action="{{ route('auth.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa đơn hàng này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa đơn hàng</button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
