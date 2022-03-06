@extends('website.layouts.app')
@section('meta')
    <meta property="og:title" content="{{$user->user->name}}" />
    <meta property="og:type" content="website" />
    <meta property="og:image:url"  content="{{asset('storage/'.$user->user->image)}}" />
    <meta property="og:image:width"  content="600" />
    <meta property="og:image:height"  content="314" />
    <meta property="og:description" content="<?=strip_tags($user->about)?>" />
    <meta property="og:site_name" content="حراج بلص" />
    <meta property="fb:app_id" content="1909299302714716" />
   
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="حراج بلص" />
    <meta name="twitter:creator" content="https://haraj-plus.sa" />
    <meta property="og:url" content="{{route('business-general-profile',$user->link)}}"/>
    <meta property="og:title" content="{{$user->user->name}}" />
    <meta property="og:description" content="<?=strip_tags($user->about)?>" />
    <meta property="og:image" content="{{asset('storage/'.$user->user->image)}}" />
@endsection
@section("pop")
    <div class="modal fade" id="link-Custom-linking">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <!-- Modal body -->
                <form  id="add-link" method="post">
                    @csrf
                <div class="profile-modal">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <h2>الرابط المخصص</h2>
                            </div>
                            <div class="col-lg-3">
                                <h3>
                                    رابط المتجر
                                </h3>
                            </div>
                            <div  id="write" class="writeinfo2"  style="display:none" >

                            </div>
                            <div class="col-lg-9">
                                
                                <input type="text" value="{{auth()->user()->promotedUser->link}}" class="form-control"
                                       required   name="link" placeholder="اختر المتجر" >

                                <i class="fas fa-paperclip"></i>
                            </div>
                            <div class="invalid-feedback">


                                يجب ادخال رابط
                            </div>



                            <div class="button1-profile col-lg-12 ">
                                <button   type="submit" id="link" class="custom-btn">اضافة</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>


    @endsection

@section('content')


    <!--start profile-pg
          ================-->
    <section class="order-div page-order-div">
        <div class="profile-pg">
            <div class="container-fluid">
                <div class="row">
                    <!--start profile-images-->
                    <div class="profile-images-grid col-12 no-marg-row wow fadeIn">
                        <div class="form-group profile-image-upload">
                        @if($user->is_active==0)
<div class="container-fluid">
    <div class="row">
        <div class="col-12  text-center wow fadeIn p-3">
          
            المتجر الخاص بك قيد المراجعة، أدخل بيانات المتجر بالشكل الصحيح لحين قبوله  

          
        </div>
    </div>
</div>
@else
@endif
                            <form  name="form1"  id="file" method="post" enctype="multipart/form-data">
                                @csrf

                            <input type="file"  name='cover' class="img-form-shape file-input form-control" value="" id="main-01" required>

                            <label class="file-input-label timeline-label full-width-img " for="main-01"><span class="edit-pen"><i class="fas fa-pencil-alt"></i></span> <img
                                    src="{{asset('storage/'.$user->cover_image)}}" alt="img" class="converted-img" />
                                <img id="preview-main-01" />
                            </label>


                            <div class="user-profile-img">
                                <input type="file"  class="img-form-shape file-input form-control" value="" name="profile" id="main-02" required>


                                <label class="file-input-label timeline-label full-width-img " for="main-02"> <span class="edit-pen"><i class="fas fa-pencil-alt"></i></span>
