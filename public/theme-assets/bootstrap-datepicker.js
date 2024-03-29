function myMod(t, e) {
    return t - e * Math.floor(t / e);
}
function leap_gregorian(t) {
    return t % 4 == 0 && !(t % 100 == 0 && t % 400 != 0);
}
var GREGORIAN_EPOCH = 1721425.5;
function gregorian_to_jd(t, e, a) {
    return (
        GREGORIAN_EPOCH -
        1 +
        365 * (t - 1) +
        Math.floor((t - 1) / 4) +
        -Math.floor((t - 1) / 100) +
        Math.floor((t - 1) / 400) +
        Math.floor(
            (367 * e - 362) / 12 +
                (e <= 2 ? 0 : leap_gregorian(t) ? -1 : -2) +
                a
        )
    );
}
function jd_to_gregorian(t) {
    var e, a, i, r, n, s, o, d, c, l, u, h;
    return (
        (a = (e = Math.floor(t - 0.5) + 0.5) - GREGORIAN_EPOCH),
        (i = Math.floor(a / 146097)),
        (r = myMod(a, 146097)),
        (n = Math.floor(r / 36524)),
        (s = myMod(r, 36524)),
        (o = Math.floor(s / 1461)),
        (d = myMod(s, 1461)),
        (l = 400 * i + 100 * n + 4 * o + (c = Math.floor(d / 365))),
        4 != n && 4 != c && l++,
        (u = e - gregorian_to_jd(l, 1, 1)),
        (h = e < gregorian_to_jd(l, 3, 1) ? 0 : leap_gregorian(l) ? 1 : 2),
        (month = Math.floor((12 * (u + h) + 373) / 367)),
        (day = e - gregorian_to_jd(l, month, 1) + 1),
        new Array(l, month, day)
    );
}
function leap_islamic(t) {
    return (11 * t + 14) % 30 < 11;
}
var ISLAMIC_EPOCH = 1948439.5;
function islamic_to_jd(t, e, a) {
    return (
        a +
        Math.ceil(29.5 * (e - 1)) +
        354 * (t - 1) +
        Math.floor((3 + 11 * t) / 30) +
        ISLAMIC_EPOCH -
        1
    );
}
function jd_to_islamic(t) {
    var e, a, i;
    return (
        (i =
            (t = Math.floor(t) + 0.5) -
            islamic_to_jd(
                (e = Math.floor((30 * (t - ISLAMIC_EPOCH) + 10646) / 10631)),
                (a = Math.min(
                    12,
                    Math.ceil((t - (29 + islamic_to_jd(e, 1, 1))) / 29.5) + 1
                )),
                1
            ) +
            1),
        new Array(e, a, i)
    );
}
function leap_persian(t) {
    return (682 * (((t - (t > 0 ? 474 : 473)) % 2820) + 474 + 38)) % 2816 < 682;
}
var PERSIAN_EPOCH = 1948320.5;
function persian_to_jd(t, e, a) {
    var i, r;
    return (
        (r = 474 + myMod((i = t - (t >= 0 ? 474 : 473)), 2820)),
        a +
            (e <= 7 ? 31 * (e - 1) : 30 * (e - 1) + 6) +
            Math.floor((682 * r - 110) / 2816) +
            365 * (r - 1) +
            1029983 * Math.floor(i / 2820) +
            (PERSIAN_EPOCH - 1)
    );
}
function jd_to_persian(t) {
    var e, a, i, r, n, s, o, d, c, l;
    return (
        (r = (t = Math.floor(t) + 0.5) - persian_to_jd(475, 1, 1)),
        (n = Math.floor(r / 1029983)),
        1029982 == (s = myMod(r, 1029983))
            ? (o = 2820)
            : ((d = Math.floor(s / 366)),
              (c = myMod(s, 366)),
              (o = Math.floor((2134 * d + 2816 * c + 2815) / 1028522) + d + 1)),
        (e = o + 2820 * n + 474) <= 0 && e--,
        (i =
            t -
            persian_to_jd(
                e,
                (a =
                    (l = t - persian_to_jd(e, 1, 1) + 1) <= 186
                        ? Math.ceil(l / 31)
                        : Math.ceil((l - 6) / 30)),
                1
            ) +
            1),
        new Array(e, a, i)
    );
}
function JalaliDate(t, e, a) {
    var i, r;
    if (isNaN(parseInt(t)) || isNaN(parseInt(e)) || isNaN(parseInt(a))) d(t);
    else {
        var n = s([parseInt(t, 10), parseInt(e, 10), parseInt(a, 10)]);
        d(new Date(n[0], n[1], n[2]));
    }
    function s(t) {
        var e = 0;
        t[1] < 0 && ((e = leap_persian(t[0] - 1) ? 30 : 29), t[1]++);
        var a = jd_to_gregorian(persian_to_jd(t[0], t[1] + 1, t[2]) - e);
        return a[1]--, a;
    }
    function o(t) {
        var e = jd_to_persian(gregorian_to_jd(t[0], t[1] + 1, t[2]));
        return e[1]--, e;
    }
    function d(t) {
        return (
            t && t.getGregorianDate && (t = t.getGregorianDate()),
            (i = new Date(t)).setHours(
                i.getHours() > 12 ? i.getHours() + 2 : 0
            ),
            (i && "Invalid Date" != i && !isNaN(i || !i.getDate())) ||
                (i = new Date()),
            (r = o([i.getFullYear(), i.getMonth(), i.getDate()])),
            this
        );
    }
    (this.getGregorianDate = function () {
        return i;
    }),
        (this.setFullDate = d),
        (this.setMonth = function (t) {
            r[1] = t;
            var e = s(r);
            (i = new Date(e[0], e[1], e[2])), (r = o([e[0], e[1], e[2]]));
        }),
        (this.setDate = function (t) {
            r[2] = t;
            var e = s(r);
            (i = new Date(e[0], e[1], e[2])), (r = o([e[0], e[1], e[2]]));
        }),
        (this.getFullYear = function () {
            return r[0];
        }),
        (this.getMonth = function () {
            return r[1];
        }),
        (this.getDate = function () {
            return r[2];
        }),
        (this.toString = function () {
            return r.join(",").toString();
        }),
        (this.getDay = function () {
            return i.getDay();
        }),
        (this.getHours = function () {
            return i.getHours();
        }),
        (this.getMinutes = function () {
            return i.getMinutes();
        }),
        (this.getSeconds = function () {
            return i.getSeconds();
        }),
        (this.getTime = function () {
            return i.getTime();
        }),
        (this.getTimeZoneOffset = function () {
            return i.getTimeZoneOffset();
        }),
        (this.getYear = function () {
            return r[0] % 100;
        }),
        (this.setHours = function (t) {
            i.setHours(t);
        }),
        (this.setMinutes = function (t) {
            i.setMinutes(t);
        }),
        (this.setSeconds = function (t) {
            i.setSeconds(t);
        }),
        (this.setMilliseconds = function (t) {
            i.setMilliseconds(t);
        });
}
jQuery(function (t) {
    (t.datepicker.regional.fa = {
        calendar: JalaliDate,
        closeText: "بستن",
        prevText: "قبل",
        nextText: "بعد",
        currentText: "امروز",
        monthNames: [
            "فروردین",
            "اردیبهشت",
            "خرداد",
            "تیر",
            "مرداد",
            "شهریور",
            "مهر",
            "آبان",
            "آذر",
            "دی",
            "بهمن",
            "اسفند",
        ],
        monthNamesShort: [
            "فروردین",
            "اردیبهشت",
            "خرداد",
            "تیر",
            "مرداد",
            "شهریور",
            "مهر",
            "آبان",
            "آذر",
            "دی",
            "بهمن",
            "اسفند",
        ],
        dayNames: [
            "یکشنبه",
            "دوشنبه",
            "سه شنبه",
            "چهارشنبه",
            "پنجشنبه",
            "جمعه",
            "شنبه",
        ],
        dayNamesShort: ["یک", "دو", "سه", "چهار", "پنج", "جمعه", "شنبه"],
        dayNamesMin: ["ی", "د", "س", "چ", "پ", "ج", "ش"],
        weekHeader: "ه",
        dateFormat: "dd/mm/yy",
        firstDay: 6,
        isRTL: !0,
        showMonthAfterYear: !1,
        yearSuffix: "",
        calculateWeek: function (t) {
            var e = new JalaliDate(
                t.getFullYear(),
                t.getMonth(),
                t.getDate() + (t.getDay() || 7) - 3
            );
            return (
                Math.floor(
                    Math.round(
                        (e.getTime() -
                            new JalaliDate(e.getFullYear(), 0, 1).getTime()) /
                            864e5
                    ) / 7
                ) + 1
            );
        },
    }),
        t.datepicker.setDefaults(t.datepicker.regional.fa);
}),
    (function (t, e) {
        var a,
            i = 0,
            r = /^ui-id-\d+$/;
        ((t.ui = t.ui || {}), t.ui.version) ||
            (t.extend(t.ui, {
                version: "1.9.1",
                keyCode: {
                    BACKSPACE: 8,
                    COMMA: 188,
                    DELETE: 46,
                    DOWN: 40,
                    END: 35,
                    ENTER: 13,
                    ESCAPE: 27,
                    HOME: 36,
                    LEFT: 37,
                    NUMPAD_ADD: 107,
                    NUMPAD_DECIMAL: 110,
                    NUMPAD_DIVIDE: 111,
                    NUMPAD_ENTER: 108,
                    NUMPAD_MULTIPLY: 106,
                    NUMPAD_SUBTRACT: 109,
                    PAGE_DOWN: 34,
                    PAGE_UP: 33,
                    PERIOD: 190,
                    RIGHT: 39,
                    SPACE: 32,
                    TAB: 9,
                    UP: 38,
                },
            }),
            t.fn.extend({
                _focus: t.fn.focus,
                focus: function (e, a) {
                    return "number" == typeof e
                        ? this.each(function () {
                              var i = this;
                              setTimeout(function () {
                                  t(i).focus(), a && a.call(i);
                              }, e);
                          })
                        : this._focus.apply(this, arguments);
                },
                scrollParent: function () {
                    var e;
                    return (
                        (e =
                            (t.ui.ie &&
                                /(static|relative)/.test(
                                    this.css("position")
                                )) ||
                            /absolute/.test(this.css("position"))
                                ? this.parents()
                                      .filter(function () {
                                          return (
                                              /(relative|absolute|fixed)/.test(
                                                  t.css(this, "position")
                                              ) &&
                                              /(auto|scroll)/.test(
                                                  t.css(this, "overflow") +
                                                      t.css(
                                                          this,
                                                          "overflow-y"
                                                      ) +
                                                      t.css(this, "overflow-x")
                                              )
                                          );
                                      })
                                      .eq(0)
                                : this.parents()
                                      .filter(function () {
                                          return /(auto|scroll)/.test(
                                              t.css(this, "overflow") +
                                                  t.css(this, "overflow-y") +
                                                  t.css(this, "overflow-x")
                                          );
                                      })
                                      .eq(0)),
                        /fixed/.test(this.css("position")) || !e.length
                            ? t(document)
                            : e
                    );
                },
                zIndex: function (e) {
                    if (void 0 !== e) return this.css("zIndex", e);
                    if (this.length)
                        for (
                            var a, i, r = t(this[0]);
                            r.length && r[0] !== document;

                        ) {
                            if (
                                ("absolute" === (a = r.css("position")) ||
                                    "relative" === a ||
                                    "fixed" === a) &&
                                ((i = parseInt(r.css("zIndex"), 10)),
                                !isNaN(i) && 0 !== i)
                            )
                                return i;
                            r = r.parent();
                        }
                    return 0;
                },
                uniqueId: function () {
                    return this.each(function () {
                        this.id || (this.id = "ui-id-" + ++i);
                    });
                },
                removeUniqueId: function () {
                    return this.each(function () {
                        r.test(this.id) && t(this).removeAttr("id");
                    });
                },
            }),
            t("<a>").outerWidth(1).jquery ||
                t.each(["Width", "Height"], function (e, a) {
                    var i =
                            "Width" === a
                                ? ["Left", "Right"]
                                : ["Top", "Bottom"],
                        r = a.toLowerCase(),
                        n = {
                            innerWidth: t.fn.innerWidth,
                            innerHeight: t.fn.innerHeight,
                            outerWidth: t.fn.outerWidth,
                            outerHeight: t.fn.outerHeight,
                        };
                    function s(e, a, r, n) {
                        return (
                            t.each(i, function () {
                                (a -=
                                    parseFloat(t.css(e, "padding" + this)) ||
                                    0),
                                    r &&
                                        (a -=
                                            parseFloat(
                                                t.css(
                                                    e,
                                                    "border" + this + "Width"
                                                )
                                            ) || 0),
                                    n &&
                                        (a -=
                                            parseFloat(
                                                t.css(e, "margin" + this)
                                            ) || 0);
                            }),
                            a
                        );
                    }
                    (t.fn["inner" + a] = function (e) {
                        return void 0 === e
                            ? n["inner" + a].call(this)
                            : this.each(function () {
                                  t(this).css(r, s(this, e) + "px");
                              });
                    }),
                        (t.fn["outer" + a] = function (e, i) {
                            return "number" != typeof e
                                ? n["outer" + a].call(this, e)
                                : this.each(function () {
                                      t(this).css(r, s(this, e, !0, i) + "px");
                                  });
                        });
                }),
            t.extend(t.expr[":"], {
                data: t.expr.createPseudo
                    ? t.expr.createPseudo(function (e) {
                          return function (a) {
                              return !!t.data(a, e);
                          };
                      })
                    : function (e, a, i) {
                          return !!t.data(e, i[3]);
                      },
                focusable: function (e) {
                    return n(e, !isNaN(t.attr(e, "tabindex")));
                },
                tabbable: function (e) {
                    var a = t.attr(e, "tabindex"),
                        i = isNaN(a);
                    return (i || a >= 0) && n(e, !i);
                },
            }),
            t(function () {
                var e = document.body,
                    a = e.appendChild((a = document.createElement("div")));
                a.offsetHeight,
                    t.extend(a.style, {
                        minHeight: "100px",
                        height: "auto",
                        padding: 0,
                        borderWidth: 0,
                    }),
                    (t.support.minHeight = 100 === a.offsetHeight),
                    (t.support.selectstart = "onselectstart" in a),
                    (e.removeChild(a).style.display = "none");
            }),
            (a = /msie ([\w.]+)/.exec(navigator.userAgent.toLowerCase()) || []),
            (t.ui.ie = !!a.length),
            (t.ui.ie6 = 6 === parseFloat(a[1], 10)),
            t.fn.extend({
                disableSelection: function () {
                    return this.bind(
                        (t.support.selectstart ? "selectstart" : "mousedown") +
                            ".ui-disableSelection",
                        function (t) {
                            t.preventDefault();
                        }
                    );
                },
                enableSelection: function () {
                    return this.unbind(".ui-disableSelection");
                },
            }),
            t.extend(t.ui, {
                plugin: {
                    add: function (e, a, i) {
                        var r,
                            n = t.ui[e].prototype;
                        for (r in i)
                            (n.plugins[r] = n.plugins[r] || []),
                                n.plugins[r].push([a, i[r]]);
                    },
                    call: function (t, e, a) {
                        var i,
                            r = t.plugins[e];
                        if (
                            r &&
                            t.element[0].parentNode &&
                            11 !== t.element[0].parentNode.nodeType
                        )
                            for (i = 0; i < r.length; i++)
                                t.options[r[i][0]] &&
                                    r[i][1].apply(t.element, a);
                    },
                },
                contains: t.contains,
                hasScroll: function (e, a) {
                    if ("hidden" === t(e).css("overflow")) return !1;
                    var i,
                        r = a && "left" === a ? "scrollLeft" : "scrollTop";
                    return (
                        e[r] > 0 || ((e[r] = 1), (i = e[r] > 0), (e[r] = 0), i)
                    );
                },
                isOverAxis: function (t, e, a) {
                    return t > e && t < e + a;
                },
                isOver: function (e, a, i, r, n, s) {
                    return t.ui.isOverAxis(e, i, n) && t.ui.isOverAxis(a, r, s);
                },
            }));
        function n(e, a) {
            var i,
                r,
                n,
                o = e.nodeName.toLowerCase();
            return "area" === o
                ? ((r = (i = e.parentNode).name),
                  !(!e.href || !r || "map" !== i.nodeName.toLowerCase()) &&
                      !!(n = t("img[usemap=#" + r + "]")[0]) &&
                      s(n))
                : (/input|select|textarea|button|object/.test(o)
                      ? !e.disabled
                      : ("a" === o && e.href) || a) && s(e);
        }
        function s(e) {
            return (
                t.expr.filters.visible(e) &&
                !t(e)
                    .parents()
                    .andSelf()
                    .filter(function () {
                        return "hidden" === t.css(this, "visibility");
                    }).length
            );
        }
    })(jQuery),
    (function ($, undefined) {
        $.extend($.ui, { datepicker: { version: "1.9.1" } });
        var PROP_NAME = "datepicker",
            dpuuid = new Date().getTime(),
            instActive;
        function Datepicker() {
            (this.debug = !1),
                (this._curInst = null),
                (this._keyEvent = !1),
                (this._disabledInputs = []),
                (this._datepickerShowing = !1),
                (this._inDialog = !1),
                (this._mainDivId = "ui-datepicker-div"),
                (this._inlineClass = "ui-datepicker-inline"),
                (this._appendClass = "ui-datepicker-append"),
                (this._triggerClass = "ui-datepicker-trigger"),
                (this._dialogClass = "ui-datepicker-dialog"),
                (this._disableClass = "ui-datepicker-disabled"),
                (this._unselectableClass = "ui-datepicker-unselectable"),
                (this._currentClass = "ui-datepicker-current-day"),
                (this._dayOverClass = "ui-datepicker-days-cell-over"),
                (this.regional = []),
                (this.regional[""] = {
                    calendar: Date,
                    closeText: "Done",
                    prevText: "Prev",
                    nextText: "Next",
                    currentText: "Today",
                    monthNames: [
                        "January",
                        "February",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December",
                    ],
                    monthNamesShort: [
                        "Jan",
                        "Feb",
                        "Mar",
                        "Apr",
                        "May",
                        "Jun",
                        "Jul",
                        "Aug",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dec",
                    ],
                    dayNames: [
                        "Sunday",
                        "Monday",
                        "Tuesday",
                        "Wednesday",
                        "Thursday",
                        "Friday",
                        "Saturday",
                    ],
                    dayNamesShort: [
                        "Sun",
                        "Mon",
                        "Tue",
                        "Wed",
                        "Thu",
                        "Fri",
                        "Sat",
                    ],
                    dayNamesMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                    weekHeader: "Wk",
                    dateFormat: "mm/dd/yy",
                    firstDay: 0,
                    isRTL: !1,
                    showMonthAfterYear: !1,
                    yearSuffix: "",
                }),
                (this._defaults = {
                    showOn: "focus",
                    showAnim: "fadeIn",
                    showOptions: {},
                    defaultDate: null,
                    appendText: "",
                    buttonText: "...",
                    buttonImage: "",
                    buttonImageOnly: !1,
                    hideIfNoPrevNext: !1,
                    navigationAsDateFormat: !1,
                    gotoCurrent: !1,
                    changeMonth: !1,
                    changeYear: !1,
                    yearRange: "c-10:c+10",
                    showOtherMonths: !1,
                    selectOtherMonths: !1,
                    showWeek: !1,
                    calculateWeek: this.iso8601Week,
                    shortYearCutoff: "+10",
                    minDate: null,
                    maxDate: null,
                    duration: "fast",
                    beforeShowDay: null,
                    beforeShow: null,
                    onSelect: null,
                    onChangeMonthYear: null,
                    onClose: null,
                    numberOfMonths: 1,
                    showCurrentAtPos: 0,
                    stepMonths: 1,
                    stepBigMonths: 12,
                    altField: "",
                    altFormat: "",
                    constrainInput: !0,
                    showButtonPanel: !1,
                    autoSize: !1,
                    disabled: !1,
                }),
                $.extend(this._defaults, this.regional[""]),
                (this.dpDiv = bindHover(
                    $(
                        '<div id="' +
                            this._mainDivId +
                            '" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>'
                    )
                ));
        }
        function bindHover(t) {
            var e =
                "button, .ui-datepicker-prev, .ui-datepicker-next, .ui-datepicker-calendar td a";
            return t
                .delegate(e, "mouseout", function () {
                    $(this).removeClass("ui-state-hover"),
                        -1 != this.className.indexOf("ui-datepicker-prev") &&
                            $(this).removeClass("ui-datepicker-prev-hover"),
                        -1 != this.className.indexOf("ui-datepicker-next") &&
                            $(this).removeClass("ui-datepicker-next-hover");
                })
                .delegate(e, "mouseover", function () {
                    $.datepicker._isDisabledDatepicker(
                        instActive.inline ? t.parent()[0] : instActive.input[0]
                    ) ||
                        ($(this)
                            .parents(".ui-datepicker-calendar")
                            .find("a")
                            .removeClass("ui-state-hover"),
                        $(this).addClass("ui-state-hover"),
                        -1 != this.className.indexOf("ui-datepicker-prev") &&
                            $(this).addClass("ui-datepicker-prev-hover"),
                        -1 != this.className.indexOf("ui-datepicker-next") &&
                            $(this).addClass("ui-datepicker-next-hover"));
                });
        }
        function extendRemove(t, e) {
            $.extend(t, e);
            for (var a in e)
                (null != e[a] && e[a] != undefined) || (t[a] = e[a]);
            return t;
        }
        $.extend(Datepicker.prototype, {
            markerClassName: "hasDatepicker",
            maxRows: 4,
            log: function () {
                this.debug && console.log.apply("", arguments);
            },
            _widgetDatepicker: function () {
                return this.dpDiv;
            },
            setDefaults: function (t) {
                return extendRemove(this._defaults, t || {}), this;
            },
            _attachDatepicker: function (target, settings) {
                var inlineSettings = null;
                for (var attrName in this._defaults) {
                    var attrValue = target.getAttribute("date:" + attrName);
                    if (attrValue) {
                        inlineSettings = inlineSettings || {};
                        try {
                            inlineSettings[attrName] = eval(attrValue);
                        } catch (t) {
                            inlineSettings[attrName] = attrValue;
                        }
                    }
                }
                var nodeName = target.nodeName.toLowerCase(),
                    inline = "div" == nodeName || "span" == nodeName;
                target.id || ((this.uuid += 1), (target.id = "dp" + this.uuid));
                var inst = this._newInst($(target), inline),
                    regional = $.extend(
                        {},
                        (settings && this.regional[settings.regional]) || {}
                    );
                (inst.settings = $.extend(
                    regional,
                    settings || {},
                    inlineSettings || {}
                )),
                    "input" == nodeName
                        ? this._connectDatepicker(target, inst)
                        : inline && this._inlineDatepicker(target, inst);
            },
            _newInst: function (t, e) {
                return {
                    id: t[0].id.replace(/([^A-Za-z0-9_-])/g, "\\\\$1"),
                    input: t,
                    selectedDay: 0,
                    selectedMonth: 0,
                    selectedYear: 0,
                    drawMonth: 0,
                    drawYear: 0,
                    inline: e,
                    dpDiv: e
                        ? bindHover(
                              $(
                                  '<div class="' +
                                      this._inlineClass +
                                      ' ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>'
                              )
                          )
                        : this.dpDiv,
                };
            },
            _connectDatepicker: function (t, e) {
                var a = $(t);
                (e.append = $([])),
                    (e.trigger = $([])),
                    a.hasClass(this.markerClassName) ||
                        (this._attachments(a, e),
                        a
                            .addClass(this.markerClassName)
                            .keydown(this._doKeyDown)
                            .keypress(this._doKeyPress)
                            .keyup(this._doKeyUp)
                            .bind("setData.datepicker", function (t, a, i) {
                                e.settings[a] = i;
                            })
                            .bind("getData.datepicker", function (t, a) {
                                return this._get(e, a);
                            }),
                        this._autoSize(e),
                        $.data(t, PROP_NAME, e),
                        e.settings.disabled && this._disableDatepicker(t));
            },
            _attachments: function (t, e) {
                var a = this._get(e, "appendText");
                e.append && e.append.remove(),
                    a &&
                        ((e.append = $(
                            '<span class="' +
                                this._appendClass +
                                '">' +
                                a +
                                "</span>"
                        )),
                        t.after(e.append)),
                    t.unbind("focus", this._showDatepicker),
                    e.trigger && e.trigger.remove();
                var i = this._get(e, "showOn");
                if (
                    (("focus" != i && "both" != i) ||
                        t.focus(this._showDatepicker),
                    "button" == i || "both" == i)
                ) {
                    var r = this._get(e, "buttonText"),
                        n = this._get(e, "buttonImage");
                    (e.trigger = $(
                        this._get(e, "buttonImageOnly")
                            ? $("<img/>")
                                  .addClass(this._triggerClass)
                                  .attr({ src: n, alt: r, title: r })
                            : $('<button type="button"></button>')
                                  .addClass(this._triggerClass)
                                  .html(
                                      "" == n
                                          ? r
                                          : $("<img/>").attr({
                                                src: n,
                                                alt: r,
                                                title: r,
                                            })
                                  )
                    )),
                        t.after(e.trigger),
                        e.trigger.click(function () {
                            return (
                                $.datepicker._datepickerShowing &&
                                $.datepicker._lastInput == t[0]
                                    ? $.datepicker._hideDatepicker()
                                    : $.datepicker._datepickerShowing &&
                                      $.datepicker._lastInput != t[0]
                                    ? ($.datepicker._hideDatepicker(),
                                      $.datepicker._showDatepicker(t[0]))
                                    : $.datepicker._showDatepicker(t[0]),
                                !1
                            );
                        });
                }
            },
            _autoSize: function (t) {
                if (this._get(t, "autoSize") && !t.inline) {
                    var e = new Date(2009, 11, 20),
                        a = this._get(t, "dateFormat");
                    if (a.match(/[DM]/)) {
                        var i = function (t) {
                            for (var e = 0, a = 0, i = 0; i < t.length; i++)
                                t[i].length > e && ((e = t[i].length), (a = i));
                            return a;
                        };
                        e.setMonth(
                            i(
                                this._get(
                                    t,
                                    a.match(/MM/)
                                        ? "monthNames"
                                        : "monthNamesShort"
                                )
                            )
                        ),
                            e.setDate(
                                i(
                                    this._get(
                                        t,
                                        a.match(/DD/)
                                            ? "dayNames"
                                            : "dayNamesShort"
                                    )
                                ) +
                                    20 -
                                    e.getDay()
                            );
                    }
                    t.input.attr("size", this._formatDate(t, e).length);
                }
            },
            _inlineDatepicker: function (t, e) {
                var a = $(t);
                a.hasClass(this.markerClassName) ||
                    (a
                        .addClass(this.markerClassName)
                        .append(e.dpDiv)
                        .bind("setData.datepicker", function (t, a, i) {
                            e.settings[a] = i;
                        })
                        .bind("getData.datepicker", function (t, a) {
                            return this._get(e, a);
                        }),
                    $.data(t, PROP_NAME, e),
                    this._setDate(e, this._getDefaultDate(e), !0),
                    this._updateDatepicker(e),
                    this._updateAlternate(e),
                    e.settings.disabled && this._disableDatepicker(t),
                    e.dpDiv.css("display", "block"));
            },
            _dialogDatepicker: function (t, e, a, i, r) {
                var n = this._dialogInst;
                if (!n) {
                    this.uuid += 1;
                    var s = "dp" + this.uuid;
                    (this._dialogInput = $(
                        '<input type="text" id="' +
                            s +
                            '" style="position: absolute; top: -100px; width: 0px;"/>'
                    )),
                        this._dialogInput.keydown(this._doKeyDown),
                        $("body").append(this._dialogInput),
                        ((n = this._dialogInst =
                            this._newInst(this._dialogInput, !1)).settings =
                            {}),
                        $.data(this._dialogInput[0], PROP_NAME, n);
                }
                if (
                    (extendRemove(n.settings, i || {}),
                    (e =
                        e && e.constructor == Date
                            ? this._formatDate(n, e)
                            : e),
                    this._dialogInput.val(e),
                    (this._pos = r
                        ? r.length
                            ? r
                            : [r.pageX, r.pageY]
                        : null),
                    !this._pos)
                ) {
                    var o = document.documentElement.clientWidth,
                        d = document.documentElement.clientHeight,
                        c =
                            document.documentElement.scrollLeft ||
                            document.body.scrollLeft,
                        l =
                            document.documentElement.scrollTop ||
                            document.body.scrollTop;
                    this._pos = [o / 2 - 100 + c, d / 2 - 150 + l];
                }
                return (
                    this._dialogInput
                        .css("left", this._pos[0] + 20 + "px")
                        .css("top", this._pos[1] + "px"),
                    (n.settings.onSelect = a),
                    (this._inDialog = !0),
                    this.dpDiv.addClass(this._dialogClass),
                    this._showDatepicker(this._dialogInput[0]),
                    $.blockUI && $.blockUI(this.dpDiv),
                    $.data(this._dialogInput[0], PROP_NAME, n),
                    this
                );
            },
            _destroyDatepicker: function (t) {
                var e = $(t),
                    a = $.data(t, PROP_NAME);
                if (e.hasClass(this.markerClassName)) {
                    var i = t.nodeName.toLowerCase();
                    $.removeData(t, PROP_NAME),
                        "input" == i
                            ? (a.append.remove(),
                              a.trigger.remove(),
                              e
                                  .removeClass(this.markerClassName)
                                  .unbind("focus", this._showDatepicker)
                                  .unbind("keydown", this._doKeyDown)
                                  .unbind("keypress", this._doKeyPress)
                                  .unbind("keyup", this._doKeyUp))
                            : ("div" != i && "span" != i) ||
                              e.removeClass(this.markerClassName).empty();
                }
            },
            _enableDatepicker: function (t) {
                var e = $(t),
                    a = $.data(t, PROP_NAME);
                if (e.hasClass(this.markerClassName)) {
                    var i = t.nodeName.toLowerCase();
                    if ("input" == i)
                        (t.disabled = !1),
                            a.trigger
                                .filter("button")
                                .each(function () {
                                    this.disabled = !1;
                                })
                                .end()
                                .filter("img")
                                .css({ opacity: "1.0", cursor: "" });
                    else if ("div" == i || "span" == i) {
                        var r = e.children("." + this._inlineClass);
                        r.children().removeClass("ui-state-disabled"),
                            r
                                .find(
                                    "select.ui-datepicker-month, select.ui-datepicker-year"
                                )
                                .prop("disabled", !1);
                    }
                    this._disabledInputs = $.map(
                        this._disabledInputs,
                        function (e) {
                            return e == t ? null : e;
                        }
                    );
                }
            },
            _disableDatepicker: function (t) {
                var e = $(t),
                    a = $.data(t, PROP_NAME);
                if (e.hasClass(this.markerClassName)) {
                    var i = t.nodeName.toLowerCase();
                    if ("input" == i)
                        (t.disabled = !0),
                            a.trigger
                                .filter("button")
                                .each(function () {
                                    this.disabled = !0;
                                })
                                .end()
                                .filter("img")
                                .css({ opacity: "0.5", cursor: "default" });
                    else if ("div" == i || "span" == i) {
                        var r = e.children("." + this._inlineClass);
                        r.children().addClass("ui-state-disabled"),
                            r
                                .find(
                                    "select.ui-datepicker-month, select.ui-datepicker-year"
                                )
                                .prop("disabled", !0);
                    }
                    (this._disabledInputs = $.map(
                        this._disabledInputs,
                        function (e) {
                            return e == t ? null : e;
                        }
                    )),
                        (this._disabledInputs[this._disabledInputs.length] = t);
                }
            },
            _isDisabledDatepicker: function (t) {
                if (!t) return !1;
                for (var e = 0; e < this._disabledInputs.length; e++)
                    if (this._disabledInputs[e] == t) return !0;
                return !1;
            },
            _getInst: function (t) {
                try {
                    return $.data(t, PROP_NAME);
                } catch (t) {
                    throw "Missing instance data for this datepicker";
                }
            },
            _optionDatepicker: function (t, e, a) {
                var i = this._getInst(t);
                if (2 == arguments.length && "string" == typeof e)
                    return "defaults" == e
                        ? $.extend({}, $.datepicker._defaults)
                        : i
                        ? "all" == e
                            ? $.extend({}, i.settings)
                            : this._get(i, e)
                        : null;
                var r = e || {};
                if (("string" == typeof e && ((r = {})[e] = a), i)) {
                    this._curInst == i && this._hideDatepicker();
                    var n = this._getDateDatepicker(t, !0),
                        s = this._getMinMaxDate(i, "min"),
                        o = this._getMinMaxDate(i, "max");
                    extendRemove(i.settings, r),
                        null !== s &&
                            r.dateFormat !== undefined &&
                            r.minDate === undefined &&
                            (i.settings.minDate = this._formatDate(i, s)),
                        null !== o &&
                            r.dateFormat !== undefined &&
                            r.maxDate === undefined &&
                            (i.settings.maxDate = this._formatDate(i, o)),
                        this._attachments($(t), i),
                        this._autoSize(i),
                        this._setDate(i, n),
                        this._updateAlternate(i),
                        this._updateDatepicker(i);
                }
            },
            _changeDatepicker: function (t, e, a) {
                this._optionDatepicker(t, e, a);
            },
            _refreshDatepicker: function (t) {
                var e = this._getInst(t);
                e && this._updateDatepicker(e);
            },
            _setDateDatepicker: function (t, e) {
                var a = this._getInst(t);
                a &&
                    (this._setDate(a, e),
                    this._updateDatepicker(a),
                    this._updateAlternate(a));
            },
            _getDateDatepicker: function (t, e) {
                var a = this._getInst(t);
                return (
                    a && !a.inline && this._setDateFromField(a, e),
                    a ? this._getDate(a) : null
                );
            },
            _doKeyDown: function (t) {
                var e = $.datepicker._getInst(t.target),
                    a = !0,
                    i = e.dpDiv.is(".ui-datepicker-rtl");
                if (((e._keyEvent = !0), $.datepicker._datepickerShowing))
                    switch (t.keyCode) {
                        case 9:
                            $.datepicker._hideDatepicker(), (a = !1);
                            break;
                        case 13:
                            var r = $(
                                "td." +
                                    $.datepicker._dayOverClass +
                                    ":not(." +
                                    $.datepicker._currentClass +
                                    ")",
                                e.dpDiv
                            );
                            r[0] &&
                                $.datepicker._selectDay(
                                    t.target,
                                    e.selectedMonth,
                                    e.selectedYear,
                                    r[0]
                                );
                            var n = $.datepicker._get(e, "onSelect");
                            if (n) {
                                var s = $.datepicker._formatDate(e);
                                n.apply(e.input ? e.input[0] : null, [s, e]);
                            } else $.datepicker._hideDatepicker();
                            return !1;
                        case 27:
                            $.datepicker._hideDatepicker();
                            break;
                        case 33:
                            $.datepicker._adjustDate(
                                t.target,
                                t.ctrlKey
                                    ? -$.datepicker._get(e, "stepBigMonths")
                                    : -$.datepicker._get(e, "stepMonths"),
                                "M"
                            );
                            break;
                        case 34:
                            $.datepicker._adjustDate(
                                t.target,
                                t.ctrlKey
                                    ? +$.datepicker._get(e, "stepBigMonths")
                                    : +$.datepicker._get(e, "stepMonths"),
                                "M"
                            );
                            break;
                        case 35:
                            (t.ctrlKey || t.metaKey) &&
                                $.datepicker._clearDate(t.target),
                                (a = t.ctrlKey || t.metaKey);
                            break;
                        case 36:
                            (t.ctrlKey || t.metaKey) &&
                                $.datepicker._gotoToday(t.target),
                                (a = t.ctrlKey || t.metaKey);
                            break;
                        case 37:
                            (t.ctrlKey || t.metaKey) &&
                                $.datepicker._adjustDate(
                                    t.target,
                                    i ? 1 : -1,
                                    "D"
                                ),
                                (a = t.ctrlKey || t.metaKey),
                                t.originalEvent.altKey &&
                                    $.datepicker._adjustDate(
                                        t.target,
                                        t.ctrlKey
                                            ? -$.datepicker._get(
                                                  e,
                                                  "stepBigMonths"
                                              )
                                            : -$.datepicker._get(
                                                  e,
                                                  "stepMonths"
                                              ),
                                        "M"
                                    );
                            break;
                        case 38:
                            (t.ctrlKey || t.metaKey) &&
                                $.datepicker._adjustDate(t.target, -7, "D"),
                                (a = t.ctrlKey || t.metaKey);
                            break;
                        case 39:
                            (t.ctrlKey || t.metaKey) &&
                                $.datepicker._adjustDate(
                                    t.target,
                                    i ? -1 : 1,
                                    "D"
                                ),
                                (a = t.ctrlKey || t.metaKey),
                                t.originalEvent.altKey &&
                                    $.datepicker._adjustDate(
                                        t.target,
                                        t.ctrlKey
                                            ? +$.datepicker._get(
                                                  e,
                                                  "stepBigMonths"
                                              )
                                            : +$.datepicker._get(
                                                  e,
                                                  "stepMonths"
                                              ),
                                        "M"
                                    );
                            break;
                        case 40:
                            (t.ctrlKey || t.metaKey) &&
                                $.datepicker._adjustDate(t.target, 7, "D"),
                                (a = t.ctrlKey || t.metaKey);
                            break;
                        default:
                            a = !1;
                    }
                else
                    36 == t.keyCode && t.ctrlKey
                        ? $.datepicker._showDatepicker(this)
                        : (a = !1);
                a && (t.preventDefault(), t.stopPropagation());
            },
            _doKeyPress: function (t) {
                var e = $.datepicker._getInst(t.target);
                if ($.datepicker._get(e, "constrainInput")) {
                    var a = $.datepicker._possibleChars(
                            $.datepicker._get(e, "dateFormat")
                        ),
                        i = String.fromCharCode(
                            t.charCode == undefined ? t.keyCode : t.charCode
                        );
                    return (
                        t.ctrlKey ||
                        t.metaKey ||
                        i < " " ||
                        !a ||
                        a.indexOf(i) > -1
                    );
                }
            },
            _doKeyUp: function (t) {
                var e = $.datepicker._getInst(t.target);
                if (e.input.val() != e.lastVal)
                    try {
                        $.datepicker.parseDate(
                            $.datepicker._get(e, "dateFormat"),
                            e.input ? e.input.val() : null,
                            $.datepicker._getFormatConfig(e)
                        ) &&
                            ($.datepicker._setDateFromField(e),
                            $.datepicker._updateAlternate(e),
                            $.datepicker._updateDatepicker(e));
                    } catch (t) {
                        $.datepicker.log(t);
                    }
                return !0;
            },
            _showDatepicker: function (t) {
                if (
                    ("input" != (t = t.target || t).nodeName.toLowerCase() &&
                        (t = $("input", t.parentNode)[0]),
                    !$.datepicker._isDisabledDatepicker(t) &&
                        $.datepicker._lastInput != t)
                ) {
                    var e = $.datepicker._getInst(t);
                    $.datepicker._curInst &&
                        $.datepicker._curInst != e &&
                        ($.datepicker._curInst.dpDiv.stop(!0, !0),
                        e &&
                            $.datepicker._datepickerShowing &&
                            $.datepicker._hideDatepicker(
                                $.datepicker._curInst.input[0]
                            ));
                    var a = $.datepicker._get(e, "beforeShow"),
                        i = a ? a.apply(t, [t, e]) : {};
                    if (!1 !== i) {
                        extendRemove(e.settings, i),
                            (e.lastVal = null),
                            ($.datepicker._lastInput = t),
                            $.datepicker._setDateFromField(e),
                            $.datepicker._inDialog && (t.value = ""),
                            $.datepicker._pos ||
                                (($.datepicker._pos = $.datepicker._findPos(t)),
                                ($.datepicker._pos[1] += t.offsetHeight));
                        var r = !1;
                        $(t)
                            .parents()
                            .each(function () {
                                return !(r |=
                                    "fixed" == $(this).css("position"));
                            });
                        var n = {
                            left: $.datepicker._pos[0],
                            top: $.datepicker._pos[1],
                        };
                        if (
                            (($.datepicker._pos = null),
                            e.dpDiv.empty(),
                            e.dpDiv.css({
                                position: "absolute",
                                display: "block",
                                top: "-1000px",
                            }),
                            $.datepicker._updateDatepicker(e),
                            (n = $.datepicker._checkOffset(e, n, r)),
                            e.dpDiv.css({
                                position:
                                    $.datepicker._inDialog && $.blockUI
                                        ? "static"
                                        : r
                                        ? "fixed"
                                        : "absolute",
                                display: "none",
                                left: n.left + "px",
                                top: n.top + "px",
                            }),
                            !e.inline)
                        ) {
                            var s = $.datepicker._get(e, "showAnim"),
                                o = $.datepicker._get(e, "duration"),
                                d = function () {
                                    var t = e.dpDiv.find(
                                        "iframe.ui-datepicker-cover"
                                    );
                                    if (t.length) {
                                        var a = $.datepicker._getBorders(
                                            e.dpDiv
                                        );
                                        t.css({
                                            left: -a[0],
                                            top: -a[1],
                                            width: e.dpDiv.outerWidth(),
                                            height: e.dpDiv.outerHeight(),
                                        });
                                    }
                                };
                            e.dpDiv.zIndex($(t).zIndex() + 1),
                                ($.datepicker._datepickerShowing = !0),
                                $.effects &&
                                ($.effects.effect[s] || $.effects[s])
                                    ? e.dpDiv.show(
                                          s,
                                          $.datepicker._get(e, "showOptions"),
                                          o,
                                          d
                                      )
                                    : e.dpDiv[s || "show"](s ? o : null, d),
                                (s && o) || d(),
                                e.input.is(":visible") &&
                                    !e.input.is(":disabled") &&
                                    e.input.focus(),
                                ($.datepicker._curInst = e);
                        }
                    }
                }
            },
            _updateDatepicker: function (t) {
                this.maxRows = 4;
                var e = $.datepicker._getBorders(t.dpDiv);
                (instActive = t),
                    t.dpDiv.empty().append(this._generateHTML(t)),
                    this._attachHandlers(t);
                var a = t.dpDiv.find("iframe.ui-datepicker-cover");
                a.length &&
                    a.css({
                        left: -e[0],
                        top: -e[1],
                        width: t.dpDiv.outerWidth(),
                        height: t.dpDiv.outerHeight(),
                    }),
                    t.dpDiv.find("." + this._dayOverClass + " a").mouseover();
                var i = this._getNumberOfMonths(t),
                    r = i[1];
                if (
                    (t.dpDiv
                        .removeClass(
                            "ui-datepicker-multi-2 ui-datepicker-multi-3 ui-datepicker-multi-4"
                        )
                        .width(""),
                    r > 1 &&
                        t.dpDiv
                            .addClass("ui-datepicker-multi-" + r)
                            .css("width", 17 * r + "em"),
                    t.dpDiv[
                        (1 != i[0] || 1 != i[1] ? "add" : "remove") + "Class"
                    ]("ui-datepicker-multi"),
                    t.dpDiv[
                        (this._get(t, "isRTL") ? "add" : "remove") + "Class"
                    ]("ui-datepicker-rtl"),
                    t == $.datepicker._curInst &&
                        $.datepicker._datepickerShowing &&
                        t.input &&
                        t.input.is(":visible") &&
                        !t.input.is(":disabled") &&
                        t.input[0] != document.activeElement &&
                        t.input.focus(),
                    t.yearshtml)
                ) {
                    var n = t.yearshtml;
                    setTimeout(function () {
                        n === t.yearshtml &&
                            t.yearshtml &&
                            t.dpDiv
                                .find("select.ui-datepicker-year:first")
                                .replaceWith(t.yearshtml),
                            (n = t.yearshtml = null);
                    }, 0);
                }
            },
            _getBorders: function (t) {
                var e = function (t) {
                    return { thin: 1, medium: 2, thick: 3 }[t] || t;
                };
                return [
                    parseFloat(e(t.css("border-left-width"))),
                    parseFloat(e(t.css("border-top-width"))),
                ];
            },
            _checkOffset: function (t, e, a) {
                var i = t.dpDiv.outerWidth(),
                    r = t.dpDiv.outerHeight(),
                    n = t.input ? t.input.outerWidth() : 0,
                    s = t.input ? t.input.outerHeight() : 0,
                    o =
                        document.documentElement.clientWidth +
                        (a ? 0 : $(document).scrollLeft()),
                    d =
                        document.documentElement.clientHeight +
                        (a ? 0 : $(document).scrollTop());
                return (
                    (e.left -= this._get(t, "isRTL") ? i - n : 0),
                    (e.left -=
                        a && e.left == t.input.offset().left
                            ? $(document).scrollLeft()
                            : 0),
                    (e.top -=
                        a && e.top == t.input.offset().top + s
                            ? $(document).scrollTop()
                            : 0),
                    (e.left -= Math.min(
                        e.left,
                        e.left + i > o && o > i ? Math.abs(e.left + i - o) : 0
                    )),
                    (e.top -= Math.min(
                        e.top,
                        e.top + r > d && d > r ? Math.abs(r + s) : 0
                    )),
                    e
                );
            },
            _findPos: function (t) {
                for (
                    var e = this._getInst(t), a = this._get(e, "isRTL");
                    t &&
                    ("hidden" == t.type ||
                        1 != t.nodeType ||
                        $.expr.filters.hidden(t));

                )
                    t = t[a ? "previousSibling" : "nextSibling"];
                var i = $(t).offset();
                return [i.left, i.top];
            },
            _hideDatepicker: function (t) {
                var e = this._curInst;
                if (
                    e &&
                    (!t || e == $.data(t, PROP_NAME)) &&
                    this._datepickerShowing
                ) {
                    var a = this._get(e, "showAnim"),
                        i = this._get(e, "duration"),
                        r = function () {
                            $.datepicker._tidyDialog(e);
                        };
                    $.effects && ($.effects.effect[a] || $.effects[a])
                        ? e.dpDiv.hide(
                              a,
                              $.datepicker._get(e, "showOptions"),
                              i,
                              r
                          )
                        : e.dpDiv[
                              "slideDown" == a
                                  ? "slideUp"
                                  : "fadeIn" == a
                                  ? "fadeOut"
                                  : "hide"
                          ](a ? i : null, r),
                        a || r(),
                        (this._datepickerShowing = !1);
                    var n = this._get(e, "onClose");
                    n &&
                        n.apply(e.input ? e.input[0] : null, [
                            e.input ? e.input.val() : "",
                            e,
                        ]),
                        (this._lastInput = null),
                        this._inDialog &&
                            (this._dialogInput.css({
                                position: "absolute",
                                left: "0",
                                top: "-100px",
                            }),
                            $.blockUI &&
                                ($.unblockUI(), $("body").append(this.dpDiv))),
                        (this._inDialog = !1);
                }
            },
            _tidyDialog: function (t) {
                t.dpDiv
                    .removeClass(this._dialogClass)
                    .unbind(".ui-datepicker-calendar");
            },
            _checkExternalClick: function (t) {
                if ($.datepicker._curInst) {
                    var e = $(t.target),
                        a = $.datepicker._getInst(e[0]);
                    ((e[0].id == $.datepicker._mainDivId ||
                        0 != e.parents("#" + $.datepicker._mainDivId).length ||
                        e.hasClass($.datepicker.markerClassName) ||
                        e.closest("." + $.datepicker._triggerClass).length ||
                        !$.datepicker._datepickerShowing ||
                        ($.datepicker._inDialog && $.blockUI)) &&
                        (!e.hasClass($.datepicker.markerClassName) ||
                            $.datepicker._curInst == a)) ||
                        $.datepicker._hideDatepicker();
                }
            },
            _adjustDate: function (t, e, a) {
                var i = $(t),
                    r = this._getInst(i[0]);
                this._isDisabledDatepicker(i[0]) ||
                    (this._adjustInstDate(
                        r,
                        e + ("M" == a ? this._get(r, "showCurrentAtPos") : 0),
                        a
                    ),
                    this._updateDatepicker(r));
            },
            _gotoToday: function (t) {
                var e = $(t),
                    a = this._getInst(e[0]);
                if (this._get(a, "gotoCurrent") && a.currentDay)
                    (a.selectedDay = a.currentDay),
                        (a.drawMonth = a.selectedMonth = a.currentMonth),
                        (a.drawYear = a.selectedYear = a.currentYear);
                else {
                    var i = new this.CDate();
                    (a.selectedDay = i.getDate()),
                        (a.drawMonth = a.selectedMonth = i.getMonth()),
                        (a.drawYear = a.selectedYear = i.getFullYear());
                }
                this._notifyChange(a), this._adjustDate(e);
            },
            _selectMonthYear: function (t, e, a) {
                var i = $(t),
                    r = this._getInst(i[0]);
                (r["selected" + ("M" == a ? "Month" : "Year")] = r[
                    "draw" + ("M" == a ? "Month" : "Year")
                ] =
                    parseInt(e.options[e.selectedIndex].value, 10)),
                    this._notifyChange(r),
                    this._adjustDate(i);
            },
            _selectDay: function (t, e, a, i) {
                var r = $(t);
                if (
                    !$(i).hasClass(this._unselectableClass) &&
                    !this._isDisabledDatepicker(r[0])
                ) {
                    var n = this._getInst(r[0]);
                    (n.selectedDay = n.currentDay = $("a", i).html()),
                        (n.selectedMonth = n.currentMonth = e),
                        (n.selectedYear = n.currentYear = a),
                        this._selectDate(
                            t,
                            this._formatDate(
                                n,
                                n.currentDay,
                                n.currentMonth,
                                n.currentYear
                            )
                        );
                }
            },
            _clearDate: function (t) {
                var e = $(t);
                this._getInst(e[0]);
                this._selectDate(e, "");
            },
            _selectDate: function (t, e) {
                var a = $(t),
                    i = this._getInst(a[0]);
                (e = null != e ? e : this._formatDate(i)),
                    i.input && i.input.val(e),
                    this._updateAlternate(i);
                var r = this._get(i, "onSelect");
                r
                    ? r.apply(i.input ? i.input[0] : null, [e, i])
                    : i.input && i.input.trigger("change"),
                    i.inline
                        ? this._updateDatepicker(i)
                        : (this._hideDatepicker(),
                          (this._lastInput = i.input[0]),
                          "object" != typeof i.input[0] && i.input.focus(),
                          (this._lastInput = null));
            },
            _updateAlternate: function (t) {
                var e = this._get(t, "altField");
                if (e) {
                    var a =
                            this._get(t, "altFormat") ||
                            this._get(t, "dateFormat"),
                        i = this._getDate(t),
                        r = this.formatDate(a, i, this._getFormatConfig(t));

                    $(e).each(function () {
                        $(this).val(r);
                    });
                }
            },
            noWeekends: function (t) {
                var e = t.getDay();
                return [e > 0 && e < 6, ""];
            },
            iso8601Week: function (t) {
                var e = new Date(t.getTime());
                e.setDate(e.getDate() + 4 - (e.getDay() || 7));
                var a = e.getTime();
                return (
                    e.setMonth(0),
                    e.setDate(1),
                    Math.floor(Math.round((a - e) / 864e5) / 7) + 1
                );
            },
            parseDate: function (t, e, a) {
                if (null == t || null == e) throw "Invalid arguments";
                if ("" == (e = "object" == typeof e ? e.toString() : e + ""))
                    return null;
                var i =
                    (a ? a.shortYearCutoff : null) ||
                    this._defaults.shortYearCutoff;
                i =
                    "string" != typeof i
                        ? i
                        : (new this.CDate().getFullYear() % 100) +
                          parseInt(i, 10);
                for (
                    var r =
                            (a ? a.dayNamesShort : null) ||
                            this._defaults.dayNamesShort,
                        n = (a ? a.dayNames : null) || this._defaults.dayNames,
                        s =
                            (a ? a.monthNamesShort : null) ||
                            this._defaults.monthNamesShort,
                        o =
                            (a ? a.monthNames : null) ||
                            this._defaults.monthNames,
                        d = -1,
                        c = -1,
                        l = -1,
                        u = -1,
                        h = !1,
                        p = function (e) {
                            var a = D + 1 < t.length && t.charAt(D + 1) == e;
                            return a && D++, a;
                        },
                        g = function (t) {
                            var a = p(t),
                                i = new RegExp(
                                    "^\\d{1," +
                                        ("@" == t
                                            ? 14
                                            : "!" == t
                                            ? 20
                                            : "y" == t && a
                                            ? 4
                                            : "o" == t
                                            ? 3
                                            : 2) +
                                        "}"
                                ),
                                r = e.substring(m).match(i);
                            if (!r) throw "Missing number at position " + m;
                            return (m += r[0].length), parseInt(r[0], 10);
                        },
                        f = function (t, a, i) {
                            var r = $.map(p(t) ? i : a, function (t, e) {
                                    return [[e, t]];
                                }).sort(function (t, e) {
                                    return -(t[1].length - e[1].length);
                                }),
                                n = -1;
                            if (
                                ($.each(r, function (t, a) {
                                    var i = a[1];
                                    if (
                                        e.substr(m, i.length).toLowerCase() ==
                                        i.toLowerCase()
                                    )
                                        return (n = a[0]), (m += i.length), !1;
                                }),
                                -1 != n)
                            )
                                return n + 1;
                            throw "Unknown name at position " + m;
                        },
                        _ = function () {
                            if (e.charAt(m) != t.charAt(D))
                                throw "Unexpected literal at position " + m;
                            m++;
                        },
                        m = 0,
                        D = 0;
                    D < t.length;
                    D++
                )
                    if (h) "'" != t.charAt(D) || p("'") ? _() : (h = !1);
                    else
                        switch (t.charAt(D)) {
                            case "d":
                                l = g("d");
                                break;
                            case "D":
                                f("D", r, n);
                                break;
                            case "o":
                                u = g("o");
                                break;
                            case "m":
                                c = g("m");
                                break;
                            case "M":
                                c = f("M", s, o);
                                break;
                            case "y":
                                d = g("y");
                                break;
                            case "@":
                                (d = (k = new this.CDate(
                                    g("@")
                                )).getFullYear()),
                                    (c = k.getMonth() + 1),
                                    (l = k.getDate());
                                break;
                            case "!":
                                var k;
                                (d = (k = new Date(
                                    (g("!") - this._ticksTo1970) / 1e4
                                )).getFullYear()),
                                    (c = k.getMonth() + 1),
                                    (l = k.getDate());
                                break;
                            case "'":
                                p("'") ? _() : (h = !0);
                                break;
                            default:
                                _();
                        }
                if (m < e.length) {
                    var v = e.substr(m);
                    if (!/^\s+/.test(v))
                        throw "Extra/unparsed characters found in date: " + v;
                }
                if (
                    (-1 == d
                        ? (d = new this.CDate().getFullYear())
                        : d < 100 &&
                          (d +=
                              new this.CDate().getFullYear() -
                              (new this.CDate().getFullYear() % 100) +
                              (d <= i ? 0 : -100)),
                    u > -1)
                )
                    for (c = 1, l = u; ; ) {
                        var y = this._getDaysInMonth(d, c - 1);
                        if (l <= y) break;
                        c++, (l -= y);
                    }
                if (
                    (k = this._daylightSavingAdjust(
                        new this.CDate(d, c - 1, l)
                    )).getFullYear() != d ||
                    k.getMonth() + 1 != c ||
                    k.getDate() != l
                )
                    throw "Invalid date";
                return k;
            },
            ATOM: "yy-mm-dd",
            COOKIE: "D, dd M yy",
            ISO_8601: "yy-mm-dd",
            RFC_822: "D, d M y",
            RFC_850: "DD, dd-M-y",
            RFC_1036: "D, d M y",
            RFC_1123: "D, d M yy",
            RFC_2822: "D, d M yy",
            RSS: "D, d M y",
            TICKS: "!",
            TIMESTAMP: "@",
            W3C: "yy-mm-dd",
            _ticksTo1970:
                24 *
                (718685 +
                    Math.floor(492.5) -
                    Math.floor(19.7) +
                    Math.floor(4.925)) *
                60 *
                60 *
                1e7,
            formatDate: function (t, e, a) {
                if (!e) return "";
                var i =
                        (a ? a.dayNamesShort : null) ||
                        this._defaults.dayNamesShort,
                    r = (a ? a.dayNames : null) || this._defaults.dayNames,
                    n =
                        (a ? a.monthNamesShort : null) ||
                        this._defaults.monthNamesShort,
                    s = (a ? a.monthNames : null) || this._defaults.monthNames,
                    o = function (e) {
                        var a = h + 1 < t.length && t.charAt(h + 1) == e;
                        return a && h++, a;
                    },
                    d = function (t, e, a) {
                        var i = "" + e;
                        if (o(t)) for (; i.length < a; ) i = "0" + i;
                        return i;
                    },
                    c = function (t, e, a, i) {
                        return o(t) ? i[e] : a[e];
                    },
                    l = "",
                    u = !1;
                if (e)
                    for (var h = 0; h < t.length; h++)
                        if (u)
                            "'" != t.charAt(h) || o("'")
                                ? (l += t.charAt(h))
                                : (u = !1);
                        else
                            switch (t.charAt(h)) {
                                case "d":
                                    l += d("d", e.getDate(), 2);
                                    break;
                                case "D":
                                    l += c("D", e.getDay(), i, r);
                                    break;
                                case "o":
                                    l += d(
                                        "o",
                                        Math.round(
                                            (new this.CDate(
                                                e.getFullYear(),
                                                e.getMonth(),
                                                e.getDate()
                                            ).getTime() -
                                                new this.CDate(
                                                    e.getFullYear(),
                                                    0,
                                                    0
                                                ).getTime()) /
                                                864e5
                                        ),
                                        3
                                    );
                                    break;
                                case "m":
                                    l += d("m", e.getMonth() + 1, 2);
                                    break;
                                case "M":
                                    l += c("M", e.getMonth(), n, s);
                                    break;
                                case "y":
                                    l += o("y")
                                        ? e.getFullYear()
                                        : (e.getYear() % 100 < 10 ? "0" : "") +
                                          (e.getYear() % 100);
                                    break;
                                case "@":
                                    l += e.getTime();
                                    break;
                                case "!":
                                    l += 1e4 * e.getTime() + this._ticksTo1970;
                                    break;
                                case "'":
                                    o("'") ? (l += "'") : (u = !0);
                                    break;
                                default:
                                    l += t.charAt(h);
                            }
                return l;
            },
            _possibleChars: function (t) {
                for (
                    var e = "",
                        a = !1,
                        i = function (e) {
                            var a = r + 1 < t.length && t.charAt(r + 1) == e;
                            return a && r++, a;
                        },
                        r = 0;
                    r < t.length;
                    r++
                )
                    if (a)
                        "'" != t.charAt(r) || i("'")
                            ? (e += t.charAt(r))
                            : (a = !1);
                    else
                        switch (t.charAt(r)) {
                            case "d":
                            case "m":
                            case "y":
                            case "@":
                                e += "0123456789";
                                break;
                            case "D":
                            case "M":
                                return null;
                            case "'":
                                i("'") ? (e += "'") : (a = !0);
                                break;
                            default:
                                e += t.charAt(r);
                        }
                return e;
            },
            _get: function (t, e) {
                return t.settings[e] !== undefined
                    ? t.settings[e]
                    : this._defaults[e];
            },
            _setDateFromField: function (t, e) {
                if (t.input.val() != t.lastVal) {
                    var a,
                        i,
                        r = this._get(t, "dateFormat"),
                        n = (t.lastVal = t.input ? t.input.val() : null);
                    a = i = this._getDefaultDate(t);
                    var s = this._getFormatConfig(t);
                    try {
                        a = this.parseDate(r, n, s) || i;
                    } catch (t) {
                        this.log(t), (n = e ? "" : n);
                    }
                    (t.selectedDay = a.getDate()),
                        (t.drawMonth = t.selectedMonth = a.getMonth()),
                        (t.drawYear = t.selectedYear = a.getFullYear()),
                        (t.currentDay = n ? a.getDate() : 0),
                        (t.currentMonth = n ? a.getMonth() : 0),
                        (t.currentYear = n ? a.getFullYear() : 0),
                        this._adjustInstDate(t);
                }
            },
            _getDefaultDate: function (t) {
                return (
                    (this.CDate = this._get(t, "calendar")),
                    this._restrictMinMax(
                        t,
                        this._determineDate(
                            t,
                            this._get(t, "defaultDate"),
                            new this.CDate()
                        )
                    )
                );
            },
            _determineDate: function (t, e, a) {
                var i,
                    r,
                    n = this.CDate,
                    s =
                        null == e || "" === e
                            ? a
                            : "string" == typeof e
                            ? (function (e) {
                                  try {
                                      return $.datepicker.parseDate(
                                          $.datepicker._get(t, "dateFormat"),
                                          e,
                                          $.datepicker._getFormatConfig(t)
                                      );
                                  } catch (t) {}
                                  for (
                                      var a =
                                              (e.toLowerCase().match(/^c/)
                                                  ? $.datepicker._getDate(t)
                                                  : null) || new n(),
                                          i = a.getFullYear(),
                                          r = a.getMonth(),
                                          s = a.getDate(),
                                          o =
                                              /([+-]?[0-9]+)\s*(d|D|w|W|m|M|y|Y)?/g,
                                          d = o.exec(e);
                                      d;

                                  ) {
                                      switch (d[2] || "d") {
                                          case "d":
                                          case "D":
                                              s += parseInt(d[1], 10);
                                              break;
                                          case "w":
                                          case "W":
                                              s += 7 * parseInt(d[1], 10);
                                              break;
                                          case "m":
                                          case "M":
                                              (r += parseInt(d[1], 10)),
                                                  (s = Math.min(
                                                      s,
                                                      $.datepicker._getDaysInMonth(
                                                          i,
                                                          r
                                                      )
                                                  ));
                                              break;
                                          case "y":
                                          case "Y":
                                              (i += parseInt(d[1], 10)),
                                                  (s = Math.min(
                                                      s,
                                                      $.datepicker._getDaysInMonth(
                                                          i,
                                                          r
                                                      )
                                                  ));
                                      }
                                      d = o.exec(e);
                                  }
                                  return new n(i, r, s);
                              })(e)
                            : "number" == typeof e
                            ? isNaN(e)
                                ? a
                                : ((i = e),
                                  (r = new n()).setDate(r.getDate() + i),
                                  r)
                            : new n(e.getTime());
                return (
                    (s = s && "Invalid Date" == s.toString() ? a : s) &&
                        (s.setHours(0),
                        s.setMinutes(0),
                        s.setSeconds(0),
                        s.setMilliseconds(0)),
                    this._daylightSavingAdjust(s)
                );
            },
            _daylightSavingAdjust: function (t) {
                return t
                    ? (t.setHours(t.getHours() > 12 ? t.getHours() + 2 : 0), t)
                    : null;
            },
            _setDate: function (t, e, a) {
                var i = !e,
                    r = t.selectedMonth,
                    n = t.selectedYear;
                this.CDate = this._get(t, "calendar");
                var s = this._restrictMinMax(
                    t,
                    this._determineDate(t, e, new this.CDate())
                );
                (t.selectedDay = t.currentDay = s.getDate()),
                    (t.drawMonth =
                        t.selectedMonth =
                        t.currentMonth =
                            s.getMonth()),
                    (t.drawYear =
                        t.selectedYear =
                        t.currentYear =
                            s.getFullYear()),
                    (r == t.selectedMonth && n == t.selectedYear) ||
                        a ||
                        this._notifyChange(t),
                    this._adjustInstDate(t),
                    t.input && t.input.val(i ? "" : this._formatDate(t));
            },
            _getDate: function (t) {
                return (
                    (this.CDate = this._get(t, "calendar")),
                    !t.currentYear || (t.input && "" == t.input.val())
                        ? null
                        : this._daylightSavingAdjust(
                              new this.CDate(
                                  t.currentYear,
                                  t.currentMonth,
                                  t.currentDay
                              )
                          )
                );
            },
            _attachHandlers: function (t) {
                var e = this._get(t, "stepMonths"),
                    a = "#" + t.id.replace(/\\\\/g, "\\");
                t.dpDiv.find("[data-handler]").map(function () {
                    var t = {
                        prev: function () {
                            window[
                                "DP_jQuery_" + dpuuid
                            ].datepicker._adjustDate(a, -e, "M");
                        },
                        next: function () {
                            window[
                                "DP_jQuery_" + dpuuid
                            ].datepicker._adjustDate(a, +e, "M");
                        },
                        hide: function () {
                            window[
                                "DP_jQuery_" + dpuuid
                            ].datepicker._hideDatepicker();
                        },
                        today: function () {
                            window["DP_jQuery_" + dpuuid].datepicker._gotoToday(
                                a
                            );
                        },
                        selectDay: function () {
                            return (
                                window[
                                    "DP_jQuery_" + dpuuid
                                ].datepicker._selectDay(
                                    a,
                                    +this.getAttribute("data-month"),
                                    +this.getAttribute("data-year"),
                                    this
                                ),
                                !1
                            );
                        },
                        selectMonth: function () {
                            return (
                                window[
                                    "DP_jQuery_" + dpuuid
                                ].datepicker._selectMonthYear(a, this, "M"),
                                !1
                            );
                        },
                        selectYear: function () {
                            return (
                                window[
                                    "DP_jQuery_" + dpuuid
                                ].datepicker._selectMonthYear(a, this, "Y"),
                                !1
                            );
                        },
                    };
                    $(this).bind(
                        this.getAttribute("data-event"),
                        t[this.getAttribute("data-handler")]
                    );
                });
            },
            _generateHTML: function (t) {
                var e = new this.CDate();
                e = this._daylightSavingAdjust(
                    new this.CDate(e.getFullYear(), e.getMonth(), e.getDate())
                );
                var a = this._get(t, "isRTL"),
                    i = this._get(t, "showButtonPanel"),
                    r = this._get(t, "hideIfNoPrevNext"),
                    n = this._get(t, "navigationAsDateFormat"),
                    s = this._getNumberOfMonths(t),
                    o = this._get(t, "showCurrentAtPos"),
                    d = this._get(t, "stepMonths"),
                    c = 1 != s[0] || 1 != s[1],
                    l = this._daylightSavingAdjust(
                        t.currentDay
                            ? new this.CDate(
                                  t.currentYear,
                                  t.currentMonth,
                                  t.currentDay
                              )
                            : new Date(9999, 9, 9)
                    ),
                    u = this._getMinMaxDate(t, "min"),
                    h = this._getMinMaxDate(t, "max"),
                    p = t.drawMonth - o,
                    g = t.drawYear;
                if ((p < 0 && ((p += 12), g--), h)) {
                    var f = this._daylightSavingAdjust(
                        new this.CDate(
                            h.getFullYear(),
                            h.getMonth() - s[0] * s[1] + 1,
                            h.getDate()
                        )
                    );
                    for (
                        f = u && f < u ? u : f;
                        this._daylightSavingAdjust(new this.CDate(g, p, 1)) > f;

                    )
                        --p < 0 && ((p = 11), g--);
                }
                (t.drawMonth = p), (t.drawYear = g);
                var _ = this._get(t, "prevText");
                _ = n
                    ? this.formatDate(
                          _,
                          this._daylightSavingAdjust(
                              new this.CDate(g, p - d, 1)
                          ),
                          this._getFormatConfig(t)
                      )
                    : _;
                var m = this._canAdjustMonth(t, -1, g, p)
                        ? '<a class="ui-datepicker-prev btn btn-link" data-handler="prev" data-event="click" title="' +
                          _ +
                          '">' +
                          (a
                              ? '<i class="ri-arrow-right-circle-line" style="font-size: 20px"></i>'
                              : '<i class="ri-arrow-left-circle-line" style="font-size: 20px"></i>') +
                          "</a>"
                        : r
                        ? ""
                        : '<a class="ui-datepicker-prev btn btn-link ui-state-disabled" title="' +
                          _ +
                          '">' +
                          (a
                              ? '<i class="ri-arrow-right-circle-line" style="font-size: 20px"></i>'
                              : '<i class="ri-arrow-left-circle-line" style="font-size: 20px"></i>') +
                          "</a>",
                    D = this._get(t, "nextText");
                D = n
                    ? this.formatDate(
                          D,
                          this._daylightSavingAdjust(
                              new this.CDate(g, p + d, 1)
                          ),
                          this._getFormatConfig(t)
                      )
                    : D;
                var k = this._canAdjustMonth(t, 1, g, p)
                        ? '<a class="ui-datepicker-next btn btn-link" data-handler="next" data-event="click" title="' +
                          D +
                          '">' +
                          (a
                              ? '<i class="ri-arrow-left-circle-line" style="font-size: 20px"></i>'
                              : '<i class="ri-arrow-right-circle-line" style="font-size: 20px"></i>') +
                          "</a>"
                        : r
                        ? ""
                        : '<a class="ui-datepicker-next btn btn-link ui-state-disabled" title="' +
                          D +
                          '">' +
                          (a
                              ? '<i class="ri-arrow-left-circle-line" style="font-size: 20px"></i>'
                              : '<i class="ri-arrow-right-circle-line" style="font-size: 20px"></i>') +
                          "</a>",
                    v = this._get(t, "currentText"),
                    y = this._get(t, "gotoCurrent") && t.currentDay ? l : e;
                v = n ? this.formatDate(v, y, this._getFormatConfig(t)) : v;
                var M = t.inline
                        ? ""
                        : '<button type="button" class="ui-datepicker-close btn btn-default" data-handler="hide" data-event="click">' +
                          this._get(t, "closeText") +
                          "</button>",
                    b = i
                        ? '<div class="ui-datepicker-buttonpane ui-helper-clearfix">' +
                          (a ? M : "") +
                          (this._isInRange(t, y)
                              ? '<button style="color: #000;" type="button" class="ui-datepicker-current btn" data-handler="today" data-event="click">' +
                                v +
                                "</button>"
                              : "") +
                          (a ? "" : M) +
                          "</div>"
                        : "",
                    w = parseInt(this._get(t, "firstDay"), 10);
                w = isNaN(w) ? 0 : w;
                for (
                    var C = this._get(t, "showWeek"),
                        I = this._get(t, "dayNames"),
                        x =
                            (this._get(t, "dayNamesShort"),
                            this._get(t, "dayNamesMin")),
                        N = this._get(t, "monthNames"),
                        A = this._get(t, "monthNamesShort"),
                        S = this._get(t, "beforeShowDay"),
                        T = this._get(t, "showOtherMonths"),
                        Y = this._get(t, "selectOtherMonths"),
                        F =
                            (this._get(t, "calculateWeek") || this.iso8601Week,
                            this._getDefaultDate(t)),
                        j = "",
                        P = 0;
                    P < s[0];
                    P++
                ) {
                    var O = "";
                    this.maxRows = 4;
                    for (var E = 0; E < s[1]; E++) {
                        var R = this._daylightSavingAdjust(
                                new this.CDate(g, p, t.selectedDay)
                            ),
                            H = " ui-corner-all",
                            K = "";
                        if (c) {
                            if (
                                ((K += '<div class="ui-datepicker-group'),
                                s[1] > 1)
                            )
                                switch (E) {
                                    case 0:
                                        (K += " ui-datepicker-group-first"),
                                            (H =
                                                " ui-corner-" +
                                                (a ? "right" : "left"));
                                        break;
                                    case s[1] - 1:
                                        (K += " ui-datepicker-group-last"),
                                            (H =
                                                " ui-corner-" +
                                                (a ? "left" : "right"));
                                        break;
                                    default:
                                        (K += " ui-datepicker-group-middle"),
                                            (H = "");
                                }
                            K += '">';
                        }
                        K +=
                            '<div class="ui-datepicker-header ui-widget-header ui-helper-clearfix' +
                            H +
                            '">' +
                            (/all|left/.test(H) && 0 == P ? (a ? k : m) : "") +
                            (/all|right/.test(H) && 0 == P ? (a ? m : k) : "") +
                            this._generateMonthYearHeader(
                                t,
                                p,
                                g,
                                u,
                                h,
                                P > 0 || E > 0,
                                N,
                                A
                            ) +
                            '</div><table class="ui-datepicker-calendar"><thead><tr>';
                        for (
                            var W = C
                                    ? '<th class="ui-datepicker-week-col">' +
                                      this._get(t, "weekHeader") +
                                      "</th>"
                                    : "",
                                L = 0;
                            L < 7;
                            L++
                        ) {
                            var U = (L + w) % 7;
                            W +=
                                "<th" +
                                ((L + w + 6) % 7 >= 5
                                    ? ' class="ui-datepicker-week-end"'
                                    : "") +
                                '><span title="' +
                                I[U] +
                                '">' +
                                x[U] +
                                "</span></th>";
                        }
                        K += W + "</tr></thead><tbody>";
                        var G = this._getDaysInMonth(g, p);
                        g == t.selectedYear &&
                            p == t.selectedMonth &&
                            (t.selectedDay = Math.min(t.selectedDay, G));
                        var z = (this._getFirstDayOfMonth(g, p) - w + 7) % 7,
                            B = Math.ceil((z + G) / 7),
                            Q = c && this.maxRows > B ? this.maxRows : B;
                        this.maxRows = Q;
                        for (
                            var J = this._daylightSavingAdjust(
                                    new this.CDate(g, p, 1 - z)
                                ),
                                V = 0;
                            V < Q;
                            V++
                        ) {
                            K += "<tr>";
                            var q = C
                                ? '<td class="ui-datepicker-week-col">' +
                                  this._get(t, "calculateWeek")(J) +
                                  "</td>"
                                : "";
                            for (L = 0; L < 7; L++) {
                                var Z = S
                                        ? S.apply(t.input ? t.input[0] : null, [
                                              J,
                                          ])
                                        : [!0, ""],
                                    X = J.getMonth() != p,
                                    tt =
                                        (X && !Y) ||
                                        !Z[0] ||
                                        (u && this._compareDate(J, "<", u)) ||
                                        (h && this._compareDate(J, ">", h));
                                (q +=
                                    '<td class="' +
                                    ((L + w + 6) % 7 >= 5
                                        ? " ui-datepicker-week-end"
                                        : "") +
                                    (X ? " ui-datepicker-other-month" : "") +
                                    ((J.getTime() == R.getTime() &&
                                        p == t.selectedMonth &&
                                        t._keyEvent) ||
                                    (F.getTime() == J.getTime() &&
                                        F.getTime() == R.getTime())
                                        ? " " + this._dayOverClass
                                        : "") +
                                    (tt
                                        ? " " +
                                          this._unselectableClass +
                                          " ui-state-disabled"
                                        : "") +
                                    (X && !T
                                        ? ""
                                        : " " +
                                          Z[1] +
                                          (J.getTime() == l.getTime()
                                              ? " " + this._currentClass
                                              : "") +
                                          (J.getTime() == e.getTime()
                                              ? " ui-datepicker-today"
                                              : "")) +
                                    '"' +
                                    ((X && !T) || !Z[2]
                                        ? ""
                                        : ' title="' + Z[2] + '"') +
                                    (tt
                                        ? ""
                                        : ' data-handler="selectDay" data-event="click" data-month="' +
                                          J.getMonth() +
                                          '" data-year="' +
                                          J.getFullYear() +
                                          '"') +
                                    ">" +
                                    (X && !T
                                        ? "&#xa0;"
                                        : tt
                                        ? '<span class="ui-state-default">' +
                                          J.getDate() +
                                          "</span>"
                                        : '<a class="ui-state-default' +
                                          (J.getTime() == e.getTime()
                                              ? " ui-state-highlight"
                                              : "") +
                                          (J.getTime() == l.getTime()
                                              ? " ui-state-active"
                                              : "") +
                                          (X ? " ui-priority-secondary" : "") +
                                          '" href="#">' +
                                          J.getDate() +
                                          "</a>") +
                                    "</td>"),
                                    J.setDate(J.getDate() + 1),
                                    (J = this._daylightSavingAdjust(J));
                            }
                            K += q + "</tr>";
                        }
                        ++p > 11 && ((p = 0), g++),
                            (O += K +=
                                "</tbody></table>" +
                                (c
                                    ? "</div>" +
                                      (s[0] > 0 && E == s[1] - 1
                                          ? '<div class="ui-datepicker-row-break"></div>'
                                          : "")
                                    : ""));
                    }
                    j += O;
                }
                return (
                    (j +=
                        b +
                        ($.ui.ie6 && !t.inline
                            ? '<iframe src="javascript:false;" class="ui-datepicker-cover" frameborder="0"></iframe>'
                            : "")),
                    (t._keyEvent = !1),
                    j
                );
            },
            _generateMonthYearHeader: function (t, e, a, i, r, n, s, o) {
                var d = this._get(t, "changeMonth"),
                    c = this._get(t, "changeYear"),
                    l = this._get(t, "showMonthAfterYear"),
                    u = '<div class="ui-datepicker-title">',
                    h = "";
                if (n || !d)
                    h +=
                        '<span class="ui-datepicker-month">' + s[e] + "</span>";
                else {
                    var p = i && i.getFullYear() == a,
                        g = r && r.getFullYear() == a;
                    h +=
                        '<select class="ui-datepicker-month" data-handler="selectMonth" data-event="change">';
                    for (var f = 0; f < 12; f++)
                        (!p || f >= i.getMonth()) &&
                            (!g || f <= r.getMonth()) &&
                            (h +=
                                '<option value="' +
                                f +
                                '"' +
                                (f == e ? ' selected="selected"' : "") +
                                ">" +
                                o[f] +
                                "</option>");
                    h += "</select>";
                }
                if (
                    (l || (u += h + (!n && d && c ? "" : "&#xa0;")),
                    !t.yearshtml)
                )
                    if (((t.yearshtml = ""), n || !c))
                        u +=
                            '<span class="ui-datepicker-year">' + a + "</span>";
                    else {
                        var _ = this._get(t, "yearRange").split(":"),
                            m = new this.CDate().getFullYear(),
                            D = function (t) {
                                var e = t.match(/c[+-].*/)
                                    ? a + parseInt(t.substring(1), 10)
                                    : t.match(/[+-].*/)
                                    ? m + parseInt(t, 10)
                                    : parseInt(t, 10);
                                return isNaN(e) ? m : e;
                            },
                            k = D(_[0]),
                            v = Math.max(k, D(_[1] || ""));
                        for (
                            k = i ? Math.max(k, i.getFullYear()) : k,
                                v = r ? Math.min(v, r.getFullYear()) : v,
                                t.yearshtml +=
                                    '<select class="ui-datepicker-year" data-handler="selectYear" data-event="change">';
                            k <= v;
                            k++
                        )
                            t.yearshtml +=
                                '<option value="' +
                                k +
                                '"' +
                                (k == a ? ' selected="selected"' : "") +
                                ">" +
                                k +
                                "</option>";
                        (t.yearshtml += "</select>"),
                            (u += t.yearshtml),
                            (t.yearshtml = null);
                    }
                return (
                    (u += this._get(t, "yearSuffix")),
                    l && (u += (!n && d && c ? "" : "&#xa0;") + h),
                    (u += "</div>")
                );
            },
            _adjustInstDate: function (t, e, a) {
                var i = t.drawYear + ("Y" == a ? e : 0),
                    r = t.drawMonth + ("M" == a ? e : 0),
                    n =
                        Math.min(t.selectedDay, this._getDaysInMonth(i, r)) +
                        ("D" == a ? e : 0),
                    s = this._restrictMinMax(
                        t,
                        this._daylightSavingAdjust(new this.CDate(i, r, n))
                    );
                (t.selectedDay = s.getDate()),
                    (t.drawMonth = t.selectedMonth = s.getMonth()),
                    (t.drawYear = t.selectedYear = s.getFullYear()),
                    ("M" != a && "Y" != a) || this._notifyChange(t);
            },
            _restrictMinMax: function (t, e) {
                var a = this._getMinMaxDate(t, "min"),
                    i = this._getMinMaxDate(t, "max"),
                    r = a && this._compareDate(e, "<", a) ? a : e;
                return (r = i && this._compareDate(r, ">", i) ? i : r);
            },
            _notifyChange: function (t) {
                var e = this._get(t, "onChangeMonthYear");
                e &&
                    e.apply(t.input ? t.input[0] : null, [
                        t.selectedYear,
                        t.selectedMonth + 1,
                        t,
                    ]);
            },
            _getNumberOfMonths: function (t) {
                var e = this._get(t, "numberOfMonths");
                return null == e ? [1, 1] : "number" == typeof e ? [1, e] : e;
            },
            _getMinMaxDate: function (t, e) {
                return this._determineDate(t, this._get(t, e + "Date"), null);
            },
            _getDaysInMonth: function (t, e) {
                return (
                    32 -
                    this._daylightSavingAdjust(
                        new this.CDate(t, e, 32)
                    ).getDate()
                );
            },
            _getFirstDayOfMonth: function (t, e) {
                return new this.CDate(t, e, 1).getDay();
            },
            _canAdjustMonth: function (t, e, a, i) {
                var r = this._getNumberOfMonths(t),
                    n = this._daylightSavingAdjust(
                        new this.CDate(a, i + (e < 0 ? e : r[0] * r[1]), 1)
                    );
                return (
                    e < 0 &&
                        n.setDate(
                            this._getDaysInMonth(n.getFullYear(), n.getMonth())
                        ),
                    this._isInRange(t, n)
                );
            },
            _isInRange: function (t, e) {
                var a = this._getMinMaxDate(t, "min"),
                    i = this._getMinMaxDate(t, "max");
                return (
                    (!a || e.getTime() >= a.getTime()) &&
                    (!i || e.getTime() <= i.getTime())
                );
            },
            _getFormatConfig: function (t) {
                var e = this._get(t, "shortYearCutoff");
                return (
                    (this.CDate = this._get(t, "calendar")),
                    {
                        shortYearCutoff: (e =
                            "string" != typeof e
                                ? e
                                : (new this.CDate().getFullYear() % 100) +
                                  parseInt(e, 10)),
                        dayNamesShort: this._get(t, "dayNamesShort"),
                        dayNames: this._get(t, "dayNames"),
                        monthNamesShort: this._get(t, "monthNamesShort"),
                        monthNames: this._get(t, "monthNames"),
                    }
                );
            },
            _formatDate: function (t, e, a, i) {
                e ||
                    ((t.currentDay = t.selectedDay),
                    (t.currentMonth = t.selectedMonth),
                    (t.currentYear = t.selectedYear));
                var r = e
                    ? "object" == typeof e
                        ? e
                        : this._daylightSavingAdjust(new this.CDate(i, a, e))
                    : this._daylightSavingAdjust(
                          new this.CDate(
                              t.currentYear,
                              t.currentMonth,
                              t.currentDay
                          )
                      );
                return this.formatDate(
                    this._get(t, "dateFormat"),
                    r,
                    this._getFormatConfig(t)
                );
            },
            _compareDate: function (t, e, a) {
                return t && a
                    ? (t.getGregorianDate && (t = t.getGregorianDate()),
                      a.getGregorianDate && (a = a.getGregorianDate()),
                      "<" == e ? t < a : t > a)
                    : null;
            },
        }),
            ($.fn.datepicker = function (t) {
                if (!this.length) return this;
                $.datepicker.initialized ||
                    ($(document)
                        .mousedown($.datepicker._checkExternalClick)
                        .find(document.body)
                        .append($.datepicker.dpDiv),
                    ($.datepicker.initialized = !0));
                var e = Array.prototype.slice.call(arguments, 1);
                return "string" != typeof t ||
                    ("isDisabled" != t && "getDate" != t && "widget" != t)
                    ? "option" == t &&
                      2 == arguments.length &&
                      "string" == typeof arguments[1]
                        ? $.datepicker["_" + t + "Datepicker"].apply(
                              $.datepicker,
                              [this[0]].concat(e)
                          )
                        : this.each(function () {
                              "string" == typeof t
                                  ? $.datepicker["_" + t + "Datepicker"].apply(
                                        $.datepicker,
                                        [this].concat(e)
                                    )
                                  : $.datepicker._attachDatepicker(this, t);
                          })
                    : $.datepicker["_" + t + "Datepicker"].apply(
                          $.datepicker,
                          [this[0]].concat(e)
                      );
            }),
            ($.datepicker = new Datepicker()),
            ($.datepicker.initialized = !1),
            ($.datepicker.uuid = new Date().getTime()),
            ($.datepicker.version = "1.9.1"),
            (window["DP_jQuery_" + dpuuid] = $);
    })(jQuery);
