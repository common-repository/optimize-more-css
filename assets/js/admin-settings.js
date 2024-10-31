!(function (e) {
    var t = {};
    function i(r) {
        if (t[r]) return t[r].exports;
        var n = (t[r] = { i: r, l: !1, exports: {} });
        return e[r].call(n.exports, n, n.exports, i), (n.l = !0), n.exports;
    }
    (i.m = e),
        (i.c = t),
        (i.d = function (e, t, r) {
            i.o(e, t) || Object.defineProperty(e, t, { enumerable: !0, get: r });
        }),
        (i.r = function (e) {
            "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, { value: "Module" }), Object.defineProperty(e, "__esModule", { value: !0 });
        }),
        (i.t = function (e, t) {
            if ((1 & t && (e = i(e)), 8 & t)) return e;
            if (4 & t && "object" == typeof e && e && e.__esModule) return e;
            var r = Object.create(null);
            if ((i.r(r), Object.defineProperty(r, "default", { enumerable: !0, value: e }), 2 & t && "string" != typeof e))
                for (var n in e)
                    i.d(
                        r,
                        n,
                        function (t) {
                            return e[t];
                        }.bind(null, n)
                    );
            return r;
        }),
        (i.n = function (e) {
            var t =
                e && e.__esModule
                    ? function () {
                          return e.default;
                      }
                    : function () {
                          return e;
                      };
            return i.d(t, "a", t), t;
        }),
        (i.o = function (e, t) {
            return Object.prototype.hasOwnProperty.call(e, t);
        }),
        (i.p = "/"),
        i((i.s = 0));
})([
    function (e, t, i) {
        i(1), i(6), (e.exports = i(11));
    },
    function (e, t) {
        jQuery(document).ready(function () {
            jQuery(".opm_css-next-step").on("click", function () {
                jQuery("#opm_css_tab_step-1").hide(), jQuery("#tab-step-1").hide(), jQuery("#opm_css_tab_step-2").show(), jQuery("#tab-step-2").show();
            }),
                jQuery(".opm_css-prev-step").on("click", function () {
                    jQuery("#opm_css_tab_step-2").hide(), jQuery("#tab-step-2").hide(), jQuery("#opm_css_tab_step-1").show(), jQuery("#tab-step-1").show();
                }),
                jQuery("form.opm_css-form").areYouSure({ message: "Changes that you made may not be saved" }),
                
                
                jQuery(".reset-confirm").click(function () {
                    if (0 == confirm("Are you sure you want to reset!")) return !1;
                });
            var e = jQuery(".opm_css_wrapper .navigation"),
                t = e.offset();
            function i(e) {
                var t = jQuery(".opm_css-form"),
                    i = t.attr("action");
                -1 !== i.indexOf("#") && ((hash = i.replace(/.*#/, "#")), (i = i.replace(/#.*/, ""))), t.attr({ action: i + "#" + e });
            }
            
                jQuery(".opm_css-navigation ul li a:not(.opm_css-ignore)").click(function () {
                    var e = jQuery(this).attr("data-tab");
                    jQuery(".opm_css-navigation ul li a").removeClass("current"),
                        jQuery(".tab-content").removeClass("current"),
                        jQuery(this).addClass("current"),
                        jQuery(".opm_css_content section").removeClass("current"),
                        jQuery(".opm_css_content section." + e).addClass("current"),
                        i(e),
                        jQuery("html, body").animate({ scrollTop: 0 }, 400);
                });
            var r = window.location.hash;
            "" != (r = r.replace("#", ""))
                ? (jQuery(".opm_css-navigation ul li a#opm_css_" + r).addClass("current"), jQuery(".opm_css_content section." + r).addClass("current"), i(r))
                : 0 == jQuery(".opm_css_content section.current").length && (jQuery(".opm_css_content section").eq(0).addClass("current"), jQuery(".opm_css-navigation ul li").eq(0).find("a").addClass("current")),
                
                jQuery(".opm_css-select2").select2({ width: "100%", placeholder: "Select" });
        }),
            
            jQuery(document).ready(function () {
                jQuery('.main-toggle[type="checkbox"]')
                    .change(function (e) {
                        var t = jQuery(this).prop("checked"),
                            i = jQuery(this).attr("data-revised"),
                            r = jQuery(this).parents(".toggle-group").find(".sub-fields");
                        r.length && ((t && "1" != i && r.find('input[type="checkbox"]:checked').length == r.find('input[type="checkbox"]').length) || (!t && "1" == i) ? r.hide() : r.show());
                    })
                    .trigger("change"),
                    jQuery(".opm_css-toggle-arrow").on("click", function () {
                        jQuery(this).toggleClass("active"), jQuery(this).next("ul").slideToggle();
                    }),
                    jQuery("#enable_opm_css_admin")
                        .on("change", function () {
                            jQuery(this).is(":checked") ? jQuery(".menu-admin-wrapper").show() : jQuery(".menu-admin-wrapper").hide();
                        })
                        .trigger("change"),
                    jQuery(".enable_welcome_for_all_roles")
                        .on("change", function () {
                            var e = jQuery("#select_user_roles" + jQuery(this).data("section"));
                            jQuery(this).is(":checked") ? e.hide() : e.show();
                        })
                        .trigger("change"),
                    jQuery('.opm_css-toggle[type="checkbox"]').change(function (e) {
                        var t = jQuery(this).prop("checked"),
                            i = jQuery(this).parent();
                        i.siblings();
                        i.find('input[type="checkbox"]').prop({ checked: t }),
                            (function e(i) {
                                var r = i.parent().parent(),
                                    n = !0;
                                if (
                                    (i.siblings().each(function () {
                                        return (n = jQuery(this).children('input[type="checkbox"]').prop("checked") === t);
                                    }),
                                    n && t)
                                )
                                    r.children('input[type="checkbox"]').prop({ checked: t }), e(r);
                                else if (n && !t) r.children('input[type="checkbox"]').prop("checked", t), r.children('input[type="checkbox"]').prop("indeterminate", r.find('input[type="checkbox"]:checked').length > 0), e(r);
                                else {
                                    var s = !0;
                                    i.parents("li").children('input[type="checkbox"]').hasClass("main-toggle-reverse") && (s = !1), i.parents("li").children('input[type="checkbox"]').prop({ checked: s });
                                }
                            })(i);
                    })
			
            });
    },
    ,
    ,
    ,
    ,
    function (e, t) {},
    ,
    ,
    ,
    ,
    function (e, t) {},
]);

jQuery(document).ready(function ($) {
    var notice = $(".opm_css-notice");
    if (notice.length && notice.hasClass("is-dismissible")) {
        window.setTimeout(function () {
            notice.fadeOut(800);
        }, 0);
    }
});



jQuery(document).ready(function () {
  jQuery(".show-hide")
    .change(function (e) {
      var t = jQuery(this).prop("checked"),
        i = jQuery(this).attr("data-show-hide"),
        r = jQuery(this).parents(".show-hide-group").find(".show-hide-content");
      	r.length && ((t && "1" != i && r.find('input[type="checkbox"]:checked').length == r.find('input[type="checkbox"]').length) || (!t && "1" == i) ? r.fadeOut() : r.fadeIn());
    })
    .trigger("change"),
  jQuery(".accordion")
       .on("change", function () {
            jQuery(this).is(":checked") ? jQuery(".accordion-panel").fadeIn() : jQuery(".accordion-panel").fadeOut();
    })
    .trigger("change");
});