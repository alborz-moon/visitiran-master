let page = 1;

function buildQuery() {
    let query = new URLSearchParams();
    if (catId != "-1") query.append("parent", catId);

    let off = $("#has_selling_offs").prop("checked") ? 1 : 0;
    let min = $("#has_selling_stock").prop("checked") ? 1 : 0;

    let maxPrice;
    let minPrice;

    if (defaultMaxPrice == -1 || defaultMinPrice == -1) {
        maxPrice = "";
        minPrice = "";
    } else {
        maxPrice = $("#skip-value-upper").val().replaceAll(",", "");
        minPrice = $("#skip-value-lower").val().replaceAll(",", "");
    }

    let orderBy = $("#orderBy").val();
    let searchKey = $("#searchBoxInput").val();

    var total_filters_count = 0;

    if (min > 0) query.append("min", min);

    if (minPrice !== "") query.append("minPrice", minPrice);

    if (maxPrice !== "") query.append("maxPrice", maxPrice);

    if (off !== 0) query.append("off", off);

    if (orderBy === "sell_count_desc") {
        query.append("orderBy", "sell_count");
        query.append("orderByType", "desc");
    } else {
        let s = orderBy.split("_");
        query.append("orderBy", s[0]);
        query.append("orderByType", s[1]);
    }

    if (searchKey !== "") query.append("key", searchKey);

    let categories = [];
    $("input[name='categories']").each(function () {
        if ($(this).prop("checked")) categories.push($(this).attr("value"));
    });
    if (categories.length > 0) {
        $("#categories_filters_count_container").removeClass("hidden");
        $("#categories_filters_count").empty().append(categories.length);
        query.append("category", categories);
        total_filters_count += categories.length;
    } else {
        $("#categories_filters_count_container").addClass("hidden");
    }

    let sellers = [];
    $("input[name='sellers']").each(function () {
        if ($(this).prop("checked")) sellers.push($(this).attr("value"));
    });

    if (sellers.length > 0) {
        $("#sellers_filters_count_container").removeClass("hidden");
        $("#sellers_filters_count").empty().append(sellers.length);
        query.append("seller", sellers);
        total_filters_count += sellers.length;
    } else {
        $("#sellers_filters_count_container").addClass("hidden");
    }

    let brands = [];
    $("input[name='brands']").each(function () {
        if ($(this).prop("checked")) brands.push($(this).attr("value"));
    });
    if (brands.length > 0) {
        $("#brands_filters_count_container").removeClass("hidden");
        $("#brands_filters_count").empty().append(brands.length);
        query.append("brand", brands);
        total_filters_count += brands.length;
    } else {
        $("#brands_filters_count_container").addClass("hidden");
    }

    var features = [];
    $("select[name='feature_filter']").each(function () {
        var selected = $(this).find(":selected").val();
        if (selected === "all") return;
        var featureId = $(this).attr("data-id");
        features.push(featureId + "_" + selected);
    });
    if (features.length > 0) {
        $("#features_filters_count_container").removeClass("hidden");
        $("#features_filters_count").empty().append(brands.length);
        query.append("features", features);
        total_filters_count += features.length;
    } else {
        $("#features_filters_count_container").addClass("hidden");
    }

    if (total_filters_count > 0) {
        $("#total_filters").removeClass("hidden");
        $("#remove_all_filters").removeClass("hidden");
        $(".remove_all_filters").removeClass("hidden");
        $("#total_filters_count").empty().append(total_filters_count);
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
            $("#products_div").append(html).removeClass("hidden");

            call_back();
        },
    });
}

function filter() {
    $("#products_div").addClass("hidden");
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
            let html = renderProducts(res.data, "sample");
            $("#products_div").empty().append(html).removeClass("hidden");
            $(".customBorderBoxShadow").addClass("minWidth200");
            $("#shimmer").addClass("hidden");
            $("#nothingToShow").addClass("hidden");
            $("#total_count")
                .empty()
                .append(res.count + " کالا");
        },
    });
}

function renderProducts(data, prefix) {
    let html = "";
    if (data === undefined) return "";

    data.forEach((elem) => {
        setProductVals(prefix, elem);
        let id = elem.id;
        var newElem = $("#sample_product_div").html();

        newElem = newElem
            .replace(prefix + "Img", prefix + "Img_" + id)
            .replace(prefix + "Header", prefix + "Header_" + id)
            .replace(prefix + "Tag", prefix + "Tag_" + id)
            .replace(prefix + "Critical", prefix + "Critical_" + id)
            .replace(prefix + "CriticalCount", prefix + "CriticalCount_" + id)
            .replace(prefix + "Rate", prefix + "Rate_" + id)
            .replace(prefix + "MultiColor", prefix + "MultiColor_" + id);

        html +=
            "<div onclick=\"redirect('" +
            id +
            "', '" +
            elem.slug +
            '\')" class="cursorPointer handleInMedia">' +
            newElem +
            "</div>";
    });

    return html;
}

$(document).ready(function () {
    $(document).on("change", "input[name='categories']", function () {
        filter();
    });
    $(document).on("change", "input[name='sellers']", function () {
        filter();
    });
    $(document).on("change", "input[name='brands']", function () {
        filter();
    });
});

function clearAllFilters() {
    $("input[name='sellers']").prop("checked", false);
    $("input[name='brands']").prop("checked", false);
    $("input[name='categories']").prop("checked", false);
    $("input[name='features']").prop("checked", false);
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
