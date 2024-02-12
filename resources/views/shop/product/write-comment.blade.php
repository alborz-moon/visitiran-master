{{-- Modal     --}}
<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <div class="d-felx flexDirectionColumn">
            <div class="d-flex">
                <h5 class="modal-title" id="commentModalLabel">دیدگاه شما</h5>       
            </div>                                     
            <div class="d-flex">
                <img class="b-0 commentImageProduct" src="{{ $itemImg }}" alt="" />
                <h5 class="fontSize16 align-self-end fontNormal mt-1 mr-15">{{ $itemName }}</h5>
            </div>
            </div>
          <button id="close-comment-modal-btn" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-0">
  <main class="page-content p-0">
      <div class="container">
          <!-- start of box -->
          <div class="ui-box bg-white product-detail-container p-0 b-0 boxShadowNone">
              <div class="ui-box-content">
                  <div class="row">
                      <div class="col-md-6 mb-md-0 mb-4">
                          <div class="add-comment-product">
                              <!-- start of form-element -->
                              <div class="d-flex justify-content-center align-items-center">
                                  @include('layouts.ratting')
                              </div>
                              <!-- end of form-element -->
                              <!-- start of form-element -->
                              <div class="form-element-row mb-3">
                                  <label class="label">نقاط قوت</label>
                                  <div class="add-point-container" id="advantages">
                                      <div class="add-point-field">
                                          <input type="text" class="form-control" id="advantage-input"
                                              autocomplete="off">
                                          <button id="add-advantage-input" type="button"
                                              class="btn btn-primary btn-add-point js-icon-form-add"><i
                                                  class="ri-add-line"></i></button>
                                      </div>
                                      <div class="comment-dynamic-labels js-advantages-list"></div>
                                  </div>
                              </div>
                              <!-- end of form-element -->
                              <!-- start of form-element -->
                              <div class="form-element-row mb-3">
                                  <label class="label">نقاط ضعف</label>
                                  <div class="add-point-container" id="disadvantages">
                                      <div class="add-point-field">
                                          <input type="text" class="form-control" id="disadvantage-input"
                                              autocomplete="off">
                                          <button id="add-disadvantage-input" type="button"
                                              class="btn btn-primary btn-add-point js-icon-form-add"><i
                                                  class="ri-add-line"></i></button>
                                      </div>
                                      <div class="comment-dynamic-labels js-disadvantages-list"></div>
                                  </div>
                              </div>
                              <!-- end of form-element -->
                              <!-- start of form-element -->
                              <div class="form-element-row mb-3">
                                  <label class="label">متن نظر شما </label>
                                  <textarea id="comment-msg" rows="5" class="form-control"
                                      placeholder="متن نظر خود را بنویسید.."></textarea>
                              </div>
                              <!-- end of form-element -->
                          </div>
                          
                      </div>
                      <div class="col-md-6 p-0">
                          <div class="fs-8 fw-bold text-dark mb-3 fontSize14">
                              دیگران را با نوشتن نظرات خود، برای انتخاب این محصول راهنمایی کنید.
                          </div>
                          <div class="fs-7 fw-bold text-info mb-3 font400 fontSize12 colorYellow">
                              لطفا پیش از ارسال نظر، خلاصه قوانین زیر را مطالعه کنید:
                          </div>
                          <ul class="ps-4 text-secondary">
                              <li class="mb-3">لازم است محتوای ارسالی منطبق برعرف و شئونات جامعه و با بیانی رسمی و
                                  عاری از لحن
                                  تند، تمسخرو توهین باشد.</li>
                              <li class="mb-3">از ارسال لینک‌های سایت‌های دیگر و ارایه‌ی اطلاعات شخصی خودتان مثل
                                  شماره تماس،
                                  پست الکترونیک و آی‌دی شبکه‌های اجتماعی پرهیز کنید.</li>
                              <li class="mb-3">در نظر داشته باشید هدف نهایی از ارائه‌ی نظر درباره‌ی کالا ارائه‌ی
                                  اطلاعات مشخص و
                                  دقیق برای راهنمایی سایر کاربران در فرآیند خرید یک محصول توسط ایشان است.</li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
          <!-- end of box -->
      </div>
  </main>
        </div>
        <div class="modal-footer between">
            <div class="d-flex align-items-center justify-content-between flex-wrap">
              <div>
                با “ثبت نظر” موافقت خود را با <a href="#" class="link">قوانین انتشار نظرات</a>
                در سایت اعلام می‌کنم.
              </div>
          </div>
          <div class="text-end">
                <a href="#" class="textColor" data-bs-dismiss="modal">انصراف و بازگشت</a>
              <button  id="submitComment" class="btn btn-primary msgComment">ثبت نظر</button>
          </div>
          </div>
      </div>
    </div>
  </div>

  <script>

    let advantages = [];
    let disadvantages = [];



    $("#submitComment").on('click', function() {
        $(".js-advantages-list").children('.js-advantage-item').each(function() {
            advantages.push($(this).text().replace("\n", ""));
        });
        $(".js-disadvantages-list").children('.js-disadvantage-item').each(function() {
            disadvantages.push($(this).text().replace("\n", ""));
        });

        let data = {};
        
         let msg = $("#comment-msg").val();
         if(msg.length == 0) {
            showErr("لطفا قسمت متن نظر را خالی نگذارید !");
            return;
         }    

         if(advantages.length > 0)
            data.positive = advantages;
        
        if(disadvantages.length > 0)
            data.negative = disadvantages;
            data.msg = msg;
        if($("#comment-rate").attr('data-rate') !== undefined)
            data.rate = $("#comment-rate").attr('data-rate');

        $.ajax({
            type: 'post',
            url: '{{ $sendComment }}',
            data: data,  
            success: function(res) {
                if(res.status === 'ok') {
                    showSuccess("دیدگاه شما ثبت شد!");
                    $("#close-comment-modal-btn").click();
                }
            }
        });

    });

  </script>