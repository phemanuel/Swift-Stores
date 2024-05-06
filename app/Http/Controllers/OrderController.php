<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use PDF;

class OrderController extends Controller
{
    public function index(Request $request) {
        $orders = new Order();
        if($request->start_date) {
            $orders = $orders->where('created_at', '>=', $request->start_date);
        }
        if($request->end_date) {
            $orders = $orders->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }
        $orders = $orders->with(['items', 'payments', 'customer'])->latest()->paginate(10);

        $total = $orders->map(function($i) {
            return $i->total();
        })->sum();
        $receivedAmount = $orders->map(function($i) {
            return $i->receivedAmount();
        })->sum();

        return view('orders.index', compact('orders', 'total', 'receivedAmount'));
    }

    public function store(OrderStoreRequest $request)
    {

        //---generate transaction id----
        function GeraHash($qtd){
            //Under the string $Caracteres you write all the characters you want to be used to randomly generate the code.
            $Caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
            $QuantidadeCaracteres = strlen($Caracteres);
            $QuantidadeCaracteres--;
            
            $Hash=NULL;
                for($x=1;$x<=$qtd;$x++){
                    $Posicao = rand(0,$QuantidadeCaracteres);
                    $Hash .= substr($Caracteres,$Posicao,1);
                }
            
            return $Hash;
            }
            
            //Here you specify how many characters the returning string must have
            $transaction_id = GeraHash(8);
            //---------------------------------
            $order = Order::create([
                'customer_id' => $request->customer_id ?? 1,
                'user_id' => $request->user()->id, 
                'transaction_id' => $transaction_id,
            ]);

        $cart = $request->user()->cart()->get();
        foreach ($cart as $item) {
            //---get item base price--
            $item_id = $item->id;
            $productBasePrice_single = Product::where('id', $item_id)->first()->product_base_price;
            // Calculate profit
            $productBasePrice = $productBasePrice_single * $item->pivot->quantity;
            $priceSold = $item->price * $item->pivot->quantity;
            $profit =  $priceSold - $productBasePrice ;

            $order->items()->create([ 
                'price' => $priceSold,
                'quantity' => $item->pivot->quantity,
                'product_id' => $item->id,
                'product_base_price' => $productBasePrice,
                'profit' => $profit,
                'product_base_price_single' => $productBasePrice_single,
                'price_single' => $item->price,
                'user_id' => $request->user()->id,
                'transaction_id' => $transaction_id
            ]);
            $item->quantity = $item->quantity - $item->pivot->quantity;
            $item->save();
        }
        $request->user()->cart()->detach();
        $order->payments()->create([
            'amount' => $request->amount,
            'user_id' => $request->user()->id,
            'transaction_id' => $transaction_id
        ]);

        // Generate and deliver receipt
        $receipt = $this->generateReceipt($order);
        return 'success';
    }

    private function generateReceipt($order)
    {
        // Retrieve necessary data for the receipt
        $data = [
            'order' => $order,
            // You can include other data here if needed
        ];        

        // Render the HTML receipt view        
        $htmlContent = View::make('receipts.receipt', $data)->render();

        // Return HTML response
        return response($htmlContent)->header('Content-Type', 'text/html');
    }

        /**
     * Display the specified order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        // Load the order with its related data
        $order->load('items.product', 'customer');

        // Return the view with the order data
        return view('orders.view_order', compact('order'));
    }
    

    public function printReceipt($orderId)
    {
        // Retrieve the Order model instance based on the provided ID
        $order = Order::findOrFail($orderId);

        // Retrieve the customer associated with the order
        $customer = $order->customer;

        // Retrieve the items in the order
        $items = $order->items;

        // You might have other data to retrieve here based on your application's needs

        // Render the HTML receipt view with the retrieved data
        $htmlContent = view('receipts.receipt', compact('order', 'customer', 'items'))->render();

        // Return HTML response
        return response($htmlContent)->header('Content-Type', 'text/html');
    }


}
