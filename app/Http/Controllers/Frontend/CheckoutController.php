<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShipDivision;
use App\Models\ShipDistrict;
use App\Models\ShipState;

use Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    public function CheckoutView(){
        if(Auth::check()){
            if(Cart::total()>0){
                $carts= Cart::content();
                $subTotal=Cart::total();
                // dd($carts);
                // dd(Cart::total());
                // dd(session()->all());
                $divisions= ShipDivision::all();
                return view('frontend.checkout.checkout_view',compact('divisions','carts','subTotal'));
            }else{
                $notification = array(
                    'message' => 'There is no product at the cart',
                    'alert-type' => 'success'
                );
                return redirect('/')->with($notification);
            }      
        }else{
            $notification = array(
                'message' => 'You Need to Login First',
                'alert-type' => 'error'
            );
            return redirect()->route('login')->with($notification);
        } 
    }

    public function GetDistrictData($division_id){
        $dists = ShipDistrict::where('division_id',$division_id)->orderBy('district','ASC')->get();
        return json_encode($dists);
    }

    public function GetStateData($district_id){
        $states = ShipState::where('district_id',$district_id)->orderBy('state_name','ASC')->get();
        return json_encode($states);
    }

    public function CheckoutStore(Request $request){

        $request->validate([
            'postal_code' => 'required',
            'user_name' => 'required',
            'state_id' => 'required'
        ]);

        $data=array();
        $data['user_name'] = $request->user_name;
        $data['user_mail'] = $request->user_mail;
        $data['user_phone'] = $request->user_phone;
        $data['postal_code'] = $request->postal_code;

        $data['division_id'] = $request->division_id;
        $data['district_id'] = $request->district_id;
        $data['state_id'] = $request->state_id;
        $data['notes'] = $request->notes;


        $cartTotal=Cart::total();

        if($request->payment_method == 'stripe'){
            return view('frontend.payment.stripe',compact('data','cartTotal'));
        }elseif($request->payment_method == 'card'){
            return 'card';
        }else{
            return 'cash';
        }
    }
}
