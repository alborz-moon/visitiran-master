let page = 1;

function buildQuery() {
    let query = new URLSearchParams();
    if (cat != "-1") query.append("tag", cat);

    // let orderBy = $("#orderBy").val();
    let searchKey = $("#searchBoxInput").val();

    var total_filters_count = 0;

    // if (orderBy === "sell_count_desc") {
    //     query.append("orderBy", "sell_count");
    //     query.append("orderByType", "desc");
    // } else {
    //     let s = orderBy.split("_");
    //     query.append("orderBy", s[0]);
    //     query.append("orderByType", s[1]);
    // }

    if (searchKey !== "") query.append("key", searchKey);

    let minRate = $("input[name='minRate']:checked").val();
    if (minRate !== undefined) {
        $("#star_filters_count_container").removeClass("hidden");
        $("#star_filters_count").empty().append(1);
        query.append("minRate", minRate);
        total_filters_count += 1;
    } else {
        $("#star_filters_count_container").addClass("hidden");
    }

    // if (levels.length > 0) {
    //     $("#levels_filters_count_container").removeClass("hidden");
    //     $("#levels_filters_count").empty().append(levels.length);
    //     query.append("levels", levels);
    //     total_filters_count += levels.length;
    // } else {
    //     $("#levels_filters_count_container").addClass("hidden");
    // }

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
            $("#launchers_div").append(html).removeClass("hidden");
            call_back();
        },
    });
}

function filter() {
    $("#launchers_div").addClass("hidden");
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
            let html = renderLauncher(res.data, "sampleLauncher");
            $("#launchers_div").empty().append(html).removeClass("hidden");
            $("#shimmer").addClass("hidden");
            $("#nothingToShow").addClass("hidden");
            $("#total_count")
                .empty()
                .append(length + " رویداد");
        },
    });
}

function renderLauncher(data, prefix) {
    let html = "";
    if (data === undefined) return "";

    data.forEach((elem) => {
        setLauncherVals(prefix, elem);
        let id = elem.id;

        var newElem = $("#sample_launcher_div").html();

        newElem = newElem
            .replace(prefix + "Img", prefix + "Img_" + id)
            .replace(prefix + "ActiveEvents", prefix + "ActiveEvents_" + id)
            .replace(prefix + "AllEvents", prefix + "AllEvents_" + id)
            .replace(prefix + "Followers", prefix + "Followers_" + id)
            .replace(prefix + "Header", prefix + "Header_" + id)
            .replace(prefix + "Rate", prefix + "Rate_" + id);

        html +=
            "<div onclick=\"launcher_redirect('" +
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
    $(document).on("change", "input[name='langs']", function () {
        filter();
    });
    $(document).on("change", "input[name='minRate']", function () {
        filter();
    });

    $(document).on("change", "input[name='cities']", function () {
        filter();
    });
});

function clearAllFilters() {
    $("input[name='types']").prop("checked", false);
    $("input[name='cities']").prop("checked", false);
    $("input[name='minRate']").prop("checked", false);
    $("input[name='langs']").prop("checked", false);
    $("#searchBoxInput").val("");
    filter();
}
