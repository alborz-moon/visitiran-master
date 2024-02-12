function getCities(stateId, selectedCity = undefined) {
    if (stateId == 0) {
        $("#city02").empty();
        return;
    }
    $.ajax({
        type: "get",
        url: GET_CITIES_URL,
        data: {
            state_id: stateId,
        },
        success: function (res) {
            initialing = false;

            if (res.status !== "ok") {
                $("#city02").empty();
                return;
            }
            let html = '<option value="0">انتخاب کنید</option>';
            res.data.forEach((elem) => {
                if (selectedCity !== undefined && elem.id === selectedCity)
                    html +=
                        '<option selected value="' +
                        elem.id +
                        '">' +
                        elem.name +
                        "</option>";
                else
                    html +=
                        '<option value="' +
                        elem.id +
                        '">' +
                        elem.name +
                        "</option>";
            });
            $("#city02").empty().append(html);
        },
    });
}

function checkInputs(required_list) {
    let isValid = true;

    required_list.forEach((elem) => {
        let tmpVal = $("#" + elem).val();
        if (tmpVal.length == 0) {
            $("#" + elem)
                .addClass("errEmpty")
                .removeClass("haveValue");
            isValid = false;
        } else if (tmpVal.length > 0) {
            $("#" + elem)
                .addClass("haveValue")
                .removeClass("errEmpty");
        }
    });

    return isValid;
}

function checkSelect(required_list_Select) {
    let isValid = true;

    required_list_Select.forEach((elem) => {
        let tmpVal = $("#" + elem).val();
        if (tmpVal === undefined || tmpVal === null || tmpVal == 0) {
            $("#select2-" + elem + "-container")
                .addClass("errEmpty")
                .removeClass("haveValue");
            isValid = false;
        } else if (tmpVal.length > 0) {
            $("#select2-" + elem + "-container")
                .addClass("haveValue")
                .removeClass("errEmpty");
        }
    });

    return isValid;
}

function checkArr(required_Arr, Arr) {
    let isValid = true;

    for (let i = 0; i < required_Arr.length; i++) {
        let elem = required_Arr[i];
        if (Arr[i].length == 0) {
            $("#select2-" + elem + "-container")
                .addClass("errEmpty")
                .removeClass("haveValue");
            isValid = false;
        } else if (Arr[i].length > 0) {
            $("#select2-" + elem + "-container")
                .addClass("haveValue")
                .removeClass("errEmpty");
        }
    }

    return isValid;
}

$(document).ready(function () {
    $("input").on("keypress", function () {
        if (
            $(this).attr("data-editable") !== undefined &&
            $(this).attr("data-editable") == "false"
        )
            return false;
    });
    $("textarea").on("keypress", function () {
        if (
            $(this).attr("data-editable") !== undefined &&
            $(this).attr("data-editable") == "false"
        ) {
            return false;
        }
    });
    $(".toggle-editable-btn").on("click", function () {
        let id = $(this).attr("data-input-id");
        if ($("#" + id).attr("data-editable") == "false") {
            $("#" + id).attr("data-editable", "true");
            $("#" + id).removeAttr("disabled");
        } else {
            $("#" + id).attr("data-editable", "false");
            $("#" + id).attr("disabled", "disabled");
        }
    });
});

function getFormattedTime(time) {
    let day = new Intl.DateTimeFormat("fa-IR", {
        day: "numeric",
    }).format(time);

    let weekday = new Intl.DateTimeFormat("fa-IR", {
        weekday: "short",
    }).format(time);

    return day + weekday;
}

