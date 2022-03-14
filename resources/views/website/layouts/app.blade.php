<!DOCTYPE html>
<html style="overflow-x: hidden;">
    <head  prefix="og: http://ogp.me/ns#">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
       <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NDX55L4');</script>
<!-- End Google Tag Manager -->
    <title>حراج بلص|@yield('seoTitle')</title>
    <meta name="description" content="@yield('seoDescription')" />
    <meta name="keywords" content="@yield('seoKeywords')" />
    <meta name="image" content="@yield('seoGoogleImg')" />
        
 @yield('meta')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#2b3e4f">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#2b3e4f">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#2b3e4f">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="google-site-verification" content="1GiZtNJV564l92PUg0SaLwgI9NuHTDoDaHx7z6LwG30" />
    <link rel="shortcut icon" href="{{asset('website/images/main/favicon.ico')}}" />



    <!-- Style sheet
         ================ -->
    <link rel="stylesheet" href="{{asset('website/css/bootstrap-rtl.min.css')}}" type="text/css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="{{asset('website/css/animate.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('website/css/jssor.css')}}" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.css"
          type="text/css" />
   {{-- <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"></script>--}}


    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="{{asset('website/css/owl.carousel.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('website/css/owl.theme.default.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('website/css/price.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('website/css/emoji.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('website/css/general.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('website/css/header.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('website/css/footer.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('website/css/keyframes.css')}}" type="text/css" />

    <link rel="stylesheet" href="{{asset('website/css/style.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('website/css/responsive.css')}}" type="text/css" />

    
</head>

<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDX55L4"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<!--start popup-->
<input type="hidden" id="auth"  value="{{auth()->id()}}">


<div class="popup">
    <!--start login-model -->


    <div class="modal fade login-modal-style" id="login-modal">
        <div class="modal-dialog modal-dialog-centered">

            <!-- Modal body -->
            <div class="modal-body">
                <div class="modal-content">

                    <div class="login-div">
                        <div class="login-shape-shadow"></div>

                        <div class="login-shape text-center">
                            <div class="inner-login-shape">
                                <img src="{{asset('website/images/main/logo2.png')}}" alt="logo" />
                                <div class="form-group  login-text">
                                    <span class="login-text-link">ليس لديك حساب؟</span>
                                    <a href="{{route('signUp')}}" 
                                       class="login-text-link register-modal-open">حساب جديد</a>
                                </div>
                            </div>
                        </div>


                        <div class="login-form">
                            <button type="button"  class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="inner-login-form">
                                <h2>أهلا وسهلا بك في  حراج بلص</h2>
                                <p>
                                    يمكنكم تسجيل الدخول باسم المستخدم وكلمة المرور الخاصة بكم أو الدخول فورا عن طريق أحد مواقع التواصل الاجتماعية التالية
                                </p>

                                <form class="needs-validation" id="loginForm" method="post" action="{{route('user.login')}}" novalidate>
                                    @csrf
                                    <div class="form-group">

                                        <div  id="success"  style="display:none" >

                                        </div>
                                        <label>البريد الإلكتروني</label>
                                        <input type="text" class="form-control"  name="email"required />

                                        <div  id="error" class="invalid-feedback">

                                        </div>


                                    </div>

                                    <div class="form-group">
                                        <label>كلمة المرور</label>
                                        <input type="password" class="form-control" name="password" required />
                                        <div class="invalid-feedback">
                                            من فضلك أدخل كلمة مرور صحيحة
                                        </div>

                                        @if($errors->has('password'))
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $errors->first('password') }}
                                            </div>
                                        @endif
                                    </div>



                                    <!--remmember-->
                                    <div class="check-form-div">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember"  class="form-check-input custom-control-input" id="remmember-pass">
                                        <label class="condition-label form-check-label custom-control-label" for="remmember-pass">تذكرني
                                           </label>

                                        </div>
                                    </div>

                           
                                    <div class="form-group">
                                        <a href="{{route('email')}}" 
                                           class="forget-password">هل نسيت كلمة
                                            المرور؟</a>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit"  id="login_submit"  class="custom-btn big-btn">تسجيل الدخول</button>
                                    </div>

                                    <!-- social regiseration -->
                                    <div class="form-group social-register">
                                        <p>أو يمكنك التسجيل من خلال</p>
                                        <button id="phoneAuth" class="custom-btn" data-href="{{route('user.phoneAuth')}}">رقم الهاتف</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
    <!-- end login-model -->



    <!--start register-model -->
    <div class="modal fade login-modal-style" id="register-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="login-div">
                        <div class="login-shape-shadow"></div>
                        <div class="login-shape text-center">
                            <div class="inner-login-shape">
                                <img src="{{asset('website/images/main/logo2.png')}}" alt="logo" />
                                <div class="form-group  login-text">
                                    <span class="login-text-link"> لديك حساب؟</span>
                                    <a href="#" data-toggle="modal" data-target="#login-modal" 
                                       class="login-text-link login-modal-open">تسجيل دخول </a>
                                </div>
                            </div>
                        </div>


                        <div class="login-form">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="inner-login-form">
                                <h2>أهلا وسهلا بك في سوق حراج بلص</h2>
                                <p>
                                يمكنكم تسجيل الدخول باسم المستخدم وكلمة المرور الخاصة بكم أو الدخول فورا عن طريق أحد مواقع التواصل الاجتماعية التالية
                                </p>


                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
    <!-- end register-model -->

@yield('pop')


</div>
<!--end popup-->


<!-- start header
     ================ -->
@include('website.layouts.header')
<!--end header-->


<!-- start top-logo
     ================ -->
<section class="top-logo  wow fadeIn">
    <div class="container">
        <div class="row">
            <!--start div-->
            <div class="col-lg-4  col-md-4 col-7  logo-grid">
                <div class="logo-div">
                    <a href="{{route('home')}}">
                        <img src="{{asset('/storage/' . $logoHeader)}}" alt="logo" />
                    </a>
                </div>
            </div>
            <!--end div-->

            <!--start div-->
            <div class="col-5 resonsive-icons-grid text-left-dir">
                <a href="{{route('favourite')}}" ><i class="fa fa-heart"></i></a>
                <!--before login-only-->
                @if(!\Auth::check())
                <a href="#" data-toggle="modal" data-target="#login-modal" ><i
                        class="fa fa-user"></i></a>
                <!--end-->
                @endif
                <a href="#" class="menu-icon" ><span></span></a>
            </div>
            <!--end div-->

            <!--start div-->
            <div class="col-lg-8  col-sm d-md-block  top-adv">
                <div class="logo-div">
                    @if(isset($ad))
                    <a  href="{{$ad->link}}" target="_blank" >
                        <img src="{{asset('storage/'.$ad->image)}}" alt="logo"/>
                    </a>
                    @endif
                </div>
            </div>
            <!--end div-->
        </div>
    </div>
</section>
<!--end top-logo-->





@if(Session::has('errors'))

    <div class="alert alert-danger active">
         @foreach ($errors->all() as $error)
          <div style="margin-right: inherit"> {{ $error }}<br/></div>
        @endforeach
    </div>
@endif

@if(Session::has('expired'))
    <div class="alert alert-danger active">

            <div style="margin-right: inherit"> {{ session()->get('expired') }}<br/></div>

    </div>
@endif

@if(Session::has('failed'))
    <div class="alert alert-danger active">

        <div style="margin-right: inherit"> {{ session()->get('failed') }}<br/></div>

    </div>
@endif

@if(session()->has('success'))
    <div class="alert alert-success active custome">
       <button type="button" class="close btn btn-danger" data-dismiss="alert"><span>×</span></button>
      {{session()->get('success')}}
    </div>
@endif

<section class="navbar-section  wow fadeIn">
    <div class="container">
        <div class="row">
            <!--start nav-->
           <div class="navbar-grid col-lg-9 md-center">
                <nav>
                    <div class="responsive-logo">
                        <img src="{{asset('website/images/main/logo.png')}}" alt="logo" />
                    </div>
                    <ul class="list-inline">
                        <!--<li class="active"><a href="{{route('home')}}"><i class="fa fa-home"></i>الرئيسية</a></li>-->

                        @foreach($categoriess as $category)
                            @if($category->subCategories()->count())
                        <li class="{{($category->subCategories()->count())?'list-item-has-child':''}}">
                            <a href="{{route('sub-category', $category->id.'-'.$category->name)}}" >
                                <i class="fa fa-book-open"></i>{{$category->name}}
                            </a>
                        @if($category->subCategories()->count())
                            <div class="submenu-list custom-height">
                            <ul class="list-unstyled">
                                @foreach($category->subCategories()->orderBy('order','ASC')->get() as $sub_cat)
                                <li>
                                    <a href="{{route('sub-category', $sub_cat->id.'-'.$sub_cat->name)}}" >{{$sub_cat->name}}</a>
                                </li>
                                @endforeach
                            </ul>
                            </div>
                            @endif
                        </li>
                            @endif
                            @if($loop->iteration == 6)
                        <li class="list-item-has-child more-list"><a href="#" > <i class="fa fa-book-open"></i> المزيد</a>
                            <div class="submenu-list custom-height">
                            <ul class="list-unstyled">
                                @continue
                            </ul>
                            </div>
                        @break
                        
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </nav>
            </div>
            <!--end nav-->

            <!--start div-->
            <div class="navbar-grid col-lg-3 d-lg-block d-none text-left-dir">
                <a href="{{route('favourite')}}"  @if(auth()->guest()) data-toggle="modal" data-target="#login-modal" @endif class="custom-btn"><i class="far fa-heart"></i>المفضلة</a>
            </div>
            <!--end div-->

        </div>
    </div>
  
</section>
<!--end navbar-->




@yield('content')


@yield('footer')

<!-- scripts
     ================ -->
<script type="text/javascript" src="{{asset('website/js/html5shiv.min.js')}}"></script>
<script type="text/javascript" src="{{asset('website/js/respond.min.js')}}"></script>
<script type="text/javascript" src="{{asset('website/js/jquery-3.4.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('website/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('website/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="{{asset('website/js/custom-datapicker.js')}}"></script>
<script type="text/javascript" src="{{asset('website/js/html5lightbox.js')}}"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
<script type="text/javascript" src="{{asset('website/js/custom-sweetalert.js')}}"></script>
<script type="text/javascript" src="{{asset('website/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('website/js/wow.min.js')}}" type="text/javascript"></script>
<script src="{{asset('website/js/custom.js')}}" type="text/javascript"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="{{asset('website/js/msg.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/js/main.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{ URL::asset('admin/plugins/ckeditor/ckeditor.js') }}"></script>


<script>

    setTimeout(function(){ $(".alert").removeClass("active"); }, 5000);

</script>


<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


@yield('scripts')
<script>
$("#phoneAuth").click(function(){
    window.location.href = $(this).data('href');
});

$("#close-form").click(function(){
    window.location.reload();

});

$(document).ready(function(){
     audioElement = document.createElement('audio');
    audioElement.setAttribute('src', "{{ asset('public/website/sound.mp3') }}");
    
    audioElement.addEventListener('ended', function() {
        this.play();
    }, false);
 
   
   
    if($("#auth").val())
    { 
         setInterval(fun,3000);
        //  setInterval(fun2,5000);
    }


});
function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}



    function fun(){
        $.ajax({
            type:'get',
            url:'/unread',
            datatype:'json',
            success: function(data)
            {
                if(data['output']!=='')
                {
                    $('#list_notify').prepend(data['output']);

                    if($(".login-btn-num.notify").text().length!==0){
                        audioElement.play();
                        var a=parseInt($(".login-btn-num.notify").text());
                        $('.login-btn-num.notify').empty();
                        $('.login-btn-num.notify').append(a+1);
                        $('.login-btn-num.notify').show();
                        sleep(2000).then(() => { if(window.location.href !== `{{env("MAIN_URL")}}/products/create`){window.location.reload();}
                        else{
                            audioElement.play();
                            audioElement.pause();
                            audioElement.currentTime = 0;
                        } });
                    }
                    else{

                        $('.login-btn-num.notify').text('1');
                        $('.login-btn-num.notify').show();
                    }
                }
            }
        });

        $.ajax({
            type:'get',
            url:'/unreadMsg',
            datatype:'json',
            success: function(data)
            {
               
               
                if(data['output']!=='')
                {
                $('#list_msg').prepend(data['output']);
           
                if($(".login-btn-num.msg").text().length!==0){
                     audioElement.play();
                    var a=parseInt($(".login-btn-num.msg").text());

                    $('.login-btn-num.msg').empty();
                    $('.login-btn-num.msg').append(a+1);
                    $('.login-btn-num.msg').show();
                   sleep(2000).then(() => { if(window.location.href !== `{{env("MAIN_URL")}}/products/create`){window.location.reload();}
                        else{
                            audioElement.play();
                            audioElement.pause();
                            audioElement.currentTime = 0;
                        } });
                   
                }
                else {

                    $('.login-btn-num.msg').text('1');
                    $('.login-btn-num.msg').show();
                   
                }

                // alert($('.login-btn-num.notify').val());
            }


            }


        })



    }




    $('#loginForm').submit(function (e) {
        e.preventDefault();
        e.stopPropagation();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var email = $("input[name='email']").val();
        var password = $("input[name='password']").val();

        $.ajax({
            url: '{{ route('user.login') }}',
            type: 'POST',
            data: {
                email: email,
                password: password
            },
            success: function(data) {


                if (data['success']===0) {
                     $('#error').empty();
                    $('#error').append(data['msg']);
                    $('#error').show();

                if(data['msg']===2)
                {
                   $('#login_submit').hide();
                    $('#error').empty();
                        $('#error').append('لقد ادخلت بيانات خاطئه لعده مرات سيتم وقفلك لدقائق');
                    setTimeout(function(){ $('#login_submit').show();
                    $('#error').empty();

                    }, 40000);

                }
                    //alert(data.success);
                } else {
                    $('#error').hide();
                      $('#success').append(data['msg']);
                      $('#success').show();
                    setTimeout(function(){ 
                        $('#loginForm').modal('hide');
                        window.location.reload();
                    }, 500);

                    printErrorMsg(data.error);
                }
            }
        });

    });


  
</script>


    <script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-firestore.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/ui/4.7.0/firebase-ui-auth__ar.js"></script>
    <link type="text/css" rel="stylesheet" href="https://www.gstatic.com/firebasejs/ui/4.6.1/firebase-ui-auth.css" />

    <script src="https://www.gstatic.com/firebaseui/dist/firebaseui.js"></script>
    <link type="text/css" rel="stylesheet" href="https://www.gstatic.com/firebaseui/dist/firebaseui.css" />

<script>

function getCountChat(db,auth_id){
    db.collection("users").doc("userId_"+auth_id).onSnapshot(function(user) {
        if(user.data().unReadingCount == 0){
            $('#message_count').html('');
        }else{
            $('#message_count').html('<span>'+user.data().unReadingCount+'</span>');
        }
});
}

function firebaseCheckUser(db ,auth_id ,auth_name ,auth_image ,firebase){
    var docRef = db.collection("users").doc("userId_"+auth_id);
    docRef.get().then(function(doc) {
        if (doc.exists) {

            db.collection("users").doc("userId_"+auth_id).update({
                'nickname':auth_name
            }).then(function(){
                db.collection("messages").where('idTo' ,'==' , "userId_"+auth_id )
                .where('read' ,'==' ,false ).get().then(function(querySnapshot){
                    if(querySnapshot.docs.length == 0){
                        db.collection("users").doc("userId_"+auth_id).update({
                            'unReadingCount':0
                        }).then(function(){
                            getCountChat(db ,auth_id);
                        });
                   }else{
                        getCountChat(db ,auth_id);
                    }
                });
            });

    console.log('name :'+reciverIds.data().nickname);

        } else {
            docRef.set({
            'nickname': auth_name,
            'photoUrl': auth_image,
            'id': "userId_"+auth_id,
            'createdAt': firebase.firestore.FieldValue.serverTimestamp(),
            'chattingWith': null,
            'typingTo': null,
            'unReadingCount' : 0,
            'status' : 'online',
            'lastSeen' : firebase.firestore.FieldValue.serverTimestamp(),
            });
            }

    }).catch(function(error) {
        // console.log("Error getting document:", error);
    });
}
const firebaseConfig = {
  apiKey: "AIzaSyBeRPwLmr6bY4J5Pq1gNf_tI3nnm2G0bOg",
  authDomain: "haraj-plus-1ae1f.firebaseapp.com",
  databaseURL: "https://haraj-plus-1ae1f.firebaseio.com",
  projectId: "haraj-plus-1ae1f",
  storageBucket: "haraj-plus-1ae1f.appspot.com",
  messagingSenderId: "944069048567",
  appId: "1:944069048567:web:24a0998287fb5dc41f3bf2",
  measurementId: "G-FM4ND7G4JQ"
};
if (firebase.apps.length === 0) {
    firebase.initializeApp(firebaseConfig);
}
//firebase.initializeApp(firebaseConfig)
const db = firebase.firestore();
var auth =  '{{ Auth::user() }}';

//    firebase.auth().signOut();
if(auth){
var auth_id =  '{{ Auth::user()? Auth::user()->id:""}}';
var auth_name =  '{{ Auth::user()? Auth::user()->name:""}}';
var auth_email =  '{{ Auth::user()? Auth::user()->email:""}}';
var auth_image =  '{{ Auth::user()? Auth::user()->image:"website/images/main/user.png"}}';

firebase.auth().onAuthStateChanged(function(user) {
if (!user) {
    
firebase.auth().signInWithEmailAndPassword(auth_email,'haraj_plus_user_'+auth_id).then(function(){
   firebaseCheckUser(db, auth_id,auth_name ,auth_image,firebase) ;
})
.catch(function(error) {
// Handle Errors here.
var errorCode = error.code;
if(errorCode == 'auth/user-not-found'){
firebase.auth().createUserWithEmailAndPassword(auth_email, 'haraj_plus_user_'+auth_id).then(function(){
    firebaseCheckUser(db, auth_id,auth_name ,auth_image ,firebase);

})}
});
}else{
firebaseCheckUser(db, auth_id,auth_name ,auth_image ,firebase);
}
});
}else{
    firebase.auth().onAuthStateChanged(function(user) {
        if(user){
            firebase.auth().signOut().then(function() {
  
// Sign-out successful.
}, function(error) {
// An error happened.
});
            console.log('login ' + user.email);
        }else{

        //   console.log('logout');
        }

    });

}



</script>

<script>

var ui = new firebaseui.auth.AuthUI(firebase.auth());

var uiConfig = {
  callbacks: {
    signInSuccessWithAuthResult: function(authResult, redirectUrl) {
      // User successfully signed in.
      // Return type determines whether we continue the redirect automatically
      // or whether we leave that to developer to handle.
        var uid = authResult.user.providerData[0]['uid'] ;
        var photoUrl = authResult.user.providerData[0]['photoURL'];
        var provider = authResult.additionalUserInfo.providerId;
        var name = authResult.user.displayName;
        var social = provider.split('.')[0];
        var token=$('meta[name="csrf-token"]').attr('content');
        
        //console.log(authResult.user);
       
      $.ajax({
            url: "{{ url('createOrGetUser') }}",
            type: 'POST',
            data: { _token : token , social: social ,uid:uid,name:name,image:photoUrl},
            success: function(output) {
                var docRef = db.collection("users").doc("userId_"+output['user']['id']);
                docRef.set({
                    'nickname': output['user']['name'],
                    'photoUrl':  output['user']['image'] != null ?output['user']['image']:'website/images/main/user.png',
                    'id': "userId_"+output['user']['id'],
                    'createdAt': firebase.firestore.FieldValue.serverTimestamp(),
                    'chattingWith': null,
                    'typingTo': null,
                    'unReadingCount' : 0,
                    'status' : 'online',
                    'lastSeen' : firebase.firestore.FieldValue.serverTimestamp(),
                    });
                    
                
                if(output['stat'] == 'new')
                {
                    // when account new redirect verify phone
                    window.location.href = output['url'];

                } else if(output['stat'] == 'add_phone'){
                    location.replace(output['url']);
                }
                else
                {
                    // when account old redirect home 
                    console.log(output['stat']);
                    location.reload();

                }
              
            }
        });
      return true;
    },
    uiShown: function() {
      // The widget is rendered.
      // Hide the loader.
      document.getElementById('loader2').style.display = 'none';
      document.getElementById('loader3').style.display = 'none';
    }
  },
  // Will use popup for IDP Providers sign-in flow instead of the default, redirect.
  signInFlow: 'popup',
  signInSuccessUrl: "{{route('main')}}",
  signInOptions: [
    // Leave the lines as is for the providers you want to offer your users.
    // firebase.auth.GoogleAuthProvider.PROVIDER_ID,
    // firebase.auth.FacebookAuthProvider.PROVIDER_ID,
    // firebase.auth.TwitterAuthProvider.PROVIDER_ID,
    // firebase.auth.GithubAuthProvider.PROVIDER_ID,
    // firebase.auth.EmailAuthProvider.PROVIDER_ID,
    firebase.auth.PhoneAuthProvider.PROVIDER_ID
  ],
  // Terms of service url.
  tosUrl: "{{route('terms')}}",
  
  // Privacy policy url.
  privacyPolicyUrl:  "{{route('privacy')}}"
};


ui.start('#firebaseui-auth-container', uiConfig);
ui.start('#firebaseui-auth-container3', uiConfig);



</script>

</body>

</html>



