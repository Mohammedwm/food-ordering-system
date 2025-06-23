<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller
{
    public function create(Request $request)
    {
        try{
        // validation
            $validator = Validator::make($request->all(),[
                'name' => ['required','string'],
                'type_restaurant' => ['required','string'],
                'user_id' => ['required','numeric','exists:users,id'],
                'latitude' => ['required','string'],
                'longitude' => ['required','string'],
            ]);

            if($validator->fails()){
                return apiError(errorAllStr($validator->errors()->all()),400);
            }
            DB::beginTransaction();

            //User create
            $restaurant = Restaurant::create([
                'name' => $request->name,
                'type_restaurant' => $request->type_restaurant,
                'user_id' => $request->user_id,
                'latitude' => $request->latitud,
                'longitude' => $request->longitude,
            ]);

            DB::commit();
            return apiSuccess($restaurant, t('Successfully add restaurant'));

        }catch (\Exception $exception){
            DB::rollBack();
            return apiError($exception->getMessage(),500);
        }
    }

    public function show(Request $request)
    {
        try{
            // validation
            $validator = Validator::make($request->all(),[
                'type_restaurant' => ['required'],
            ]);

            if($validator->fails()){
                return apiError(errorAllStr($validator->errors()->all()),400);
            }
            $restaurant = Restaurant::where('type_restaurant',$request->type_restaurant)->get();
            return apiSuccess($restaurant);

        }catch (\Exception $exception){
            return apiError($exception->getMessage(),500);
        }

    }
}
