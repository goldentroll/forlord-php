

// Checkout
$(document).delegate('#button-account', 'click', function() {
    $.ajax({
        url: 'checkout/' + $('input[name=\'account\']:checked').val(),
        dataType: 'html',
        beforeSend: function() {
            $('#button-account').button('loading');
        },
        complete: function() {
            $('#button-account').button('reset');
        },
        success: function(html) {
            $('.alert, .text-danger').remove();

            $('#payment-address .panel-heading').after(html);

            if ($('input[name=\'account\']:checked').val() == 'register') {
                $('#payment-address-content').parent().find('.panel-heading .panel-title').html('<a data-toggle="collapse" data-parent="#checkout-page" href="#payment-address-content" class="accordion-toggle"> <i class="fa fa-print"></i> Account &amp; Billing Details </a> ');
            } else {
                $('#payment-address-content').parent().find('.panel-heading .panel-title').html('<a data-toggle="collapse" data-parent="#checkout-page" href="#payment-address-content" class="accordion-toggle"> <i class="fa fa-print"></i> Billing Details </a>');
            }

            $('a[href=\'#payment-address-content\']').trigger('click');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

//Login
$(document).delegate('#button-login', 'click', function() {

    $.ajax({
        url: 'checkout/login',
        type: 'POST',
        dataType: 'json',
        data: $('#payment-address-content :input'),
        beforeSend: function() {
            $('#button-login').button('loading');
        },
        complete: function() {
            $('#button-login').button('reset');
        },
        success: function(json) {

            // console.log('hi');
            
            $('.alert, .text-danger').remove();
            $('.form-group').removeClass('has-error');

            if (json['success']) {
                
                $('#payment-address-content .panel-body').prepend('<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> ' +json['success']+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

                // console.log(json['redirect']);
               
                // location = json['redirect'];
                location.reload(json['redirect']);
            } else if (json['error']) {
                // alert(json['error']);

                $('#payment-address-content .panel-body').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' +json['error']+' '+'Sorry your Username or Password is In correct'+ '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

                // Highlight any found errors
                $('input[name=\'email\']').parent().addClass('has-error');
                $('input[name=\'password\']').parent().addClass('has-error');
           }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

// Register
$(document).delegate('#button-register', 'click', function() {
    $.ajax({
        url: 'checkout/register',
        type: 'POST',
        data: $('#payment-address-content input[type=\'text\'], #payment-address-content input[type=\'date\'], #payment-address-content input[type=\'datetime-local\'], #payment-address-content input[type=\'time\'], #payment-address-content input[type=\'password\'], #payment-address-content input[type=\'hidden\'], #payment-address-content input[type=\'checkbox\']:checked, #payment-address-content input[type=\'radio\']:checked, #payment-address-content textarea, #payment-address-content select'),
        dataType: 'json',
        beforeSend: function() {
            $('#button-register').button('loading');
        },
        success: function(json) {
            $('.alert, .text-danger').remove();
            $('.form-group').removeClass('has-error');

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                $('#button-register').button('reset');

                if (json['error']['warning']) {
                    $('#payment-address-content .panel-body').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

                for (i in json['error']) {
                    var element = $('#input-payment-' + i.replace('_', '-'));

                    if ($(element).parent().hasClass('input-group')) {
                        $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
                    } else {
                        $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
                    }
                }

                // Highlight any found errors
                $('.text-danger').parent().addClass('has-error');
            } else {
                    $.ajax({
                    url: 'checkout/payment_method',
                    dataType: 'html',
                    success: function(html) {
                        $('#collapse-payment-method .panel-body').html(html);

                        $('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<a href="#collapse-payment-method" data-toggle="collapse" data-parent="#checkout-page" class="accordion-toggle">Step 5: Payment Method <i class="fa fa-caret-down"></i></a>');

                        $('a[href=\'#collapse-payment-method\']').trigger('click');

                        $('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('Step 6: Confirm Order');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
                
                $.ajax({
                    url: 'checkout/payment_address',
                    dataType: 'html',
                    complete: function() {
                        $('#button-register').button('reset');
                    },
                    success: function(html) {
                        $('#payment-address-content .panel-body').html(html);

                        $('#payment-address-content').parent().find('.panel-heading .panel-title').html('<a href="#payment-address-content" data-toggle="collapse" data-parent="#checkout-page" class="accordion-toggle">Step 2: Billing Details <i class="fa fa-caret-down"></i></a>');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});



$(document).delegate('#button-saved-address', 'click', function() {
    var address = $('payment-address-content input[type=\'radio\']:checked').val;
    // $.ajax({
    //     url: 'checkout/payment_method',
    //     type: 'POST',
    //     data: $('#payment-address-content :input'),
    //     beforeSend: function() {
    //         $('#button-saved-address').button('loading');
    //     },
    //     complete: function() {
    //         $('#button-saved-address').button('reset');
    //     },
    //     success: function(html) {
    //         $('#payment-method .panel-heading').after(html);

    //         $('#payment-method-content').parent().find('.panel-heading .panel-title').html('<a href="#payment-method-content" data-toggle="collapse" data-parent="#checkout-page" class="accordion-toggle"> <i class="fa fa-dollar"></i> Payment Method </a>');
            
    //         $('#payment-address-content').removeClass('in');
    //         $('#payment-method-content').addClass('in');
    //         // $('a[href=\'#payment-method\']').trigger('click');
    //     },
    //     error: function(xhr, ajaxOptions, thrownError) {
    //         alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    //     }
    // });
});

// Payment Address
$(document).delegate('#button-payment-address', 'click', function() {

    // $("#form-payment-address input, #form-payment-address select").each(function () {
    //       $(this).rules("add", {
    //         required: true
    //       });
    // });

    $.ajax({
        url: 'checkout/payment_address',
        type: 'POST',
        data: $('#payment-address-content input[type=\'text\'], #payment-address-content input[type=\'date\'], #payment-address-content input[type=\'datetime-local\'], #payment-address-content input[type=\'time\'], #payment-address-content input[type=\'password\'], #payment-address-content input[type=\'checkbox\']:checked, #payment-address-content input[type=\'radio\']:checked, #payment-address-content input[type=\'hidden\'], #payment-address-content textarea, #payment-address-content select'),
        dataType: 'json',
        beforeSend: function() {
            $('#button-payment-address').button('loading');
        },
        complete: function() {
            $('#button-payment-address').button('reset');
        },
        success: function(json) {
            $('.alert, .text-danger').remove();

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                if (json['error']['warning']) {
                    $('#payment-address-content .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

                for (i in json['error']) {
                    var element = $('#input-payment-' + i.replace('_', '-'));

                    if ($(element).parent().hasClass('input-group')) {
                        $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
                    } else {
                        $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
                    }
                }

                // Highlight any found errors
                $('.text-danger').parent().parent().addClass('has-error');
            } else {
                $.ajax({
                    url: 'index.php?route=checkout/payment_method',
                    dataType: 'html',
                    success: function(html) {
                        $('#collapse-payment-method .panel-body').html(html);

                        $('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<a href="#collapse-payment-method" data-toggle="collapse" data-parent="#checkout-page" class="accordion-toggle">Step 5: Payment Method <i class="fa fa-caret-down"></i></a>');

                        $('a[href=\'#collapse-payment-method\']').trigger('click');

                        $('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('Step 6: Confirm Order');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
                
                $.ajax({
                    url: 'index.php?route=checkout/payment_address',
                    dataType: 'html',
                    success: function(html) {
                        $('#payment-address-content .panel-body').html(html);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

// Shipping Address
$(document).delegate('#button-shipping-address', 'click', function() {
    $.ajax({
        url: 'index.php?route=checkout/shipping_address/save',
        type: 'post',
        data: $('#collapse-shipping-address input[type=\'text\'], #collapse-shipping-address input[type=\'date\'], #collapse-shipping-address input[type=\'datetime-local\'], #collapse-shipping-address input[type=\'time\'], #collapse-shipping-address input[type=\'password\'], #collapse-shipping-address input[type=\'checkbox\']:checked, #collapse-shipping-address input[type=\'radio\']:checked, #collapse-shipping-address textarea, #collapse-shipping-address select'),
        dataType: 'json',
        beforeSend: function() {
            $('#button-shipping-address').button('loading');
        },
        success: function(json) {
            $('.alert, .text-danger').remove();

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                $('#button-shipping-address').button('reset');

                if (json['error']['warning']) {
                    $('#collapse-shipping-address .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

                for (i in json['error']) {
                    var element = $('#input-shipping-' + i.replace('_', '-'));

                    if ($(element).parent().hasClass('input-group')) {
                        $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
                    } else {
                        $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
                    }
                }

                // Highlight any found errors
                $('.text-danger').parent().parent().addClass('has-error');
            } else {
                $.ajax({
                    url: 'index.php?route=checkout/shipping_method',
                    dataType: 'html',
                    complete: function() {
                        $('#button-shipping-address').button('reset');
                    },
                    success: function(html) {
                        $('#collapse-shipping-method .panel-body').html(html);

                        $('#collapse-shipping-method').parent().find('.panel-heading .panel-title').html('<a href="#collapse-shipping-method" data-toggle="collapse" data-parent="#checkout-page" class="accordion-toggle">Step 4: Delivery Method <i class="fa fa-caret-down"></i></a>');

                        $('a[href=\'#collapse-shipping-method\']').trigger('click');

                        $('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('Step 5: Payment Method');
                        $('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('Step 6: Confirm Order');

                        $.ajax({
                            url: 'index.php?route=checkout/shipping_address',
                            dataType: 'html',
                            success: function(html) {
                                $('#collapse-shipping-address .panel-body').html(html);
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });

                $.ajax({
                    url: 'index.php?route=checkout/payment_address',
                    dataType: 'html',
                    success: function(html) {
                        $('#payment-address-content .panel-body').html(html);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

// Guest
$(document).delegate('#button-guest', 'click', function() {
    $.ajax({
        url: 'index.php?route=checkout/guest/save',
        type: 'post',
        data: $('#payment-address-content input[type=\'text\'], #payment-address-content input[type=\'date\'], #payment-address-content input[type=\'datetime-local\'], #payment-address-content input[type=\'time\'], #payment-address-content input[type=\'checkbox\']:checked, #payment-address-content input[type=\'radio\']:checked, #payment-address-content input[type=\'hidden\'], #payment-address-content textarea, #payment-address-content select'),
        dataType: 'json',
        beforeSend: function() {
            $('#button-guest').button('loading');
        },
        success: function(json) {
            $('.alert, .text-danger').remove();

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                $('#button-guest').button('reset');

                if (json['error']['warning']) {
                    $('#payment-address-content .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

                for (i in json['error']) {
                    var element = $('#input-payment-' + i.replace('_', '-'));

                    if ($(element).parent().hasClass('input-group')) {
                        $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
                    } else {
                        $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
                    }
                }

                // Highlight any found errors
                $('.text-danger').parent().addClass('has-error');
            } else {
                                $.ajax({
                    url: 'index.php?route=checkout/payment_method',
                    dataType: 'html',
                    complete: function() {
                        $('#button-guest').button('reset');
                    },
                    success: function(html) {
                        $('#collapse-payment-method .panel-body').html(html);

                        $('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<a href="#collapse-payment-method" data-toggle="collapse" data-parent="#checkout-page" class="accordion-toggle">Step 5: Payment Method <i class="fa fa-caret-down"></i></a>');

                        $('a[href=\'#collapse-payment-method\']').trigger('click');

                        $('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('Step 6: Confirm Order');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
                            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

// Guest Shipping
$(document).delegate('#button-guest-shipping', 'click', function() {
    $.ajax({
        url: 'index.php?route=checkout/guest_shipping/save',
        type: 'post',
        data: $('#collapse-shipping-address input[type=\'text\'], #collapse-shipping-address input[type=\'date\'], #collapse-shipping-address input[type=\'datetime-local\'], #collapse-shipping-address input[type=\'time\'], #collapse-shipping-address input[type=\'password\'], #collapse-shipping-address input[type=\'checkbox\']:checked, #collapse-shipping-address input[type=\'radio\']:checked, #collapse-shipping-address textarea, #collapse-shipping-address select'),
        dataType: 'json',
        beforeSend: function() {
            $('#button-guest-shipping').button('loading');
        },
        success: function(json) {
            $('.alert, .text-danger').remove();

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                $('#button-guest-shipping').button('reset');

                if (json['error']['warning']) {
                    $('#collapse-shipping-address .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

                for (i in json['error']) {
                    var element = $('#input-shipping-' + i.replace('_', '-'));

                    if ($(element).parent().hasClass('input-group')) {
                        $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
                    } else {
                        $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
                    }
                }

                // Highlight any found errors
                $('.text-danger').parent().addClass('has-error');
            } else {
                $.ajax({
                    url: 'index.php?route=checkout/shipping_method',
                    dataType: 'html',
                    complete: function() {
                        $('#button-guest-shipping').button('reset');
                    },
                    success: function(html) {
                        $('#collapse-shipping-method .panel-body').html(html);

                        $('#collapse-shipping-method').parent().find('.panel-heading .panel-title').html('<a href="#collapse-shipping-method" data-toggle="collapse" data-parent="#checkout-page" class="accordion-toggle">Step 4: Delivery Method <i class="fa fa-caret-down"></i>');

                        $('a[href=\'#collapse-shipping-method\']').trigger('click');

                        $('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('Step 5: Payment Method');
                        $('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('Step 6: Confirm Order');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

$(document).delegate('#button-shipping-method', 'click', function() {
    $.ajax({
        url: 'shipping/save',
        type: 'post',
        data: $('#shipping-method-content input[type=\'radio\']:checked'),
        dataType: 'json',
        beforeSend: function() {
            $('#button-shipping-method').button('loading');
        },
        success: function(json) {
            $('.alert, .text-danger').remove();

            if (json['error']) {
                $('#button-shipping-method').button('reset');
                
                if (json['error']) {
                    $('#shipping-method-content .panel-body').prepend('<div class="alert alert-danger">' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
            } else {
                $.ajax({
                    url: 'checkout/payment_method',
                    dataType: 'html',
                    complete: function() {
                        $('#button-shipping-method').button('reset');
                    },
                    success: function(html) {
                        $('#payment-method-content').remove();
                        $('#payment-method .panel-heading').after(html);

                        $('#payment-method-content').parent().find('.panel-heading .panel-title').html('<a href="#payment-method-content" data-toggle="collapse" data-parent="#checkout-page" class="accordion-toggle"> <i class="fa fa-dollar"></i> Payment Method </a>');
                        
                        $('#shipping-method-content').removeClass('in');
                        $('#payment-method-content').addClass('in');
                        
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

// $(document).delegate('#button-confirm', 'click', function() {

// });

$(document).delegate('#button-payment-method', 'click', function() {
    $('.alert, .text-danger').remove();
    var name=$('#con:checked').val()
    var pay_method=$('#pay_method:checked').val();



    
    // if(pay_method)
    //     {
    //         alert(pay_method);
    //     }
    if($("#payment-method-content input[type=\'checkbox\']:checked").length > 0 ) {
        $.ajax({
            url: 'checkout/payment_method',
            type: 'post',
            data: $('#payment-method-content input[type=\'radio\']:checked, #payment-method-content input[type=\'checkbox\']:checked, #payment-method-content textarea'),
            // data: $('#checkout-page input[type=\'text\'], #checkout-page input[type=\'password\'], #checkout-page input[type=\'radio\']:checked, #checkout-page input[type=\'checkbox\']:checked, #checkout-page select'),
            dataType: 'json',
            beforeSend: function() {
                $('#button-payment-method').button('loading');
            },
            complete: function() {
                $('#button-payment-method').button('reset');
            },
            success: function(json) {
                $('.alert, .text-danger').remove();

                if (json['method']) {
                    
                    var url = '../payment/'+json['method'];
                    // alert(url);
                     $.ajax({
                        url: url,
                        type: 'post',
                        // data: $('#payment-method-content input[type=\'radio\']:checked'),
                        data: $('#checkout-page :input, #checkout-page input[type=\'checkbox\']:checked, #checkout-page select'),
                        dataType: 'html',
                        complete: function() {
                            $('#button-payment-method').button('reset');
                        },
                        success: function(html) {
                            $('#confirm-content').remove();
                            $('#confirm .panel-heading').after(html);

                            $('#confirm-content').parent().find('.panel-heading .panel-title').html('<a href="#confirm-content" data-toggle="collapse" data-parent="#checkout-page" class="accordion-toggle"> <i class="fa fa-gavel"></i> Confirm Order </a>');
                            $('#confirm-content').addClass('collapse');
                            $('a[href=\'#confirm-content\']').trigger('click');
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }  else if (json['error']) {

                    // alert(json['error']);
                    $('#payment-method-content .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                    
                } else {
                    
                    $.ajax({
                        url: url,
                        data: $('#payment-method-content input[type=\'radio\']:checked'),
                        dataType: 'html',
                        complete: function() {
                            $('#button-payment-method').button('reset');
                        },
                        success: function(html) {
                          $('#confirm-content').remove();
                            $('#confirm .panel-heading').after(html);

                            $('#confirm-content').parent().find('.panel-heading .panel-title').html('<a href="#confirm-content" data-toggle="collapse" data-parent="#checkout-page" class="accordion-toggle"> <i class="fa fa-gavel"></i> Confirm Order </a>');

                            $('a[href=\'#confirm-content\']').trigger('click');
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert("Please select any payment method");
            }
        });
    }
    else if($('#con:checked').length==0 || $('#agre:checked').length==0)

    {
        $('#payment-method-content .panel-body').prepend('<div class="alert alert-danger">Please accept All terms and conditions.<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

    }

     else {
        // alert('hi');
        $('#payment-method-content .panel-body').prepend('<div class="alert alert-danger">Please accept All terms and conditions.<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    }
});

    


$(document).delegate('#button-confirm', 'click', function() {
    // address = $('$existing-customer').serialize();
    // alert()
    var payment=$('#payment-method-content input[type=\'radio\']:checked').val();
    
    if(payment=='AccountBalance')
    {
        $.ajax({
        url: 'checkout/conform',
        type: 'post',
        data: $('#payment-method-content input[type=\'radio\']:checked, #payment-method-content input[type=\'checkbox\']:checked'),
        dataType: 'json',
        beforeSend: function() {
              // $('#confirm-content').html('loading');
             $('#button-confirm').html('loading');
        },
        complete: function() {
             // $('#confirm-content').button('rest');
            $('#button-confirm').html('continue');
        },
        success: function(json) {
            if(json['field']) {
                // alert(json['field']);
                $('#confirm-content form').append(json['field']);
            }
            if(json['success']) {

                // console.log('hi');
                 $('#confirm-content form').append('<input type="hidden" name="custom" value="'+json['MemberId']+','+json['Orderid']+'"/>');
                  $('#confirm-content').button('loading');
                 $('#button-confirm').html('loading');
                $('#confirm-content form').submit();        
            } else {
                // console.log('ha');
                 $('#button-confirm').html('continue');
            }
            
            // console.log('saved');
        }
    }); 
    }
    else if(payment=='cashod' || payment=='manual' || payment=='onlinefund')
        {

         $.ajax({
        url: 'checkout/conform',
        type: 'post',
        data: $('#payment-method-content input[type=\'radio\']:checked, #payment-method-content input[type=\'checkbox\']:checked'),
        dataType: 'json',
        beforeSend: function() {
              // $('#confirm-content').html('loading');
             $('#button-confirm').html('loading');
        },
        complete: function() {
             // $('#confirm-content').button('rest');
            $('#button-confirm').html('continue');
        },
        success: function(json) {


            if(json['field']) {
                
                // alert(json['field']);
                $('#confirm-content form').append(json['field']);
            }
            if(json['success']) {
                
                // console.log('hi');
                 $('#confirm-content form').append('<input type="hidden" name="custom" value="'+json['MemberId']+','+json['Orderid']+'"/>');
                  $('#confirm-content').button('loading');
                 $('#button-confirm').html('loading');
                $('#confirm-content form').submit();        
            } else {
                // console.log('ha');
                 $('#button-confirm').html('continue');
            }
            
            // console.log('saved');
        }
    });
    }
    else
    {

         $.ajax({
        url: 'checkout/conform',
        type: 'post',
        data: $('#payment-method-content input[type=\'radio\']:checked, #payment-method-content input[type=\'checkbox\']:checked'),
        dataType: 'json',
        beforeSend: function() {
              // $('#confirm-content').html('loading');
             $('#button-confirm').html('loading');
        },
        complete: function() {

             // $('#confirm-content').button('rest');
            $('#button-confirm').html('continue');
        },
        success: function(json) {
            if(json['field']) {
                // alert(json['field']);
                $('#confirm-content form').append(json['field']);
            }
            if(json['success']) {
                // console.log('hi');
                $('#confirm-content form').append('<input type="hidden" name="custom" value="'+json['MemberId']+','+json['Orderid']+'"/>');
                $('#confirm-content').button('loading');
                 $('#button-confirm').html('loading');
                 $('#confirm-content form').submit();        
            } else {
                // console.log('ha');
                 $('#button-confirm').html('continue');
            }
            
            console.log('saved');
        }
    });
    }

   
});


function SelectZone(id) {
  var country_id = id.value;
  $.ajax({
    url: 'checkout/country/' + country_id,
    beforeSend: function() {
      $('#country').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
    },
    complete: function() {
      $('.fa-spin').remove();
    },
    success: function(json) {

      $('#region-state').html(json);
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
}

function registration() {
    if ($('.customer-forms').valid()) {
    $.ajax({
        url: 'checkout/checkuser',
        type: 'POST',
        data: $('#payment-address-content :input'),
        // data: $('#payment-address-content :input, #payment-address-content input[type=\'radio\']:checked, #payment-address-content input[type=\'checkbox\']:checked,'),
        dataType: 'json',
        beforeSend: function() {
            $('#button-register').button('loading');
        },
        complete: function() {
            $('#button-register').button('reset');
        },
        success: function(json) {
            if(json['error']) {
                $('#payment-address-content .panel-body').prepend('<div class="alert alert-danger">' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            } else {
                $('.alert, .text-danger').remove();

                $.ajax({
                    url: 'checkout/shipping',
                    type: 'POST',
                    data: $('#payment-address-content :input'),
                    beforeSend: function() {
                        $('#button-saved-address').button('loading');
                    },
                    complete: function() {
                        $('#button-saved-address').button('reset');
                    },
                    success: function(html) {
                        $('#shipping-method .panel-heading').after(html);

                        $('#shipping-method-content').parent().find('.panel-heading .panel-title').html('<a href="#shipping-method-content" data-toggle="collapse" data-parent="#checkout-page" class="accordion-toggle"> <i class="fa fa-dollar"></i> Shipping Method </a>');
                        
                        $('#payment-address-content').removeClass('in');
                        $('#shipping-method-content').addClass('in');
                        // $('a[href=\'#payment-method\']').trigger('click');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        }
    })

    

    //   $.ajax({
    //     url: 'checkout/payment_method',
    //     type: 'POST',
    //     data: $('#payment-address-content :input'),
    //     beforeSend: function() {
    //         $('#button-saved-address').button('loading');
    //     },
    //     complete: function() {
    //         $('#button-saved-address').button('reset');
    //     },
    //     success: function(html) {
    //         $('#payment-method .panel-heading').after(html);

    //         $('#payment-method-content').parent().find('.panel-heading .panel-title').html('<a href="#payment-method-content" data-toggle="collapse" data-parent="#checkout-page" class="accordion-toggle"> <i class="fa fa-dollar"></i> Payment Method </a>');
            
    //         $('#payment-address-content').removeClass('in');
    //         $('#payment-method-content').addClass('in');
    //         // $('a[href=\'#payment-method\']').trigger('click');
    //     },
    //     error: function(xhr, ajaxOptions, thrownError) {
    //         alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    //     }
    // });
    }
  }

  function guest() {
    if ($('.guest-forms').valid()) {
        $('.alert, .text-danger').remove();
    $.ajax({
        url: 'checkout/checkguestuser',
        type: 'POST',
        data: $('#payment-address-content :input'),
        // data: $('#payment-address-content :input, #payment-address-content input[type=\'radio\']:checked, #payment-address-content input[type=\'checkbox\']:checked,'),
        dataType: 'json',
        beforeSend: function() {
            $('#button-registe22r').button('loading');
        },
        complete: function() {
            $('#button-registe22r').button('reset');
        },
        success: function(json) {
            if(json['error']) {
                $('#payment-address-content .panel-body').prepend('<div class="alert alert-danger">' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            } else {
                $('.alert, .text-danger').remove();

                $.ajax({
                    url: 'checkout/shipping',
                    type: 'POST',
                    data: $('#payment-address-content :input'),
                    beforeSend: function() {
                        $('#button-saved-address').button('loading');
                    },
                    complete: function() {
                        $('#button-saved-address').button('reset');
                    },
                    success: function(html) {
                        $('#shipping-method .panel-heading').after(html);

                        $('#shipping-method-content').parent().find('.panel-heading .panel-title').html('<a href="#shipping-method-content" data-toggle="collapse" data-parent="#checkout-page" class="accordion-toggle"> <i class="fa fa-dollar"></i> Shipping Method </a>');
                        
                        $('#payment-address-content').removeClass('in');
                        $('#shipping-method-content').addClass('in');
                        // $('a[href=\'#payment-method\']').trigger('click');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        }
        });
    }
    
    function newaddress() {
        if ($('#existing-customer').valid()) {
            $.ajax({
                url: 'checkout/payment_method',
                type: 'POST',
                data: $('#payment-address-content :input'),
                beforeSend: function() {
                    // $('#button-existing-addr').button('loading');
                    $('#button-existing-addr').button('loading');
                },
                complete: function() {
                    // $('#button-registe22r').button('reset');
                    $('#button-existing-addr').button('loading');
                },
                success: function(html) {
                    $('#payment-method .panel-heading').after(html);

                    $('#payment-method-content').parent().find('.panel-heading .panel-title').html('<a href="#payment-method-content" data-toggle="collapse" data-parent="#checkout-page" class="accordion-toggle"> <i class="fa fa-dollar"></i> Payment Method </a>');
                    
                    $('#payment-address-content').removeClass('in');
                    $('#payment-method-content').addClass('in');
                    // $('a[href=\'#payment-method\']').trigger('click');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    }
}