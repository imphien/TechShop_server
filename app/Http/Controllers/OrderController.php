<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\OrderDetail;
use App\ulitilize\UUID;
use Carbon\Carbon;
use App\Http\Controllers\OrderDetailController;
use Illuminate\Http\Response;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\OrderCollection;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = DB::table('tbl_order')
                    ->simplePaginate(10);
        return $order;
    }

    public function searchOrder(Request $request)
    {
       $order = Order::with('product');
       if($status = $request->input('status'))
       {
           $order->whereRaw("status = '".$status."'" );
       }
        $result = $order
                ->select('order_id','customer_name','customer_address','email','note','created_at','status')->paginate(5);
        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $rules = array(
            "products.*.product_id" => [
                'required',
                Rule::exists('tbl_product')->where(function($query){
                    $query->get('tbl_product.product_id');
                }),
            ],
            "products.*.quantity" => [
                'required'
            ]
        );
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return response()->json($validator->errors(),404);
        }
        else{
            $order = new Order();
            $order_id = new UUID();
            $temp = $order_id->gen_uuid();
            $order->order_id = $temp;
            $order->date = Carbon::now();
            $order->customer_name = $request->customer_name;
            $order->customer_phone_number = $request->customer_phone_number;
            $order->customer_address = $request->customer_address;
            $order->note = $request->note;
            $order->email = $request->email;
            $order->save();
            foreach($request->products as $pro)
            {
                $order_detail = new OrderDetail();
                $order_detail->order_id = $temp;
            $order_detail->product_id = $pro['product_id'];
                $order_detail->quantity = $pro['quantity'];
                $order_detail -> save();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
