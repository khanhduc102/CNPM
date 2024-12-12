<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
      
        $orders = Order::orderByDesc('created_at')->paginate(10);
        return view('admin.order.index',compact('orders'),[
            'title' => 'Quản lý đơn hàng'
        ]);
    }
    // Trong App/Http/Controllers/admin/OrderController.php
// Trong App/Http/Controllers/admin/OrderController.php

public function confirm(Order $order)
{

    if ($order->status == 'pending') {
        $order->status = 'confirmed';
        $order->save();

        \Log::info('Đơn hàng đã được xác nhận', [
            'order_id' => $order->id,
            'new_status' => $order->status
        ]);

        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được xác nhận!');
    }

    return redirect()->route('orders.index')->with('error', 'Đơn hàng không thể xác nhận!');
}

public function showConfirmPage(Order $order)
{
    // Kiểm tra nếu đơn hàng đang trong trạng thái 'pending'
    if ($order->status !== 'pending') {
        return redirect()->route('admin.orders.index')->with('error', 'Đơn hàng không thể xác nhận!');
    }

    return view('admin.orders.confirm', compact('order'));
}


}
