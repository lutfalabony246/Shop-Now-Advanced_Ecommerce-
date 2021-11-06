@extends('frontend.main_master')

@section('content')
@section('title')
    My cart Page
@endsection

<style>
    .CenterLine td{
        text-align: center;
    }
</style>
<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="{{ '/' }}">Home</a></li>
                <li class='active'>My Cart</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
    <div class="container">
        <div class="row">
            <div class="shopping-cart">
                <div class="shopping-cart-table ">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="cart-romove item">Image</th>
                                    <th class="cart-description item">Name</th>
                                    <th class="cart-product-name item">Color</th>
                                    <th class="cart-edit item">Size</th>
                                    <th class="cart-qty item">Quantity</th>
                                    <th class="cart-sub-total item">Subtotal</th>
                                    <th class="cart-total last-item">Remove</th>
                                </tr>
                            </thead>

                            <tbody id="cartPage">


                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-4 col-sm-12 estimate-ship-tax">
                </div>

                <div class="col-md-4 col-sm-12 estimate-ship-tax">

                    @if (Session::has('coupon'))

                    @else

                        <table class="table" id="couponField">
                            <thead>
                                <tr>
                                    <th>
                                        <strong class="estimate-title" style="color: red">Discount Code</strong>
                                        <strong>Enter your coupon code</strong>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" id="coupon_name" class="form-control  text-input "
                                                placeholder="Input You Coupon ">
                                        </div>
                                        <div class="clearfix pull-right">
                                            <button type="submit" onclick="applyCoupon()"
                                                class="btn-upper btn btn-success"><strong>APPLY OUPON</strong> </button>
                                        </div>

                                    </td>
                                </tr>
                            </tbody><!-- /tbody -->
                        </table><!-- /table -->

                    @endif


                </div>


                <div class="col-md-4 col-sm-12 cart-shopping-total">
                    <table class="table">

                        <thead id="couponClaFiled">

                        </thead><!-- /thead -->
                        <tbody>
                            <tr>
                                <td>
                                    <div class="cart-checkout-btn pull-right">
                                        <a href="{{ route('checkout') }}" type="submit"
                                            class="btn btn-primary checkout-btn">PROCCED TO CHEKOUT</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody><!-- /tbody -->
                    </table><!-- /table -->
                </div>


            </div><!-- /.row -->
        </div><!-- /.sigin-in-->
    </div><!-- /.sigin-in-->
</div><!-- /.sigin-in-->


<br>
@include('frontend.common.brands')
</div>

@endsection
