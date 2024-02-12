
<!-- start of personal-info-birth-modal -->
<div class="remodal remodal-xs" data-remodal-id="personal-info-birth-modal" data-remodal-options="hashTracking: false">
    <div class="remodal-header">
        <div class="remodal-title">تولد</div>
        <button data-remodal-action="close" class="remodal-close"></button>
    </div>
    <div class="remodal-content">
        <div class="row">
            <div class="col-4">
                <div class="form-element-row">
                    <label class="label fs-7">سال</label>
                    <input onkeypress="return isNumber(event)" value="" id="Brithday_year" type="text"
                        class="form-control" placeholder="">
                </div>
            </div>
            <div class="col-4">
                <div class="form-element-row">
                    <label class="label fs-7">ماه</label>
                    <select class="select2" name="month" id="Brithday_month">
                        <option value="0">ماه</option>
                        <option value="1">فروردین</option>
                        <option value="2">اردیبهشت</option>
                        <option value="3">خرداد</option>
                        <option value="4">تیر</option>
                        <option value="5">مرداد</option>
                        <option value="6">شهریور</option>
                        <option value="7">مهر</option>
                        <option value="8">آبان</option>
                        <option value="9">آ‌ذر</option>
                        <option value="10">دی</option>
                        <option value="11">بهمن</option>
                        <option value="12">اسفند</option>
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-element-row">
                    <label class="label fs-7">روز</label>
                    <input onkeypress="return isNumber(event)" id="Brithday_day" value="" type="text"
                        class="form-control" placeholder="">
                </div>
            </div>
        </div>
    </div>
    <div class="remodal-footer">
        <button onclick="setValBrithday()" class="btn btn-sm btn-primary px-3">ثبت تاریخ تولد</button>
    </div>
</div>
<!-- end of personal-info-birth-modal -->