function removeShimmer() {
    $("#shimmer").addClass("hidden");
    $("#hiddenHandler").removeClass("hidden");
    removeUnNecessaryLocks();
}
function removeUnNecessaryLocks() {
    let should_hide_locks_inputs = [];
    let permitted_inputs = [
        "date_input_start",
        "time_start",
        "date_input_stop",
        "date_input_end",
        "time_stop",
        "time_end",
        "first_name",
        "last_name",
    ];

    $("input,textarea").each(function () {
        if ($(this).attr("type") === "checkbox") {
            $(this)
                .removeAttr("disabled", "disabled")
                .attr("data-editable", true);
            should_hide_locks_inputs.push($(this).attr("id"));
            return;
        }

        let id = $(this).attr("id");

        if (id === undefined) return;
        if (permitted_inputs.indexOf(id) !== -1) {
            $(this)
                .removeAttr("disabled", "disabled")
                .attr("data-editable", true);
            should_hide_locks_inputs.push($(this).attr("id"));
            return;
        }

        let val = $(this).val();

        if (val === undefined || val === null || val.length == 0) {
            val = $(this).attr("data-val");
            if (val === undefined || val === null || val.length == 0) {
                $(this)
                    .removeAttr("disabled", "disabled")
                    .attr("data-editable", true);
                should_hide_locks_inputs.push($(this).attr("id"));
            } else
                $(this)
                    .attr("disabled", "disabled")
                    .attr("data-editable", false);
        } else $(this).attr("disabled", "disabled").attr("data-editable", false);
    });

    if (should_hide_locks_inputs.length > 0) {
        $(".toggle-editable-btn").each(function () {
            if (
                should_hide_locks_inputs.indexOf(
                    $(this).attr("data-input-id")
                ) !== -1
            )
                $(this).addClass("hidden");
        });
    }
}

function createMap(containerId, loc) {
    mapboxgl.setRTLTextPlugin(
        "https://cdn.parsimap.ir/third-party/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.2.3/mapbox-gl-rtl-text.js",
        null
    );
    let map = new mapboxgl.Map({
        container: containerId,
        style: "https://api.parsimap.ir/styles/parsimap-streets-v11?key=p1c7661f1a3a684079872cbca20c1fb8477a83a92f",
        center:
            loc.x !== undefined && loc.y !== undefined
                ? [loc.y, loc.x]
                : [51.4, 35.7],
        zoom: 13,
    });
    var marker = undefined;

    if (loc.x !== undefined && loc.y !== undefined) {
        marker = new mapboxgl.Marker();
        marker
            .setLngLat({
                lng: loc.y,
                lat: loc.x,
            })
            .addTo(map);
    }

    function addMarker(e) {
        if (marker !== undefined) marker.remove();
        //add marker
        marker = new mapboxgl.Marker();
        marker.setLngLat(e.lngLat).addTo(map);
        loc.x = e.lngLat.lat;
        loc.y = e.lngLat.lng;
    }
    map.on("click", addMarker);
    const control = new ParsimapGeocoder();
    map.addControl(control);
    return map;
}

function watchEnterInTellInput(telsObj) {
    $(document).on("click", ".remove-tel-btn", function () {
        let id = $(this).attr("data-id");
        telsObj.tels = telsObj.tels.filter((elem, index) => {
            return elem.id != id;
        });
        $("#tel-modal-" + id).remove();
    });

    $(".setEnter").keyup(function (e) {
        var html = "";
        if ($(".setEnter").is(":focus") && e.keyCode == 13) {
            var launchPhone = $(".setEnter").val();
            if (launchPhone.length < 7 || launchPhone.length > 11) {
                showErr("شماره موردنظر معتبر نمی باشد.");
                return;
            }
            telsObj.tels.push({
                id: telsObj.idx,
                val: launchPhone,
            });
            html +=
                '<div id="tel-modal-' +
                telsObj.idx +
                '" class="item-button spaceBetween colorBlack">' +
                launchPhone +
                "";
            html +=
                '<button class="btn btn-outline-light borderRadius50 marginLeft3">';
            html +=
                '<i data-id="' +
                telsObj.idx +
                '" class="remove-tel-btn ri-close-line"></i>';
            html += "</button>";
            html += "</div>";
            $("#addTell").append(html);
            $(".setEnter").val("");
            telsObj.idx++;
        }
    });
}
