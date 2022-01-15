@extends('website.layouts.app')
@section('pop')

<div class="loader" id="loader">
<div class="auto-center"></div><!--
--><div class="bounce-conteneur">
<div class="bounce bounce-left"></div>
<div class="bounce bounce-center"></div>
<div class="bounce bounce-right"></div>
</div>
</div>
    <!--start preview-model -->
    <div class="modal fade login-modal-style white-bg" id="preview-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <!-- Modal body -->
                <div class="modal-body">
                    <form class="needs-validation row no-marg-row gray-form"  novalidate>
                        <div class="form-group text-center  col-12">
                            <h2 class="page-title"> عرض الإعلان</h2>
                        </div>
                        <div class="form-group  col-12">
                            <div class="generate-form2 row no-marg-row">
                                <div class="form-group col-12 text-center adv-img-preview">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>اسم المنتج<span class="starrisk">*</span></label>
                                <input type="text" name="" id="name2" class="form-control"
                                       disabled />
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>القسم الرئيسي <span class="starrisk">*</span></label>

                                <input type="text" name=""  id="category2" class="form-control" disabled />


                            </div>

                        </div>


                        <div class="col-md-12">
                            <div class="form-group">
                                <label>القسم الفرعي <span class="starrisk">*</span></label>
                                <input type="text" name="" id="sub-category" class="form-control"  disabled />


                            </div>
                        </div>

                       

                        <div class="col-md-12">
                            <div class="form-group">
                                <label> المدينة <span class="starrisk">*</span></label>
                                <input type="text" name="" class="form-control" id="city2"  disabled />


                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>سعر المنتج<span class="starrisk">*</span></label>
                                <input type="number" id="price2" class="form-control" min="1"
                                       disabled />
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>حالة المنتج <span class="starrisk">*</span></label>
                                <input type="text" name=""  id="status2" class="form-control"  disabled />


                            </div>
                        </div>

                        <div class="col-md-12" style="overflow: hidden">
                            <div class="form-group" style="overflow: hidden">
                                <label> فيديو إعلاني</label>
                                <div id="video_url2"></div>
{{--                                <input type="text" name="" id="video_url2" class="form-control" disabled>--}}
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label> وصف المنتج<span class="starrisk">*</span></label>
                                <div class="form-control height_auto" id="description2"></div>
                            </div>

                        </div>

                    </form>
                </div>


            </div>
        </div>
    </div>
    <!-- end preview-model -->



