<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        try {
            // validation
            $validator = Validator::make($request->all(), [
                'user_id' => ['required'],
                'restaurants_id' => ['required'],
                'latitude' => ['required'],
                'longitude' => ['required'],
                'total_price' => ['required', 'numeric'],
                'payment_method' => ['required', Rule::in(['cod', 'card'])],
                'order_item' => ['required'],
                'order_item.*' => ['required', 'array'],
            ]);

            if ($validator->fails()) {
                return apiError(errorAllStr($validator->errors()->all()), 400);
            }
            $response = Http::withToken('YOUR_AUTH_TOKEN')->get("/api/restaurants/show/{$request->restaurants_id}");
            if ($response->successful()) {
                $restaurants = $response->json();
            } else {
                return apiError('Restaurant not found', 404);
            }
            if ($restaurants->status != 1) {
                return apiError('The merchant is not currently accepting orders', 422);
            }

            $response = Http::withToken('YOUR_AUTH_TOKEN')->get("/api/users/show/{$request->user_id}");
            if ($response->successful()) {
                $user = $response->json();
            } else {
                return apiError('user not found', 404);
            }
            if ($restaurants->status != 1) {
                return apiError('The merchant is not currently accepting orders', 422);
            }
            DB::beginTransaction();
            $order = Order::create([
                'user_id' => $user->id(),
                'restaurants_id' => $restaurants->id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'total' => $request->total_price,
                'restaurants_status' => 'pending',
                'payment_method' => $restaurants->payment_method,
            ]);
            $order_item = json_decode($request->order_item, True);
            foreach ($order_item as $item) {
                $response = Http::withToken('YOUR_AUTH_TOKEN')->get("/api/restaurants/product/{$item['product_id']}");
                if ($response->successful()) {
                    $product = $response->json();
                } else {
                    return apiError('product not found', 404);
                }

                $order->items()->Create([
                    'product_id' => $product->id,
                    'product_name' => $product->product_name ?? null,
                    'price' => $product->price ?? 0,
                    'quantity' => $item['quantity'] ?? 1,
                ]);
            }
            return apiSuccess($order,'Add Order Successfully');
            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
            return apiError($exception->getMessage(), 500);
        }
    }

    public function show(Request $request)
    {
        try{
            // validation
            $validator = Validator::make($request->all(),[
                'order_id' => ['required','exists:orders,id'],
            ]);

            if($validator->fails()){
                return apiError(errorAllStr($validator->errors()->all()),400);
            }
            $order = Order::findOrFail($request->order_id);
            return apiSuccess($order);

        }catch (\Exception $exception){
            return apiError($exception->getMessage(),500);
        }

    }
}
