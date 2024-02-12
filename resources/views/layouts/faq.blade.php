<div class="container mb-5" style="direction: rtl">
    <div class="bg-white">
        <div class="d-flex spaceBetween alignItemsCenter">
            <span class="ui-box-title fontSize20"> 
                <img class="p-2" src="{{ asset('./theme-assets/images/svg/headlineTitle.svg') }}" alt="">
                مرام نامه اصالت و کیفیت
            </span>
        </div>
            <div class="ui-box-content">
                <div  class="accordion" id="accordionExample">
                        <div id="faq" class="accordion-item b-0"></div>
                </div>
            </div>
    </div>
</div>

<script>
    
    $.ajax({
        type: 'get',
        url: '{{ route('api.faq') }}',
        headers: {
            'accept': 'application/json'
        },
        success: function(res) {
            if(res.status === "ok") {
                var html = "";
                for(var i = 0; i < res.data.length; i++) {
                    html += '<h2 class="accordion-header" id="heading' + res.data[i].id + '">';
                    html += '<button class="accordion-button collapsed pb-3 " type="button" data-bs-toggle="collapse" data-bs-target="#collapse' + res.data[i].id + '" aria-expanded="true" aria-controls="collapse' + res.data[i].id + '">';
                    html += res.data[i].title + '</button></h2>';
                    html += '<div id="collapse' + res.data[i].id + '" class="accordion-collapse collapse" aria-labelledby="heading' + res.data[i].id + '" data-bs-parent="#accordionExample">';
                    html += '<div class="accordion-body">' + res.data[i].description + '</div>';
                    html += '</div>';
                }
                $("#faq").empty().append(html);
            }
        }
    });

</script>