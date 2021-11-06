<?php

namespace App\Http\Controllers\Frontend;
use Gloudemans\Shoppingcart\Facades\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageCartController extends Controller
{
    //view cart
    public function MyCart()
    {
        return view('frontend.wishlist.view_mycart');
    }
    //my cart data show
    public function GetCartProduct()
    {
        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();

        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,
          'cartTotal' => $cartTotal

        ));
    } // end method 
    //my cart remove
    public function RemoveMyCart($rowId)
    {
        Cart::remove($rowId);
        return response()->json(['success'=>'successfully removed from the cart']);
    }
    //increment

    public function CartIncrement($rowId)
    {
        $row=Cart::get($rowId);
        Cart::update($rowId,$row->qty+1);
        return response()->json('increment');
    }
    //decrement
    public function CartDecrement($rowId)
    {
        $row=Cart::get($rowId);
        Cart::update($rowId,$row->qty-1);
        return response()->json('increment');
    }

 }