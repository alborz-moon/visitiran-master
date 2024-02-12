<!DOCTYPE html>
<html lang="fa">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style>
        body {
            font-family: 'iran';
            margin: 0 !important;
            padding: 0 !important;
            direction: rtl;
        }

        .d-flex {
            display: flex;
        }

        .spaceBetween {
            justify-content: space-between;
        }

        .bold {
            font-family: 'iran';
            direction: rtl;
            font-weight: bold;
        }

        .normal {
            font-weight: 600 !important;
        }

        .responsive {
            width: 100%;
        }

        .logo {
            width: 80px;
            float: right;
            position: relative;
            display: inline-block;
        }

        .floatRight {
            float: right;
        }

        .relative {
            position: relative;
        }

        .absolute {
            position: absolute;
        }

        .yellow {
            color: #c59358;
        }

        .font12 {
            font-size: 12px
        }

        .font14 {
            font-size: 14px
        }

        .font16 {
            font-size: 16px
        }

        .font18 {
            font-size: 18px
        }

        .ml-50 {
            margin-right: 50px;
            gap: 50px;
        }

        .bold {
            font-weight: bold;
        }

        .float-r {
            float: right !important;
        }

        .float-l {
            float: left !important;
        }

        .yellow {
            color: #c59358 !important;
        }

        .fontSize18 {
            font-size: 18px !important;
        }

        .fontSize12 {
            font-size: 12px !important;
        }

        .fontSize10 {
            font-size: 10px !important;
        }

        .margin-r-10 {
            margin-right: 10px;
        }

        .border {
            border: 1px solid black;
        }

        .halfW {
            width: 320px;
        }

        .padding5 {
            padding: 5px;
        }

        .padding0,
        .p-9 {
            padding: 0 !important;
        }

        .margin0,
        .m-0 {
            margin: 0 !important;
        }

        .hr {
            border-bottom: 1px solid #777;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .silver {
            color: #555;
        }

        th {
            font-size: 14px
        }

        th,
        td {
            margin: 0;
            padding: 8px 10px;
            border-left: 1px solid rgb(185, 185, 185);
            border-bottom: 1px solid rgb(185, 185, 185);
            text-align: center;
            font-size: 11px;
        }
    </style>
</head>

