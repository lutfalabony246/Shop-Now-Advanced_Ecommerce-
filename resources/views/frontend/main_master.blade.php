<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    {{-- js ajax cart --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">
    <title>@yield('title')</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css ') }}">

    <!-- Customizable CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.transitions.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/rateit.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap-select.min.css') }}">

    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/font-awesome.css') }}">

    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800'
        rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body class="cnt-home">
    <!-- ============================================== HEADER ============================================== -->

    @include('frontend.body.header')
    <!-- ============================================== HEADER : END ============================================== -->


    @yield('content')

    <!-- ======================================= FOOTER ================================ -->
    @include('frontend.body.footer')
    <!-- =============================== FOOTER : END================================= -->

    <!-- For demo purposes – can be removed on production -->

    <!-- For demo purposes – can be removed on production : End -->

    <!-- JavaScripts placed at the end of the document so the pages load faster -->
    <script src="{{ asset('frontend/assets/js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap-hover-dropdown.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/echo.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.easing-1.3.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap-slider.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.rateit.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/scripts.js') }}"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Add to card model -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong><span id="pname"></span></strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModel">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card" style="width: 18rem;">
                                <img src="" class="card-img-top" id="pimg" alt="productimg" height="200" width="180">

                            </div>
                        </div>
                        <div class="col-lg-4">

                            <ul class="list-group">
                                <li class="list-group-item">Product Price: <strong class="text-danger">$<span
                                            id="pprice"></span></strong>

                                    <del id="oldprice">$</del>

                                </li>

                                <li class="list-group-item">Product Code: <strong id="pcode"></strong></li>
                                <li class="list-group-item">Category: <strong id="pcategory"></strong></li>
                                <li class="list-group-item">Brands: <strong id="pbrand"></strong></li>

                                <li class="list-group-item">Stock: <span class="badge badge-pill badge-success"
                                        id="aviable" style="background: green; color:white;"></span>
                                    <span class="badge badge-pill badge-success" id="stockout"
                                        style="background: red; color:white;"></span>
                                </li>

                            </ul>
                        </div>
                        <div class="col-lg-4">

                            <div class="form-group">
                                <label for="color">Choose Color</label>

                                <select class="form-control" name="color" id="color">


                                </select>
                            </div>

                            <div class="form-group" id="sizeArea">
                                <label for="size">Choose Size</label>
                                <select class="form-control" name="size" id="size">

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="qty">Choose Quantity</label>

                                <input type="number" class="form-control" id="qty" value="1" min="1">

                            </div>

                            <input type="hidden" id="product_id">
                            <button type="submit" class="btn btn-primary mb-2" onclick="addToCart()">Add to
                                Cart</button>

                        </div>
                    </div>
                </div> <!-- end row -->


            </div>
        </div>
    </div>



    {{-- ajax --}}
    {{-- main problems is id in [is worng celo] --}}
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        // product view model function
        function productView(id) {
            // alert(id)
            $.ajax({
                // problem is not use , in get
                type: 'GET',
                url: '/product/view/modal/' + id,
                dataType: 'json',
                success: function(data) {
                    // console.log(data)

                    $('#pname').text(data.product.product_name);

                    $('#price').text(data.product.selling_price);
                    $('#pcode').text(data.product.product_code);

                    $('#pcategory').text(data.product.category.category_name);
                    $('#pbrand').text(data.product.brand.brand_name);
                    $('#pstock').text(data.product.product_qty);
                    // img 
                    $('#pimg').attr('src', '/' + data.product.product_thambnail);

                    // product id for add to cart
                    $('#product_id').val(id);

                    // Qty 
                    $('#qty').val(1);


                    // Product Price
                    if (data.product.discount_price == null) {

                        /// for discount price is null then only show selling price
                        $('#pprice').text('');
                        $('#oldprice').text('');

                        $('#pprice').text(data.product.selling_price);

                    } else {
                        $('#pprice').text(data.product.discount_price);
                        $('#oldprice').text(data.product.selling_price);
                    }

                    // in stock product
                    if (data.product.product_qty > 0) {

                        $('#aviable').text('');
                        $('#stockout').text('');

                        $('#aviable').text('Aviable');

                    } else {

                        $('#aviable').text('');
                        $('#stockout').text('');

                        $('#stockout').text('Stockout');
                    }



                    // load product color 
                    $('select[name="color"]').empty();
                    $.each(data.color, function(key, value) {
                        $('select[name="color"]').append('<option value=" ' + value + ' " > ' + value +
                            ' </option>')
                    })


                    // load product size 
                    $('select[name="size"]').empty();
                    $.each(data.size, function(key, value) {
                        $('select[name="size"]').append('<option value=" ' + value + ' " > ' + value +
                            ' </option>')
                        // product size =null then hide is option
                        if (data.size == "") {
                            $('#sizeArea').hide();

                        } else {
                            $('#sizeArea').show();
                        }


                    })

                }

            })

        } // end function 


        //   start add to cart product function

        function addToCart() {
            var product_name = $('#pname').text();
            var id = $('#product_id').val();
            var color = $('#color option:selected').text();
            var size = $('#size option:selected').text();
            var quantity = $('#qty').val();

            // add to cart post
            $.ajax({
                type: "POST",
                dataType: 'json',
                data: {
                    color: color,
                    size: size,
                    quantity: quantity,
                    product_name: product_name
                },
                url: "/cart/data/store/" + id,
                success: function(data) {
                    // for auto update
                    miniCart();
                    // for cart auto close
                    $('#closeModel').click();

                    // for test data
                    // console.log(data)

                    //start message
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000,

                    })
                    if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                            type: 'success',
                            title: data.success
                        })
                    } else {
                        Toast.fire({
                            type: 'error',
                            title: data.error
                        })
                    }

                    // end message

                } // fun end
            })

        } // end function


        //   End add to cart product function
    </script>

    <script type="text/javascript">
        function miniCart() {
            $.ajax({
                type: 'GET',
                url: '/product/mini/cart',
                dataType: 'json',
                success: function(response) {
                    //   console.log(response)
                    var miniCart = ""

                    $.each(response.carts, function(key, value) {

                        // sub total and qty
                        $('span[id="cartSubTotal"]').text(response.cartTotal);

                        $('#cartQty').text(response.cartQty);


                        // end sub total and qty


                        miniCart += `<div class="cart-item product-summary">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="image"> <a href="detail.html"><img src="/${value.options.image}" alt=""></a> </div>
                        </div>
                        <div class="col-xs-7">
                            <h3 class="name"><a href="index.php?page-detail">${value.name}</a></h3>
                            <div class="price"> ${value.price} $ *  Qty: ${value.qty}</div>
                        </div>

                        <div class="col-xs-1 action"> 

                        <button type="submit" id="${value.rowId}" onclick="miniCartRemove(this.id)"><i class="fa fa-trash"></i></button> 
                        
                        </div>

                    </div>

                 </div>
               </div>
               <!-- /.cart-item -->
               <div class="clearfix"></div>
               <hr>`

                    });

                    $('#miniCart').html(miniCart);

                }
            })
        }

        miniCart();

        /// mini cart remove Start 
        function miniCartRemove(rowId) {
            $.ajax({
                type: 'GET',
                url: '/minicart/product-remove/' + rowId,
                dataType: 'json',
                success: function(data) {
                    miniCart();

                    // Start Message 
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                            type: 'success',
                            title: data.success
                        })
                    } else {
                        Toast.fire({
                            type: 'error',
                            title: data.error
                        })
                    }
                    // End Message 

                }
            });
        }
        //  end mini cart remove 
    </script>


    <!--  /// Start Add Wishlist Page  //// -->
    <script type="text/javascript">
        function addToWishList(product_id) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "/add-to-wishlist/" + product_id,

                success: function(data) {
                    // Start Message 
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',

                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                            type: 'success',
                            icon: 'success',
                            title: data.success
                        })
                    } else {
                        Toast.fire({
                            type: 'error',
                            icon: 'error',
                            title: data.error
                        })
                    }
                    // End Message 

                }
            })
        }
    </script>
    <!--  /// End Add Wishlist Page  ////   -->


    <!--  ///  Wishlist Function start  ////   -->
    <script type="text/javascript">
        function wishlist() {
            $.ajax({
                type: 'GET',
                url: '/get-wishlist-product',
                dataType: 'json',
                success: function(response) {
                    var rows = ""
                    $.each(response, function(key, value) {
                        rows += `<tr>
                                    <td class="col-md-2"><img src="/${value.product.product_thambnail} " alt="imga"></td>
                                    <td class="col-md-7">
                                          <div class="product-name"><a href="#">${value.product.product_name}</a></div>
                                          
                                          <div class="price">
                                          ${value.product.discount_price == null
                                             ? `${value.product.selling_price}`
                                             :
                                             `${value.product.discount_price} <span>${value.product.selling_price}</span>`
                                          }
                                             
                                          </div>
                                    </td>
                        <td class="col-md-2">
                              <button class="btn btn-primary icon" type="button" title="Add Cart" data-toggle="modal" data-target="#exampleModal" id="${value.product_id}" onclick="productView(this.id)"> Add to Cart </button>
                        </td>
                        <td class="col-md-1 close-btn">
                              <button type="submit" class="" id="${value.id}" onclick="wishlistRemove(this.id)"><i class="fa fa-times"></i></button>
                        </td>
                                 </tr>`
                    });

                    $('#wishlist').html(rows);
                }
            })
        }
        wishlist();


        ///  Wishlist remove Start 
        function wishlistRemove(id) {
            $.ajax({
                type: 'GET',
                url: '/wishlist-remove/' + id,
                dataType: 'json',
                success: function(data) {
                    wishlist();
                    // Start Message 
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',

                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                            type: 'success',
                            icon: 'success',
                            title: data.success
                        })
                    } else {
                        Toast.fire({
                            type: 'error',
                            icon: 'error',
                            title: data.error
                        })
                    }
                    // End Message 
                }
            });
        }
        // End Wishlist remove   
    </script>
    <!--  ///  Wishlist Function End  ////   -->

    <!--  ///  My Cat Function start  ////   -->
    <script type="text/javascript">
        function cart() {
            $.ajax({
                type: 'GET',
                url: '/get-cart-product',
                dataType: 'json',
                success: function(response) {
                    var rows = ""
                    // use carts auto load
                    $.each(response.carts, function(key, value) {
                        rows += `<tr class="CenterLine">
                        <td><img src="/${value.options.image} " alt="imga" style="width:60px; height:60px;"></td>
                       
                        <td>
                              <div class="product-name"><a href="#">${value.name}</a></div>
                              
                              <div class="price">
                                 $${value.price}
                              </div>
                            </td>


                        <td>
                        <strong>${value.options.color} </strong> 
                        </td>
                        <td>
                        ${value.options.size == null
                            ? `<span> Null </span>`
                            :
                        `<strong>${value.options.size} </strong>` 
                        }           
                            </td>

                        <td>
                            ${value.qty > 1
                            ? `<button type="submit" class="btn btn-danger btn-sm" id="${value.rowId}" onclick="cartDecrement(this.id)" >-</button> `
                            : `<button type="submit" class="btn btn-danger btn-sm" disabled >-</button> `
                            }

                            <input type="text" value="${value.qty}" min="1" max="5000" disabled="" style="width:35px;" >

                            <button type="submit" class="btn btn-success btn-large"  id="${value.rowId}" onclick="cartIncrement(this.id)">+</button>  

                        </td>
                            
                        <td>
                            <strong>$${value.subtotal} </strong> 
                        </td>

            
                        <td class="close-btn">
                        <button type="submit" class="" id="${value.rowId}" onclick="cartRemove(this.id)"><i class="fa fa-times"></i></button>
                        </td>
                     </tr>`
                    });

                    $('#cartPage').html(rows);
                }
            })
        }

        cart(); // end function




        ///  my cart remove Start 
        function cartRemove(id) {
            $.ajax({
                type: 'GET',
                url: '/cart-remove/' + id,
                dataType: 'json',
                success: function(data) {
                    couponCalculation();
                    cart();
                    miniCart()

                    $('#couponField').show();
                    $('#coupon_name').val('');

                    // Start Message 
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',

                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                            type: 'success',
                            icon: 'success',
                            title: data.success
                        })
                    } else {
                        Toast.fire({
                            type: 'error',
                            icon: 'error',
                            title: data.error
                        })
                    }
                    // End Message 
                }
            });
        }
        // End my cart remove 


        // -------- CART INCREMENT --------//
        function cartIncrement(rowId) {
            $.ajax({
                type: 'GET',
                url: "/cart-increment/" + rowId,
                dataType: 'json',
                success: function(data) {

                    //coupon update price auto
                    couponCalculation();
                    cart();
                    miniCart();
                }
            });
        }
        // ---------- END CART INCREMENT -----///


        // -------- CART Decrement  --------//
        function cartDecrement(rowId) {
            $.ajax({
                type: 'GET',
                url: "/cart-decrement/" + rowId,
                dataType: 'json',
                success: function(data) {

                    // auto coupon update price
                    couponCalculation();
                    cart();
                    miniCart();
                }
            });
        }
        // ---------- END CART Decrement -----///
    </script>
    <!-- my cart function End -->

            <!--============== Apply Coupon================ -->
        <script>

            function applyCoupon(){
            var coupon_name = $('#coupon_name').val();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {coupon_name:coupon_name},
                url: "{{ url('/coupon_apply') }}",
                success:function(data){

                    couponCalculation(); 
                    // coupon remove then auto page hide 
                    $('#couponField').hide();

                    // Start Message 
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            
                            showConfirmButton: false,
                            timer: 3000
                                    })
                                if ($.isEmptyObject(data.error)) {
                                    Toast.fire({
                                        type: 'success',
                                        icon: 'success',
                                        title: data.success
                                    })
                                }else{
                                    Toast.fire({
                                        type: 'error',
                                        icon: 'error',
                                        title: data.error
                                    })
                                }
                                // End Message 
                        }
                        })
                    } 


            //Coupon Calculation

                function couponCalculation(){
                $.ajax({
                    type: 'GET',
                    url: "{{ url('/coupon-calculation') }}",
                    dataType: 'json',
                    success:function(data){

                        if (data.total) {
                        $('#couponClaFiled').html(
                            `	<tr>
                            <th>
                                <div class="cart-sub-total">
                                    Subtotal<span class="inner-left-md">$ ${data.total}</span>
                                </div>
                                <div class="cart-grand-total">
                                    Grand Total<span class="inner-left-md">$ ${data.total}</span>
                                </div>
                            </th>
                        </tr>`
                    )

                        }else{

                        $('#couponClaFiled').html(
                            `	<tr>
                            <th>
                                <div class="cart-sub-total">
                                    Subtotal<span class="inner-left-md">$ ${data.subtotal}</span>
                                </div>

                        <div class="cart-sub-total">
                                    Coupon Name<span class="inner-left-md"> ${data.coupon_name}</span>
                        <button type="submit" onclick="couponRemove()" ><i class="fa fa-times"></i></button>
                                </div>

                        <div class="cart-sub-total">
                                    Discount Amount <span class="inner-left-md">$ ${data.discount_amount}</span>
                                </div>


                                <div class="cart-grand-total">
                                    Grand Total<span class="inner-left-md">$ ${data.total_amount}</span>
                                </div>
                            </th>
                        </tr>`
                        )

                        }


                    }
                });
            }
        couponCalculation();
        </script>
        <!--================= End Apply Coupon================ -->


        <!--  =========== Start- Coupon Remove================= -->
        <script type="text/javascript">
            
            function couponRemove(){
            $.ajax({
                type:'GET',
                url: "{{ url('/coupon-remove') }}",
                dataType: 'json',
                success:function(data){
                    // coupon calcution load
                    couponCalculation(); 

                    // coupon remove then auto page load
                    $('#couponField').show();
                    
                    // old coupon code remove auto
                    $('#coupon_name').val('');


                        // Start Message 
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        
                        showConfirmButton: false,
                        timer: 3000
                        })
                    if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                            type: 'success',
                            icon: 'success',
                            title: data.success
                        })
                    }else{
                        Toast.fire({
                            type: 'error',
                            icon: 'error',
                            title: data.error
                        })
                    }
                    // End Message 
                }
            });
            }
        </script>
        <!-- =========== End Coupon Remove================= -->


</body>

</html>
