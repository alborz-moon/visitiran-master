@extends('admin.layouts.create')

@section('title')
{{ isset($item) ? 'ویرایش ویژگی' . ' > ' . $categoryName : 'افزودن ویژگی' . ' > ' . $categoryName}}
@stop

@section('form')


    <form id="myForm" action="{{ isset($item) ? route('feature.update', ['feature' => $item['id']]) : route('category.features.store', ['category' => $categoryId])}}" method="post">
        {{ csrf_field() }}

        <div class="flex flex-col center gap10" style="margin: 10px">

            <div>
                <label for="name">نام</label>
                <input {{ isset($item) ? '' : 'required' }} value="{{ isset($item) ? $item['name'] : '' }}" type="text" name="name" id="name" />
            </div>
            
            <div>
                <label for="answer_type">نوع ویژگی</label>
                <select name="answer_type" id="answer_type">
                    <option {{ isset($item) && !$item['answer_type'] == 'text' ? 'selected' : '' }} value="text">متنی</option>
                    <option {{ isset($item) && $item['answer_type'] == 'longtext' ? 'selected' : '' }} value="longtext">متن بلند</option>
                    <option {{ isset($item) && $item['answer_type'] == 'multi_choice' ? 'selected' : '' }} value="multi_choice">چند گزینه ای</option>
                    <option {{ isset($item) && $item['answer_type'] == 'number' ? 'selected' : '' }} value="number">عدد</option>
                </select>
            </div>

            <div id="choices" class="{{ isset($item) && $item['answer_type'] == 'multi_choice' ? '' : 'hidden'}}" style="display: block; text-align: right; width: calc(100% - 10px)">

                <div id="choices_inputs">
                    @if(isset($item) && isset($item['choices']))
                    <?php $i = 0; ?>
                        
                        @foreach ($item['choices'] as $choice)
                            <input type='hidden' name='choices[{{ $i }}][key]' value='{{ $choice['key'] }}'>
                            <input type='hidden' name='choices[{{ $i }}][label]' value='{{ $choice['label'] }}'>
                            
                            <?php $i++; ?>
                        @endforeach
                        
                    @endif
                </div>

                <div>
                    <label style="width: 150px" for="choices_count">تعداد گزینه</label>
                    <select id="choices_count" style="width: calc(100% - 180px);">
                        <option value="0">انتخاب کنید</option>
                        @for($i = 0; $i < 20; $i++)
                            <option {{ isset($item) && isset($item['choices']) && count($item['choices']) == $i + 1 ? 'selected' : '' }} value={{ $i + 1 }}>{{ $i + 1 }}</option>
                        @endfor
                    </select>
                </div>
                <div id="choices_div">
                    @if(isset($item) && isset($item['choices']))
                    
                        <?php $i = 0; ?>
                        @foreach ($item['choices'] as $choice)
                            <div style="margin-top: 20px">
                                <label style="width: 250px" for="choices_{{ $i + 1 }}_key">
                                    مقدار گزینه {{ $i + 1 }}
                                </label>
                                <input data-id='{{ $i + 1 }}' class="choice_key" id="choices_{{ $i + 1 }}_key" value="{{ $choice['key'] }}" type="text">
                            </div>

                            <div style="margin-top: 20px">
                                <label style="width: 250px" for="choices_{{ $i + 1 }}_label">
                                    نحوه نمایش گزینه {{ $i + 1 }}
                                </label>
                                <input data-id='{{ $i + 1 }}' class="choice_label" id="choices_{{ $i + 1 }}_label" value="{{ $choice['label'] }}" type="text">
                            </div>
                            
                            <?php $i++; ?>
                        @endforeach
                    @endif

                </div>
            </div>

            <div>
                <label for="unit">واحد</label>
                <input value="{{ isset($item) ? $item['unit'] : '' }}" type="text" placeholder="این فیلد اختیاری است" name="unit" id="unit" />
            </div>
            
            <div>
                <label for="priority">اولویت</label>
                <input value="{{ isset($item) ? $item['priority'] : '' }}" type="number" name="priority" id="priority" />
            </div>

            <div>
                <label for="show_in_top">آیا این ویژگی کلیدی است؟</label>
                <select name="show_in_top" id="show_in_top">
                    <option {{ isset($item) && !$item['show_in_top'] ? 'selected' : '' }} value="0">خیر</option>
                    <option {{ isset($item) && $item['show_in_top'] ? 'selected' : '' }} value="1">بله</option>
                </select>
            </div>
            
            <div class="hidden needMultiChoice">
                <label for="effect_on_price">آیا این ویژگی در قیمت محصول تاثیر دارد؟</label>
                <select name="effect_on_price" id="effect_on_price">
                    <option {{ isset($item) && !$item['effect_on_price'] ? 'selected' : '' }} value="0">خیر</option>
                    <option {{ isset($item) && $item['effect_on_price'] ? 'selected' : '' }} value="1">بله</option>
                </select>
            </div>
            
            <div class="hidden needMultiChoice">
                <label for="effect_on_available_count">آیا این ویژگی در موجودی محصول تاثیر دارد؟</label>
                <select name="effect_on_available_count" id="effect_on_available_count">
                    <option {{ isset($item) && !$item['effect_on_available_count'] ? 'selected' : '' }} value="0">خیر</option>
                    <option {{ isset($item) && $item['effect_on_available_count'] ? 'selected' : '' }} value="1">بله</option>
                </select>
            </div>

        </div>

        <div class="flex center gap10">
            <span onclick="document.location.href = '{{ route('category.features.index', ['category' => $categoryId]) }}'" class="btn btn-danger">بازگشت</span>
            <input value="ذخیره" type="submit" class="btn green" id="saveBtn" />
        </div>

    </form>

    <script>

        var choices;

        $(document).ready(function() {

            @if(isset($item) && isset($item['choices']))
                choices = [];
                
                @for ($i = 0; $i < count($item['choices']); $i++)
                    choices.push({key: '{{ $item['choices'][$i]['key'] }}', label: '{{ $item['choices'][$i]['label'] }}'});
                @endfor

            @endif

            $('#answer_type').on('change', function() {
                if($(this).val() === "multi_choice") {
                    $("#choices").removeClass('hidden');
                    $(".needMultiChoice").removeClass('hidden');
                }
                else {
                    $("#choices").addClass('hidden');
                    $(".needMultiChoice").addClass('hidden');
                }
            });

            $("#choices_count").on('change', function() {
                
                choices = [];

                var choices_count = $(this).val();
                var html = '';

                for(var i = 1; i <= choices_count; i++) {
                    
                    choices.push({key: null, label: null});

                    html += '<div style="margin-top: 20px"><label style="width: 250px" for="choices_' + i + '_key">مقدار گزینه ' + i + '</label><input data-id=' + i + ' class="choice_key" id="choices_' + i + '_key" type="text"></div>';
                    html += '<div style="margin-top: 20px"><label style="width: 250px" for="choices_' + i + '_label">نحوه نمایش گزینه ' + i + '(اختیاری)</label><input data-id=' + i + ' class="choice_label" id="choices_' + i + '_label" type="text"></div>';
                }

                $("#choices_div").empty().append(html);
            });

            $(document).on('keyup', '.choice_key', function() {
                choices[parseInt($(this).attr('data-id')) - 1].key = $(this).val();
                test();
            });
            
            $(document).on('keyup', '.choice_label', function() {
                choices[parseInt($(this).attr('data-id')) - 1].label = $(this).val();
                test();
            });

            function test() {
                var html = "";
                choices.forEach((element, index) => {
                    html += "<input type='hidden' name='choices[" + index + "][key]' value='" + element.key + "'>"
                    html += "<input type='hidden' name='choices[" + index + "][label]' value='" + element.label + "'>"
                });
                $("#choices_inputs").empty().append(html);
            }

        });

    </script>
@stop