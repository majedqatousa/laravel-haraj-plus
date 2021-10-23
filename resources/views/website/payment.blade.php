@extends('website.layouts.app')

@section('content')


    <!-- start commmission forma -title -->
    <div class="title-forma-data">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>نموذج التحويل البنكي</h2>
                    <h3> قبل الإشتراك في حسابات حراج بلص المدفوعة عن طريق التحويل البنكي
                         يرجي تحويل المبلغ المطلوب علي حساب مؤسسة حراج بلص التجارية وفقا للبيانات التالية :</h3>
               <ul class="bank-list">
                   <li>
                       <span> اسم البنك</span> البنك البريطاني ساب
                   </li>
                  
                   <li>
                       <span>رقم الحساب</span> 032211120001
                   </li>
                   <li>
                       <span> الايبان</span> SA3545000000032211120001
                   </li>
               </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- end commmission forma -title -->


    <!-- start commission-from group -->
    <div id="loader">
     <div class="form-group  wow fadeIn">
            <div class="container bg-form-group">
                <div class="form-group row">

    <form class="needs-validation" method="post" action="{{route('payments.store')}}" enctype="multipart/form-data"
          novalidate>
        @csrf
        <div class="form-group  wow fadeIn">
            <div class="container bg-form-group">
                <div class="form-group row">

                    <div class="col-lg-3 title-from-grop">
                        <label>رقم الحساب :</label>
                    </div>
                    <div class="col-lg-9 input-from-group">
                        <input name='bank_no' type="number" min="1" class="form-control" required>
                        <div class="invalid-feedback">
                            من فضلك ادخل رقم الحساب
                        </div>
                    </div>
                    <div class="col-lg-3 title-from-grop">
                        <label>اسم المحول :</label>
                    </div>
                    <div class="col-lg-9 input-from-group">
                        <input name='transferee_name' type="text" class="form-control" required>
                        <div class="invalid-feedback">
                            من فضلك ادخل اسم المحول
                        </div>
                    </div>


                    <div class="col-lg-3  title-from-grop">
                        <label>اسم البنك:</label>
                    </div>
                    <div class="col-lg-9 input-from-group">
                        <select name="bankAccount_id" class="form-control form-control-lg">
                            @foreach($banks as $key=>$value)
                                <option value="{{$key}}">
                                    {{$value}}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">

                        </div>
                    </div>

                    <div class="col-lg-3  title-from-grop">
                        <label>نوع الباقه:</label>
                    </div>
                  
                    <div class="col-lg-9 input-from-group">
                        
                        <input name='pakage_id' type="hidden" value="{{ $package->id }}"  class="form-control">
                        <input  type="text" value="{{ $package->type }}"  class="form-control" readonly>
                        
                    </div>
                       


                    <div class="col-lg-3 title-from-grop">
                        <label>تاريخ التحويل :</label>
                    </div>
                    <div class="col-lg-9 input-from-group">
                        <input type="text" name="transfer_date" class="form-control form-control-lg" placeholder="اختر اليوم">
                        <div class="invalid-feedback">من فضلك إختر تاريح التحويل</div>
                    </div>

                    <div class="col-lg-3 title-from-grop">
                        <label>المبلغ المدفوع :</label>
                    </div>
                    <div class="col-lg-9 input-from-group">
                        <input type="number" class="form-control" min="1" name="money_amount" required>
                        <div class="invalid-feedback">
                            من فضلك ادخل المبلغ
                        </div>
                    </div>


                    <div class="col-lg-3 title-from-grop">
                        <label>صورة الإيصال :</label>
                    </div>

                    <div class="col-lg-9 input-from-group">
                        <div class="input-group mb-3">

                            <div class="custom-file">
                                <input name="image" type="file" class="custom-file-input form-control"
                                       id="inputGroupFile01"
                                       aria-describedby="inputGroupFileAddon01" required>
                                <label class="custom-file-label" for="inputGroupFile01">رفع الملف</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">
                            أدخل صورة الإيصال
                        </div>
                    </div>


                    <div class="col-lg-3 title-from-grop">
                        <label>ملاحظات :</label>
                    </div>
                    <div class="col-lg-9 input-from-group">
                        <textarea name="notes" class="form-control"></textarea>
                    </div>

                    <div class="col-lg-12 button-form-group">
                        <button type="submit" class="custom-btn"> ارسال</button>
                    </div>
                </div>
            </div>
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
        $(".custom-file-input").on("change", function () {
            var names = [];
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            $(this).next(".custom-file-label").html(names.join(','));
        });
        
        

        $(function() {
          $('input[name="transfer_date"]').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 2019,

                "locale": {
        "applyLabel": "تطبيق",
        "cancelLabel": "إلغاء",
        "fromLabel": "من",
        "toLabel": "إلي",
        "customRangeLabel": "Custom",
        "daysOfWeek": [
            "حد",
            "ثن",
            "ثلا",
            "ربع",
            "خم",
            "جم",
            "سب"
        ],
        "monthNames": [
            "يناير",
            "فبراير",
            "مارس",
            "أبريل",
            "مايو",
            "يونيو",
            "يوليو",
            "أغسطس",
            "سبتمبر",
            "أكتوبر",
            "نوفمبر",
            "ديسمبر"
        ],
    }

       
        });
        });
</script>
<script>
     $( "form" ).on( "submit", function( event ) {
        event.preventDefault();
        $("#loader").html("<div class='load-aj'><img src='https://haraj-plus.sa/public/website/images/ajax-loader.gif'/></div>");
          var formData = new FormData(this);
       
                $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(data) {
                      $("#loader").hide(100);
                      
                        Swal.fire({
                        type: 'success',
                        title: 'تم إرسال الحوالة بنجاح',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    location.replace(`{{env('MAIN_URL')}}`);
                },
                error: function(data) {
                      $("#loader").hide(100);
                      console.log("Error !! ");
                      console.log(data);
                      
                      
                }
                });
    });
</script>
@endsection
