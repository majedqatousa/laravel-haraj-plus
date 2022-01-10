

<header class="first_bg  wow fadeIn"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <div class="container">
        <div class="row">
            <!--start div-->
            <div class="col-lg-5 col-md-7  sm-center main-search-grid">
                <div class="main-search">
                    <form class="needs-validation red-form" method="get" action="{{route('search.result')}}" novalidate>
                        <div class="form-group">
                            <input class="form-control" name="search" placeholder="ابحث هنا" required />
                            <div class="invalid-feedback">
                                من فضلك أدخل نص صحيح
                            </div>
                            <button type="submit" class="pos-search-btn first_bg second_bg_hover auto-icon "><i
                                    class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!--end div-->

            <!--start div-->
            <!--before login-->
            @if(!auth()->id())
            <div class="col-lg-7 col-md-5 d-md-block d-none login-grid text-left-dir sm-center">
                <div class="main-login">
                    <div class="before-login">
                        <a  href="#" data-toggle="modal" data-target="#login-modal" class="second_color_hover">تسجيل
                            الدخول</a>
                        <a  href="{{route('signUp')}}"
                           class="white-btn second_bg_hover"> حساب جديد</a>
                    </div>
                </div>



            </div>
            @else
            <!--after login-->
            <div class="col-lg-7 col-md-5  login-grid text-left-dir sm-center">
                <div class="main-login">
                    <div class="after-login">
                        <div class="after-login-div">
                            <a  href="{{route('chat.index')}}" class="white-btn second_bg_hover"><i class="fas fa-comment-dots"></i>
                                <span  id="msg" class="login-btn-text">الرسائل</span>
                                
                                <span  class="login-btn-num msg" id="message_count"></span>

                            </a>

                            <div class="arrow-list big-arrow-list">
<!--                                <ul  id="list_msg" class="list-unstyled">-->
<!--                                    @if(isset($client_messages)&&$client_messages->isNotEmpty())-->
<!--                                    @foreach($client_messages as $client_message)-->
<!--                                    <li>-->
<!--                                        <a  href="{{route('chat.getChat',$client_message->id)}}">-->
<!--                                            <img src="{{isset($client_message->getSender->image)&&file_exists('storage/'.$client_message->getSender->image)?asset('storage/'.$client_message->getSender->image):asset('website/images/avatar.png')}}" alt="img" />-->
<!--                                            <div class="side-login">-->
<!--{{--                                                <h3> {{$client_message->content.'بإرسال'.$client_message->getReceiver->name.'لقد قام'}}  </h3>--}}-->
<!--{{--                                                <h3> بإرسال رساله لك{{$client_message->getReceiver->name}} لقد قام </h3>--}}-->
<!--                                                <h3>قام {{$client_message->getSender->name}} بإرسال رسالة لك</h3>-->

<!--                                                <span class="login-time"><i class="far fa-clock"></i>{{$client_message->created_at->diffForHumans()}}-->
<!--                                                        </span>-->
<!--                                            </div>-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--@endforeach-->
<!--                                        @else-->
<!--                                        <li>لا توجد رسائل</li>-->
<!--                                    @endif-->

<!--                                </ul>-->
                                <!--@if(isset($client_messages)&&$client_messages->isNotEmpty())-->

                                <!--<div class="text-center">-->
                                <!--    <a  href="{{route('chat.index')}}" class="show-all">عرض الكل</a>-->
                                <!--</div>-->
                                <!--    @endif-->
                            </div>
                        </div>

                        <div class="after-login-div">
                            <div id="notify">
                            <a  href="#" class="white-btn second_bg_hover"><i class="fa fa-bell"></i>
                                <span class="login-btn-text">الإشعارات</span>

                                <span  id="btn-num" @if(auth()->user()->Notifications->count()==0) style="display: none" @endif class="login-btn-num notify">{{auth()->user()->Notifications->count()!=0?auth()->user()->unReadNotifications->count():''}}</span>

                            </a>
                        </div>
                            <div class="arrow-list big-arrow-list">
                                @if(auth()->user()->Notifications->isNotEmpty())
                                <ul  id="list_notify"   class="list-unstyled">

                                    @foreach(auth()->user()->Notifications as $notification )
                                        <li >
                                  
                                            <a  href="{{isset($notification->data['actionUrl'])?$notification->data['actionUrl']:''}}">
                                                <img src="{{isset($notification->data['image'])?asset('storage/'.$notification->data['image']):asset('admin/images/main/avatar.png')}}" alt="img" />
                                                
                                                <div class="side-login">

                                                    <h3>{{isset($notification->data['message'])?$notification->data['message']:''}} </h3>

                                                    <span class="login-time"><i class="far fa-clock"></i> {{$notification->data['message']?$notification->created_at->diffForHumans(Carbon\Carbon::now(), false):''}}</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>
@else
                                    <h4 class='empty-div-messages text-center'>لا يوجد اشعارات</h4>
                                @endif
                               {{-- <div class="text-center">
                                    <a   href="" class="show-all">عرض الكل</a>
                                </div>--}}

                            </div>

                        </div>


                        <div class="after-login-div">
                            <a  href="#" class="user-img full-width-img"><img  @if(str_split(auth()->user()->image , 4)[0] != 'http') src="{{asset('admin/images/main/avatar.png')}}" @elseif(str_split(auth()->user()->image , 4)[0] == 'http') src="{{ auth()->user()->image }}" @elseif(auth()->user()->image != null) src="{{asset('storage/'.auth()->user()->image)}}"@endif class="converted-img" alt="user" />
                            </a>


                            <div class="arrow-list">
                                <!--for user-->
                                <ul class="list-unstyled">
                                    @if(auth()->user()->is_promoted==1)
                                    <li><a  href="{{route('business-profile',auth()->id())}}" ><i class="fas fa-store"></i>{{ auth()->user()->name .' متجري'}} </a>
                                     @endif
                                    <li><a     href="{{route('showProfile')}}"  ><i class="far fa-user"></i>اعلاناتى</a>


                                    </li>


                                        @if(auth()->user()->type==1)

                                            <li><a  href="{{route('main')}}"><i class="fa fa-user"></i>لوحه التحكم </a>
                                            </li>
                                            @endif


                                    <li><a  href="{{route('edit-data')}}"><i class="fa fa-edit"></i>تعديل البيانات</a>
                                    </li>
                                        @if(auth()->user()->is_promoted==0 || auth()->user()->is_promoted==2)
                                    <li><a  href="{{route('store.index')}}"><i class="fas fa-store"></i></i>
                                    إنشاء متجر
                                            </a>
                                    </li>
                                        @endif
{{--                                        @if(auth()->user()->is_promoted==0 && checkProductsNo())--}}
{{--                                    <li><a  href="{{route('products.add')}}"><i class="fa fa-plus"></i>إضافة--}}
{{--                                            إعلان</a>--}}
{{--                                    </li>--}}

{{--                                        @else--}}
                                            <li><a  href="{{route('products.add')}}"><i class="fa fa-plus"></i>إضافة
                                                    إعلان</a>
                                            </li>

                                       {{-- @else
                                            <li><a  href="{{route('products.add')}}"><i class="fa fa-plus"></i>إضافة
                                                    إعلان</a>
                                            </li>
--}}
@if(isset($support->url))

                                    <li><a  href="{{route('tech')}}"><i class="fa fa-headset"></i>الدعم الفني</a></li>
                                    @endif
                                    <li><a  href="{{route('Logout')}}"><i class="fa fa-sign-out-alt"></i>تسجيل الخروج</a></li>
                                </ul>

                              
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--end after login-->
            @endif
        </div>

    </div>
</header>
