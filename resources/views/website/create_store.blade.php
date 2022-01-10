@extends('website.layouts.app')

@section('content')

<div class="title-forma-data">
        <div class="container">
            <h2>أنشئ متجرك الآن <strong>مجاناً</strong></h2>
            
            <h3> أحصل على مزايا حراج بلص مجاناً لمدة عام من تاريخ الإشتراك</h3>
         
            <div class="text-center col-12 margin-div">
                <a href="{{route('store.create')}}" class="custom-btn big-btn">إنشاء متجر</a>
            </div>
        </div>
</div>

@endsection

@include('website.layouts.footer')

