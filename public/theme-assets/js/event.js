function fetchData(url, key, id, not_fill_id, searchable = false) {
    $.ajax({
        type: "get",
        url: url,
        success: function (res) {
            let html = renderEventSlider(res.data, key);

            if (searchable) {
                $("#" + key + "sSlider > .swiper-slide").remove();
                $("#" + key + "sSlider")
                    .append(html)
                    .removeClass("hidden");
            } else {
                $("#" + key + "sSlider")
                    .empty()
                    .append(html)
                    .removeClass("hidden");
            }

            $("#" + not_fill_id).remove();
            $("#" + id).removeClass("hidden");

            const productSpecialsSwiperSlider = new Swiper(
                "." + key + "-product-swiper-slider",
                {
                    // Optional parameters
                    spaceBetween: 10,

                    // Navigation arrows
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },

                    breakpoints: {
                        1200: {
                            slidesPerView: 3.5,
                        },
                        992: {
                            slidesPerView: 3,
                            spaceBetween: 10,
                        },
                        576: {
                            slidesPerView: 2.4,
                            spaceBetween: 5,
                        },
                        480: {
                            slidesPerView: 1,
                            spaceBetween: 8,
                        },
                    },
                }
            );
        },
    });
}

function fetchLaunchers(url, key, id, not_fill_id, searchable = false) {
    $.ajax({
        type: "get",
        url: url,
        success: function (res) {
            let html = renderLauncherSlider(res.data, key);

            if (searchable) {
                $("#" + key + "sSlider > .swiper-slide").remove();
                $("#" + key + "sSlider")
                    .append(html)
                    .removeClass("hidden");
            } else {
                $("#" + key + "sSlider")
                    .empty()
                    .append(html)
                    .removeClass("hidden");
            }

            $("#" + not_fill_id).remove();
            $("#" + id).removeClass("hidden");

            const productSpecialsSwiperSlider = new Swiper(
                "." + key + "-product-swiper-slider",
                {
                    // Optional parameters
                    spaceBetween: 10,

                    // Navigation arrows
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },

                    breakpoints: {
                        1200: {
                            slidesPerView: 3.5,
                        },
                        992: {
                            slidesPerView: 3,
                            spaceBetween: 10,
                        },
                        576: {
                            slidesPerView: 2.4,
                            spaceBetween: 5,
                        },
                        480: {
                            slidesPerView: 1,
                            spaceBetween: 8,
                        },
                    },
                }
            );
        },
    });
}
