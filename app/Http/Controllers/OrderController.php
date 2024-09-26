<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class OrderController extends Controller
{
    // This method retrieves all orders for a specific customer
    public function index($customer_id)
    {
        // Retrieve orders for a specific customer with the status name
        $orders = DB::table('orders')
            ->join('order_statuses', 'orders.status', '=', 'order_statuses.order_status_id')
            ->where('orders.customer_id', '=', $customer_id) // Filter by customer_id
            ->select(
                'orders.order_id',
                'orders.customer_id',
                'orders.order_date',
                'orders.status',
                'orders.comments',
                'orders.shipped_date',
                'orders.shipper_id',
                'order_statuses.name as status_name'
            )
            ->get();

        return response()->json($orders);
    }

    // This method retrieves a specific order for a specific customer
    public function show($customer_id, $order_id)
    {
        // Retrieve the specific order by customer_id and order_id
        $order = DB::table('orders')
            ->join('order_statuses', 'orders.status', '=', 'order_statuses.order_status_id')
            ->where('orders.customer_id', '=', $customer_id) // Ensure it belongs to the customer
            ->where('orders.order_id', '=', $order_id)       // Ensure it matches the order id
            ->select(
                'orders.order_id',
                'orders.customer_id',
                'orders.order_date',
                'orders.status',
                'orders.comments',
                'orders.shipped_date',
                'orders.shipper_id',
                'order_statuses.name as status_name'
            )
            ->first(); // Fetch only one order

        // If the order is not found, return a 404 error
        if (!$order) {
            return response()->json(['message' => 'Order not found for this customer'], 404);
        }

        // Return the order data as a JSON response
        return response()->json($order);
    }
}
