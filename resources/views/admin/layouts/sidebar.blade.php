<div class="fixed-menu-grid" id="dark-scroll">
    <div class="fixed-menu">
        <span class="collapse-menu-icon"><i class="fas fa-arrow-right"></i></span>
        <div class="logo-title">
            <img src="{{asset('/website/images/main/logo.png')}}" alt="img"/>
            <div class="side-logo-title">
                حراج بلص
                <a href="{{route('home')}}" class="color-hover">زياره الموقع</a>
            </div>
        </div>
        <div class="main-menu">
            <ul class="list-unstyled">
               <li @if(\Request::segment(2)=='index') class="active" @endif>
                    <a href="{{route('main')}}" title="الرئيسية"><i
                            class="fa fa-home"></i><span>الرئيسية</span></a></li>


                    <li @if(\Request::segment(2)=='users') class="active" @endif>
                    <a href="{{route('users.index')}}" title="العملاء"><i
                            class="fa fa-users"></i><span>العملاء</span></a></li>

                    <li @if(\Request::segment(2)=='businessmen') class="active" @endif>
                    <a href="{{route('businessmen')}}" title="العملاء"><i
                            class="fa fa-users"></i><span>رجال الاعمال</span></a></li>
               <li @if(\Request::segment(2)=='products'&&!isset($_GET['is_valid'])) class="active" @endif>

                    <a href="{{route('products.index')}}" title="المنتجات"><i
                            class="fa fa-car"></i><span>المنتجات</span></a>
               </li>
                <li class="{{(isset($_GET['is_valid'])&&$_GET['is_valid']==3)?'active':''}}">

                    <a  href="{{route('products.index')}}?is_valid=3" title="المنتجات"><i
                            class="fa fa-car"></i><span>المنتجات قيد المراجعة</span></a>
                </li>



              <li @if(\Request::segment(2)=='payments')  class="active" @endif>

                    <a href="{{route('payments.index')}}" title="طلبات الترقيه"><i
                            class="fa fa-car"></i><span>طلبات الترقيه</span></a></li>



                <li>




               <li @if(\Request::segment(2)=='brands')  class="active" @endif>

                    <a href="{{route('brands.index')}}" title="الماركات"><i
                            class="fa fa-car"></i><span>الماركات</span></a>
                </li>

                <li @if(\Request::segment(2)=='countries')  class="active" @endif>


                    <a href="{{route('countries.index')}}" title="الدول"><i
                            class="fa fa-flag"></i><span>الدول</span></a>
                </li>

                 <li @if(\Request::segment(2)=='cities')  class="active" @endif>
                    <a href="{{route('cities.index')}}" title="المدن"><i
                            class="fa fa-home"></i><span>المدن</span></a>
                </li>

              <li @if(\Request::segment(2)=='categories')  class="active" @endif>
                    <a href="{{route('categories.index')}}" title="الأقسام الرئيسية"><i
                            class="fa fa-tshirt"></i><span>الأقسام الرئيسية</span></a>
                </li>

                <li @if(\Request::segment(2)=='sub-categories')  class="active" @endif>
                    <a href="{{route('sub-categories.index')}}" title=" الأقسام الفرعية"><i
                            class="fa fa-ice-cream"></i><span>الأقسام الفرعية</span></a>
                </li>

                 <li @if(\Request::segment(2)=='sliders')  class="active" @endif>
                    <a href="{{route('sliders.index')}}" title="السلايدرز"><i class="fa fa-arrows-alt-h"></i><span>السلايدرز</span></a>


                 <li @if(\Request::segment(2)=='ads')  class="active" @endif>
                    <a href="{{route('ads.index')}}" title="الاعلانات"><i
                            class="fa fa-ad"></i><span>الاعلانات</span></a>
                </li>

              <li @if(\Request::segment(2)=='bank-accounts')  class="active" @endif>
                    <a href="{{route('bank-accounts.index')}}" title="الحسابات البنكية"><i
                            class="fa fa-money-check"></i><span>الحسابات البنكية
                                            </span></a>
                </li>



                <li @if(\Request::segment(2)=='contacts')  class="active" @endif>
                    <a href="{{route('contacts.index')}}" title="الاتصالات"><i
                            class="fa fa-phone"></i><span>الاتصالات</span></a>

                </li>


               <li @if(\Request::segment(2)=='packages')  class="active" @endif>
                    <a href="{{route('packages.index')}}" title="الباقات"><i
                            class="fa fa-box"></i><span>الباقات</span></a>
                </li>

                <li @if(\Request::segment(2)=='reports')  class="active" @endif>
                    <a href="{{route('reports.index')}}" title="البلاغات عن المنتجات"><i
                            class="far fa-hand-paper"></i><span>البلاغات عن المنتجات</span></a>
                </li>


                <li @if(\Request::segment(2)=='comment-reports')  class="active" @endif>
                    <a href="{{route('commentReports')}}" title="البلاغات عن التعليقات"><i
                                class="far fa-hand-paper"></i><span>البلاغات عن التعليقات</span></a>
                </li>


                               <li @if(\Request::segment(2)=='subscribers')  class="active" @endif>
                    <a href="{{route('subscribers.index')}}" title="القائمة البريدية"><i
                            class="fa fa-envelope"></i><span>القائمة البريدية</span></a>
                </li>

               <li @if(\Request::segment(2)=='static-pages')  class="active" @endif>
                    <a href="{{route('static-pages.index')}}" title="الصفحات الثابتة"><i
                            class="fa fa-copy"></i><span>الصفحات الثابتة</span></a>
                </li>

                <li @if(\Request::segment(2)=='techs')  class="active" @endif>
                        <a href="{{route('techs.index')}}" title="رسائل الدعم الفني"><i
                         class="fas fa-envelope"></i><span>رسائل الدعم الفني</span></a>
                    </li>

                    <li @if(\Request::segment(2)=='notifications')  class="active" @endif>
                        <a href="{{route('notifications')}}" title="الإشعارات"><i
                         class="fas fa-bell"></i><span> الإشعارات</span></a>
                    </li>


               <li @if(\Request::segment(2)=='settings')  class="active" @endif>
                    <a href="{{route('settings.index')}}" title="إعدادات
                                            الموقع"><i class="fa fa-cog"></i><span>إعدادات
                                            الموقع</span></a>
                </li>
              


            </ul>


        </div>
    </div>
</div>
<!--end div-->
