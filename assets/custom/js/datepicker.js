var ComponentsDateTimePickers = function() {
    var t = function() {
            jQuery().datepicker && $(".date-picker").datepicker({
                rtl: App.isRTL(),
                orientation: "bottom",
                autoclose: !0,
                format: 'dd-mm-yyyy',
                }), $(document).scroll(function() {
                    $("#form_input_user .date-picker").datepicker("place")
            });
        },
        f = function() {
            jQuery().datepicker && $(".date-picker-from").datepicker({
                rtl: App.isRTL(),
                orientation: "bottom",
                autoclose: !0,
                format: 'dd-mm-yyyy',
                 minDate: new Date(2009, 10 - 1, 25),

                }), $(document).scroll(function() {
                    $("#form_input_user .date-picker-from").datepicker("place")
            });
        },
        e = function() {
            jQuery().timepicker && ($(".timepicker-default").timepicker({
                autoclose: !0,
                showSeconds: !0,
                minuteStep: 1
            }), $(".timepicker-no-seconds").timepicker({
                autoclose: !0,
                minuteStep: 5
            }), $(".timepicker-24").timepicker({
                showSeconds: !0,
                autoclose: !0,
                minuteStep: 1,
                secondStep: 1,
                showMeridian: !1
            }), $(".timepicker").parent(".input-group").on("click", ".input-group-btn", function(t) {
                t.preventDefault(), $(this).parent(".input-group").find(".timepicker").timepicker("showWidget")
            }), $(document).scroll(function() {
                $("#form_input_user .timepicker-default, #form_input_user .timepicker-no-seconds, #form_input_user .timepicker-24").timepicker("place")
            }))
        },
        to = function() {
            jQuery().datepicker && $(".date-picker-to").datepicker({
                rtl: App.isRTL(),
                orientation: "bottom",
                autoclose: !0,
                 format: 'dd-mm-yyyy',
                }), $(document).scroll(function() {
                    $("#form_input_user .date-picker-to").datepicker("place")
            });
        };
    return {
        init: function() {
            t(),f(),to(),e()
        }
    }
}();
App.isAngularJsApp() === !1 && jQuery(document).ready(function() {
    ComponentsDateTimePickers.init()
});