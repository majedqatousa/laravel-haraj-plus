@extends('website.layouts.app')

@section('seoTitle', 'الرئيسية')
@section('seoGoogleImg',asset('website/images/main/haraj.png'))
@section('seoDescription', 'الموقع الرسمي حراج بلص Haraj Plus موقع سعودي منصة إعلانية حرة تعمل على ربط بين التاجر والمستهلك لبيع المنتجات الجديدة والمستعملة ، حيث يتيح لأي شخص في المملكة فتح حساب وعرض منتجاته بالصور والفيديو') 
@section('seoKeywords', 'حراج,حراج بلص,حراج بلس
,haraj plus,حراج السعودية,موقع حراج السيارات,الحراج المفتوح,سوق حراج,الحراج الجديد,اعلان حراج')
@section('meta')
 <meta property="og:title" content="حراج بلص" />
    <meta property="og:type" content="website" />
    <meta property="og:image:url"  content="{{asset('website/images/website.png')}}" />
    <meta property="og:image:width"  content="1200" />
    <meta property="og:image:height"  content="630" />
    <meta property="og:description" content="الموقع الرسمي حراج بلص Haraj Plus موقع سعودي منصة إعلانية حرة تعمل على ربط بين التاجر والمستهلك لبيع المنتجات الجديدة والمستعملة ، حيث يتيح لأي شخص في المملكة فتح حساب وعرض منتجاته بالصور والفيديو" />
    <meta property="og:site_name" content="حراج بلص" />
    <meta property="fb:app_id" content="1909299302714716" />
   
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="حراج بلص" />
    <meta name="twitter:creator" content="https://haraj-plus.sa" />
    <meta property="og:url" content="https://haraj-plus.sa" />
    <meta property="og:title" content="حراج بلص" />
    <meta property="og:image"  itemprop="image" content="{{asset('website/images/website.png')}}" />
    <meta property="og:image:width"  content="150" />
    <meta property="og:image:height"  content="100" />
    <meta property="twitter:description" content="الموقع الرسمي حراج بلص Haraj Plus موقع سعودي منصة إعلانية حرة تعمل على ربط بين التاجر والمستهلك لبيع المنتجات الجديدة والمستعملة ، حيث يتيح لأي شخص في المملكة فتح حساب وعرض منتجاته بالصور والفيديو" />
    
<script type="application/ld+json">
   
        {
            "@context": "http://schema.org",
            "@type": "Corporation",
            "name": "الموقع الرسمي حراج بلص Haraj Plus موقع سعودي منصة إعلانية حرة تعمل على ربط بين التاجر والمستهلك لبيع المنتجات الجديدة والمستعملة ، حيث يتيح لأي شخص في المملكة فتح حساب وعرض منتجاته بالصور والفيديو",
            "description": "الموقع الرسمي حراج بلص Haraj Plus موقع سعودي منصة إعلانية حرة تعمل على ربط بين التاجر والمستهلك لبيع المنتجات الجديدة والمستعملة ، حيث يتيح لأي شخص في المملكة فتح حساب وعرض منتجاته بالصور والفيديو",
            "image": "{{asset('website/images/main/haraj.png')}}",
            "logo": "{{asset('website/images/main/haraj.png')}}",
            "url": "https://haraj-plus.sa/",
            "telephone": "phone number"
        }
        </script>
  
    @endsection
@section('content')

    <section class="order-div main-index-order">
        <!-- start slider-products
         ================ -->
    <section class="slider-products  wow fadeIn">
        <div class="container">
            <div class="row">
                <div class="col-12 gray-bg row no-marg-row">
                    <div class="col-xl-2 latest-title-grid">
                        <div class="new-product-box">
                        أحدث المنتجات
                        </div>
                    </div>
                    <div class="col-xl-10 no-marg-row">
                        <div id="owl-demo6" class="owl-carousel owl-theme no-full-images    products-carousel2">
                            <!--start item-->
                            @if(!$recentProducts->isEmpty())
                                @foreach($recentProducts as $product )
                                    <div class="item">
                                        <!--start product-grid-->
                                        <div class="product-grid md-center">
                                            <div class="product-div">
                                                <div class="product-img">
                                                    <a  href="{{asset('storage/'.$product->main_image)}}"
                                                        class="html5lightbox"
                                                        data-group="set-1">
                                                        <img src="{{asset('storage/'.$product->main_image)}}"
                                                                alt="logo"/>
                                                    </a>
                                                </div>
                                                <a  href="{{route('product-details',$product->id.'-'.$product->name)}}">
                                                    <div class="product-details">
                                                        <h3 class="product-name first_color">{{strpos($product->name, '%') !== false ? str_replace("%","/",$product->name) : $product->name }}
 </h3>
                                                        @if($product->discount_ratio !=null)
                                                            <span class="new-price price">{{$product->price-($product->price*$product->discount_ratio)/100 }} ر.س</span>
                                                            <span class="old-price price">{{$product->price }}ر.س</span>
                                                        @else
                                                            <span
                                                                class="new-price price">{{$product->price}} ر.س</span>
                                                        @endif

                                                        <span
                                                            class="product-time second_bg first_color">{{$product->created_at->diffForHumans(Carbon\Carbon::now(), false)}} </span>

                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <!--end product-grid-->
                                    </div>
                                    <!--end item-->
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--end slider-products-->


    <!-- start main-slider
        ================ -->
    <section class="main-slider  wow fadeIn">
        <div class="container-fluid">
            <div class="row">
                <div id="owl-demo" class="owl-carousel owl-theme main-carousel top-nav">
                    <!-- start owl-item -->
                    @if(!$sliders->isEmpty())
                        @foreach($sliders as $slider)

                            <div class="item">
                             <a href="{{$slider->url}}"  target="_blank">
                                <div class="slider-img">
                                    <img src="{{asset('storage/'.$slider->image)}}"
                                            alt="slider img"/>  
                                </div>
                                @if($slider->title || $slider->body)
                                <div class="slider-caption">
                                    <div class="container">
                                        <div class="caption">
                                            <h2 class="first_color">{{$slider->title}} </h2>
                                        <p>
                                            {{$slider->body}}
                                        </p>

                                        <!--<a  href="{{$slider->url}}" class="custom-btn big-btn" target="_blank">المزيد من التفاصيل</a>-->
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                </a>  
                            </div>
                            <!-- end owl-item -->
                        @endforeach
                    @endif
                </div>

            </div>
        </div>
    </section>
    <!--end main-slider-->

</section>


<!-- start advanced-search
        ================ -->
<section class="advanced-search text-center margin-index-div  wow fadeIn">
    <div class="container">
        <div class="row">
            
            
            <div class="col-12 advanced-search-container">
                   
                <h2 class="sec-title text-center">بحث متقدم</h2>
                <form class="needs-validation row no-marg-row" method="get"  novalidate>
                    <div class="col-12">
                        <div class="form-group">
                            <input class="form-control" name="name"  id='pro_name' placeholder="ابحث هنا" required/>
                            <div class="invalid-feedback">
                                من فضلك أدخل نص صحيح
                            </div>
                            <button type="submit" id="search-pro" href="{{route("products.search")}}" class="pos-search-btn first_color"><i
                                    class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>

                    <div class="row no-marg-row white-form">
                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="category_id"  id="inner-filter" href="{{route("products.search")}}" class="form-control">
                                    <option selected disabled value="0">التصنيف</option>
                                    @if(!$categories->isEmpty())
                                        @foreach($categories as $key=>$value)
                                            <option id="{{$key}}" value="{{ $key }}">{{$value}} </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>  
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="text" placeholder="التاريخ" name="datefilter" href="{{route("products.search")}}" id="datefilter" class="form-control" value=""/>


                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="price-filter">
                                    <h3 class="form-control">السعر</h3>
                                    <div class="filter-list">
                                        <div class="range-slider">
                                            <input type="text" class="js-range-slider" value="" href="{{route("products.search")}}"/>
                                        </div>
                                        <div class="extra-controls form-inline ">
                                            <div class="form-group text-center">
                                                <input type="text" name="price_from" id="min_price" value="0"
                                                        class="js-input-from form-control"/>
                                                <input type="text" name="price_to" id="max_price" value="10000"
                                                        class="js-input-to form-control"/>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
<!--end advanced-search-->

<!-- start products
        ================ -->
        <section class="products md-center  wow fadeIn data-search" style="display: none">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="sec-title text-center">نتائج البحث</h2>
                
                        <div id="owl-demo7" class="owl-carousel owl-theme no-full-images products-carousel prod">
                            <!--start item-->
                            @if(!$products_pro->isEmpty())
                                @foreach($products_pro as $product)
                                    <div class="item">
                                        <!--start product-grid-->
                                        <div class="product-grid">
                                            <div class="product-div">
                                                @if(auth()->id())
                                                    @if($favouriteProducts!=[] )
        
                                                        <span
                                                            @if(in_array($product->id,$favouriteProducts)) class="fav-icon first_bg active"
                                                            onclick="toggleFavourites({{$product->id, auth()->id()}})"
                                                            @else  class="fav-icon first_bg "
                                                            onclick="toggleFavourites({{$product->id, auth()->id()}})" @endif  ><i
                                                                class="far fa-heart"></i></span>
                                                    @else
                                                        <span onclick="toggleFavourites({{$product->id, auth()->id()}})"
                                                                class="fav-icon first_bg">
        
                                                <i class="far fa-heart"></i>
                                            </span>
                                                    @endif
                                                @endif
                                                <a  href="{{route('product-details',$product->id.'-'.$product->name)}}">
                                                    <div class="product-img">
                                                        <img src="{{asset('storage/'.$product->main_image)}}" alt="logo"/>
                                                    </div>
                                                    <div class="product-details">
                                                        <h3 class="product-name first_color">{{strpos($product->name, '%') !== false ? str_replace("%","/",$product->name) : $product->name }}
</h3>
                                                        @if($product->discount_ratio !=null)
                                                            <span class="new-price price">{{$product->price-($product->price*$product->discount_ratio)/100 }} ر.س</span>
                                                            <span class="old-price price">{{$product->price}} ر.س</span>
                                                        @else
                                                            <span class="new-price price">{{$product->price}} ر.س</span>
                                                        @endif
                                                        <div class="two-btns">
                                                           
                                                             <button class="custom-btn sm-btn">الشراء
                                                            الأن</button>
                                                            <span
                                                                class="product-time second_bg first_color"> {{$product->created_at->diffForHumans(Carbon\Carbon::now(), false)}}</span>
                                                        </div>
                                                    </div>
                                                </a>
                                                <span class="pointer-shadow"></span>
        
                                            </div>
                                        </div>
                                        <!--end product-grid-->
                                    </div>  
                                    <!--end item-->
                                @endforeach
        
                        </div>
                        @if($pro_count>=12)
                            <div class="text-center col-12">
                                <a   href="{{route('productsUser',1)}}"  class="custom-btn big-btn">المزيد</a>
                            </div>
                        @endif
                        @else
                            <h4 class='empty-div-messages text-center'>لا يوجد منتجات</h4>
                        @endif
                        <h3 class="col-12 text-center" id="error-message" style="color:crimson;display:none">عذرا .. ما تبحث عنه غير متوفر يمكنك التجربة بكلمات مفتاحية مختلفة</h3>
        
                    </div>
                </div>
            </div>
        </section>










<!-- start products
        ================ -->
<section class="products md-center  wow fadeIn">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="sec-title text-center"> منتجات رجال الاعمال</h2>
        
                <div id="owl-demo3" class="owl-carousel owl-theme no-full-images products-carousel prod">
                    <!--start item-->
                    @if(!$products_pro->isEmpty())
                        @foreach($products_pro as $product)
                            <div class="item">
                                <!--start product-grid-->
                                <div class="product-grid">
                                    <div class="product-div">
                                        @if(auth()->id())
                                            @if($favouriteProducts!=[] )

                                                <span
                                                    @if(in_array($product->id,$favouriteProducts)) class="fav-icon first_bg active"
                                                    onclick="toggleFavourites({{$product->id, auth()->id()}})"
                                                    @else  class="fav-icon first_bg "
                                                    onclick="toggleFavourites({{$product->id, auth()->id()}})" @endif  ><i
                                                        class="far fa-heart"></i></span>
                                            @else
                                                <span onclick="toggleFavourites({{$product->id, auth()->id()}})"
                                                        class="fav-icon first_bg">

                                        <i class="far fa-heart"></i>
                                    </span>
                                            @endif
                                        @endif
                                        <a  href="{{route('product-details',$product->id.'-'.$product->name)}}">
                                            <div class="product-img">
                                                <img src="{{asset('storage/'.$product->main_image)}}" alt="logo"/>
                                            </div>
                                            <div class="product-details">
                                                <h3 class="product-name first_color">{{$product->name}} </h3>
                                                 @if($product->discount_ratio !=null)
                                                    <span class="new-price price">{{$product->price-($product->price*$product->discount_ratio)/100 }} ر.س</span>
                                                    <span class="old-price price">{{$product->price}} ر.س</span>
                                                @else
                                                    <span class="new-price price">{{$product->price}} ر.س</span>
                                                @endif
                                                <div class="two-btns">
                                                   
                                                     <button class="custom-btn sm-btn">الشراء
                                                    الأن</button>
                                                    <span
                                                        class="product-time second_bg first_color"> {{$product->created_at->diffForHumans(Carbon\Carbon::now(), false)}}</span>
                                                </div>
                                            </div>
                                        </a>
                                        <span class="pointer-shadow"></span>

                                    </div>
                                </div>
                                <!--end product-grid-->
                            </div>  
                            <!--end item-->
                        @endforeach

                </div>
                @if($pro_count>=12)
                    <div class="text-center col-12">
                        <a   href="{{route('productsUser',1)}}"  class="custom-btn big-btn">المزيد</a>
                    </div>
                @endif
                @else
                    <h4 class='empty-div-messages text-center'>لا يوجد منتجات</h4>
                @endif
                <h3 class="col-12 text-center" id="error-message" style="color:crimson;display:none">عذرا .. ما تبحث عنه غير متوفر يمكنك التجربة بكلمات مفتاحية مختلفة</h3>

            </div>
        </div>
    </div>
</section>
<!--end products-->


<!-- start main-banner
        ================ -->
<section class="main-banner home-products  wow fadeIn">
    <div class="container-fluid">
        <div class="row">
            @if(isset($banner1))
                <a  href="{{$banner1->link}}" target="_blank">
                    <img src="{{asset('storage/'.$banner1->image)}}" alt="jaadara"/>
                </a>
            @endif
        </div>
    </div>
</section>
<!--end main-banner-->


<!-- start stores
        ================ -->
<section class="stores margin-index-div  md-center wow fadeIn">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="sec-title text-center"> متاجر رجال الاعمال</h2>
                <div id="owl-demo4" class="owl-carousel owl-theme no-full-images  products-carousel">
                @if(!$stores->isEmpty())
                    @foreach($stores as $store)
                        <!--start item-->

                            <div class="item load-div-stores">
                                <!--start product-grid-->
                                <div class="product-grid">
                                    <div class="product-div">
                                        <div class="stores-img">

                                            <img src="{{ isset($store->user->image)?asset('storage/'.$store->user->image):asset('admin/images/main/avatar.png')}}" alt="logo"/>

                                        </div>
                                        <div class="product-details">
                                            <h3 class="stores-name first_color">{{$store->user->name}}</h3>
                                            <p>
                                                {{$store->about}}
                                            </p>
                                            <div class="text-center">

                                                    <a  href="{{route('business-general-profile',$store->link)}}"
                                                        class="more-link"> المزيد من التفاصيل</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end product-grid-->
                            </div>
                            <!--end item-->
                        @endforeach


                </div>
            </div>
            @if($store_count>6)
                <div class="text-center col-12 margin-index-div">
                    <a  id="loadmore-stores" class="custom-btn big-btn">المزيد</a>
                </div>
            @endif
            @else
                <h4 class='empty-div-messages text-center'>لا يوجد متاجر</h4>
            @endif
        </div>
    </div>
</section>
<!--end stores-->




<!-- start brands-slider
        ================ -->
<section class="brands  wow fadeIn">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h2 class="sec-title text-center"> الماركات العالمية</h2>
            </div>
            <div class="gray-bg col-12">
                <div class="container">
                    <div class="row">
                        <div id="owl-demo2"
                                class="owl-carousel owl-theme no-full-images top-nav full-width-nav brands-carousel">
                            <!-- start owl-item -->
                            @if(!$brands->isEmpty())
                                @foreach($brands as $brand)
                                    <div class="item">
                                        <div class="brand-img">
                                            <a  href="{{$brand->link}}">
                                                <img src="{{asset('storage/'.$brand->image)}}" alt="slider img"/>
                                            </a>
                                        </div>
                                    </div>

                                @endforeach
                            <!-- end owl-item -->
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--end brands-slider-->


<!-- start products
        ================ -->
<section class="products home-products  md-center  wow fadeIn">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="sec-title text-center"> منتجات المستخدمين</h2>

                <div id="owl-demo5" class="owl-carousel owl-theme no-full-images load  products-carousel">

                <!--start item-->
                    @if(!$products->isEmpty())
                        @foreach($products as $product)
                            <div class="item">
                                <!--start product-grid-->
                                <div class="product-grid">
                                    <div class="product-div">
                                        @if(auth()->id())
                                            @if($favouriteProducts!=[] )

                                                <span
                                                    @if(in_array($product->id,$favouriteProducts)) class="fav-icon first_bg active"
                                                    onclick="toggleFavourites({{$product->id, auth()->id()}})"
                                                    @else class="fav-icon first_bg "
                                                    onclick="toggleFavourites({{$product->id, auth()->id()}})"  @endif  ><i
                                                        class="far fa-heart"></i></span>
                                            @else
                                                <span onclick="toggleFavourites({{$product->id, auth()->id()}})"
                                                        class="fav-icon first_bg">

                                        <i class="far fa-heart"></i>
                                    </span>
                                            @endif
                                        @endif
                                        <a  href="{{route('product-details',$product->id.'-'.$product->name)}}">
                                            <div class="product-img">
                                                <img src="{{asset('storage/'.$product->main_image)}}" alt="logo"/>
                                            </div>
                                            <div class="product-details">
                                                <h3 class="product-name first_color">{{$product->name}} </h3>
                                              @if($product->discount_ratio !=null)

                                                    <span class="new-price price">{{$product->price-($product->price*$product->discount_ratio)/100 }} ر.س</span>
                                                    <span class="old-price price">{{$product->price}} ر.س</span>
                                                @else
                                                    <span class="new-price price">{{$product->price}} ر.س</span>
                                                @endif
                                                <div class="two-btns">
                                                    <button class="custom-btn sm-btn">الشراء
                                                    الأن</button>
                                                    <span
                                                        class="product-time second_bg first_color">{{$product->created_at->diffForHumans(Carbon\Carbon::now(), false)}} </span>
                                                </div>
                                            </div>
                                        </a>
                                        <span class="pointer-shadow"></span>

                                    </div>
                                </div>
                                <!--end product-grid-->
                            </div>

                    @endforeach
                    <!--end item-->

                </div>
            </div>
            @if($normal_count >=12)
                <div class="text-center col-12 margin-index-div">
                    <a   href="{{route('productsUser',0)}}" class="custom-btn big-btn loadmore">المزيد</a>
                </div>
            @endif
            @else
                <h4 class='empty-div-messages text-center'>لا يوجد منتجات</h4>
            @endif



        </div>
    </div>
</section>
<!--end products-->



<!-- start main-banner
        ================ -->
<section class="main-banner wow fadeIn">
    <div class="container-fluid">
        <div class="row">
            @if(isset($banner2))
                <a  href="{{$banner2->link}}" target="_blank">
                    <img src="{{asset('storage/'.$banner2->image)}}" alt="jaadara"/>
                </a>
            @endif
        </div>
    </div>
</section>
<!--end main-banner-->
@endsection
@include('website.layouts.footer')
@section('scripts')

<script src="{{asset('website/js/price.js')}}" type="text/javascript"></script>
<script src="{{asset('website/js/index.js')}}" type="text/javascript"></script>



    <script>
    $(function () {
        $(".load-div-business").slice(0, 12).fadeTo("slow", 12);
        $(".load-div").slice(0, 12).fadeTo("slow", 12);
        $(".load-div-stores").slice(0, 12).fadeTo("slow", 12);

        $("#loadmore-business").on('click', function (e) {
            e.preventDefault();
            $(".load-div-business:hidden").slice(0, 12).slideDown("fast");

            if ($(".load-div-business:hidden").length == 0) {
                $("#loadmore-business").fadeOut('fast');
            } else {
                $("#loadmore-business ").fadeIn('fast');

            }
            $('html,body').animate({
                scrollTop: $(this).offset().top - 600
            }, 1500);
        });


        $("#loadmore").on('click', function (e) {
            e.preventDefault();
            $(".load-div:hidden").slice(0, 12).slideDown("fast");

            if ($(".load-div:hidden").length == 0) {
                $("#loadmore").fadeOut('fast');
            } else {
                $("#loadmore").fadeIn('fast');

            }
            $('html,body').animate({
                scrollTop: $(this).offset().top - 600
            }, 1500);
        });

        $("#loadmore-stores").on('click', function (e) {
            e.preventDefault();
            $(".load-div-stores:hidden").slice(0, 8).slideDown("fast");

            if ($(".load-div-stores:hidden").length == 0) {
                $("#loadmore-stores").fadeOut('fast');
            } else {
                $("#loadmore-stores").fadeIn('fast');

            }
            $('html,body').animate({
                scrollTop: $(this).offset().top - 600
            }, 1500);
        });

    });


    $(function () {
        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
                "locale": {
        "applyLabel": "تطبيق",
        "cancelLabel": "إلغاء",
        "fromLabel": "من",
        "toLabel": "إلي",
        "customRangeLabel": "Custom",
        "daysOfWeek": [
            "حد",
            "ثن",
            "ثلا",
            "ربع",
            "خم",
            "جم",
            "سب"
        ],
        "monthNames": [
            "يناير",
            "فبراير",
            "مارس",
            "أبريل",
            "مايو",
            "يونيو",
            "يوليو",
            "أغسطس",
            "سبتمبر",
            "أكتوبر",
            "نوفمبر",
            "ديسمبر"
        ],
    },
    dir:"rtl"
        });
        $('input[name="datefilter"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                'MM/DD/YYYY'));
        });
        $('input[name="datefilter"]').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });


    /*$(document).ready(function (e) {

        loadmore();


    });*/

    function loadmore() {


        var url = $('#loadmore').val();

        // console.log(url);

        if (url == 0) {

            url = "/loadMoreProducts"
        }
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#owl-demo5').append(data['output'])
                if (data['next_url'] == '') {
                    $('#loadmore').remove();

                } else
                    $('#loadmore').val(data['next_url'])
                $('#loadmore').show();

            }
        });


    }



