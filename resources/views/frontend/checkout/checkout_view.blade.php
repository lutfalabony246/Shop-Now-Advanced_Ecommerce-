@extends('frontend.main_master')

@section('content')
@section('title')
    My checkout Page
@endsection

<style>
    .left-box{
        background-color: #fff;
        box-shadow: 0 2px 4px 0 rgb(0 0 0 / 8%);
        padding: 20px;
        overflow: hidden;
        margin-right: 1rem;
        margin-bottom: 2rem;
    }
    .checkout_box{
        margin-bottom: 30px;
    }

    .check-span{
        color: red;
    }

    .right-box{
        background-color: #fff;
        box-shadow: 0 2px 4px 0 rgb(0 0 0 / 8%);
        padding: 20px;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    table tr th{
        text-align: center!important;
        padding: 1rem;
    }
    table tr td{
        text-align: center!important;
    }
    .payment-box{
        background-color: #fff;
        box-shadow: 0 2px 4px 0 rgb(0 0 0 / 8%);
        padding: 20px;
        overflow: hidden;
        margin-top: 2rem;
    }
    .checkout-page-button{
        margin-left: 1rem;
    }
</style>

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="{{ '/' }}">Home</a></li>
                <li class='active'>Checkout</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
    <div class="container">
        <div class="checkout_box">
            <div class="row">

                <div class="col-md-8 col-sm-12">
                    <div class="row left-box">
                        <div class="col-md-6">
                            <h2><b>User Information</b></h2>
                            <form action="{{ route('store.checkout') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-static">User Name <span class="check-span">*</span> </label>
                                <input type="text" name="user_name" class="form-control" value="{{ Auth::user()->name }}">
                            </div>

                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-static">E-Mail <span class="check-span">*</span> </label>
                                <input type="text" name="user_mail" class="form-control"  value="{{ Auth::user()->email }}">
                            </div>

                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-static">Phone Number<span class="check-span">*</span> </label>
                                <input type="text" name="user_phone" class="form-control"  value="{{ Auth::user()->phone }}">
                            </div>

                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-static">Postal Code<span class="check-span">*</span> </label>
                                <input type="text" name="postal_code" class="form-control">
                            </div>
                            
                            @error('postal_code') 
                            <span class="text-danger">{{ $message }}</span>
                            @enderror 

                        </div>

                        <div class="col-md-6">
                            <h2><b>Shipping Address</b></h2>

                            <div class="form-group">
                                <h5>Division Select <span class="check-span">*</span></h5>
                                <div class="controls">
                                    <select name="division_id" class="form-control">
                                        <option value="" selected="" disabled="">Select Division</option>
                                        @foreach ($divisions as $division)
                                            <option value="{{ $division->id }}">{{ $division->division_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('division_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group">
                                <h5>District Select <span class="check-span">*</span></h5>
                                <div class="controls">
                                    <select name="district_id" class="form-control">
                                        <option value="" selected="" disabled="">Select District</option>
                                    </select>
                                    @error('district_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <h5>State Select <span class="check-span">*</span></h5>
                                <div class="controls">
                                    <select name="state_id" class="form-control">
                                        <option value="" selected="" disabled="">Select State</option>
                                    </select>
                                    @error('state_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-static">Notes<span class="check-span">*</span> </label>
                                <textarea type="text" name="notes" class="form-control"></textarea>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-12 right-box">
                    <h2><b>Checkout Progress</b></h2>
                    <hr>
                    <div class="checkout">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Quantity</th>
                                    <th>Size</th>
                                    <th>Color</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $cart)
                                <tr>
                                    <td>{{ $cart->name }}</td>
                                    <td>
                                        <img src="{{ asset($cart->options->image) }}"  height="50px" width="50px" alt="">
                                    </td>
                                    <td>
                                        {{ $cart->qty }} 
                                    </td>
                                    <td>
                                        {{ $cart->options->size }}
                                    </td>
                                    <td>
                                        {{ $cart->options->color }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <ul class="nav list-unstyled">
                        <li>
                            @if(Session('coupon'))
                                <strong>SubTotal: </strong>${{ $subTotal }}</br><br>

                                <strong>Coupon Name: </strong>{{ session()->get('coupon')['coupon_name'] }} ( {{ session()->get('coupon')['coupon_discount'] }}% )</br><br>

                                <strong>Coupon Discount: </strong>${{ session()->get('coupon')['discount_amount'] }}</br><br>

                                <strong>Grand Total: </strong>${{ session()->get('coupon')['total_amount'] }}

                            @else
                            <strong>SubTotal: </strong>${{ $subTotal }}</br><br>
                            <strong>Grand Total: </strong>${{ $subTotal }}
                            @endif
                        </li>
                    </ul>
                </div>
            
                <div class="col-md-6 payment-box">
                    <div class="payment-heading">
                        <h3>Select Payment Method</h3>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Stripe</label>
                            <input type="radio" name="payment_method" value="stripe">
                            <img src="{{ asset('frontend/assets/images/payments/4.png') }}" alt="">
                        </div>
                        <div class="col-md-4">
                            <label for="">Card</label>
                            <input type="radio" name="payment_method" value="card">
                            <img src="{{ asset('frontend/assets/images/payments/3.png') }}" alt="">
                        </div>
                         <div class="col-md-4">
                            <label for="">Cash</label>
                            <input type="radio" name="payment_method" value="cash">
                            <img src="{{ asset('frontend/assets/images/payments/2.png') }}" alt="">
                        </div><br><br>
                        <button type="submit" class="btn btn-success btn-large checkout-page-button">Payment Step</button>
                    </div>
                </div>
                           </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
      $('select[name="division_id"]').on('change', function(){
          var division_id = $(this).val();
          if(division_id) {
              $.ajax({
                  url: "{{  url('/checkout/district/ajax') }}/"+division_id,
                  type:"GET",
                  dataType:"json",
                  success:function(data) {
                     var d =$('select[name="district_id"]').empty();
                        $.each(data, function(key, value){
                            $('select[name="district_id"]').append('<option value="'+ value.id +'">' + value.district + '</option>');
                        });
                  },
              });
          } else {
              alert('danger');
          }
      });
  });
  </script>

<script>
    $(document).ready(function() {
      $('select[name="district_id"]').on('change', function(){
          var district_id = $(this).val();
          if(district_id) {
              $.ajax({
                  url: "{{  url('/checkout/state/ajax') }}/"+district_id,
                  type:"GET",
                  dataType:"json",
                  success:function(data) {
                     var d =$('select[name="state_id"]').empty();
                        $.each(data, function(key, value){
                            $('select[name="state_id"]').append('<option value="'+ value.id +'">' + value.state_name + '</option>');
                        });
                  },
              });
          } else {
              alert('danger');
          }
      });
  });
  </script>

@endsection


