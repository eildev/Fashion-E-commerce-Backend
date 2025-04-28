<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Variant;
class ApiVariantController extends Controller
{
    public function viewAll() {
        $variant = Variant::with('product.productDetails','variantImage','productStock')->get();

        return response()->json([
            'variant' => $variant,
        ]);
    }

}
