function setVals(prefix, elem, complete = false) {
    let id = elem.id;

    $("#" + prefix + "-img")
        .attr("src", elem.detail.img)
        .attr("alt", elem.detail.alt);

    $("#" + prefix + "-href")
        .text(elem.detail.title)
        .attr("href", elem.detail.href);

    let priceAfter;

    if (
        elem.detail.price !== undefined &&
        (elem.detail.off_type === undefined ||
            elem.detail.off_type === null ||
            elem.detail.off_type === "" ||
            elem.detail.off_type === "null")
    ) {
        $("#" + prefix + "-price").text(elem.detail.price);
        priceAfter = elem.detail.price.replaceAll(",", "");
    } else if (elem.detail.price !== undefined) {
        if (elem.detail.off_type === "percent") {
            priceAfter =
                ((100 - parseInt(elem.detail.off_value)) *
                    parseInt(elem.detail.price.replaceAll(",", ""))) /
                100;
        } else {
            priceAfter = Math.max(
                0,
                parseInt(elem.detail.price.replaceAll(",", "")) -
                    parseInt(elem.detail.off_value)
            );
        }

        $("#" + prefix + "-price").text(priceAfter.formatPrice(0, ",", "."));
    }

    if (elem.color !== undefined) {
        $("#" + prefix + "-color-parent").removeClass("hidden");
        $("#" + prefix + "-color")
            .css("background-color", elem.color)
            .removeClass("hidden");
    } else {
        $("#" + prefix + "-color-parent").addClass("hidden");
        $("#" + prefix + "-color").addClass("hidden");
    }

    if (elem.detail.feature !== undefined) {
        $("#" + prefix + "-feature-parent").removeClass("hidden");
        $("#" + prefix + "-feature")
            .text(elem.detail.feature)
            .removeClass("hidden");
    } else {
        $("#" + prefix + "-feature-parent").addClass("hidden");
        $("#" + prefix + "-feature").addClass("hidden");
    }

    $("#" + prefix + "-remove-btn").attr("data-id", id);

    if (complete) {
        $("#" + prefix + "-category").text(elem.detail.category);

        if (elem.detail.guarantee != null && elem.detail.guarantee !== "") {
            $("#" + prefix + "-guarantee").text(elem.detail.guarantee);
            $("#" + prefix + "-guarantee-parent").removeClass("hidden");
        } else $("#" + prefix + "-guarantee-parent").addClass("hidden");

        if (elem.detail.seller != null && elem.detail.seller !== "") {
            $("#" + prefix + "-seller").text(elem.detail.seller);
            $("#" + prefix + "-seller-parent").removeClass("hidden");
        } else $("#" + prefix + "-seller-parent").addClass("hidden");
        $("#" + prefix + "-count").attr("value", elem.count);

        if (elem.colorLabel !== undefined)
            $("#" + prefix + "-color-label")
                .text(elem.colorLabel)
                .removeClass("hidden");
        else $("#" + prefix + "-color-label").addClass("hidden");

        if (priceAfter != parseInt(elem.detail.price.replaceAll(",", ""))) {
            $("#" + prefix + "-price-before-off")
                .removeClass("hidden")
                .text(elem.detail.price);
            $("#" + prefix + "-off-section").removeClass("hidden");
            $("#" + prefix + "-off-amount").text(elem.detail.off_value + " %");
        } else {
            $("#" + prefix + "-off-section").addClass("hidden");
            $("#" + prefix + "-price-before-off").addClass("hidden");
        }

        $("#" + prefix + "-plus-btn").attr("data-id", elem.id);
        $("#" + prefix + "-minus-btn").attr("data-id", elem.id);
        $("#" + prefix + "-remove-btn").attr("data-id", elem.id);
    } else {
        $("#" + prefix + "-count").text(elem.count + " عدد");
    }

    return priceAfter;
}

