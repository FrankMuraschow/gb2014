jQuery(function($) {"use strict";

    function getParameter(paramName) {
        var searchString = window.location.search.substring(1), i, val, params = searchString.split("&");
        for ( i = 0; i < params.length; i++) {
            val = params[i].split("=");
            if (val[0] === paramName) {
                return unescape(val[1]);
            }
        }
        return null;
    }

    function positionWrapper(event) {
        var innerWrap = $('#innerWrapper'), body = $('body'), marVal = innerWrap.css('margin-left'), bgImg, windowWidth1015 = $(window).width() <= 1015, resizeEvent = event.type === "resize", that;

        if (resizeEvent === true) {
            that = $('.navButton.active:not(.hover)');
            innerWrap.removeClass('transisitionAllMed');
        } else {
            that = $(event.target);
            $('.navButton').removeClass('active hover');
            that.addClass('active');
        }

        switch (that.attr('id')) {
            case "btnAttendance":
                marVal = windowWidth1015 ? -1190 : -1390;
                break;
            case "btnProvision":
                marVal = windowWidth1015 ? -2380 : -2781;
                break;
            case "btnLocation":
                marVal = windowWidth1015 ? -3570 : -4171;
                break;
            case "btnAccommodation":
                marVal = windowWidth1015 ? -4760 : -5562;
                break;
            case "btnLogout":
                marVal = windowWidth1015 ? -0 : 0;
                break;
        }

        innerWrap.css('margin-left', marVal);

        if (resizeEvent === true) {
            window.setTimeout(function() {
                innerWrap.addClass('transisitionAllMed');
            }, 1);
        }
    }


    $(document).ready(function() {
        var innerWrap = $('#innerWrapper'), body = $('body');

        $('#tbPassword').on('focus', function() {
            var that = $(this);
            if (that.val() === "" || that.val() === "Passwort") {
                that.removeClass('inital');
                that.val('');
            }
            that.addClass('active');
        }).on('blur', function() {
            var that = $(this);
            if (that.val() === "" || that.val() === "Passwort") {
                that.addClass('inital');
                that.val('Passwort');
            }
            that.removeClass('active');
        });

        $('#tbUser').on('focus', function() {
            var that = $(this);
            if (that.val() === "" || that.val() === "Nutzername") {
                that.removeClass('inital');
                that.val('');
            }
            that.addClass('active');
        }).on('blur', function() {
            var that = $(this);
            if (that.val() === "" || that.val() === "Nutzername") {
                that.addClass('inital');
                that.val('Nutzername');
            }
            that.removeClass('active');
        });

        $('#btnPassword').on('click', function() {
            console.log($('#tbUser').val());
            console.log($('#tbPassword').val());
            $.ajax({
                url : "././dbConnectController.php",
                type : "POST",
                data : ( {
                    action : "validateUser",
                    usr : $('#tbUser').val(),
                    pw : $('#tbPassword').val()
                }),
                dataType : "text",
                success : function(result) {
                    console.log(result);
                    result = $.trim(result);
                }
            });
        })

        $(window).on('resize', positionWrapper);

        $('.navButton').on('click', positionWrapper).on('mouseover', function() {
            if ($(this).hasClass('active') === false) {
                $(this).addClass('active hover');
            }
        }).on('mouseleave', function() {
            if ($(this).hasClass('hover') === true) {
                $(this).removeClass('active hover');
            }
        });
    });
});
