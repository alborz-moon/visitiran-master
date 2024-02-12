let page = 1;

function buildQuery() {
    let query = new URLSearchParams();
    if (cat != "-1") query.append("tag", cat);

    let off = $("#has_selling_offs").prop("checked") ? 1 : 0;
    // let min = $("#has_selling_stock").prop("checked") ? 1 : 0;
    let minPrice = $("#skip-value-lower").val().replaceAll(",", "");
    let maxPrice = $("#skip-value-upper").val().replaceAll(",", "");
    // let orderBy = $("#orderBy").val();
    let searchKey = $("#searchBoxInput").val();

    var total_filters_count = 0;

    // if (min > 0) query.append("min", min);

    if (minPrice !== "") query.append("minPrice", minPrice);

    if (maxPrice !== "") query.append("maxPrice", maxPrice);

    // if (off !== 0) query.append("off", off);

    // if (orderBy === "sell_count_desc") {
    //     query.append("orderBy", "sell_count");
    //     query.append("orderByType", "desc");
    // } else {
    //     let s = orderBy.split("_");
    //     query.append("orderBy", s[0]);
    //     query.append("orderByType", s[1]);
    // }

    if (searchKey !== "") query.append("key", searchKey);

    let tags = [];
    $("input[name='tags']").each(function () {
        if ($(this).prop("checked")) tags.push($(this).attr("value"));
    });
    if (tags.length > 0) {
        $("#tags_filters_count_container").removeClass("hidden");
        $("#tags_filters_count").empty().append(tags.length);
        query.append("tag", tags);
        total_filters_count += tags.length;
    } else {
        $("#tags_filters_count_container").addClass("hidden");
    }

    let levels = [];
    $("input[name='levels']").each(function () {
        if ($(this).prop("checked")) levels.push($(this).attr("value"));
    });

    if (levels.length > 0) {
        $("#levels_filters_count_container").removeClass("hidden");
        $("#levels_filters_count").empty().append(levels.length);
        query.append("levels", levels);
        total_filters_count += levels.length;
    } else {
        $("#levels_filters_count_container").addClass("hidden");
    }

    let types = [];
    $("input[name='types']").each(function () {
        if ($(this).prop("checked")) types.push($(this).attr("value"));
    });

    if (types.length > 0) {
        $("#types_filters_count_container").removeClass("hidden");
        $("#types_filters_count").empty().append(types.length);
        query.append("types", types);
        total_filters_count += types.length;
    } else {
        $("#types_filters_count_container").addClass("hidden");
    }

    let facilities = [];
    $("input[name='facilities']").each(function () {
        if ($(this).prop("checked")) facilities.push($(this).attr("value"));
    });
    if (facilities.length > 0) {
        $("#facilities_filters_count_container").removeClass("hidden");
        $("#facilities_filters_count").empty().append(facilities.length);
        query.append("facilities", facilities);
        total_filters_count += facilities.length;
    } else {
        $("#facilities_filters_count_container").addClass("hidden");
    }

    let langs = [];
    $("input[name='langs']").each(function () {
        if ($(this).prop("checked")) langs.push($(this).attr("value"));
    });
    if (langs.length > 0) {
        $("#langs_filters_count_container").removeClass("hidden");
        $("#langs_filters_count").empty().append(langs.length);
        query.append("languages", langs);
        total_filters_count += langs.length;
    } else {
        $("#langs_filters_count_container").addClass("hidden");
    }

    let launchers = [];
    $("input[name='launchers']").each(function () {
        if ($(this).prop("checked")) launchers.push($(this).attr("value"));
    });
    if (launchers.length > 0) {
        $("#launchers_filters_count_container").removeClass("hidden");
        $("#launchers_filters_count").empty().append(launchers.length);
        query.append("launchers", launchers);
        total_filters_count += launchers.length;
    } else {
        $("#launchers_filters_count_container").addClass("hidden");
    }

    let cities = [];
    $("input[name='cities']").each(function () {
        if ($(this).prop("checked")) cities.push($(this).attr("value"));
    });
    if (cities.length > 0) {
        $("#cities_filters_count_container").removeClass("hidden");
        $("#cities_filters_count").empty().append(cities.length);
        query.append("cities", cities);
        total_filters_count += cities.length;
    } else {
        $("#cities_filters_count_container").addClass("hidden");
    }

    if (total_filters_count > 0) {
        $("#total_filters").removeClass("hidden");
        $("#remove_all_filters").removeClass("hidden");
        $("#total_filters_count").empty().append(total_filters_count);
        $(".remove_all_filters").removeClass("hidden");
        $("#total_filters_count_mobile").empty().append(total_filters_count);
    } else {
        $("#total_filters").addClass("hidden");
        $("#remove_all_filters").addClass("hidden");
        $(".remove_all_filters").addClass("hidden");
    }

    return query;
}

