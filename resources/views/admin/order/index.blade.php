<!-- resources/views/admin/orders/index.blade.php -->
@extends('admin.main')

@section('contents')
    <div class="container-fluid flex-grow-1 container-p-y">
        <h3 class="fw-bold text-primary py-3 mb-4">Danh sách đơn hàng</h3>

        <!-- Hiển thị thông báo thành công hoặc lỗi -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="d-flex p-4 justify-content-between">
                <h5 class="fw-bold">Danh sách đơn hàng</h5>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2">Thông tin đơn hàng</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($orders as $order)
                            <tr>
                                <td><strong>ID:</strong></td>
                                <td>{{ $order->id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Người dùng:</strong></td>
                                <td>{{ $order->user->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tổng tiền:</strong></td>
                                <td>{{$order->total}} VNĐ</td>
                            </tr>
                            <tr>
                              <td><strong>Ngày đặt:</strong> </td>
                              <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Chi tiết:</strong></td>
                                <td>
                                    <ol>
                                        @php
                                            $decodedProducts = json_decode($order->products, true);
                                        @endphp
                                        @foreach($decodedProducts as $product)
                                            <li class="mt-2">
                                                <strong>Sản phẩm:</strong> {{ $product['title'] }}<br>
                                                <strong>Link:</strong> <a href="{{ route('products.details', ['slug' =>$product['slug']]) }}">{{$product['slug']}}</a><br>
                                                <strong>Giá:</strong> {{ number_format($product['price']) }} VNĐ<br>
                                                <strong>Số lượng:</strong> {{ $product['quantity'] }}<br>
                                                <strong>Tổng giá:</strong> {{ number_format($product['subtotal']) }} VNĐ<br>
                                            </li>
                                        @endforeach
                                    </ol>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Trạng thái:</strong></td>
                                <td>
                                    @switch($order->status)
                                        @case('pending')
                                            <span class="badge bg-warning">Chờ xử lý</span>
                                            @break
                                        @case('confirmed')
                                            <span class="badge bg-success">Đã xác nhận</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">Chưa xác định</span>
                                    @endswitch
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Hành động:</strong></td>
                                <td>
                                    @if($order->status == 'pending')
                                    <a href="{{ route('admin.orders.confirm', $order->id) }}" >
                                       
                                       Xác nhận
                                     </a>
                                    @else
                                        <span>Không thể xác nhận</span>
                                    @endif
                                </td>
                            </tr>
                            <tr><td colspan="2"><hr></td></tr> <!-- Dòng phân cách giữa các đơn hàng -->
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination mt-4 pb-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
