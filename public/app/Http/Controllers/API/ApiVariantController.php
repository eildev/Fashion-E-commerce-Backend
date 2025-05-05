<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Variant;
class ApiVariantController extends Controller
{
    public function viewAll() {
        $variant = Variant::with('product.productDetails','product.promotionproduct.coupon','variantImage','productStock', 'productVariantPromotion.coupon','reviewRating')->get();

        return response()->json([
            'variant' => $variant,
        ]);
    }

}
