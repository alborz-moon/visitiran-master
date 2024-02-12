<div class="textAlignEnd">
    @if ($is_bookmark == 0)
        <button id="bookmark" onclick="call_bookmark()" class="ri-bookmark-line fontSize30 b-0 colorWhiteGray btnHover backColorWhite"></button>
    @else
        <button  id="bookmark" onclick="call_bookmark()" class="ri-bookmark-fill fontSize30 b-0 colorYellow btnHover backColorWhite"></button>
    @endif
    <button data-remodal-target="share-modal" class="icon-visit-share fontSize30 b-0 colorWhiteGray btnHover backColorWhite"></button>
</div>
<div class="remodal remodal-xs remodal-is-initialized remodal-is-opened hiddenbtnShare hidden" data-remodal-id="share-modal" data-remodal-options="hashTracking: false" tabindex="-1">
    <div class="remodal-header">
        <div class="remodal-title">اشتراک‌ گذاری</div>
        <button data-remodal-action="close" class="remodal-close"></button>
    </div>
    <div class="remodal-content">
        <div class="text-muted fs-7 fw-bold mb-3">
            با استفاده از روش‌های زیر می‌توانید این صفحه را با دوستان خود به اشتراک بگذارید.
        </div>
        <div id="showModal" class="d-flex align-items-center border-top  py-3 mb-3">
            <div class="widget flex-grow-1 border-0 p-0 me-2">
                <div class="widget-content widget-socials">
                    <ul  class="align-items-center">
                        <li>
                            <a id="whatsapp" href="#" class="d-inline-flex share-link" data-action="share/whatsapp/share" target="_blank"><i class="ri-whatsapp-fill"></i></a>
                        </li>
                        <li>
                            <a id="telegram" class="d-inline-flex share-link-telegram"><i class="ri-telegram-fill"></i></a>
                        </li>
                        <li>
                            <a href="#" id="instagram" class="d-inline-flex share-link-instagram"><i class="ri-instagram-fill"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="btn btn-sm btn-primary copy-url-btn clipboard" data-copy="">کپی لینک
            </div> 
        </div>
    </div>
</div>

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
            url: '{{ route('event.event_comment.store', ['event' => $event['id']]) }}',  
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
        $('.hiddenbtnShare').removeClass('hidden');
        $('#telegram').click(function(){
            $(this).attr("href","https://telegram.me/share/url?url=" + $url + "&text=سایت میراث");
        });

        $('#whatsapp').click(function(){
            $(this).attr("href","whatsapp://send?text=" + $url +"");
        });

        $('#instagram').click(function(){
            $(this).attr("href", "https://www.instagram.com/sharer.php?u=" + $url +"");
        });
});
</script>