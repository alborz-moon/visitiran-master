<?php 

$top_categories = isset($top_categories) ? $top_categories : null;
$eventTags = isset($eventTags) ? $eventTags : null;

$general_categories = request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE ? $top_categories : $eventTags;

if($general_categories == null) {
  if(request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
    $general_categories = null;
  else
    $general_categories = App\Http\Resources\EventTagShare::collection(\App\Models\EventTag::visible()->get())->toArray(request());
}

?>

<div class="remodal remodal-xl" data-remodal-id="search-modal"
    data-remodal-options="hashTracking: false">
    <div class="remodal-content">
        <div class="search-container">
          <form action="#" class="search-form">
            <input min="3" id="searchInput" type="text" class="form-control search-field marginLeft48 searchInput" placeholder="جستجو کنید..">
          </form>
        </div>
        <button id="searchBtn" data-remodal-action="close" class="btn-search btn-action b-0 customSearch colorblue d-flex">
          <i class="icon-visit-close customSearch"></i>
        </button>
        @if(isset($general_categories))
          <div class="my-3">
              <div class="d-flex flexWrap gap10 defaultCatgories">
                @foreach ($general_categories as $cat)
                  @if(request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
                    <a href="{{ route('single-category', ['category' => $cat['id'], 'slug' => $cat['slug']]) }}" class="btn btn-search-modal">
                  @else
                    <a href="{{ route('event.single-category', ['tag' => $cat['id'], 'slug' => $cat['slug']]) }}" class="btn btn-search-modal">
                  @endif
                    {{ $cat['name'] }}
                  </a>
                @endforeach
              </div>
              <div class="afterCatgories d-flex flexWrap gap10">
                
              </div>
          </div>
        @endif
        <hr>
        <div class="searchDetails">
          
        </div>
        <div class="haveNotCat hidden">موردی یافت نشد!</div>
    </div>
</div>
<div id="parentSearchMobile" class="pt-4">
    <button id="closeSearch" onclick='$("#mainPageContent").css("marginTop", "-25px")' type="button" class="btn-close customCloseIconBanner p-0 position-absolute l-0 hidden zIndex1"></button>
    <div id="container-search" class="search-container p-2 hidden">
    <form action="#" class="search-form">
      <input min="3" id="searchInput" type="text" class="form-control search-field marginLeft48 searchInput" placeholder="جستجو کنید..">
    </form>
    
    @if(isset($general_categories))
      <div id="hiddenCat" class="my-3 hidden">
        <div class="d-flex flexWrap gap10 defaultCatgories">
          @foreach ($general_categories as $cat)
            @if(request()->getHost() == \App\Http\Controllers\Controller::$SHOP_SITE)
              <a href="{{ route('single-category', ['category' => $cat['id'], 'slug' => $cat['slug']]) }}" class="btn btn-search-modal">
            @else
              <a href="{{ route('event.single-category', ['tag' => $cat['id'], 'slug' => $cat['slug']]) }}" class="btn btn-search-modal">
            @endif
              {{ $cat['name'] }}
            </a>
          @endforeach
        </div>
        <div class="afterCatgories d-flex flexWrap gap10">
            
        </div>
      </div>
    @endif
    <hr>
    <div class="searchDetails">

    </div>
    <div class="haveNotCat hidden">موردی یافت نشد!</div>
    </div>
</div>

<script>
    $('.searchInput').on('keyup',function(){
        if (this.value.length > 2){
          $.ajax({
            type: 'post',
            url:  '{{ $route }}' ,
            data: {
              key: this.value,
              return_type: 'card' 
            },
            success: function(res) {
              var html= "";
              $('.defaultCatgories').addClass('hidden');
              if(res.status === "ok") {
                if (res.data.length != 0){
                    $(".haveNotCat").addClass('hidden');
                    for (var i = 0; i < res.data.length; i++){
                      html += '<div class="d-flex my-2 padding15">';
                      html += '<div class="icon-visit-search fontSize15 padding5"></div>';
                      html += '<div class="d-flex flexDirectionColumn">';
                      html += '<a href="' + res.data[i].href + '" class="fontSize14 colorBlack">' + res.data[i].name + '</a>';
                      html += '<div class="fontSize12 colorBlue">' + res.data[i].category + '</div>';
                      html += '</div>';
                      html += '</div>';
                    }
                  }else{
                    $(".haveNotCat").removeClass('hidden');
                  }
                  $(".searchDetails").empty().append(html);
                  
                }
             }
         });
         
         $.ajax({
          type: 'post',
          url:  '{{  $routeCat }}' ,
          data: {
             key: this.value,
          },
          success: function(res) {
            var html= "";
            if(res.status === "ok") {
               if(res.data.length != 0){
                 for(var i = 0; i < res.data.length; i++) {
                     html += '<a href="' + res.data[i].href + '" class="btn btn-search-modal whiteSpaceNoWrap">' + res.data[i].name + '</a>';
                 }
               }
            }
            $(".afterCatgories").empty().append(html);
          }
        });
      }else{
        $(".afterCatgories").empty();
        $(".searchDetails").empty()
        $('.defaultCatgories').removeClass('hidden');
        $(".haveNotCat").removeClass('hidden');
      }


    });

    $('#searchMobile').on('click',function(){
        $('#closeSearch').removeClass('hidden');
        $('#hiddenCat').removeClass('hidden');
        $('#parentSearchMobile').addClass('search-mobile').css('bottom','0');
        $('#searchMobile').removeClass('hidden');
        $('#container-search').removeClass('hidden');
        $('body').css('overflow','hidden');
    });
    $('#closeSearch').on('click',function(){
        $('#closeSearch').addClass('hidden');
        $('#hiddenCat').addClass('hidden');
        $('#container-search').addClass('hidden');
        $('#parentSearchMobile').addClass('search-mobile').css('bottom','-100%');
        $('body').css('overflow','auto');
    });
</script>