function replaceIds(prefix, newElem, id, complete = false) {
    newElem = newElem
        .replace(prefix + "-img", prefix + "-img-" + id)
        .replace(prefix + "-href", prefix + "-href-" + id)
        .replace(prefix + "-brand", prefix + "-brand-" + id)
        .replace(prefix + "-count", prefix + "-count-" + id)
        .replace(prefix + "-price", prefix + "-price-" + id)
        .replace(prefix + "-color", prefix + "-color-" + id)
        .replace(prefix + "-remove-btn", prefix + "-remove-btn-" + id);

    if (complete)
        newElem = newElem
            .replace(prefix + "-category", prefix + "-category-" + id)
            .replace(prefix + "-color-label", prefix + "-color-label-" + id)
            .replace(prefix + "-color-seller", prefix + "-seller-" + id)
            .replace(
                prefix + "-color-seller-parent",
                prefix + "-seller-parent-" + id
            )
            .replace(prefix + "-guarantee", prefix + "-guarantee-" + id)
            .replace(prefix + "-plus-btn", prefix + "-plus-btn-" + id)
            .replace(prefix + "-minus-btn", prefix + "-minus-btn-" + id)
            .replace(
                prefix + "-guarantee-parent",
                prefix + "-guarantee-parent-" + id
            );
    return newElem;
}

function refreshBasket() {
    let basket = window.localStorage.getItem("basket");

    if (basket === null || basket === undefined) {
        $("#basket-items-count").empty().append("0 کالا");
        $("#basket-items").empty();
        return;
    }

    basket = JSON.parse(basket);

    if (basket.length > 0) {
        $("#basketItems").removeClass("hidden").text(basket.length);
    }

    let prefix = "mini-cart-products";
    let html = "";
    let totalPrice = 0;

    basket.forEach((elem) => {
        let id = elem.id;
        setVals(prefix, elem);
        let newElem = $("#sample-mini-cart-products").html();

        newElem = replaceIds(prefix, newElem, id);

        if (
            elem.detail.off_type === undefined ||
            elem.detail.off_type === null ||
            elem.detail.off_type === "" ||
            elem.detail.off_type === "null"
        )
            totalPrice +=
                elem.count * parseInt(elem.detail.price.replaceAll(",", ""));
        else {
            if (elem.detail.off_type === "percent") {
                priceAfter =
                    ((100 - parseInt(elem.detail.off_value)) *
                        parseInt(elem.detail.price.replaceAll(",", ""))) /
                    100;
            } else {
                priceAfter = Math.max(
                    0,
                    parseInt(elem.detail.price.replaceAll(",", "")) -
                        parseInt(elem.detail.off_value)
                );
            }

            totalPrice += elem.count * priceAfter;
        }

        html += newElem;
    });

    $("#basket-items-count")
        .empty()
        .append(basket.length + " کالا");
    $("#mini-cart-total-value")
        .empty()
        .append(totalPrice.formatPrice(0, ",", ""));

    $("#basket-items").empty().append(html);
}

$(document).ready(function () {
    $(document).on("click", ".mini-cart-product-remove", function () {
        let basket = window.localStorage.getItem("basket");

        if (basket === null || basket === undefined) return;

        basket = JSON.parse(basket);
        let wantedId = $(this).attr("data-id");

        basket = basket.filter((elem) => {
            return elem.id !== wantedId;
        });

        window.localStorage.setItem("basket", JSON.stringify(basket));
        refreshBasket();
    });
});

function renderBasket() {
    let basket = window.localStorage.getItem("basket");

    if (
        basket === null ||
        basket === undefined ||
        basket === "" ||
        JSON.parse(basket).length === 0
    ) {
        $("#full_basket_count_items").empty().append("0 کالا");
        $("#full_basket_items").empty();
        $("#empty-basket").removeClass("hidden");
        $("#full-basket").addClass("hidden");
        refreshBasket();
        return;
    }

    basket = JSON.parse(basket);

    let prefix = "full-basket-item";
    let html = "";
    let totalPricesAfterOff = 0;
    let totalPrices = 0;

    basket.forEach((elem) => {
        totalPricesAfterOff += setVals(prefix, elem, true) * elem.count;
        totalPrices +=
            parseInt(elem.detail.price.replaceAll(",", "")) * elem.count;
        let id = elem.id;
        var newElem = $("#sample_full_basket_item").html();

        newElem = replaceIds(prefix, newElem, id, true);

        html += newElem;
    });

    $("#full_basket_count_items")
        .empty()
        .append(basket.length + " کالا");

    $("#full_basket_total_after_price")
        .empty()
        .append(totalPricesAfterOff.formatPrice(0, ",", "."));

    $("#full_basket_total_price")
        .empty()
        .append(totalPrices.formatPrice(0, ",", "."));

    $("#full_basket_total_off")
        .empty()
        .append((totalPrices - totalPricesAfterOff).formatPrice(0, ",", "."));

    $("#full_basket_items").empty().append(html);

    refreshBasket();
}

