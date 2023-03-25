'use strict';
//  Author: ThemeREX.com
//  forms-validation.html scripts
//

(function($) {

    $(document).ready(function() {

        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();

        $.validator.methods.smartCaptcha = function(value, element, param) {
            return value == param;
        };

        $("#allcp-form").validate({

            // States

            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",

            // Rules

            rules: {
                sponsorname: {
                    required: true
                },
                firstname: {
                    required: true
                },
                lastname: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                username: {
                    required: true,
                    minlength: 5,
                    maxlength: 16
                },
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 16
                },
                confirmPassword: {
                    required: true,
                    minlength: 6,
                    maxlength: 16,
                    equalTo : "#password"
                },
                address: {
                    required: true
                },
                city: {
                    required: true
                },
                country: {
                    required: true
                },
                phone: {
                    required: true,
                    minlength: 10,
                    maxlength: 13
                }
                
            },

            // error message
            messages: {
                sponsorname: {
                    required: 'Please enter sponsor name'
                },
                firstname: {
                    required: 'Please enter first name'
                },
                lastname: {
                    required: 'Please enter last name'
                },
                email: {
                    required: 'Please enter Email',
                    email: 'Enter a VALID email address'
                },
                username: {
                    required: 'Please enter User name'
                },
                password: {
                    required: 'Please enter password',
                },
                confirmPassword: {
                    required: 'Please enter confirm password',
                    equalTo: 'Please enter confirm password'
                },
                address: {
                    required: 'Please enter User Address'
                },
                city: {
                    required: 'Please enter User City'
                },
                country: {
                    required: 'Please select country'
                },
                phone: {
                    required: 'Please enter Phone Number'
                }
                
                

            },


            highlight: function(element, errorClass, validClass) {
                $(element).closest('.field').addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('.field').removeClass(errorClass).addClass(validClass);
            },
            errorPlacement: function(error, element) {
                if (element.is(":radio") || element.is(":checkbox")) {
                    element.closest('.option-group').after(error);
                } else {
                    error.insertAfter(element.parent());
                }
            },
            errorPlacement: function(error, element) {
                if (element.is(":select") || element.is(":selected")) {
                    element.closest('.option-group').after(error);
                } else {
                    error.insertAfter(element.parent());
                }
            }
        });


        // Cache DOM
        var pageHeader = $('.content-header').find('b');
        var allcpForm = $('.allcp-form');
        var options = allcpForm.find('.option');
        var switches = allcpForm.find('.switch');
        var buttons = allcpForm.find('.button');
        var Panel = allcpForm.find('.panel');

        // Skin Switcher
        $('#skin-switcher a').on('click', function() {
            var btnData = $(this).data('form-skin');

            $('#skin-switcher a').removeClass('item-active');
            $(this).addClass('item-active');

            allcpForm.each(function(i, e) {
                var skins = 'theme-primary theme-info theme-success theme-warning theme-danger theme-alert theme-system theme-dark';
                var panelSkins = 'panel-primary panel-info panel-success panel-warning panel-danger panel-alert panel-system panel-dark';
                $(e).removeClass(skins).addClass('theme-' + btnData);
                Panel.removeClass(panelSkins).addClass('panel-' + btnData);
                pageHeader.removeClass().addClass('text-' + btnData);
            });

            $(options).each(function(i, e) {
                if ($(e).hasClass('block')) {
                    $(e).removeClass().addClass('block mt15 option option-' + btnData);
                } else {
                    $(e).removeClass().addClass('option option-' + btnData);
                }
            });

            $('body').find('.ui-slider').each(function(i, e) {
                $(e).addClass('slider-primary');
            });

            $(switches).each(function(i, ele) {
                if ($(ele).hasClass('switch-round')) {
                    if ($(ele).hasClass('block')) {
                        $(ele).removeClass().addClass('block mt15 switch switch-round switch-' + btnData);
                    } else {
                        $(ele).removeClass().addClass('switch switch-round switch-' + btnData);
                    }
                } else {
                    if ($(ele).hasClass('block')) {
                        $(ele).removeClass().addClass('block mt15 switch switch-' + btnData);
                    } else {
                        $(ele).removeClass().addClass('switch switch-' + btnData);
                    }
                }

            });
            buttons.removeClass().addClass('button btn-' + btnData);
        });

        setTimeout(function() {
            allcpForm.addClass('theme-primary');
            Panel.addClass('panel-primary');
            pageHeader.addClass('text-primary');

            $(options).each(function(i, e) {
                if ($(e).hasClass('block')) {
                    $(e).removeClass().addClass('block mt15 option option-primary');
                } else {
                    $(e).removeClass().addClass('option option-primary');
                }
            });

            $('body').find('.ui-slider').each(function(i, e) {
                $(e).addClass('slider-primary');
            });

            $(switches).each(function(i, ele) {
                if ($(ele).hasClass('switch-round')) {
                    if ($(ele).hasClass('block')) {
                        $(ele).removeClass().addClass('block mt15 switch switch-round switch-primary');
                    } else {
                        $(ele).removeClass().addClass('switch switch-round switch-primary');
                    }
                } else {
                    if ($(ele).hasClass('block')) {
                        $(ele).removeClass().addClass('block mt15 switch switch-primary');
                    } else {
                        $(ele).removeClass().addClass('switch switch-primary');
                    }
                }
            });
            buttons.removeClass().addClass('button btn-primary');
        }, 800);
    });

})(jQuery);