@endsection
@section('content')

    <!--start page-order-div
          ================-->
    <section class="order-div page-order-div">
        <div class="add-advertisment-pg margin-div">
            <div class="container">
                <div class="row">
                    <div class="col-12 row  main-adv-block wow fadeInUp">
                        <div class="col-12 text-center">
                            <h1 class="page-title">إضافة إعلان</h1>
                        </div>
                        <form class="needs-validation row no-marg-row gray-form"  method="post" enctype="multipart/form-data" action="{{route("store")}}" novalidate id="product-form">
                            @csrf
                            <div class="form-group  col-12">
                                <div class="generate-form row no-marg-row">
                                    <div class="col-12">
                                        <span class="add-photo" id="generate-img-form-link"><i
                                                    class="fa fa-plus"></i>أخرى</span>
                                    </div>

                                    <div class=" col-xl-2 col-md-4 col-sm-6  secondary-img-upload">
                                        <div class="form-group secondary-img-upload">
                                            <input type="file" class="img-form-shape file-input form-control" value=""
                                                   id="main-01"  name="main_image" required>

                                            <label class="file-input-label" for="main-01">الصورة الأساسية</label>

                                            <div class="invalid-feedback">
                                                أدخل صورة المنتح الرئيسية
                                            </div>

                                            @if ($errors->has('main_image'))
                                                <div style="display:block;" class="invalid-feedback">{{ $errors->first('main_image') }}</div>
                                            @endif
                                            <div class="img_contain">
                                                <img id="preview-main-01" /></div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>اسم المنتج<span class="starrisk">*</span></label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="اسم المنتج" value="{{old('name')}}" required>
                                    <div class="invalid-feedback">من فضلك أدخل اسم المنتج</div>

                                    @if ($errors->has('name'))
                                        <div style="display:block;" class="invalid-feedback">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">

                                    <label>القسم الرئيسي <span class="starrisk">*</span></label>
                                    <select class="form-control"  id="category" onchange="showSubCategories(this)"  required>

                                        <option value="" selected disabled>القسم</option>
                                        @foreach($categories as $key=>$value)
                                            @if(\App\Models\Category::find($key)->subCategories()->count())
                                            <option value="{{$key}}"  >{{$value}}</option>
                                            @endif
                                        @endforeach


                                    </select>
                                    <div class="invalid-feedback">
                                        من فضلك إختر قسم
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>القسم الفرعي <span class="starrisk">*</span></label>
                                    <select class="form-control" value="{{old('category_id')}}" name="category_id" id="catstyle" >

                                    </select>
                                    <div class="invalid-feedback">
                                        من فضلك إختر قسم
                                    </div>
                                    @if ($errors->has('category_id'))
                                        <div style="display:block;" class="invalid-feedback">{{ $errors->first('category_id') }}</div>
                                    @endif
                                </div>
                            </div>


                            {{-- <div class=" col-md-4">
                              <div class="form-group">
                                       <label>الدولة <span class="starrisk">*</span></label>
                                 <select class="form-control"  id="country1" onchange="showCities2(this)"  required>

                                     @foreach($countries as $key=>$value)
                                         <option   value="{{$key}}">{{$value}} </option>
                                     @endforeach
                                 </select>
                                 <div class="invalid-feedback">
                                     من فضلك إختر المدينة
                                 </div>
                             </div>
                             </div>--}}
                            <input type="hidden" id="counter">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>المدينة <span class="starrisk">*</span></label>
                                    <select class="form-control"  id="citysel2" name="city_id" value="{{old('city_id')}}"required>
                                        <option selected disabled>
                                            المدينة
                                        </option>
                                        @foreach($cities as $key=>$value)
                                            <option  value="{{$key}}" >{{$value}} </option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">
                                        من فضلك إختر المدينة
                                    </div>
                                    @if ($errors->has('city_id'))
                                        <div style="display:block;" class="invalid-feedback">{{ $errors->first('city_id') }}</div>
                                    @endif
                                </div>


                            </div>



                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>سعر المنتج<span class="starrisk">*</span></label>
                                    <input type="number" value="{{old('price')}}" name="price" id="price1" class="form-control" min="1" placeholder="سعر المنتج"
                                           required />
                                    <div class="invalid-feedback">من فضلك أدخل السعر </div>
                                    @if ($errors->has('price'))
                                        <div style="display:block;" class="invalid-feedback">{{ $errors->first('price') }}</div>
                                    @endif
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>نسبة الخصم </label>
                                    <input type="number" value="{{old('discount_ratio')}}" name="discount_ratio" class="form-control" min="1" max="100" placeholder="نسبة الخصم">
                                    <div class="invalid-feedback">

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>حالة المنتج <span class="starrisk">*</span></label>
                                    <select class="form-control" value="{{old('status')}}" id="status" name="status"required>
                                        <option value="" selected disabled>حالة المنتج</option>
                                        <option value="1">جديد</option>
                                        <option value="2">مستعمل </option>
                                    </select>
                                    <div class="invalid-feedback">
                                        من فضلك إختر حالة المنتج
                                    </div>
                                    @if ($errors->has('status'))
                                        <div style="display:block;" class="invalid-feedback">{{ $errors->first('status') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label> فيديو إعلاني</label>
                                    <input type="url" value="{{old('video_url')}}" id="video_url" name="video" class="form-control" placeholder="أضف رابط الفيديو من اليوتيوب">
                                    <div class="invalid-feedback">
                                        من فضلك ادخل رابط صحيح
                                    </div>
                                    @if ($errors->has('video_url'))
                                    <div style="display:block;" class="invalid-feedback">{{ $errors->first('video_url') }}</div>
                                @endif
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label> وصف المنتج<span class="starrisk">*</span></label>
                                    <textarea class="form-control"  id="description"  name="description" placeholder="وصف المنتج" required>{{old('description')}}</textarea>
                                    <div class="invalid-feedback">من فضلك أدخل نص صحيح</div>
                                    @if ($errors->has('description'))
                                        <div style="display:block;" class="invalid-feedback">{{ $errors->first('description') }}</div>
                                    @endif
                                </div>

                            </div>

                            <div class="col-12">
                                <div class="check-form-div">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"  name="is_checked" class="form-check-input custom-control-input"
                                               id="invalidCheck" value="1" required>
                                        <label class="condition-label form-check-label custom-control-label"
                                               for="invalidCheck">الموافقة على
                                            <a  href="{{route('terms')}}" target="_blank">شروط وأحكام
                                                الموقع</a></label>
                                        <div class="invalid-feedback">
                                            يجب عليك قبول الشروط والاحكام
                                        </div>
                                        @if ($errors->has('is_checked'))
                                            <div style="display:block;" class="invalid-feedback">{{ $errors->first('is_checked') }}</div>
                                        @endif


                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <span class="note">* بنشرك للإعلان، أنت توافق على شروط الاستخدام و قواعد النشر</span>

                            </div>


                            <div class="col-12 text-left-dir">
                                <div class="form-group">
                                    <button type="button" data-toggle="modal" data-target="#preview-modal"
                                            id="ad" onclick="change()"
                                            class="custom-btn sm-btn">شاهد الإعلان قبل نشره</button>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="custom-btn big-btn">إضافة</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--end page-order-div-->
@endsection


@section("scripts")

 
    <script>
        
        $(window).on("load",function(){
        $("#loader").hide(100)
        });
    </script>
    

    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    
    <script>
        CKEDITOR.replace( 'description' );

    </script>
    <script>
        //upload append div


        $(function () {
            var count = 0;
            var count2 = 0;
            var count3 = 0;
            var remaining = 6;

  function UpdateRemaining(isAdd) {
      if (isAdd) {
          remaining = remaining - 1;
      } else {
          remaining = remaining + 1;
      }


  }

            $('#generate-img-form-link').click(function () {

      if (remaining == 0) {
            $('#generate-img-form-link').addClass("active");
              Swal.fire({
                type: 'warning',
                title: 'الحد الأقصي لصور المنتج هو سبع صور فقط',
                showConfirmButton: false,
                timer: 2000
            });


       }else {
                    var newDiv = $(
                    ' <div class="col-xl-2 col-md-4 col-sm-6"><div class="form-group img-append-div"><input type="file" class="img-form-shape file-input" id="test-' +
                    (
                        count++) + '"  name="image[]"><label class="file-input-label" for="test-' +
                    (
                        count2++) +
                    '"><i class="fa fa-plus"></i></label><div class="img_contain"> <img id="preview-test-' +
                    (count3++) +
                    '"/></div></div>'
                );

                $(newDiv).appendTo('.generate-form');
                var newDiv2 = $(
                    '<span class="remove-img auto-icon"><i class="fa fa-trash"></i></span>'
                );
                $(".generate-form input[type='file']").each(function () {
                    var mainimg = $(this).parent(".form-group").append(newDiv2);
                });
                      UpdateRemaining(true);
}

            });


            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        imgId = '#preview-' + $(input).attr('id');

                        $(imgId).attr('src', e.target.result);

                        // var picture = '<img src="' + e.target.result + '" class="pro-append" >'
                        // $(".adv-img-preview").empty().append(picture);
                    }

                    reader.readAsDataURL(input.files[0]);
                }

            }


            $(document).on('change', '.generate-form input[type="file"]', function () {
                readURL(this);
                var count=0;


                $(this).next("label").text("").css("background", "transparent");

            });

        $(document).on('click', '.remove-img', function () {
            $(this).closest(".img-append-div").parent().remove();
                  UpdateRemaining(false);

        });

        });







        function change(){

            var summer1 = CKEDITOR.instances.description.getData();
            $('#description2').html(summer1);
            $('#price2').val($('#price1').val());
            $('#name2').val($('#name').val());
            $('#video_url2').html($('#video_url').val());
            $('#status2').val($('#status option:selected').html());
            $('#city2').val($('#citysel2 option:selected').html());
            $('#sub-category').val($('#catstyle option:selected').html());
            $('#category2').val($('#category option:selected').html());
              var a =  $('.generate-form .img_contain img').clone();
             var e = $('.adv-img-preview').html(a);
                $('.adv-img-preview img').removeAttr('id');
                $('.adv-img-preview img').each(function () {
                if (this.src.length > 0) {
                }else{
                   $(this).remove();
                }
});



        }
    </script>
   
    <script>
    $( "form" ).on( "submit", function( event ) {
        event.preventDefault();
          $("#loader").show(1000);
          
            var summer2 = CKEDITOR.instances.description.getData(); //.replace(/<\/?[^>]+(>|$)/g, "");
            $('#description').val(summer2);
            if((($('#name').val()).includes('/'))){
                var str = $('#name').val();
               $('#name').val(str.replace('/','%'));
            }
          var formData = new FormData(this);
       
                $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(data) {
                      $("#loader").hide(100);
                    location.replace(`{{env("MAIN_URL")}}/profile-products`);
                },
                error: function(data) {
                     $("#loader").hide(100);
                     console.log("Error !! ");
                }
                });
    });
    </script>
    
    

@endsection
