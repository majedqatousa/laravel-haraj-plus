@extends('website.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center margin-div">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ضع كود التفعيل المكون من اربع خانات الذي تم ارساله الى جوالك برسالة نصية </div>
                <div class="card-body text-center">


                <div class="p-t-31 p-b-9 cstm-div phone-div">
						<span class="txt1">
							Phone Number <span style="font-size: 10px;">(include country code eg:+91)</span>
						</span>
					</div>
					<div class="wrap-input100 validate-input phone-div" data-validate = "Username is required">
						<input class="input100" type="text" name="phone_number" >
						<span class="focus-input100"></span>
					</div>
                    <div id="recaptcha-container" style="margin-top: 10px"></div>
                    <div class="p-t-31 p-b-9 cstm-div otp-div" >
						<span class="txt1">
							OTP  
						</span>
					</div>
					<div class="wrap-input100 validate-input otp-div" data-validate = "Username is required">
						<input class="input100"  type="text" name="verify_otp" >
						<span class="focus-input100"></span>
					</div>
					
					<div class="container-login100-form-btn m-t-17 phone-div">
						<button class="login100-form-btn sendOTP">
							Send OTP
						</button>
					</div>

					<div class="container-login100-form-btn m-t-17 otp-div">
						<button type="button" id="verifyOTP" class="login100-form-btn">
							Verify OPT
						</button>
					</div>
                    <div class="form-group row mb-0">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary" id="activate">
                                تفعيل
                            </button>
                        </div>
                       
                    </div>
                    <br><br>




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
    
 // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional

  $(document).ready(function(){

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
                // SMS sent. Prompt user to type the code from the message, then sign the
                // user in with confirmationResult.confirm(code).
                window.confirmationResult = confirmationResult;
                $(".phone-div").attr('style', 'display: none !important');
                $("#recaptcha-container").attr('style', 'display: none !important');
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
     
     const code = $("[name=verify_otp]").val();
     confirmationResult.confirm(code).then((result) => {
         // User signed in successfully.
         const user = result.user;
         alert("Verified successfully");
         // ...
     }).catch((error) => {
         // User couldn't sign in (bad verification code?)
         // ...
         console.log(error.message)
     });


 })
  });
  console.log("Firebase started.");

  // Facebook
  

   

    // now verify otp
  
</script>
@endsection