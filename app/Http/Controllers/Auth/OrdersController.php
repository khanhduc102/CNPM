<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    // Hiển thị lịch sử đơn hàng của khách hàng
    public function orderHistory()
    {
        $orders = Order::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('auth.orders.history', compact('orders'));
    }
    public function index()
{
    $orders = Order::with('user')->get(); // Lấy danh sách đơn hàng, bao gồm cả thông tin người dùng
    return view('orders.index', compact('orders'));
}


    // Hiển thị chi tiết một đơn hàng
    public function showOrder(Order $order)
    {
        // Kiểm tra nếu đơn hàng thuộc về người dùng đang đăng nhập
        if ($order->user_id != auth()->id()) {
            return redirect()->route('auth.orders.history')->with('error', 'Bạn không có quyền xem đơn hàng này.');
        }

        // Giải mã sản phẩm trong đơn hàng
        $products = json_decode($order->products, true); // Giải mã JSON để có dữ liệu sản phẩm

        return view('auth.orders.show', compact('order', 'products'));
    }
    public function destroy(Order $order)
{
    // Kiểm tra nếu đơn hàng thuộc về người dùng đang đăng nhập
    if ($order->user_id != auth()->id()) {
        return redirect()->route('auth.orders.history')->with('error', 'Bạn không có quyền xóa đơn hàng này.');
    }

    // Xóa đơn hàng
    $order->delete();

    // Chuyển hướng về trang lịch sử đơn hàng và thông báo thành công
    return redirect()->route('auth.orders.history')->with('success', 'Đơn hàng đã được xóa!');
}

}
