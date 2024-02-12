<ul id='menu'>
    {{-- <li class="mega-menu-category show">
            <a href="#">صفحه های طراحی شده</a>
            <ul class="mega-menu">
                <li class="parent"><a class="colorBlue customBold" href="#">صفحه زده شده </a></li>
                <li><a href="{{route('404')}}"">404</a></li>
                <li><a href="{{route('cart-empty')}}">سبد خرید خالی</a></li>
            </ul>
        </li>
        <li class="mega-menu-category">
            <a href="#">دسته بندی محصولات</a>
            <ul class="mega-menu">
                <li class="parent"><a class="colorBlue customBold" href="#">فرش</a></li>
                <li><a href="#">منسوجات</a></li>
            </ul>
        </li>
        <li><a href="#">فرش</a></li>
        <li><a href="#">ابزار</a></li> --}}
</ul>


<script>
     $(document).ready(function() {
        $.ajax({
            type: 'get',
            url: '{{ route('api.category.menu') }}',
            headers: {
                'accept': 'application/json'
            },
            success: function(res) {
                var html= "";
                var htmlMobile="";
                if(res.status == "ok") {

                    for(var i = 0; i < res.data.length; i++) {
                        if (i==0) {
                            html += '<li class="mega-menu-category show">';
                        }
                        else{
                            html += '<li class="mega-menu-category">';
                        }
                        html += '<a href="' + res.data[i].href + '">' + res.data[i].name + '</a>';
                        if (res.data[i].subs.length != 0){
                            html += '<ul class="mega-menu">';
                            for(var j = 0; j < res.data[i].subs.length; j++) {
                                    html += '<li class="parent"><a class="colorBlue customBold" href="' + res.data[i].subs[j].href + '">' + res.data[i].subs[j].name + '</a>';
                                if (res.data[i].subs[j].subs.length != 0){
                                    for(var k = 0; k < res.data[i].subs[j].subs.length; k++) {
                                        html += '<li><a href="' + res.data[i].subs[j].subs[k].href + '">' + res.data[i].subs[j].subs[k].name + '</a></li>';
                                    }
                                }
                            }
                            html += '</ul>';
                        }
                        html += '</li>';
                    }
                    $("#menu").empty().append(html);
                }
            }
        });
    });

    $(document).on('mouseenter', '.mega-menu-category', function() {
        $('.mega-menu-category').removeClass('show');
        $(this).addClass('show');
    });
    

</script>