<body>
    <div class="absolute" style="width: 260px;top:25px;left:0">
        <p class="margin0 padding0">
        <div class="fontSize12">تاریخ: <span>{{ $created_at }}</span></div>
        </p>
    </div>
    <div class="relative">
        <div class="logo">
            <img class="responsive" src="{{ asset('theme-assets/images/menuImage2.svg') }}" alt="">
        </div>

        <div class="absolute">
            <div class="yellow font14 bold">ویزیت ایران</div>
            <div class="font12 bold">بازارگاه صنایع دستی</div>
            <div class="font12 bold">صورت حساب الکترونیک</div>
            <div class="font12">شماره سفارش :<span>{{ $tracking_code }}</span></div>
        </div>
    </div>
    <div class="fontSize16 bold">مشخصات خریدار</div>
    <div style="margin-top: 10px">
        <div class="float-r" style="width: 260px">
            <p class="margin0 padding0">
                <span class="bold fontSize14">نام و نام خانوادگی: </span>
                <span class="fontSize12">{{ $name }}</span>
            </p>
        </div>

        <div class="float-r" style="width: 260px">
            <p class="margin0 padding0">
                <span class="bold fontSize14">شماره ملی: </span>
                <span class="fontSize12">{{ $nid }}</span>
            </p>
        </div>

        <div class="float-r" style="width: 260px">
            <p class="margin0 padding0">
                <span class="bold fontSize14">تلفن:</span>
                <span class="fontSize12">{{ $tel }}</span>
            </p>
        </div>

        <div class="float-r" style="width: 260px">
            <p class="margin0 padding0">
                <span class="bold fontSize14">ایمیل:</span>
                <span class="fontSize12">{{ $email }}</span>
            </p>
        </div>
    </div>

    <div style="margin-top: 10px">
        <div class="float-r">
            <p class="margin0 padding0">
                <span class="bold fontSize14">آدرس تحویل:</span>
                <span class="fontSize12">{{ $address }}</span>
            </p>
        </div>
    </div>
    <div style="margin-top: 20px;margin-bottom: 10px" class="fontSize16 bold">مشخصات فروشنده</div>
    <div class="p-0 m-0">
        <div class="float-r" style="width: 280px">
            <p class="margin0 padding0">
                <span class="bold fontSize14">نام:</span>
                <span class="fontSize12">کانون جهانگردی و اتومبیلرانی جمهوری اسلامی ایران</span>
            </p>
        </div>


        <div class="float-r" style="width: 260px">
            <p class="margin0 padding0">
                <span class="bold fontSize14">شناسه ملی:</span>
                <span class="fontSize12">10100001064</span>
            </p>
        </div>

        <div class="float-r" style="width: 270px">
            <p class="margin0 padding0">
                <span class="bold fontSize14">شماره اقتصادی:</span>
                <span class="fontSize12">411137511731</span>
            </p>
        </div>

        <div class="float-r" style="width: 270px">
            <p class="margin0 padding0">
                <span class="bold fontSize14">شماره تلفن:</span>
                <span class="fontSize12">66900770</span>
            </p>
        </div>
    </div>
    <div style="margin-top: 10px">
        <div class="float-r" style="width: 100٪">
            <p class="margin0 padding0">
                <span class="bold fontSize14">آدرس :</span>
                <span class="fontSize12">تهران، خیابان آزادی، بین خوش و بهبودی، نبش خیابان شهید قانعی، پلاک 231 کد پستی
                    : 1457994785</span>
            </p>
        </div>
    </div>
    <p style="margin-top: 20px" class="fontSize16 bold">مشخصات سفارش</p>
    <table>
        <thead>
            <tr style="background-color: rgb(189, 189, 189)">
                <th>ردیف</th>
                <th>نام محصول</th>
                <th>توضیحات محصول</th>
                <th>تعداد</th>
                <th>قیمت واحد (ریال)</th>
                <th>مبلغ کل (ریال)</th>
                <th>تخفیف (ریال)</th>
                <th>مبلغ کل پس از تخفیف (ریال)</th>
                <th>جمع مالیات و عوارض ارزش افزوده (ریال)</th>
                <th>جمع کل پس از تخفیف و مالیات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product['id'] }}</td>
                    <td>{{ $product['title'] }}</td>
                    <td>{{ $product['desc'] }}</td>
                    <td>{{ $product['count'] }}</td>
                    <td>{{ $product['price'] }}</td>
                    <td>{{ $product['total'] }}</td>
                    <td>{{ $product['off'] }}</td>
                    <td>{{ $product['total_after_off'] }}</td>
                    <td>{{ $product['total_after_off_tax'] }}</td>
                    <td>{{ $product['all'] }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5">حمل و نقل</td>
                <td>{{ $transfer['price'] }}</td>
                <td>{{ $transfer['off'] }}</td>
                <td>{{ $transfer['total_after_off'] }}</td>
                <td>{{ $transfer['total_after_off_tax'] }}</td>
                <td>{{ $transfer['all'] }}</td>
            </tr>
            <tr>
                <td colspan="5">جمع کل</td>
                <td>{{ $total['total'] }}</td>
                <td>{{ $total['off'] }}</td>
                <td>{{ $total['total_after_off'] }}</td>
                <td>{{ $total['total_after_off_tax'] }}</td>
                <td>{{ $total['all'] }}</td>
            </tr>
        </tbody>
    </table>
    <div>
        <div class="float-r" style="width: 50%">
            <p class="margin0 padding0">
                <span class="bold fontSize14">مهر و امضای فروشنده</span>
                <span class="fontSize10"></span>
            </p>
        </div>
        <div class="float-r" style="width: 50%">
            <p class="margin0 padding0">
                <span class="bold fontSize14">مهر و امضای خریدار</span>
                <span class="fontSize10"></span>
            </p>
        </div>
    </div>
</body>

</html>
