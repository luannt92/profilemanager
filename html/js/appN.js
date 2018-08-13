$(document).ready(function(){
    $('#contactForm').bootstrapValidator({
        fields : {
            name: {
                validators: {
                    notEmpty: {
                        message: 'Please supply your name'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'Please supply your email address'
                    },
                    emailAddress: {
                        message: 'Please supply a valid email address'
                    }
                }
            },
            phone: {
                validators: {
                    notEmpty: {
                        message: 'Please supply your phone number'
                    }
                }
            },
            subject: {
                validators: {
                    notEmpty: {
                        message: 'Please supply subject for your email'
                    }
                }
            },
            content: {
                validators: {
                    notEmpty: {
                        message: 'Please supply content for your email'
                    }
                }
            },
            check: {
                validators: {
                    notEmpty: {
                        message: 'Please supply a correct result'
                    }
                }
            }
        }
    });

    $('#modalForgotPass').bootstrapValidator({
        fields : {
            email: {
                validators: {
                    notEmpty: {
                        message: 'Please supply your registered email'
                    },
                    emailAddress: {
                        message: 'Please supply a valid email address'
                    }
                }
            },
        }


    });

    $('#changePassword').bootstrapValidator({
        fields : {
            password: {
                validators: {
                    notEmpty: {
                        message: 'Please supply your new password'
                    },
                    identical: {
                        field: 'confirmPassword',
                        message: 'The password and its confirm are not the same'
                    }
                }
            },
            confirmPassword: {
                validators: {
                    notEmpty: {
                        message: 'You must re-enter your password'
                    },
                    identical: {
                        field: 'password',
                        message: 'The password and its confirm are not the same'
                    }
                }
            }
        }
    });

    $('.more-show').on('click', function (e) {
        e.preventDefault();
        $('.more-partners').show(250);
    });

    $('.close-more'). on('click', function (e) {
        e.preventDefault();
        $('.more-partners').hide(250);
    })
});