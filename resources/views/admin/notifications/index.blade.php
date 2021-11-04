

@extends('admin.layouts.app')

@section('pageTitle')لوحة التحكم
@endsection

@section('pageSubTitle') الإشعارات
@endsection

@section('content')
    <!--start row-->
    <div class="row">
        <!--start div-->
        <div class="breadcrumbes col-12">
            <ul class="list-inline">
                <li><a href="{{route('main')}}"><i class="fa fa-home"></i>الرئيسية</a></li>
                <li>الإشعارات</li>
            </ul>
        </div>
        <!--start row-->
    <div class="row">
        <!--start div-->
        <div class="breadcrumbes col-12">
            <ul class="list-inline">
                <li><a href="{{route('main')}}"><i class="fa fa-home"></i>الرئيسية</a></li>
                <li>اضافة سلايدر</li>
            </ul>
        </div>
        <!--end div-->


        <!--start div-->
        <div class="col-md-12 clients-grid margin-bottom-div">
            <div class="main-white-box">
                <h3 class="sec-title color-title"><span>إرسال إشعار</span></h3>
                @include('alert')
                <form class="needs-validation row border-form" id="myform" novalidate="" method="post" enctype="multipart/form-data" action="{{route('sendNotification')}}"
                >
                    @csrf



                    <div class="form-group  col-md-6">
                        <label>الصورة<span class="starrisk">*</span></label>
                        <input type="file" class="form-control"  name="image" required>
                        <div class="invalid-feedback">
                            من فضلك أدخل العنوان
                        </div>
                        @if ($errors->has('image'))
                            <div style="display:block;" class="invalid-feedback">{{$errors->first('image') }}</div>
                        @endif
                                         
                    </div>

                    <div class="form-group  col-md-6">
                        <label>العنوان<span class="starrisk"></span></label>
                        <input type="text" class="form-control" placeholder="العنوان"  name="title" >
                        <div class="invalid-feedback">
                            من فضلك أدخل الإشعار
                        </div>
                        @if ($errors->has('title'))
                            <div style="display:block;" class="invalid-feedback">{{$errors->first('title') }}</div>
                        @endif
                      
                    </div>

                


                    <div class="form-group  margin-top-div text-center col-12">
                        <button type="submit" class="custom-btn">إرسال</button>
                    </div>



                </form>
            </div>

        </div>
        <!--end div-->

    </div>
    <!--end row-->
    </div>
    <!--end row-->




@endsection







<!-- scripts
     ================ -->



