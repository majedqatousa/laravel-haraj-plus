@extends('website.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center margin-div">
        <div class="col-md-8 text-center">
            <div class="card">
                <div class="card-header">ضع كود التفعيل المكون من 6 خانات الذي تم ارساله الى جوالك برسالة نصية </div>

                <div class="card-body text-center">




                    <div class="row phone-div">
                  
                      
                   
                        <div class="form-group col-md-7 text-center">
                      
                            <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="رقم الجوال " minlength="10" maxlength="14" value="{{old('phone')}}" required>
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
                    <div class="row">
                    <div class="form-group col-md-4 text-center">
                        <input type="hidden" class="form-control" value="{{ route('verify2') }}" id="action">
                        <div class="wrap-input100 validate-input otp-div" style="display: none;"  data-validate="Username is required">
                           
                            <input class="form-control" placeholder=" رمز التفعيل " minlength="6" maxlength="6" type="text" name="verify_otp" >
                            <span class="focus-input100"></span>
                           
                          
                        </div>
                    </div>
                        <div class="col-md-3">
                            <div class="form-group row mb-0">
                                <div class="col-12 text-center" >
                                    <button class="btn btn-primary" id="verifyOTP" style="display: none;" >
                                    تأكيد الرمز
                                    </button>
                                </div>

                            </div>
                        </div>
                      
                    </div>
                  







                    <br><br>




                    <br><br>
                    <!-- <h4 class="ch-ver">إنتظر قليلاً لوصول كود التحقق</h4> -->


                </div>

            </div>
        </div>
    </div>
</div>



@endsection


@include('website.layouts.footer')
@section('scripts')

<script>
    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional

    $(document).ready(function() {
        $(".otp-div").attr('style', 'display: none !important');
        $("#verifyOTP").attr('style', 'display: none !important');

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

            if (isNaN(phoneNumber)) {
                alert("الرجاء إدخال رقم هاتف صحيح");
                return
            }
            if (phoneNumber.length === 0) {
                alert("الرجاء إدخال رقم هاتف صحيح");
                return
            }
            if (phoneNumber.length !== 10) {
                alert("يجب ان يتكون رقم الهاتف من 10 خانات");
                return
            }


            const appVerifier = window.recaptchaVerifier;
            firebase.auth().signInWithPhoneNumber('+966' + phoneNumber, appVerifier)
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
            var action = $('#action').val();

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
                url: '{{ route('verify2') }}',
                type: "GET",
                dataType: 'json',
                data: {
                    phone: $('[name=phone_number]').val()
                },
                success: function(data) {
                    // alert(data.success + " sad " + data.phone);
                    if(data['success'] ==1){
                        setTimeout(function(){ 
                            // window.location.reload();
                            window.location.href = "tech";
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
                console.log("Erorr v nott valid")
                alert("رمز التفعيل خاطئ");
                console.log(error.message)
            });


        })
    });
</script>
@endsection