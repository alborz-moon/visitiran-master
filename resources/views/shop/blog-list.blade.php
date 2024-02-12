@extends('layouts.structure')
@section('content')
        <main class="page-content TopParentBannerMoveOnTop">
            <div class="container">
                <!-- start of box => contact-us -->
                <h3 class="mt-4 mb-5">تازه ها</h3>
                <div class="row mb-5">
                    <div class="col-lg-4">
                        <select id="distinctTags" class="select2 form-control jet-select__control w-100 py-2 px-5 customSearchBorder" name="category">
			        </select>   
                    </div>
                    <div class="col-lg-4">
                        <select id="orderBy" class="select2 form-control jet-sorting-select w-100 py-2 px-5 customSearchBorder" name="select-name">
						    <option value="-1">مرتب سازی</option>
						    <option value="header_asc">عنوان</option>
						    <option value="createdAt_desc">جدیدترین‌ها</option>
						    <option value="seen_desc">پربازدیدترین‌ها</option>
					    </select>
                    </div>
                    <div class="col-lg-4">
                        <input class="form-control jet-search-filter__input w-100 py-2 px-5 d-none d-lg-block customSearchBorder" type="search" autocomplete="off" value="" placeholder="جست‌وجو بر اساس کلمات کلیدی">
                    </div>    
               		
                </div>
                    <div class="container mb-5">
                        <div id="shimmer-blog-list" class="row">
                            @for($i = 0; $i < 5; $i++)
                            <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="cardBlog SimmerParent">
                            <a href="" class="w-100 p-3 pb-0">
                            <div class="d-flex ">
                                <div class="shimmerBG w-100 h-100" style="height:250px!important"></div>
                            </div>
                            </a>
                            <a href="" class="w-100 p-3"><div class="overFlowHidden mx-3 mb-3" style="height: 90px">
                                <div class="shimmerBG title-line m-2"></div>
                                <div class="shimmerBG content-line m-5"></div>
                            </div></a>
                            </div>
                            </div>
                            @endfor   
                        </div>
                        <div id="blogList" class="row blog-list-hidden">
                        </div>
                    </div>
            </div>
        </main>
@stop

@section('footer')
    @parent
@stop

@section('extraJS')
    @parent
    <script>
        
        $(document).ready(function() {

            filter();
            $(".blog-list-hidden").addClass('hidden');
            $("#shimmer-blog-list").removeClass('hidden');
            $("#distinctTags").on('change', function() {
               filter();
            });

            $("#orderBy").on('change', function() {
               filter();
            });

            function buildQuery() {
            
                let query = new URLSearchParams();
                
                let orderBy = $("#orderBy").val();
                let distinctTags = $('#distinctTags').val();

                if (distinctTags != null && distinctTags != -1)
                    query.append('tag', distinctTags);

                if(orderBy != -1) {
                    let s = orderBy.split('_');
                    query.append('orderBy', s[0]);
                    query.append('orderByType', s[1]);
                }
                return query;
            }
            $.ajax({
                type: 'get',
                url: '{{ route('api.blog.getDistinctTags') }}',
                success: function(res) {
                    var option = '<option value="-1">دسته بندی</option>';
                    if(res.status === "ok") {

                        for(var i = 0; i < res.tags.length; i++)
                            option += '<option value="' + res.tags[i] + '">' + res.tags[i] + '</option>';

                        $("#distinctTags").empty().append(option);
                    }
                }
            });

            function filter() {
                $.ajax({
                    type: 'get',
                    url: '{{ route('api.blog.list') }}' + "?" + buildQuery(),
                    success: function(res) {
                        var html = '';
                        $(".blog-list-hidden").empty().append(html).removeClass('hidden');
                        $("#shimmer-blog-list").addClass('hidden');
                        if(res.status === "ok") {
                            for(var i = 0; i < res.data.length; i++) {
                                html += '<div class="col-lg-4 col-md-6 col-sm-12 p-0">';
                                html += '<div class="cardBlog margin6">';
                                html += '<a href="' + res.data[i].href + '" class="w-100 p-3 pb-0">';
                                html += '<div class="d-flex">';
                                html += '<img class="w-100 h-100" src="' + res.data[i].img + '" style="height:250px!important" alt="' + res.data[i].alt + '">';
                                html += '</div>';
                                html += '</a>';
                                html += '<a href="' + res.data[i].href + '" class="w-100 p-3"><div class="overFlowHidden mx-3 mb-3" style="height: 90px">';
                                html += '<h6 class="colorBlack">' + res.data[i].header + '</h6>';
                                html += '<p class="colorBlack textAlignJustify">' + res.data[i].digest + '</p>';
                                html += '</div></a>';
                                html += '</div>';
                                html += '</div>';
                            }
                        $("#blogList").empty().append(html);
                    }
                    }
                });

            }
        });

    </script>

@stop