</script>



<script>
$(document).ready(function() {
$('#search-pro').click(function(e){
            e.preventDefault();
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
            var name=$('#pro_name').val();
            var type = $("#inner-filter option:selected" ).val();
            var min_price =$('#min_price').val();
            var max_price =$('#max_price').val();
            // var token=$('meta[name="csrf-token"]').attr('content');
           $.ajax({
            url :$(this).attr('href'),
            type:'GET',
            dataType: "json",
            data:{'name':name ,'min_price':min_price ,'max_price':max_price,'type':type},
            success: function(data) {
                if(data['error']){
                        $(".data-search").show();
                        $('#owl-demo7').empty();
                        $("#error-message").show();
                }
            else{
                    $("#error-message").hide();
                    $(".data-search").show();
                    $('#owl-demo7').empty();
                    $('#owl-demo7').append(data['output']);
                    $('#owl-demo7').trigger('destroy.owl.carousel');
                    $("#owl-demo7").owlCarousel({
                loop: true,
                rtl: true,
                nav: false,
                dots: false,
                items: 4,
                autoplay: true,
                mouseDrag: true,
                touchDrag: true,
                margin: 20,
                responsive: {
                    0: {
                        items: 1
                    },
                    576: {
                        items: 2
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 3
                    },
                    1200: {
                        items: 4,
                        loop: false,
                        autoplay: false,
                        mouseDrag: false,
                        touchDrag: false,
                        autoplay: false,
                        margin: 0

                    }
                }
            });
                }
            }

        });

        });



$(".js-range-slider").on('change',function() {

    var min_price =$('#min_price').val();
    var max_price =$('#max_price').val();
    var type = $("#inner-filter option:selected" ).val();
    var name=$('#pro_name').val();

        $.ajax({
        url: $(this).attr('href'),
        dataType: "json",
        data:{'min_price':min_price ,'max_price':max_price,'type':type ,'name':name},
        success: function(data) {
            if(data['error']){
                $(".data-search").show();
                        $('#owl-demo7').empty();
                        $("#error-message").show();
                }
            else{
                $(".data-search").show();
                    $("#error-message").hide();
                    $('#owl-demo7').empty()
                    $('#owl-demo7').append(data['output']);
                    $('#owl-demo7').trigger('destroy.owl.carousel');
                    $("#owl-demo7").owlCarousel({
                loop: true,
                rtl: true,
                nav: false,
                dots: false,
                items: 4,
                autoplay: true,
                mouseDrag: true,
                touchDrag: true,
                margin: 20,
                responsive: {
                    0: {
                        items: 1
                    },
                    576: {
                        items: 2
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 3
                    },
                    1200: {
                        items: 4,
                        loop: false,
                        autoplay: false,
                        mouseDrag: false,
                        touchDrag: false,
                        autoplay: false,
                        margin: 0

                    }
                }
            });
                }
        }

    });

});


$( "#inner-filter").on('change',function() {
   var type = $("#inner-filter option:selected" ).val();
  var min_price =$('#min_price').val();
    var max_price =$('#max_price').val();
    var name=$('#pro_name').val();

        $.ajax({
        url: $(this).attr('href'),
        dataType: "json",
        data:{'type':type},
        success: function(data) {
            if(! data){
                $(".data-search").show();
                        $('#owl-demo7').empty();
                        $("#error-message").show();
                }
            else{
                
                $(".data-search").show();
                    $("#error-message").hide();
                    $('#owl-demo7').empty();
                    $('#owl-demo7').append(data['output']);
                    $('#owl-demo7').trigger('destroy.owl.carousel');
                    $("#owl-demo7").owlCarousel({
                loop: true,
                rtl: true,
                nav: false,
                dots: false,
                items: 4,
                autoplay: true,
                mouseDrag: true,
                touchDrag: true,
                margin: 20,
                responsive: {
                    0: {
                        items: 1
                    },
                    576: {
                        items: 2
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 3
                    },
                    1200: {
                        items: 4,
                        loop: false,
                        autoplay: false,
                        mouseDrag: false,
                        touchDrag: false,
                        autoplay: false,
                        margin: 0

                    }
                }
            });
                  }
                    }

                });

});
});
</script>



@endsection

