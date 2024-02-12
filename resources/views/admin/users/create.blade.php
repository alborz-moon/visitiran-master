@extends('admin.layouts.create')

@section('header')
    @parent
@stop

@section('title')
{{ isset($item) ? 'ویرایش کاربر' : 'افزودن کاربر' }}
@stop

@section('form')

    <form id="myForm" action="{{ isset($item) ? route('users.update', ['user' => $item['id']]) : route('users.store')}}" method="post">
        {{ csrf_field() }}

        <div class="flex flex-col center gap10" style="margin: 10px">

            <div>
                <label for="first_name">نام</label>
                <input required value="{{ isset($item) ? $item['first_name'] : old('first_name') }}" type="text" name="first_name" id="first_name" />
            </div>
            
            <div>
                <label for="last_name">نام خانوادگی</label>
                <input required value="{{ isset($item) ? $item['last_name'] : old('last_name') }}" type="text" name="last_name" id="last_name" />
            </div>
            
            <div>
                <label for="nid">کد ملی</label>
                <input onkeypress="return isNumber(event)" required value="{{ isset($item) ? $item['nid'] : old('nid') }}" type="tel" name="nid" id="nid" />
            </div>
            
            <div>
                <label for="phone">شماره همراه</label>
                <input onkeypress="return isNumber(event)" required value="{{ isset($item) ? $item['phone'] : old('phone') }}" type="tel" name="phone" id="phone" />
            </div>
            
            <div>
                <label for="mail">ایمیل</label>
                <input required value="{{ isset($item) ? $item['mail'] : old('mail') }}" type="mail" name="mail" id="mail" />
            </div>
            
            <div>
                <label for="password">رمزعبور</label>
                <input type="password" name="password" id="password" />
            </div>

            <div>
                <label for="access">اجازه دسترسی</label>
                <select name="access" required id="access">
                    <option {{ old('access') == 'both' || (isset($item) && $item['access'] == 'both') ? 'selected' : '' }} value="both">هر دو سایت</option>
                    <option {{ old('access') == 'event' || (isset($item) && $item['access'] == 'event') ? 'selected' : '' }} value="event">سایت ایونت</option>
                    <option {{ old('access') == 'shop' || (isset($item) && $item['access'] == 'shop') ? 'selected' : '' }} value="shop">سایت فروشگاه</option>
                </select>
            </div>
            
            <div>
                <label for="level">نقش کاربر</label>
                <select name="level" required id="level">
                    <option {{ old('level') == 'admin' || $level == 'admin' || (isset($item) && $item['level'] == 'admin') ? 'selected' : '' }} value="admin">ادمین</option>
                    <option {{ old('level') == 'editor' || $level == 'editor' || (isset($item) && $item['level'] == 'editor') ? 'selected' : '' }} value="editor">ویرایشگر</option>
                    <option {{ old('level') == 'news' || $level == 'news' || (isset($item) && $item['level'] == 'news') ? 'selected' : '' }} value="news">مدیریت بلاگ</option>
                    <option {{ old('level') == 'report' || $level == 'report' || (isset($item) && $item['level'] == 'report') ? 'selected' : '' }} value="report">گزارش گیری</option>
                    <option {{ old('level') == 'finance' || $level == 'finance' || (isset($item) && $item['level'] == 'finance') ? 'selected' : '' }} value="finance">گزارش گیری مالی</option>
                </select>
            </div>

        </div>


        <div class="flex center gap10">
            <span onclick="document.location.href = '{{ route('users.index', ['level' => $level]) }}'" class="btn btn-danger">بازگشت</span>
            <input value="ذخیره" type="submit" class="btn green" id="saveBtn" />
        </div>

    </form>
@stop