<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Request;
use Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Slider;
use App\Models\Brand;
use App\Models\Multi_Img;
use Illuminate\Support\Facades\Hash;


class IndexController extends Controller
{
    // Home Page view

    public function index(){
        $categories =Category::orderBy('category_name','ASC')->get();
        $products =Product::where('status',1)->orderBy('id','DESC')->get();
        $featured =Product::where('featured',1)->orderBy('id','DESC')->get();
        $hots =Product::where('hot_deals',1)->orderBy('id','DESC')->get();
        $hots =Product::where('hot_deals',1)->where('discount_price','!=',NULL)->orderBy('id','DESC')->get();
        $special_offers =Product::where('special_offer',1)->orderBy('id','DESC')->get();
        $special_deals =Product::where('special_deals',1)->orderBy('id','DESC')->get();
        $sliders = Slider::all();
        

        // first category product view
        $skip_category_0 = Category::skip(0)->first();
        $skip_product_0 = Product::where('status',1)->where('category_id',$skip_category_0->id)->orderBy('id','DESC')->get();

        // second category product view
        $skip_category_1 = Category::skip(1)->first();
        $skip_product_1 = Product::where('status',1)->where('category_id',$skip_category_1->id)->orderBy('id','DESC')->get();

        // first brand product view
        $skip_brand_1 = Brand::skip(1)->first();
        $skip_brand_product_1 = Product::where('status',1)->where('brand_id',$skip_brand_1->id)->orderBy('id','DESC')->get();

        return view('frontend.index',compact('categories','sliders','products','featured','hots','special_deals','special_offers','skip_category_0','skip_product_0','skip_category_1','skip_product_1','skip_brand_1','skip_brand_product_1'));
    } // end method


    // User logout 
     public function UserLogout(){
        
        Auth::logout();
        return Redirect()->route('login');

     } // end method 


     // User Profile Update 
     public function UserProfileUpdate(){

        $id = Auth::user()->id;
        $user = User::find($id);

        return view('frontend.profile.user_profile_update', compact('user'));
     }// end mathod



      // user profile store    
    public function UserProfileStore(Request $request){

        $data = User::find(Auth::user()->id);
  
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone =$request->phone;
  
  
        if ($request->file('profile_photo_path')) {
          $file = $request->file('profile_photo_path');
          // for auto replace old img 
          @unlink(public_path('upload/users_images/'.$data->profile_photo_path));
          // end rep..
          $filename = date('YmdHi').$file->getClientOriginalName();
          $file->move(public_path('upload/users_images'),$filename);
          $data['profile_photo_path'] = $filename;
  
            }
            $data->save();
  
        // update notification
            $notification = array(
                'message' =>  ' Profile Update Sucessyfuly',
                'alert-type' => 'success'
            ); 
            return redirect()->route('dashboard')->with($notification);
       
  
  
      }// end method


         // user Password change
         public function UserChangePassword(){
            $id = Auth::user()->id;
            $user = User::find($id);
        return view('frontend.profile.user_password_change', compact('user'));
        }// end method
  

          // user password update
          public function UserPasswordUpdate(Request $request){

            $validateData = $request->validate([
                'oldpassword' => 'required',
                'password' => 'required|confirmed',
            ]);

            $hashedPassword = Auth::User()->password;
            if (Hash::check($request->oldpassword,$hashedPassword)) {
            $user = Auth::User();
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();

         // update sms
         $notification = array(
            'message' =>  ' User Password Update Sucessyfully',
            'alert-type' => 'success'
        ); 

            return redirect()->route('user.logout')->with($notification);

            }else{
                return redirect()->back();
            }

        } // end method

        public function ProductDetail($id){

            $multiImgs= Multi_Img::where('product_id',$id)->get();
            $product =Product::findOrFail($id);

            // for color and size
            $product_color = $product->product_color; 
            $product_color_all = explode (',',$product_color); 
            $product_size = $product->product_size; 
            $product_size_all = explode (',',$product_size); 

            // for relaetd product
            // for related product show
            $cat_id = $product->category_id;
            $relatedProducts = Product::where('category_id',$cat_id)->where('id','!=',$id)->orderBy('id','DESC')->get();

            return view('frontend.product.product_detail',compact('product','multiImgs','product_color_all',
            'product_size_all','relatedProducts'));
        }

        // TagWise Product
        public function TagWiseProduct($tag){
            // for tag page 
           $categories = Category::orderBy('category_name', 'ASC')->get();
           $products = Product::where('status', 1)->where('product_tags', $tag)->orderBy('id', 'DESC')->paginate(5);
           return view('frontend.tags.tags_view', compact('products','categories'));
        }

         // Subcategory wise product
        public function SubCatWiseProduct($subcat_id){

            // $start = 27000; // min price value
            // $end =  40000; // max price value where('discount_price', '>=', $start)->where('discount_price', '<=', $end)->

            if(Request::get('sort') == 'price_asc'){
                $products = Product::where('status',1)->orderBy('discount_price', 'ASC')->where('subcategory_id',$subcat_id)->paginate(4);
            }elseif(Request::get('sort') == 'price_desc'){
                $products = Product::where('status',1)->orderBy('discount_price', 'DESC')->where('subcategory_id',$subcat_id)->paginate(4);
            }elseif(Request::get('sort') == 'name_asc'){
                $products = Product::where('status',1)->orderBy('product_name', 'ASC')->where('subcategory_id',$subcat_id)->paginate(4);
            }elseif(Request::get('sort') == '1'){
                $products = Product::where('status',1)->orderBy('product_name', 'ASC')->where('subcategory_id',$subcat_id)->limit(1)->get();
            }elseif(Request::get('sort') == '2'){
                $products = Product::where('status',1)->orderBy('product_name', 'ASC')->where('subcategory_id',$subcat_id)->limit(2)->get();
            }elseif(Request::get('sort') == '3'){
                $products = Product::where('status',1)->orderBy('product_name', 'ASC')->where('subcategory_id',$subcat_id)->limit(3)->get();
            }
            else{
                $products = Product::where('status',1)->where('subcategory_id',$subcat_id)->latest()->paginate(4);
            }
            

            $categories = Category::orderBy('category_name','ASC')->get();
            return view('frontend.product.subcategory_view',compact('products','categories'));
        }
       
        // SubSubcategory wise product
        public function SubSubCatWiseProduct($subsubcat_id){
            $products = Product::where('status',1)->where('subsubcategory_id',$subsubcat_id)->orderBy('id','DESC')->paginate(4);
            $categories = Category::orderBy('category_name','ASC')->get();
            return view('frontend.product.sub_subcategory_view',compact('products','categories'));
        }

        /// Product View With Ajax
        public function ProductViewAjax($id){
            $product = Product::with('category', 'brand')->findOrFail($id);
            $color = $product->product_color;
            $product_colors = explode(',', $color);
        
            // size varibale is messing
            $size = $product->product_size;
            $product_sizes = explode(',', $size);
        
            return response()->json(array(
            'product' =>$product, 
            'color' => $product_colors,
            'size' => $product_sizes,
            ));
        
        } // end mathod

} // main end