<img
                                        src="{{asset('storage/'.$user->user->image)}}" alt="img" class="converted-img" />
                                    <img id="preview-main-02" /></label>

                            </div>
                            </form>
                        </div>
                    </div>
                    <!--end profile-images-->
                </div>
            </div>

            <div class="container">
                <div class="row">


                    <div class="col-12  text-center wow fadeIn">
                        <div class="store-information-text">
                             <h2 class="info-title first_color">    نبذه عن  معرض {{$user->user->name}} </h2>
                            <p>
                               {{$user->about}}
                            </p>
                        </div>
                    </div>

                    <div class="col-12 two-btns  margin-div text-left-dir wow fadeIn">
                       @if(auth()->id()==$user->user->id)
                        <a rel="nofollow" href="#" data-toggle="modal" data-target="#link-Custom-linking"
                           class="custom-btn big-btn">الرابط المخصص</a>
                        @endif
                    </div>
                </div>

            </div>


        </div>





        <!-- start products
         ================ -->



        <div class="products md-center show-profile margin-div products-pg  profile-products wow fadeIn">
            <div class="container">
                <div class="row">
                     <div class="col-12 text-left-dir sm-center">
                        <a  href="{{route('products.add')}}" class="info-title second_color_hover first_color">إضافة منتج
                        </a>

                        <div class="share-social">
                            <span class="first_color info-title">| مشاركة </span>
                            <div class="share-social">
                                <ul class="list-inline auto-icon">
                                    <div class="sharethis-inline-share-buttons" data-url="{{route('business-general-profile',$user->link)}}" data-title="<?=strip_tags($user->about)?>"></div>
                                </ul>
                            </div>
                        </div>
                    </div>
                  
                    <div class="col-12">

                        <h2 class="sec-title text-center"> المنتجات </h2>

                    </div>


                    <div class="row no-marg-row col-12">
                       @if(!$products->isEmpty())



                           @foreach($products as $product)
                               <!--start item-->
                                   <div class="item col-xl-3 col-lg-4 col-6 load-div">
                                       <!--start product-grid-->
                                       <div class="product-grid">
                                           <div class="product-div">

                                               <a  href="{{route('product-details',$product->id.'-'.$product->name)}}">
                                                   <div class="product-img">
                                                       <img src="{{asset('storage/'.$product->main_image)}}" alt="logo" />
                                                   </div>
                                                   <div class="product-details">
                                                       <h3 class="product-name first_color">{{$product->name}} </h3>
                                                       @if($product->discount_ratio)
                                                           <span class="new-price price">{{$product->price-$product->price*$product->discount_ratio/100 }} ر.س</span>
                                                           <span class="old-price price">{{$product->price}} ر.س</span>
                                                       @else
                                                           <span class="new-price price">{{$product->price}} ر.س</span>
                                                       @endif
                                                       <div class="two-btns">


                                                           @if($product->is_valid==1)

                                                               <button class="custom-btn sm-btn">مفعل</button>
                                                           @elseif($product->is_valid==0)
                                                               <button class="custom-btn sm-btn">تم تجميده</button>
                                                           @else
                                                               <button class="custom-btn sm-btn">قيد الانتظار </button>
                                                           @endif
                                                           <span class="product-time second_bg first_color">{{$product->created_at->diffForHumans(Carbon\Carbon::now(), false)}}</span>
                                                       </div>
                                                   </div>
                                               </a>
                                               <div class="edit-prouct-icons">
                                                   <a  href="{{route('product.change',$product->id)}}" title="تعديل"><i class="fa fa-edit"></i></a>
                                                   @if($product->is_valid==1)
                                                       <a  href="{{route('products.deactivate',$product->id)}}" title="تجميد"><i class="fa fa-cube"></i></a>

                                                   @elseif($product->is_valid==0)
                                                       @if($product->activation_user_id==auth()->id())
                                                           <a  href="{{route('products.deactivate',$product->id)}}" title="تفعيل"><i class="fas fa-retweet"></i></a>
                                                       @endif
                                                   @endif
                                                   <a  title="delete" onclick="return false;" object_id="{{ $product->id }}" delete_url="/products/delete/"
                                                      class="edit-btn-table remove-alert-website" href="#">
                                                       <i class="fa fa-times"></i> </a>

                                               </div>

                                           </div>
                                       </div>
                                       <!--end product-grid-->
                                   </div>
                                   <!--end item-->
                               @endforeach

                        @if($count>12)
                            <div class="text-center col-12 margin-div">
                                <a   href="#" class="custom-btn big-btn" id="loadmore-profile">المزيد</a>
                            </div>
                            @endif
                           @else
                               <h4 class='empty-div-messages text-center'>لا يوجد منتجات</h4>


@endif
                           <div class="render"  style="display: none">



                           </div>

                    </div>
                </div>


            </div>
        </div>




        </div>
        <!--end products-->

    </section>
    <!--end profile-pg-->

    @endsection
@section('scripts')
<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5e9e29a0e3a49d0012075ee9&product=image-share-buttons&cms=website' async='async'></script>
    <script>
        //upload append div

        $(function () {
            $(".load-div").slice(0, 12).fadeTo("slow", 1);

            $("#loadmore-profile").on('click', function (e) {
                e.preventDefault();
                $(".load-div:hidden").slice(0, 12).slideDown("fast");

                if ($(".load-div:hidden").length == 0) {
                    $("#loadmore-profile").fadeOut('fast');
                } else {
                    $("#loadmore-profile").fadeIn('fast');

                }
                $('html,body').animate({
                    scrollTop: $(this).offset().top - 600
                }, 1500);
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    imgId = '#preview-' + $(input).attr('id');
                    $(imgId).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }

        }


        $(document).on('change', '.profile-image-upload input', function() {
            readURL(this);
            $(this).next("label").css("background-image", "none");

        });




        //load div





        $(document).ready(function () {
         var a;
            $('#main-01').change(function () {

                sendFile(new FormData($('#file')[0]));

            });
            $('#main-02').change(function () {
                sendFile(new FormData($('#file')[0]));
            });

            function sendFile(file) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }});
                $.ajax({
                    type: 'post',
                    url: '/edit-profile',
                    data:file,

                    success: function (data) {

                    },
                    processData: false,
                    contentType: false
                });
            }
        });





    </script>




    @endsection