function fetchMore(call_back) {
    page++;
    $.ajax({
        type: "get",
        url: LIST_API + "?page=" + page + "&" + buildQuery().toString(),
        success: function (res) {
            if (res.status !== "ok") return;
            var length = res.data.length;
            if (length == 0) {
                return;
            }
            let html = renderProducts(res.data, "sample");
            $("#events_div").append(html).removeClass("hidden");
            call_back();
        },
    });
}

function filter() {
    $("#events_div").addClass("hidden");
    $("#shimmer").removeClass("hidden");

    $.ajax({
        type: "get",
        url: LIST_API + "?" + buildQuery().toString(),
        success: function (res) {
            if (res.status !== "ok") return;

            var length = res.data.length;
            if (length == 0) {
                $("#shimmer").addClass("hidden");
                $("#nothingToShow").removeClass("hidden");
                return;
            }
            let html = renderEvents(res.data, "sampleEvent");
            $("#events_div").empty().append(html).removeClass("hidden");
            $("#shimmer").addClass("hidden");
            $("#nothingToShow").addClass("hidden");
            $("#total_count")
                .empty()
                .append(length + " رویداد");
        },
    });
}

function renderEvents(data, prefix) {
    let html = "";
    if (data === undefined) return "";

    data.forEach((elem) => {
        setEventVals(prefix, elem);
        let id = elem.id;

        var newElem = $("#sample_event_div").html();

        newElem = newElem
            .replace(prefix + "Img", prefix + "Img_" + id)
            .replace(prefix + "Header", prefix + "Header_" + id)
            .replace(prefix + "Tag", prefix + "Tag_" + id)
            .replace(prefix + "Critical", prefix + "Critical_" + id)
            .replace(prefix + "CriticalCount", prefix + "CriticalCount_" + id)
            .replace(prefix + "Rate", prefix + "Rate_" + id)
            .replace(prefix + "MultiColor", prefix + "MultiColor_" + id);

        html +=
            "<div onclick=\"event_redirect('" +
            id +
            "', '" +
            elem.slug +
            '\')" class="cursorPointer eventHandleInMedia">' +
            newElem +
            "</div>";
    });

    return html;
}

$(document).ready(function () {
    $(document).on("change", "input[name='langs']", function () {
        filter();
    });
    $(document).on("change", "input[name='levels']", function () {
        filter();
    });
    $(document).on("change", "input[name='facilities']", function () {
        filter();
    });
    $(document).on("change", "input[name='launchers']", function () {
        filter();
    });
    $(document).on("change", "input[name='cities']", function () {
        filter();
    });
    $(document).on("change", "input[name='types']", function () {
        filter();
    });
    $(document).on("change", "input[name='tags']", function () {
        filter();
    });
});

function clearAllFilters() {
    $("input[name='types']").prop("checked", false);
    $("input[name='cities']").prop("checked", false);
    $("input[name='tags']").prop("checked", false);
    $("input[name='launchers']").prop("checked", false);
    $("input[name='facilities']").prop("checked", false);
    $("input[name='levels']").prop("checked", false);
    $("input[name='langs']").prop("checked", false);
    $("#has_selling_stock").prop("checked", false);
    $("#has_selling_offs").prop("checked", false);
    $("#searchBoxInput").val("");
    $("#skip-value-lower").val(defaultMinPrice);
    $("#skip-value-upper").val(defaultMaxPrice);

    $(".noUi-connect").css("transform", "translate(0%, 0px) scale(1, 1)");
    $(".noUi-origin").first().css("transform", "translate(0, 0px)");
    $(".noUi-origin:last-child").css("transform", "translate(-1000%, 0px)");
    $(".noUi-handle-lower")
        .attr("aria-valuenow", parseInt(defaultMinPrice.replaceAll(",", "")))
        .attr("aria-valuetext", defaultMinPrice);

    $(".noUi-handle-upper")
        .attr("aria-valuenow", parseInt(defaultMaxPrice.replaceAll(",", "")))
        .attr("aria-valuetext", defaultMaxPrice);

    filter();
}
