<!DOCTYPE html>
<html lang="fa">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style>
        body {
            margin: 0 !important;
            padding: 0 !important;
            direction: rtl;
        }

        .d-flex {
            display: flex;
        }

        .bold {
            direction: rtl;
            font-weight: bold;
        }

        .responsive {
            width: 100%;
        }

        .logo {
            width: 150px;
            float: right;
            position: relative;
            display: inline-block;
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


        .blue {
            color: #009bb9;
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

        .bold {
            font-weight: bold;
        }

        .yellow {
            color: #c59358 !important;
        }

        .border {
            border: 1px solid black;
        }

        .border-bottom {
            border: 1px solid #eaeaea;
        }

        .silver {
            color: #555;
        }

        a {
            text-decoration: none !important;
        }

        .footer {
            margin: 0 !important;
            padding-left: 20px !important;
            padding-right: 20px !important;
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            background-color: #eaeaea;
            direction: rtl;
            text-align: right;
        }

        .footer p {
            margin-top: 5px !important;
            margin-bottom: 5px !important;
        }
    </style>
</head>

<body>

    <div class="relative">
        <div class="logo">
            <img class="responsive" src="https://events.visitiran.ir/theme-assets/images/menuImage2.svg">
        </div>

        <div style="float: right; text-align: right; display: flex; flex-direction: column; gap: 1px; ">
            <div style="margin-top: 18px; margin-right: 10px">
                <div class="yellow font14 bold">ویزیت ایران</div>
                <div class="font14 bold">بازارگاه صنایع دستی</div>
            </div>

        </div>

    </div>

    <div style="clear: both"></div>
    <div class="border-bottom"></div>

    <div style="text-align: right; direction: rtl">
        <p class="font14 bold">{{ $name }} عزیز</p>
        <p>امیدواریم از خرید خود لذت برده باشید</p>
        <p>رسید خرید شما برای سفارش شماره <span class="yellow">{{ $invoice_no }}</span> ضمیمه این پیام ارسال
            گردیده
            است.</p>

    </div>

    <div class="border-bottom"></div>

    <div style="text-align: right; direction: rtl">
        <p>
            <span class="font14 bold">آدرس تحویل: </span>
            <span>{{ $address }}</span>
        </p>

    </div>

    <div class="border-bottom"></div>

    <div style="text-align: right; direction: rtl">

        <p class="font14 bold">برای مشاهده لیست خرید <a class="blue" href="https://events.visitiran.ir/my-events">از
                اینجا</a>&nbsp;&nbsp;اقدام کنید.</p>

        {{-- <p class="font14 bold">برای مشاهده لیست خرید <a class="blue"
            href="https://events.visitiran.ir/my-events">از
            اینجا</a>&nbsp;&nbsp;اقدام کنید.</p> --}}

        <p class="font14 bold">برای پشتیبانی <a class="blue" href="https://hcshop.taci.ir/my-tickets">از
                اینجا</a>&nbsp;&nbsp;اقدام کنید.</p>

        <p class="font14 bold">برای مرجوع نمودن کالا <a class="blue" href="https://events.visitiran.ir/my-events">از
                اینجا</a>&nbsp;&nbsp;اقدام کنید.</p>

    </div>

    <div class="footer">
        <p class="font14 bold silver">پشتیبانی</p>
        <p class="font14 bold yellow">هفت روز هفته از ساعت ۸ الی ۱۷</p>
        <p class="font14 silver">
            <span>تلفن پشتیبانی</span>
            <span>&nbsp;</span>

            <span>۸۸۸۱۹۵۶۲</span>
            <span>- ۰۲۱</span>
        </p>
    </div>

    <p style="direction:  rtl; text-align: right" class="font14">این ایمیل برای اطلاع رسانی از آخرین وضعیت سفارش شما از
        سایت events.visitiran.ir ارسال شده است. در
        صورتی که این خرید از سوی شما انجام نیافته است ما را مطلع نمایید.</p>
</body>

</html>
