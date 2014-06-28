jQuery.fn.bdValidate = function() {"use strict";
    var value = "";
    if (this[0].tagName.toLowerCase() === "input") {
        value = this.val();
    } else {
        value = this.text();
    }

    if (value === "") {
        this.addClass('error');
        return false;
    } else {
        this.removeClass('error');
        return true;
    }
};

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

    function processAttendance() {

        $.ajax({
            url : "././dbConnectController.php",
            type : "POST",
            data : ( {
                action : "getAttendance"
            }),
            dataType : "text"
        }).done(function(result) {
            console.log('result: ' + result);
            $('.checkbox').removeClass('selected');
            // $('.checkbox:data(value==' + result + ')').addClass('selected');
        }).fail().always();
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
                processAttendance();
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

    function showNavInstant() {
        $('#btnAttendance').trigger('click');
        $('#btnLogin').text('Logout').attr('id', 'btnLogout');
    }

    function showNav() {
        $('#btnLogin').text('Logout').attr('id', 'btnLogout');
        //$('#ctnLogin .table-row').fadeOut();
        $('#btnAttendance').fadeIn(400, function() {
            $('#btnAttendance').trigger('click');
            $('#btnProvision').fadeIn(400, function() {
                $('#btnLocation').fadeIn(400, function() {
                    $('#btnAccommodation').fadeIn(400);
                });
            });
        });
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
        }).on('keyup', function(e) {
            var code = e.keyCode || e.which;
            if (code === 13) {
                btnPassWordClick();
            }
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
        }).on('keyup', function(e) {
            var code = e.keyCode || e.which;
            if (code === 13) {
                btnPassWordClick();
            }
        });

        function btnPassWordClick() {
            var check = ($('#tbUser').bdValidate() && $('#tbPassword').bdValidate())

            if (check) {
                $('#btnPassword').off().addClass('black');
                $('#pwLoader').removeClass('hidden');
                $.ajax({
                    url : "././dbConnectController.php",
                    type : "POST",
                    data : ( {
                        action : "validateUser",
                        usr : $('#tbUser').val(),
                        pw : $('#tbPassword').val()
                    }),
                    dataType : "text"
                }).done(function(result) {
                    result = $.trim(result);
                    if (result === "LOGIN FAILED") {
                        $('.content').effect('shake', {
                            direction : "left",
                            distance : 5,
                            times : 1
                        });
                    } else {
                        $('nav').prepend(result);
                        showNav();
                    }
                }).fail(function(result) {
                    $('#pwLoader').addClass('hidden');
                    $('#btnPassword').on('click', btnPassWordClick).removeClass('black');
                    $('.bigButtonContainer').effect('shake', {
                        distance : 10,
                        times : 2
                    });
                    console.log(result);
                }).always(function() {
                });
            }
        }

        function btnLogoutClick() {
            $.ajax({
                url : "././dbConnectController.php",
                type : "POST",
                data : ( {
                    action : "logoutUser"
                })
            }).always(function() {
                $('#tbUser').val("Nutzername").trigger('blur');
                $('#tbPassword').val("Passwort").trigger('blur');
                $('nav').children('div').not('#btnLogout').remove();
                $('#ctnLogin .table-row').show();
                $('#btnLogout').text('Login');
                $('#btnLogout').attr('id', 'btnLogin');
            });
        }

        // EVENT BINDING

        $(window).on('resize', positionWrapper);

        $('nav').on('click', '.navButton', positionWrapper).on('mouseover', '.navButton', function() {
            if ($(this).hasClass('active') === false) {
                $(this).addClass('active hover');
            }
        }).on('mouseleave', '.navButton', function() {
            if ($(this).hasClass('hover') === true) {
                $(this).removeClass('active hover');
            }
        });

        $('nav').on('click', '#btnLogout', btnLogoutClick);
        $('#btnPassword').on('click', btnPassWordClick);
    });
});
