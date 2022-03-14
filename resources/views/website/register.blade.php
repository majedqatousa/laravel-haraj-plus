@extends('website.layouts.app')

@section('content')



<section class="register-section">
   <div class="add-advertisment-pg margin-div">
    <div class="container">
        <div class="row">
            <div class="col-12 row  main-adv-block wow fadeInUp">
                <div class="col-12 text-center">
                    <h1 class="page-title">حساب جديد</h1>
                </div>
                 <div class="register-content col-12">
                    <div class="login-div">
                        <!--<div class="login-shape-shadow"></div>-->
                        <!--<div class="login-shape text-center">-->
                            <!--<div class="inner-login-shape">-->
                            <!--    <img src="{{asset('website/images/main/logo3.png')}}" alt="logo" />-->
                            <!--    <div class="form-group  login-text">-->
                            <!--        <span class="login-text-link"> لديك حساب؟</span>-->
                            <!--        <a  href="#" data-toggle="modal" data-target="#login-modal"-->
                            <!--           class="login-text-link login-modal-open">تسجيل دخول </a>-->
                            <!--    </div>-->
                            <!--</div>-->
                        <!--</div>-->


                        <div class="login-form">
                            <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
                            <!--    <span aria-hidden="true">&times;</span>-->
                            <!--</button>-->
                            <div class="inner-login-form">
                                <h2>أهلا وسهلا بك في  حراج بلص</h2>
                                <p>
                                يمكنكم تسجيل الدخول باسم المستخدم وكلمة المرور الخاصة بكم أو الدخول فورا عن طريق أحد مواقع التواصل الاجتماعية التالية
                                </p>

                                <form id="register" class="needs-validation" method="post" action="{{route('register')}}" novalidate>
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" class="form-control"  value="{{old('name')}}" name="name"placeholder="إسم المستخدم "
                                               required>
                                        <div class="invalid-feedback">
                                            من فضلك أدخل إسم صحيح
                                        </div>

                                        @if($errors->has('name'))
                                            <div class="invalid-feedback" style="display: block">
                                               {{$errors->first('name')}}
                                            </div>
                                            @endif

                                    </div>


                                    <div class="form-group">
                                        <input type="email" class="form-control"  name="email" value="{{old('email')}}" placeholder="البريد الإلكتروني"
                                               required>
                                        <div class="invalid-feedback">
                                            من فضلك أدخل بريد إلكتروني صحيح
                                        </div>

                                        @if($errors->has('email'))
                                            <div class="invalid-feedback" style="display: block">
                                                {{$errors->first('email')}}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                
                                        <input type="tel" class="form-control" id="phone_number"   name="phone" placeholder="رقم الجوال "
                                               minlength="10" maxlength="14"  value="{{old('phone')}}"required>
                                    <label class="phone_number" for="phone_number">
                                        +966 <img src="{{asset('website/images/main/saudi-arabia.png')}}">
                                    </label>
                                        <div class="invalid-feedback">
                                            من فضلك أدخل رقم جوال صحيح
                                        </div>


                                        @if($errors->has('phone'))
                                            <div class="invalid-feedback" style="display: block">
                                                {{$errors->first('phone')}}
                                            </div>
                                        @endif
                                    </div>


                                    <div class="form-group">

                                        <select class="form-control" id="country22" value="1" onchange="showCities(this)" style="display: none" required>
                                            <option style="display: none" selected disabled> الدوله</option>
                                          {{-- @foreach($countries as $key=>$value)
                                                <option   value="{{$key}}">{{$value}} </option>
                                            @endforeach--}}
                                        </select>
                                        <div class="invalid-feedback">
                                            من فضلك إختر دولة صحيحة
                                        </div>
                                    </div>

                                    <div class="form-group  ">

                                        <select class="form-control"  id="citysel22" name="city_id"required>
                                            <option value="{{old('city_id')}}"  selected disabled>
                                               المدينه
                                            </option>
                                             @foreach($cities as $city)
                                                  <option  value="{{$city->id}}" >{{$city->name}} </option>
                                                  @endforeach
                                        </select>

                                        <div class="invalid-feedback">
                                            من فضلك إختر مدينه صحيحة
                                        </div>

                                        @if($errors->has('city_id'))
                                            <div class="invalid-feedback" style="display: block">
                                                {{$errors->first('city_id')}}
                                            </div>
                                        @endif



                                    </div>


                                    <!--<div class="form-group">-->
                                    <!--    <input type="text" class="form-control" name="address" placeholder="العنوان" required>-->
                                    <!--    <div class="invalid-feedback">-->
                                    <!--        من فضلك أدخل عنوان صحيح-->
                                    <!--    </div>-->

                                    <!--    @if($errors->has('address'))-->
                                    <!--        <div class="invalid-feedback" style="display: block">-->
                                    <!--            {{$errors->first('address')}}-->
                                    <!--        </div>-->
                                    <!--    @endif-->
                                    <!--</div>-->

                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" placeholder="كلمة المرور"
                                               required>
                                        <div class="invalid-feedback">
                                            من فضلك أدخل كلمة مرور صحيحة
                                        </div>

                                        @if($errors->has('password'))
                                            <div class="invalid-feedback" style="display: block">
                                                {{$errors->first('password')}}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password-confirm" placeholder="تأكيد كلمة المرور"
                                               required>
                                        <div class="invalid-feedback">
                                            من فضلك قم بتأكيد كلمة المرور
                                        </div>

                                        @if($errors->has('password-confirm'))
                                            <div class="invalid-feedback" style="display: block">
                                                {{$errors->first('password-confirm')}}
                                            </div>
                                        @endif
                                    </div>



                                    <div class="form-group">
                                        <button type="submit" id="send" class="custom-btn big-btn">تسجيل </button>
                                    </div>

                                    <!-- social regiseration -->
                                    <!-- <div class="form-group social-register">
                                        <p>أو يمكنك التسجيل من خلال</p>
                                        <div id="firebaseui-auth-container3"></div>
                                        <div id="loader3">Loading...</div>
     
                                    </div> -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>




@endsection
@include('website.layouts.footer')
@section('scripts')
<script>
    $("#send").click(function(event){
     event.stopPropagation();
    var yas = $('#phone_number').val(); 
    yas = yas.replace(/[٠١٢٣٤٥٦٧٨٩]/g, function (d) { return d.charCodeAt(0) - 1632; })
        .replace(/[۰۱۲۳۴۵۶۷۸۹]/g, function (d) { return d.charCodeAt(0) - 1776; });
    $('#phone_number').val(yas);
    
});
    </script>

@endsection

