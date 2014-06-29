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
        return $.ajax({
            url : "././dbConnectController.php",
            type : "POST",
            data : ( {
                action : "getAttendance"
            })
        });
    }

    function positionWrapper(event) {
        var innerWrap = $('#innerWrapper'), body = $('body'), marVal = innerWrap.css('margin-left'), bgImg, windowWidth1015 = $(window).width() <= 1015, resizeEvent = event.type === "resize", that;

        if (resizeEvent === true) {
            that = $('.navButton.active:not(.hover)');
            innerWrap.removeClass('transisitionAllMed');
        } else {
            that = $(event.target);
            $('.navButton.active').addClass('pointer');
            $('.navButton').removeClass('active hover');
            that.addClass('active');
            that.removeClass('pointer');
        }

        switch (that.attr('id')) {
            case "btnAttendance":
                marVal = windowWidth1015 ? -1190 : -1390;
                break;
            case "btnProvision":
                marVal = windowWidth1015 ? -2380 : -2780;
                break;
            case "btnLocation":
                marVal = windowWidth1015 ? -3570 : -4170;
                break;
            case "btnAccommodation":
                marVal = windowWidth1015 ? -4760 : -5560;
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
        var navDfd = $.Deferred();
        $('#btnLogin').text('Logout').attr('id', 'btnLogout');
        //$('#ctnLogin .table-row').fadeOut();
        $('#btnAttendance').fadeIn(400, function() {
            $('#btnAttendance').trigger('click');
            $('#btnProvision').fadeIn(400, function() {
                $('#btnLocation').fadeIn(400, function() {
                    $('#btnAccommodation').fadeIn(400, function() {
                        navDfd.resolve();
                    });
                });
            });
        });

        return navDfd.promise();
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

        $('#tbEmail').on('focus', function() {
            var that = $(this);
            if (that.val() === "" || that.val() === "Email") {
                that.removeClass('inital');
                that.val('');
            }
            that.addClass('active');
        }).on('blur', function() {
            var that = $(this);
            if (that.val() === "" || that.val() === "Email") {
                that.addClass('inital');
                that.val('Email');
            }
            that.removeClass('active');
        }).on('keyup', function(e) {
            var code = e.keyCode || e.which;
            if (code === 13) {
                btnEmailClick();
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
            var check = ($('#tbUser').bdValidate() && $('#tbPassword').bdValidate()), dfdPw;

            if (check) {
                $('#btnPassword').off().addClass('loading');
                $('#pwLoader').removeClass('hidden');
                dfdPw = $.ajax({
                    url : "././dbConnectController.php",
                    type : "POST",
                    data : ( {
                        action : "validateUser",
                        usr : $('#tbUser').val(),
                        pw : $('#tbPassword').val()
                    }),
                    dataType : "text"
                }).done(function(result) {
                    processAttendance().done(function(attendanceResult) {
                        attendanceResult = $.trim(attendanceResult);
                        $('.checkbox').removeClass('checked');
                        $('.checkbox[data-value=' + attendanceResult + ']').addClass('checked');
                    }).always(function() {
                        result = $.trim(result);
                        $('nav').prepend(result);
                        showNav().always(function() {
                            $('#pwLoader').addClass('hidden');
                            $('#btnPassword').on('click', btnPassWordClick).removeClass('loading');
                        });
                    });
                }).fail(function(result) {
                    $('.bigButtonContainer').effect('shake', {
                        distance : 10,
                        times : 2
                    });
                    $('#pwLoader').addClass('hidden');
                    $('#btnPassword').on('click', btnPassWordClick).removeClass('loading');
                })
            }
        }

        function btnLogoutClick() {
            $('#tbUser').val("Nutzername").trigger('blur');
            $('#tbPassword').val("Passwort").trigger('blur');
            $('nav').children('div').not('#btnLogout').remove();
            $('#ctnLogin .table-row').show();
            $('#btnLogout').text('Login');
            $('#btnLogout').attr('id', 'btnLogin');

            $.ajax({
                url : "././dbConnectController.php",
                type : "POST",
                data : ( {
                    action : "logoutUser"
                })
            });
        }

        function btnEmailClick() {
            var tbEmail = $('#tbEmail'), check = tbEmail.bdValidate(), emailVal = tbEmail.val();
            if (check) {
                $('#btnEmail').off().addClass('loading');
                $('#emailLoader').removeClass('hidden');
                $.ajax({
                    url : "././dbConnectController.php",
                    type : "POST",
                    data : ( {
                        action : "setEmail",
                        val : emailVal
                    })
                }).done(function() {
                    location.reload();
                }).fail(function() {
                    $('.bigButtonContainer').effect('shake', {
                        distance : 10,
                        times : 2
                    });
                    tbEmail.addClass('error');
                }).always(function() {
                    $('#btnEmail').on('click', btnEmailClick).removeClass('loading');
                    $('#emailLoader').addClass('hidden');
                });
            }
        }

        function cbAttendanceClick() {
            var that = $(this), checkedVal = that.data('value'), cbLoader = that.children('.cbLoading');

            if (!that.hasClass('checked')) {
                cbLoader.removeClass('hidden');
                that.removeClass('pointer').off();

                $.ajax({
                    url : "././dbConnectController.php",
                    type : "POST",
                    data : ( {
                        action : "setAttendance",
                        val : checkedVal
                    })
                }).done(function() {
                    cbLoader.addClass('hidden');
                    $('.checkbox.checked').removeClass('checked').addClass('pointer');
                    that.addClass('checked');
                }).always(function() {
                    $('#cbAttendance').find('.checkbox').not('.checked').on('click', cbAttendanceClick);
                });
            }

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
        $('#btnEmail').on('click', btnEmailClick);
        $('#cbAttendance').find('.checkbox').on('click', cbAttendanceClick);

    });
});
