<span>
    @if ($product['is_bookmark'] == 0)
        <button id="bookmark" onclick="call_bookmark()" class="ri-bookmark-line fontSize30 b-0 colorWhiteGray btnHover backColorWhite"></button>
    @else
        <button  id="bookmark" onclick="call_bookmark()" class="ri-bookmark-fill fontSize30 b-0 colorYellow btnHover backColorWhite"></button>
    @endif
    <button data-remodal-target="share-modal" class="icon-visit-share fontSize30 b-0 colorWhiteGray btnHover backColorWhite"></button>
</span>


<script>
var $temp = $("<input>");
var $url = $(location).attr('href');

$('.clipboard').on('click', function() {
    $("body").append($temp);
    $temp.val($url).select();
    document.execCommand("copy");
    $temp.remove();
    // $("p").text("URL copied!");
});
    function call_bookmark() {
        let is_bookmark = $("#bookmark").hasClass('ri-bookmark-fill') ? 0 : 1;
        $.ajax({  
            type: 'post', 
            url: '{{ route('api.product.comment.store', ['product' => $product['id']]) }}',  
            data: {   
                'is_bookmark': is_bookmark,  
            },
            success: function(res) {  
                if(res.status === "ok") {
                    if(is_bookmark == 1)
                        $("#bookmark").removeClass('ri-bookmark-line')
                            .addClass('ri-bookmark-fill colorYellow');
                    else
                        $("#bookmark")
                            .removeClass('ri-bookmark-fill')
                            .removeClass('colorYellow')
                            .addClass('ri-bookmark-line colorWhiteGray');
                }
            }
        });
    }
    $(document).ready(function() {

    $('#telegram').click(function(){
        $('.share-link-telegram').attr("href","https://telegram.me/share/url?url=" + $url + "&text=سایت میراث");
    });

    $('#whatsapp').click(function(){
        $('.share-link-telegram').attr("href","https://telegram.me/share/url?url=" + $url + "&text=سایت میراث");
    });

});
</script>
