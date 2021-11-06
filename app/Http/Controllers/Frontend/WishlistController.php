<?php

namespace App\Http\Controllers\Frontend;

use Auth;
use App\Models\Wishlist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    // Product Wishlist view     
	public function ViewWishlist(){
		return view('frontend.wishlist.view_wishlist');
	} // end mathod


    // Product wishlist show
    public function GetWishlistProduct(){

		$wishlist = Wishlist::with('product')->where('user_id',Auth::id())->latest()->get();
		return response()->json($wishlist);
	} // end mehtod 


    // Remove  Wishlist  Product
    public function RemoveWishlistProduct($id){

		Wishlist::where('user_id',Auth::id())->where('id',$id)->delete();
		return response()->json(['success' => 'Successfully Product Remove']);

	} // end mathod
}
