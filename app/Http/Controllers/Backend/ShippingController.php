<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\ShipDivision;
use App\Models\ShipDistrict;
use App\Models\ShipState;

class ShippingController extends Controller
{

    // methods for division section start
    public function DivisionView(){
        $divisions=ShipDivision::all();
        return view('backend.shipping.division.division_view',compact('divisions'));
    }

    public function DivisionStore(Request $request){

        $request->validate([
            'division_name' => 'required',
        ]);

        $division =new ShipDivision();
        $division->division_name = $request->division_name;
        $division->created_at=Carbon::now();
        $division->save();

        $notification = array(
            'message' => 'Division Add Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


    public function DivisionEdit($id){
        $division = ShipDivision::find($id);
        return view('backend.shipping.division.division_edit',compact('division'));
    }

    public function DivisionUpdate(Request $request){

        $request->validate([
            'division_name' => 'required',
        ]);

        $division =ShipDivision::find($request->id);
        $division->division_name = $request->division_name;
        $division->updated_at=Carbon::now();
        $division->save();

        $notification = array(
            'message' => 'Division Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('manage.division')->with($notification);
    }

    public function DivisionDelete($id){

        ShipDivision::find($id)->delete();

        $notification = array(
            'message' => 'Division Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    // methods for division section ends here

    // methods for district section start
    public function DistrictView(){
        $divisions =ShipDivision::all();
        $districts= ShipDistrict::with('ShipDivision')->get();
        return view('backend.shipping.district.district_view',compact('districts','divisions'));
    }

    public function DistrictStore(Request $request){
        $request->validate([
             'division_id' => 'required',
             'district_name' => 'required'
         ]);
 
         ShipDistrict::insert([
         'division_id' => $request->division_id,
         'district' => $request->district_name,
         'created_at' => Carbon::now(),
         ]);
 
         $notification = array(
             'message' => 'District Inserted Successfully',
             'alert-type' => 'success'
         );
 
         return redirect()->back()->with($notification);
 
     } // end method 

     public function DistrictEdit($id){
        $divisions = ShipDivision::all();
        $district = ShipDistrict::find($id);
        return view('backend.shipping.district.district_edit',compact('district','divisions'));
    }

    public function DistrictUpdate(Request $request){
        $request->validate([
             'division_id' => 'required',
             'district_name' => 'required'
         ]);
 
         $district=ShipDistrict::find($request->id);
         $district->division_id = $request->division_id;
         $district->district = $request->district_name;
         $district->updated_at=Carbon::now();
         $district->save();
 
         $notification = array(
             'message' => 'District Updated Successfully',
             'alert-type' => 'success'
         );

         return redirect()->route('manage.district')->with($notification);
 
     }

     public function DistrictDelete($id){
        ShipDistrict::find($id)->delete();
        $notification = array(
            'message' => 'District Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
     }
     // methods for district section end

     public function StateView(){
        $divisions = ShipDivision::all();
        $states= ShipState::with('ShipDivision','ShipDistrict')->get();
         return view('backend.shipping.state.state_view',compact('divisions','states'));
     }

     // method for state section start
     // for sub district auto select 
     public function GetDistrict($division_id){
        $district = ShipDistrict::where('division_id',$division_id)->orderBy('district','ASC')->get();
        return json_encode($district);
     } // end method

     // district store
     public function StateStore(Request $request){

        $request->validate([
             'division_id' => 'required',
             'district_id' => 'required',
             'state_name' => 'required', 
         ]);
 
         ShipState::insert([
         'division_id' => $request->division_id,
         'district_id' => $request->district_id,
         'state_name' => $request->state_name,
         'created_at' => carbon::now()
         ]);
 
         $notification = array(
             'message' => 'State Inserted Successfully',
             'alert-type' => 'success'
         );
 
         return redirect()->back()->with($notification);
 
     } // end method 



     public function StateDelete($id){
         ShipState::find($id)->delete();

         $notification = array(
            'message' => 'State Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
     }

     public function StateEdit($id){

        $divisions = ShipDivision::orderBy('division_name','ASC')->get();

        $districts = ShipDistrict::orderBy('district','ASC')->get();

        $state = ShipState::findOrFail($id);

        return view('backend.shipping.state.state_edit',compact('divisions','districts','state'));
     }

     public function StateUpdate(Request $request){

        ShipState::find($request->id)->update([
        'division_id' => $request->division_id,
        'district_id' => $request->district_id,
        'state_name' => $request->state_name,
        'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'State Update Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('manage.state')->with($notification);
     }

    //  method for state secction end
}
