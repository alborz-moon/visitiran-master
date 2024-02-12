<script>
     $(document).ready(function() {
        $.ajax({
            type: 'get',
            url: '{{ route('api.category.menu') }}',
            headers: {
                'accept': 'application/json'
            },
            success: function(res) {
                var htmlMobile= "";
                if(res.status == "ok") {
                    htmlMobile += '<li><a href="{{ route('home') }}" class="toggle-submenu afterContentNone">صفحه اصلی</a></li>';
                    for(var i = 0; i < res.data.length; i++) {
                        htmlMobile +='<li>';
                        if (res.data[i].subs.length != 0){
                            htmlMobile +='<a onclick="selectMenu(' + res.data[i].id + ')" href="#" class="toggle-submenu"><span>' + res.data[i].name + '</span></a>';
                        }
                        else{
                            htmlMobile +='<a onclick="selectMenu(' + res.data[i].id + ')" href="' + res.data[i].href + '" class="toggle-submenu afterContentNone"><span>' + res.data[i].name + '</span></a>';
                        }                        
                        if (res.data[i].subs.length != 0){
                            
                            htmlMobile +='<ul id="subMenu_oldFather_' + res.data[i].id + '" class="submenu">';
                            htmlMobile +='<li onclick="backMenu(' + res.data[i].id + ')" class="close-submenu"><i class="ri-arrow-right-s-line"></i>' + res.data[i].name + '</li>';
                            for (var j = 0; j < res.data[i].subs.length; j++){   
                                htmlMobile += '<li>';
                                if (res.data[i].subs[j].subs.length != 0){
                                    htmlMobile += '<a href="#" onclick="selectMenu(' + res.data[i].subs[j].id + ')" class="toggle-submenu">' + res.data[i].subs[j].name + '</a>';
                                }else{
                                    htmlMobile += '<a href="' + res.data[i].subs[j].href + '" onclick="selectMenu(' + res.data[i].subs[j].id + ')" class="toggle-submenu afterContentNone">' + res.data[i].subs[j].name + '</a>';
                                }
                                if (res.data[i].subs[j].subs.length != 0){
                                    htmlMobile += '<ul id="subMenu_Father_' + res.data[i].subs[j].id + '" class="submenu">';
                                    htmlMobile += '<li onclick="backMenu(' + res.data[i].subs[j].id + ')" class="close-submenu"><i class="ri-arrow-right-s-line"></i>' + res.data[i].subs[j].name + '</li>';
                                    for (var k = 0; k < res.data[i].subs[j].subs.length; k++){   
                                        htmlMobile += '<li><a href="' + res.data[i].subs[j].subs[k].href + '" onclick="selectMenu(' + res.data[i].subs[j].subs[k].id + ')" class="toggle-submenu afterContentNone">' + res.data[i].subs[j].subs[k].name + '</a>';
                                    }
                                htmlMobile += '</ul>';
                                }
                                htmlMobile += '</li>';
                            }
                            htmlMobile +='</ul>';
                        }
                        htmlMobile +='</li>';
                    }
                    htmlMobile += '<li><a href="{{ route('category.list', ['orderBy' => 'createdAt']) }}" class="toggle-submenu afterContentNone">پیشنهاد های ویژه</a></li>';
                    $("#moblieMenu").append(htmlMobile);
                }
            }
        });
    });  

    function selectMenu(idx){
        $("#subMenu_oldFather_" + idx).addClass('toggle');
        $("#subMenu_Father_" + idx).addClass('toggle');
    }
    function backMenu(idx){
        $("#subMenu_oldFather_" + idx).removeClass('toggle');
        $("#subMenu_Father_" + idx).removeClass('toggle');
    }

</script>