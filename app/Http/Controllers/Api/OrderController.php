<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\Order as OrderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
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
        ]);

        if($request->arrayProduct){
            foreach($request->arrayProduct[0] as $product){
                $order->products()->attach($product['id'], [
                    'total_product' =>(int)$product['total_product'],
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
        $order->total_product = $request->total_product;
        $order->price = $request->price;
        $order->total_price = $request->total_price;
        $order->save();

        return new OrderResource($order);
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
}
