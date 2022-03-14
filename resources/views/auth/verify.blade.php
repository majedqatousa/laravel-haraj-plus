@extends('website.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center margin-div">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">تفعيل الحساب الخاص بك من خلال رقم الجوال</div>
                <div class="card-body text-center">
                  
                      
                        <div class="row phone-div">

                            <div class="wrong-otp">

                            </div>

                            <div class="form-group col-md-7 text-center">
 <div class="wrong-otp m-t-10" style="display: none;color:red;">
                            رمز التفعيل خاطئ    
                            </div>
                                <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="رقم الجوال " value="{{$phone}}" disabled>
                                <label class="phone_number" for="phone_number">
                                    <img src="{{asset('website/images/main/saudi-arabia.png')}}">
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
                            <div class="col-md-3">
                                <div class="form-group row mb-0">
                                    <div class="col-12 text-center">
                                        <button class="btn btn-primary sendOTP">
                                            إرسال الرمز
                                        </button>
                                    </div>

                                </div>
                            </div>



                        </div>
                        <div id="recaptcha-container" style="margin-top: 10px"></div>

                        <div class="otp-div" style="display: none">
                        <div class="verfication-style ">
                            <input type="hidden" name="token" id="code" style="display: none" value="{{$token}}">
                            <input type="hidden" name="user" id="user_id" style="display: none" value="{{$id}}">
                            <input type="text" name="verify_otp" maxlength="6" minlength="6" />
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-12 text-center">
                                <button id="verifyOTP" class="btn btn-primary" id="activate">
                                    تفعيل
                                </button>
                            </div>
                        </div>
                        </div>
   
                        <br><br>

                

                    <!-- <button type="submit" href="{{url("/resend")}}" user-id="{{ $id }}" class="custom-btn" id="resend" style="display:none">إعادة ارسال كود التحقيق</button> -->

                    <br><br>
                    <h4 class="ch-ver">إنتظر قليلاً لوصول كود التحقق</h4>


                </div>
            </div>
        </div>
    </div>
</div>



@endsection


@include('website.layouts.footer')
@section('scripts')

<script>
    $(document).ready(function() {
        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
            'size': 'normal',
            'callback': (response) => {
                // reCAPTCHA solved, allow signInWithPhoneNumber.
                // ...
            },
            'expired-callback': () => {
                // Response expired. Ask user to solve reCAPTCHA again.
                // ...
            }
        });
        $(".sendOTP").click(function() {
            console.log("Firebase started.");

            const phoneNumber = $("[name=phone_number]").val();
            const appVerifier = window.recaptchaVerifier;
            firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
                .then((confirmationResult) => {
                    console.log(confirmationResult);

                    // SMS sent. Prompt user to type the code from the message, then sign the
                    // user in with confirmationResult.confirm(code).
                    window.confirmationResult = confirmationResult;
                    $(".phone-div").attr('style', 'display: none !important');
                    $("#recaptcha-container").attr('style', 'display: none !important');
                    $(".otp-div").attr('style', 'display: block !important');
                    $("#verifyOTP").attr('style', 'display: block !important');
                    // now show otp field

                    $(".otp-div").attr('style', 'display: block !important');
                    // ...
                }).catch((error) => {
                    // Error; SMS not sent
                    alert(error.message + " phone : " + phoneNumber);
                    // ...
                });


        });

        $("#verifyOTP").click(function() {
            console.log('test');
            const phoneNumber = $("[name=phone_number]").val();
            const code = $("[name=verify_otp]").val();

            confirmationResult.confirm(code).then((result) => {
                // User signed in successfully.
                const user = result.user;

                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            $.ajax({
                url: '{{ route('verify') }}',
                type: "GET",
                dataType: 'json',
                data: {
                    phone: $('[name=phone_number]').val(), user:$('[name=user]').val()
                },
                success: function(data) {
                    // alert(data.success + " sad " + data.phone);
                    if(data['success'] ==1){
                        setTimeout(function(){ 
                            window.location.reload();
                            window.location.href = "/";
                        });
                    }else{
                        console.log("no user for this phone number ");
                        window.location.reload();
                     
                    }
                    
                },
                error: function(data){
                    // alert(data.error + " sad " + data.phone);
                    var errors = data.responseJSON;
                console.log(errors);
                }
               
            });

                // ...
            }).catch((error) => {
                // User couldn't sign in (bad verification code?)
                // ...
                // console.log("Erorr v nott valid")
              
              alert("رمز التفعيل خاطئ");

                
                console.log(error.message)
            });


        })

        
        setTimeout(function() {
            $('#resend').show()
        }, 60000);

        $('#resend').click(function(e) {
            e.preventDefault();
            var user = $(this).attr('user-id');
            var url = $(this).attr('href');
            $.ajax({
                url: $(this).attr('href'),
                type: 'get',
                dataType: "json",
                data: {
                    'id': user
                },
                success: function(data) {
                    $('#resend').hide();
                }
            });

        });
    });
</script>
@endsection