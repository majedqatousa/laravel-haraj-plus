@extends('admin.layouts.app')
@section('pageTitle')لوحة التحكم
@endsection

@section('pageSubTitle') المتاجر
@endsection

@section('content')

@if($stores->isEmpty())
    <div class="more-link-grid text-center col-12">
        <span class="more-link color-bg full-width-btn"> لا توجد متاجر </span>
    </div>
@else
<div class="row">
<div class="col">
        <h3> المتاجر بانتظار الموافقة : {{$count}}</h3>
    </div>
</div>
<div class="row">
  
@foreach($stores as $store)
   
        <div class="col-xl-3 col-lg-4 col-md-6 products-grid">
            <div class="product-div">
            <div class="text-center">
            <a href="{{asset("storage/".$store->user->image)}}" class="html5lightbox" data-group="set-0">
                        <img style="  vertical-align: middle;
                            width: 50px;
                            height: 50px;
                            border-radius: 50%;" src="{{asset("storage/".$store->user->image)}}" alt="product" />
                    </a>
            </div>
                <div class="product-img">
                    <a href="{{asset("storage/".$store->cover_image)}}" class="html5lightbox" data-group="set-0">
                        <img src="{{asset("storage/".$store->cover_image)}}" alt="product" />
                    </a>
                </div>
              
            
               
               
                <div class="product-details">
                    <form class="needs-validation" novalidate>
                        <div class="row no-marg-row">
                            <div class="col-12">
                                <div class="pro-main-details">
                                    <div class="pro-det form-control">  الاسم:{{$store->user->name}}   </div>
                                    <i class="fa fa-file-alt"></i>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="pro-main-details">
                                    <div class="pro-det form-control">الوصف : {{$store->about}}</div>
                                    <i class="fa fa-money-bill-alt"></i>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="pro-main-details">
                                    <div class="pro-det form-control">
                                @if($store->is_active==0)
                                    بانتظار التفعيل
                                @else فعال
                                @endif
                                </div>
                                <i class="fas fa-thumbtack"></i>
                                </div>
                            </div>

                

                       



            <div class="col-12">
                <div class="more-div left-text-dir">
                                    <span class="more-text">المزيد <i
                                            class="fa fa-chevron-left"></i></span>
                    <div class="more-list">
                        <ul class="list-unstyled">

                            @if($store->user_id!=auth()->id())
                            <li><a href="{{route('chatUserPro',$store->user->id)}}" ><i
                                        class="fa fa-envelope"></i> مراسله صاحب المنتج</a></li>
                            @endif
                            @if($store->is_active==0)
                            <li><a href="{{route("store.activate",$store->id)}}"><i
                                        class="fa fa-edit"></i>تفعيل المتجر</a></li>
                            @endif
                         
                            <li><a href="{{route("store.delete",$store->id)}}"><i
                                        class="fa fa-trash"></i>حذف المنتج</a></li>


                        </ul>
                    </div>
                </div>
            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
   
@endforeach
</div>
@endif



@endsection


@section('scripts')
      <script>




          $(document).ready(function(e){

                $(document).on("click",".more-text", function () {
                  $(this).next(".more-list").slideToggle("slow")
              });
              loadmore()
          });
</script>

@endsection


