<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Product;
use App\Models\ProductFeatures;
use Illuminate\Http\Request;

class ProductFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return view('admin.product.features.list', [
            'items' => $product->features(),
            'productId' => $product->id,
            'productName' => $product->name,
            'defaultPrice' => $product->price,
            'defaultCount' => $product->available_count,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductFeatures  $productFeatures
     * @return \Illuminate\Http\Response
     */
    public function store(Product $product, Request $request)
    {
        $validator = [
            'value' => 'required',
            'category_feature_id' => 'required|exists:category_features,id',
            'price' => 'nullable',
            'count' => 'nullable'
        ];

        $request->validate($validator, self::$COMMON_ERRS);

        $categoryFeature = Feature::find($request['category_feature_id']);

        if($product->category_id != $categoryFeature->category_id)
            return abort(401);

        $validator = null;

        if($categoryFeature->answer_type == 'number') {
            $validator = [
                'value' => 'required|integer|min:0',
            ];
        }
        else if($categoryFeature->answer_type == 'multi_choice') {

            $choices = explode('__', $categoryFeature->choices);
            $label = null;

            $values = $request['value'];

            if($categoryFeature->effect_on_price && !$request->has('price'))
                abort(401);

            if($categoryFeature->effect_on_available_count && !$request->has('count'))
                abort(401);

            if($request->has('price') && $request->has('count'))
                abort(401);

            if($request->has('price')) {
                $prices = $request['price'];

                if(count($prices) != count($values))
                    abort(401);
                    
                $format_prices = [];
                foreach($prices as $price)
                    array_push($format_prices, number_format($price, 0));
                    
                $request['price'] = implode('$$', $format_prices);
            }

            if($request->has('count')) {
                $counts = $request['count'];

                if(count($counts) != count($values))
                    abort(401);
                
                $request['count'] = implode('$$', $counts);
            }

            foreach($choices as $choice) {
                $tmp = explode('$$', $choice);
                if(in_array($tmp[0], $values)) {
                    if($label == null)
                        $label = count($tmp) == 2 ? $tmp[1] : '';
                    else
                        $label .= '$$' . (count($tmp) == 2 ? $tmp[1] : '');
                }
            }

            if($label == null)
                abort(401);
            
            $request['value'] = implode('$$', $values) . '__' . $label;
        }

        
        if($categoryFeature->answer_type != 'multi_choice' &&
            $request->has('price')
        )
            abort(401);

        if($validator != null)
            $request->validate($validator, self::$COMMON_ERRS);
        
        $pf = ProductFeatures::where('category_feature_id', $request['category_feature_id'])
            ->where('product_id', $product->id)->first();
        
        if($pf == null) {
            $pf = new ProductFeatures();
            $pf->product_id = $product->id;
            $pf->category_feature_id = $request['category_feature_id'];
        }

        $pf->value = $request['value'];

        if($request->has('price')) {
            $pf->price = $request['price'];
            $all_prices = explode('$$', $request['price']);
            $min = -1;

            foreach($all_prices as $itr) {

                if($min == -1 || (int)str_replace(',', '', $itr) < $min)
                    $min = (int)str_replace(',', '', $itr);

            }

            $product->price = $min;
            $product->save();

        }

        if($request->has('count')) {
            $pf->available_count = $request['count'];
            $all_counts = explode('$$', $request['count']);
            $tatal_counts = 0;

            foreach($all_counts as $itr)
                $tatal_counts += (int)$itr;

            $product->available_count = $tatal_counts;
            $product->save();
        }

        $pf->save();

        return response()->json(
            ['status' => 'ok']
        );
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductFeatures $productFeature)
    {
        $productFeature->delete();
        return response()->json(['status' => 'ok']);
    }


}
