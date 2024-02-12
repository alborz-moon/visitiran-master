let total_height;
let containerId;
let top_offset;
let screen_height;
let next_call_h;
let row_height;
let fetch_more_func;
let lock;

function calc_H(call_back_func) {
    setTimeout(function () {
        let old_total_height = total_height;
        total_height = $("#" + containerId).height();
        top_offset = $("#" + containerId).offset().top;
        next_call_h = top_offset + total_height - screen_height - row_height;
        if (old_total_height !== undefined && old_total_height === total_height)
            lock = true;
        else lock = false;
        if (call_back_func !== undefined) call_back_func();
    }, 1000);
}

function init_lazy_loading(cId, rowH, fetchMore) {
    containerId = cId;
    row_height = rowH;
    fetch_more_func = fetchMore;
    screen_height = $(window).height();
    calc_H(observe_scroll);
}

function observe_scroll() {
    $(window).scroll(function (event) {
        if (lock) return;
        var scroll = $(window).scrollTop();
        if (scroll >= next_call_h) {
            lock = true;
            fetch_more_func(calc_H);
        }
    });
}