$(document).on("click", ".countPlus", function () {
    let basket = window.localStorage.getItem("basket");

    if (
        basket === null ||
        basket === undefined ||
        basket === "" ||
        JSON.parse(basket).length === 0
    )
        return;

    basket = JSON.parse(basket);
    let id = $(this).attr("data-id");
    let c = parseInt($("#full-basket-item-count-" + id).val()) + 1;

    basket.forEach((elem) => {
        if (elem.id === id) elem.count = c;
    });

    window.localStorage.setItem("basket", JSON.stringify(basket));
    renderBasket();
});

$(document).on("click", ".countMinus", function () {
    let basket = window.localStorage.getItem("basket");

    if (
        basket === null ||
        basket === undefined ||
        basket === "" ||
        JSON.parse(basket).length === 0
    )
        return;

    basket = JSON.parse(basket);
    let id = $(this).attr("data-id");
    let c = parseInt($("#full-basket-item-count-" + id).val());
    if (c === 1) return;

    c--;

    basket.forEach((elem) => {
        if (elem.id === id) elem.count = c;
    });

    window.localStorage.setItem("basket", JSON.stringify(basket));
    renderBasket();
});

$(document).on("click", ".removeBasketItemBtn", function () {
    let basket = window.localStorage.getItem("basket");

    if (
        basket === null ||
        basket === undefined ||
        basket === "" ||
        JSON.parse(basket).length === 0
    )
        return;

    basket = JSON.parse(basket);
    let id = $(this).attr("data-id");

    window.localStorage.setItem(
        "basket",
        JSON.stringify(basket.filter((elem) => elem.id !== id))
    );
    renderBasket();
});

function renderPaymentCard() {
    let basket = window.localStorage.getItem("basket");

    if (
        basket === null ||
        basket === undefined ||
        basket === "" ||
        JSON.parse(basket).length === 0
    ) {
        $("#full_basket_count_items").empty().append("0 کالا");
        $("#full_basket_items").empty();
        $("#empty-basket").removeClass("hidden");
        $("#full-basket").addClass("hidden");
        return;
    }

    basket = JSON.parse(basket);

    let totalPricesAfterOff = 0;
    let totalPrices = 0;

    basket.forEach((elem) => {
        let priceAfter;

        if (
            elem.detail.off_type === undefined ||
            elem.detail.off_type === null ||
            elem.detail.off_type === "" ||
            elem.detail.off_type === "null"
        ) {
            priceAfter = elem.detail.price.replaceAll(",", "");
        } else {
            if (elem.detail.off_type === "percent") {
                priceAfter =
                    ((100 - parseInt(elem.detail.off_value)) *
                        parseInt(elem.detail.price.replaceAll(",", ""))) /
                    100;
            } else {
                priceAfter = Math.max(
                    0,
                    parseInt(elem.detail.price.replaceAll(",", "")) -
                        parseInt(elem.detail.off_value)
                );
            }
        }

        totalPricesAfterOff += priceAfter * elem.count;
        totalPrices +=
            parseInt(elem.detail.price.replaceAll(",", "")) * elem.count;
    });

    $("#full_basket_count_items")
        .empty()
        .append(basket.length + " کالا");

    $("#full_basket_total_after_price")
        .empty()
        .append(totalPricesAfterOff.formatPrice(0, ",", "."));

    $("#full_basket_total_price")
        .empty()
        .append(totalPrices.formatPrice(0, ",", "."));

    $("#full_basket_total_off")
        .empty()
        .append((totalPrices - totalPricesAfterOff).formatPrice(0, ",", "."));
}
