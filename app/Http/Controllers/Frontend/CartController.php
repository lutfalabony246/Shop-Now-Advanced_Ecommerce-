<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Auth;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // add to cart post 

    public function AddToCart(Request $request, $id){

        // reomove old data add to cart
        if (Session::has('coupon')) {
            Session::forget('coupon');
            }

        $product = Product::findOrfail($id);
        // product discount 
        if ($product->discount_price == NULL) {
            Cart::add([
              'id' => $id,
              'name' => $request->product_name,
              'qty' => $request->quantity,               
              'price' => $product->selling_price, 
              'weight' => 1,
              'options' => [
                  'image' => $product->product_thambnail,
                  'color' => $request->color,
                  'size' => $request->size, 
              ],
                ]);
            
            return response()->json(['success' => 'Successfully Added on Your Cart']);

         }else{

            Cart::add([
                'id' => $id,
                'name' => $request->product_name,
                'qty' => $request->quantity,               
                'price' => $product->discount_price, 
                'weight' => 1,
                'options' => [
                    'image' => $product->product_thambnail,
                    'color' => $request->color,
                    'size' => $request->size,
                ],
                  ]);

          return response()->json(['success' => 'Successfully Added on Your Cart']);
         }
    } // end mathod 

    // Mini cart Section
    public function AddMiniCart(){
       $carts = Cart::content();
       $cartQty = Cart::count();
       $cartTotal = Cart::total();

        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,
            'cartTotal' => $cartTotal,
        ));

    } // end mathod 

    /// remove mini cart 
    public function RemoveMiniCart($rowId){ 
        Cart::remove($rowId);
        return response()->json(['success' => 'Product Remove from Cart']);

    } // end mehtod 

     // add to wishlist Product mathod 
     public function AddToWishlist(Request $request, $product_id){
        if (Auth::check()){
            $exists = Wishlist::where('user_id',Auth::id())->where('product_id',$product_id)->first();
            if (!$exists) {       
            Wishlist::insert([
                'user_id' => Auth::id(), 
                'product_id' => $product_id, 
                'created_at' => Carbon::now(), 
            ]);
            
           return response()->json(['success' => 'Successfully Added On Your Wishlist']);
            }else{
                return response()->json(['error' => 'Product Already Wishlist Add ']); 
            }
        }else{
            return response()->json(['error' => 'At First Login Your Account']);
        }
   

    } // end method 

        // apply coupon 
        public function CouponApply(Request $request){

            $coupon = Coupon::where('coupon_name',$request->coupon_name)->where('coupon_validity','>=',Carbon::now()->format('Y-m-d'))->first();

            $total=str_replace(',','', Cart::total());     
            
            if ($coupon) {
                Session::put('coupon',[
                    'coupon_name' => $coupon->coupon_name,
                    'coupon_discount' => $coupon->coupon_discount,
                    'discount_amount' => $total * $coupon->coupon_discount/100, 
                    'total_amount' => $total - $total * $coupon->coupon_discount/100                 
            ]);

            return response()->json(array(

                'validity' => true,

                'success' => 'Coupon Applied Successfully'
            ));

            }else{
                return response()->json(['error' => 'Invalid Coupon']);
            }

      } // end method 

    // Coupon Calculation
    public function CouponCalculation(){

        if (Session::has('coupon')) {
            return response()->json(array(
                'subtotal' => Cart::total(),
                'coupon_name' => session()->get('coupon')['coupon_name'],
                'coupon_discount' => session()->get('coupon')['coupon_discount'],
                'discount_amount' => session()->get('coupon')['discount_amount'],
                'total_amount' => session()->get('coupon')['total_amount'],
            ));
        }else{
        return response()->json(array(
                'total' => Cart::total(),
            ));

        }
    } // end method 



    // Remove Coupon 
    public function CouponRemove(){
        Session::forget('coupon');
        return response()->json(['success' => 'Coupon Remove Successfully']);
    }



}
