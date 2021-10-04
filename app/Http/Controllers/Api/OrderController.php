<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\Order as OrderResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return response()->json($orders,'200');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Order::create([
            'name_customer' => $request->name_customer,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'total_price' => $request->total_price,
            'date' => $request->date
        ]);

        if($request->arrayProduct){
            foreach($request->arrayProduct as $product){
                $order->products()->attach($product['id'], [
                    'total_product' => $product['total_product'],
                    'total_price_pr' => $product['total_price_pr']
                ]);
            }
        };

        return response()->json($order,'200');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,int $order)
    {
        //
        $order = Order::find($order);

        $order->name_customer = $request->name_customer;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->address = $request->address;
        $order->total_price =$request ->total_price;
        $order->date =$request ->date;
        DB::table('order_product')->where('order_id',$order->id)->delete();
        if($request->arrayProduct){
            foreach($request->arrayProduct as $product){
                if ($product['id']){
                    $order->products()->attach($product['id'], [
                        'total_product' =>(int)$product['total_product'],
                        'total_price_pr' => $product['total_price_pr']
                    ]);
                }else {
                    $order->products()->attach($product['product_id'], [
                        'total_product' =>(int)$product['total_product'],
                        'total_price_pr' => $product['total_price_pr']
                    ]);
                }

            }
        };
        $order->save();

        return response()->json($order,'200');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
        $order->delete();
        return response()->json(['message' => 'delete success'],200);
    }
    public function  getProductOrder(Request $request,Order $order){
        $listProductOrder = DB::table('products')
            ->join('order_product', 'products.id', '=', 'order_product.product_id')
            ->where('order_product.order_id',$order->id)
            ->get(array(
                'products.id as id',
                'total_product',
                'total_price_pr',
                'price',
                'name',
            ));
        return response()->json($listProductOrder,'200');
    }
}
