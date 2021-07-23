<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $product = $request->route('product');

        if($product==null){
            return response()->json(['message'=>'Product not found'], 404);
        }

        if($product->user_id != auth()->user()->id){
            return response()->json(['message'=>'You are not the owner of this product'], 401);
        }
        return $next($request);
    }
}
