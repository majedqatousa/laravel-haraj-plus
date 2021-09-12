

@extends('admin.layouts.app')

@section('pageTitle')لوحة التحكم
@endsection

@section('pageSubTitle') الأقسام الرئيسية
@endsection

@section('content')
    <!--start row-->
    <div class="row">
        <!--start div-->
        <div class="breadcrumbes col-12">
            <ul class="list-inline">
                <li><a href="{{route('main')}}"><i class="fa fa-home"></i>الرئيسية</a></li>
                <li>الأقسام الرئيسية</li>
            </ul>
        </div>
        <!--end div-->


        <!--start div-->
        <div class="col-md-12 clients-grid margin-bottom-div">
            <a href="{{route('categories.create')}}" class="more-link color-bg inline-block-btn">إضافة قسم رئيسي</a>
            <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                   style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>صورة القسم الرئيسي</th>
                    <th>الاسم</th>
                    <th>الترتيب</th>
                    <th> تعديل</th>

                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    @if($category->parent_id == null)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td><img src="{{asset( '/storage/'. $category->image)}}" alt="category" style="width:200px; height:100px"></td>
                        <td>{{$category->name}}</td>
                        <td>{{$category->order}}</td>
                        <td>
                            <a href="{{route('categories.edit', $category->id)}}" class="edit-btn-table"><i class="fa fa-edit"></i></a>
                            <a title="delete" onclick="return true;" object_id="{{ $category->id }}" delete_url="/categories/" class="edit-btn-table remove-alert" href="#">
                                <i class="fa fa-times"></i> </a>

                        </td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>

        </div>
        <!--end div-->

    </div>
    <!--end row-->




@endsection







<!-- scripts
     ================ -->



