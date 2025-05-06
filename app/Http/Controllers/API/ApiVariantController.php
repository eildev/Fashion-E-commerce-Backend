<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Variant;
use App\Models\Category;
use App\Models\Brand;
use App\Models\TagName;
use App\Models\Product;
class ApiVariantController extends Controller
{
    public function viewAll() {
        $variant = Variant::with('product.productDetails','product.promotionproduct.coupon','variantImage','productStock', 'productVariantPromotion.coupon','reviewRating','product.productFeatures.feature','product.product_tags.tag')->get();

        return response()->json([
            'variant' => $variant,
        ]);
    }

    public function search(Request $request){
        try{
           
        $searchTerm = $request->input('q');

        // Get related IDs
        $categories = Category::where('categoryName', 'like', "%{$searchTerm}%")
            ->take(10)->get(['id']);
        $categoryIds = $categories->pluck('id');

        $brands = Brand::where('BrandName', 'like', "%{$searchTerm}%")
            ->take(10)->get(['id']);
        $brandIds = $brands->pluck('id');

        $tags = TagName::where('tagName', 'like', "%{$searchTerm}%")
            ->take(10)->get(['id']);
        $tagIds = $tags->pluck('id');

        $productIds = Product::where('product_name', 'like', "%{$searchTerm}%")
            ->orWhereIn('category_id', $categoryIds)
            ->orWhereIn('brand_id', $brandIds)
            ->orWhereHas('product_tags', function ($query) use ($tagIds) {
                $query->whereIn('tag_id', $tagIds);
            })
            ->pluck('id');

        $variants = Variant::with([
                'product.productDetails',
                'product.promotionproduct.coupon',
                'variantImage',
                'productStock',
                'productVariantPromotion.coupon',
                'reviewRating'
            ])
            ->where('variant_name', 'like', "%{$searchTerm}%")
            ->orWhereIn('product_id', $productIds)
            ->take(10)
            ->get();

            return response()->json([
                'status' => '200',
                'variants' => $variants,
            ]);

        }
        catch(\Exception $e){
            return response()->json([
                'status' => '500',
                'message' => 'Product Not Found',
                'error' => $e->getMessage(),
            ]);
        }




    }

}
