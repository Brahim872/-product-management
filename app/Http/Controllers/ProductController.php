<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class ProductController extends Controller
{

    public function rules()
    {
        return [
            'name' => 'required',
            'size' => 'required',
            'price' => 'required',
            'category' => 'required',
        ];
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plansFeatures = Product::get();
        return returnResponseJson(['products' => $plansFeatures], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), $this->rules());

            if ($validator->fails()) {
                return returnValidatorFails($validator);
            }

            $plan_features = Product::create([
                "name" => $request->name,
                "size" => $request->size,
                "color" => $request->color,
                "description" => $request->description,
                "price" => $request->price,
                "category" => $request->category,
                "discount" => $request->discount,

            ]);

            return returnResponseJson([
                'permissionPlan' => new ProductResource($plan_features)
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return returnCatchException($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return returnResponseJson(['products' => $product], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $product)
    {
        try {
            $product = Product::find($product);
            $validator = Validator::make($request->all(), $this->rules());

            if ($validator->fails()) {
                return returnValidatorFails($validator);
            }

            $plan_features = $product->update([
                "name" => $request->name,
                "size" => $request->size,
                "color" => $request->color,
                "description" => $request->description,
                "price" => $request->price,
                "category" => $request->category,
                "discount" => $request->discount,
            ]);

            return returnResponseJson([
                'product' => $plan_features
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return returnCatchException($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($product)
    {
        try {
            $product = Product::find($product);
            $product->delete();
            return returnResponseJson([
                'message' => "success"
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return returnCatchException($e);
        }
    }
}
