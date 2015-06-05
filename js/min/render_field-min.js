jQuery(document).ready(function ($) {
    var e = $(".acf-address-field");
    e.each(function (e, a) {
        var t = $(a), l = t.data("name"), n = t.data("value"), p = t.data("layout"), u = t.data("options");
        n = $.extend({
            street1: null,
            street2: null,
            street3: null,
            city: null,
            state: null,
            zip: null,
            country: null
        }, n), $.each(p, function (e, a) {
            var p = $("<ul/>");
            $.each(a, function (e, a) {
                var t = $("<li/>"), d = l + "[" + a.id + "]";
                t.append($("<label/>").prop("for", d).text(u[a.id].label)), t.append($('<input type="text"/>').prop("name", d).prop("value", n[a.id]).prop("placeholder", u[a.id].defaultValue)), p.append(t)
            }), t.append(p)
        })
    })
});