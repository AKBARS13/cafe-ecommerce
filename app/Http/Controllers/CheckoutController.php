<?php

namespace App\Http\Controllers;

use App\Models\CafeSetting;
use App\Models\Table;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\Payment\PaymentFactory;
use Illuminate\Http\Request;

class CheckoutController extends BaseController
{
    private CartService $cartService;
    private OrderService $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $cartItems = $this->cartService->getItems();

        if ($cartItems->isEmpty()) {
            return $this->errorRedirect('Keranjang belanja kosong. Silakan tambahkan produk terlebih dahulu.');
        }

        $total = $this->cartService->calculateTotal();
        $tax = $total * 0.1;
        $grandTotal = $total + $tax;
        $paymentMethods = PaymentFactory::getAvailableMethods();
        $cafeSetting = CafeSetting::current();
        $availableTables = Table::available()->orderBy('table_number')->get();

        return view('checkout.index', compact(
            'cartItems', 'total', 'tax', 'grandTotal', 'paymentMethods',
            'cafeSetting', 'availableTables'
        ));
    }

    public function process(Request $request)
    {
        $cafeSetting = CafeSetting::current();

        $rules = [
            'payment_method' => 'required|in:cash,transfer,e_wallet',
            'order_type' => 'required|in:dine_in,takeaway,reservation',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string|max:500',
            'guest_count' => 'nullable|integer|min:1|max:20',
        ];

        // Validasi spesifik per tipe order
        if ($request->order_type === 'dine_in' || $request->order_type === 'takeaway') {
            $rules['reservation_time'] = 'required|date_format:H:i';
            $rules['reservation_date'] = 'required|date|after_or_equal:today|before_or_equal:today';
        } elseif ($request->order_type === 'reservation') {
            if (!$cafeSetting->accept_reservation) {
                return $this->errorRedirect('Cafe sedang tidak menerima reservasi.');
            }
            $maxDate = now()->addDays($cafeSetting->max_reservation_days)->format('Y-m-d');
            $rules['reservation_date'] = 'required|date|after_or_equal:today|before_or_equal:' . $maxDate;
            $rules['reservation_time'] = 'required|date_format:H:i';
        }

        $validated = $request->validate($rules);

        // Validasi jam untuk dine_in/takeaway harus dalam jam operasional
        if (in_array($request->order_type, ['dine_in', 'takeaway'])) {
            $time = $request->reservation_time;
            $openTime = date('H:i', strtotime($cafeSetting->open_time));
            $closeTime = date('H:i', strtotime($cafeSetting->close_time));

            if ($time < $openTime || $time > $closeTime) {
                return back()->withErrors([
                    'reservation_time' => "Jam pemesanan harus antara $openTime - $closeTime"
                ])->withInput();
            }
        }

        try {
            $result = $this->orderService->createOrder($request->all());
            return redirect()->route('orders.show', $result['order']->id)
                ->with('success', 'Pesanan berhasil dibuat! ' . $result['payment']['message']);
        } catch (\Exception $e) {
            return $this->errorRedirect('Gagal membuat pesanan: ' . $e->getMessage());
        }
    }
}