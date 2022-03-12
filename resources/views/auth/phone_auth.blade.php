@extends('website.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center margin-div">
        <div class="col-md-8 text-center">
            <div class="card">
                <div class="card-header">ضع كود التفعيل المكون من اربع خانات الذي تم ارساله الى جوالك برسالة نصية </div>
                <form>
                    <div class="card-body text-center">




                        <div class="row">
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
                                    <button  class="btn btn-primary sendOTP" id="activate">
                                        إرسال الرمز
                                    </button>
                                </div>

                            </div>
                        </div>

                        </div>



                        <div id="recaptcha-container" style="margin-top: 10px"></div>
                        <div class="p-t-31 p-b-9 cstm-div otp-div">
                            <span class="txt1">
                                OTP
                            </span>
                        </div>
                        <div class="wrap-input100 validate-input otp-div" data-validate="Username is required">
                            <input class="input100" type="text" name="verify_otp">
                            <span class="focus-input100"></span>
                        </div>
                        <input type="hidden" class="form-control" value="{{ route('verify2') }}" id="action">
                    

                        <div class="container-login100-form-btn m-t-17 otp-div">
                            <button type="button" id="verifyOTP" class="login100-form-btn" data-href="{{URL::to('verify2')}}">
                                Verify OPT
                            </button>
                        </div>

                        <br><br>




                        <br><br>
                        <h4 class="ch-ver">إنتظر قليلاً لوصول كود التحقق</h4>


                    </div>
                </form>
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
                alert("Please enter valid phone number");
                return
            }
           

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
                    alert(error.message);
                    // ...
                });


        });
        $("#verifyOTP").click(function() {
            var action = $('#action').val();

            const phoneNumber = $("[name=phone_number]").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            $.ajax({
                url: action,
                type: "GET",
                dataType: 'json',
                data: {
                    phone: $('[name=phone_number]').val()
                },
                success: function(data) {
                    alert(dara.success);
                },
                error: function(data) {
                    alert("error " + data.error);
                }
            });

            const code = $("[name=verify_otp]").val();

            //  confirmationResult.confirm(code).then((result) => {
            //      // User signed in successfully.
            //      const user = result.user;
            //      alert("Verified successfully " + " "+ phoneNumber);

            //      // ...
            //  }).catch((error) => {
            //      // User couldn't sign in (bad verification code?)
            //      // ...
            //      console.log("Erorr v nott valid")

            //      console.log(error.message)
            //  });


        })
    });
</script>
@endsection