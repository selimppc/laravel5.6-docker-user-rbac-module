<script>
    /**
     * Created by selimreza on 12/2/16.
     */


//change password checkbox....
    $('#checkboxPass').click(function (){
        var check_value = $("#checkbox").is(":checked");
        if(check_value){
            $('#pass-old').hide();
            $('#re-pass').hide();
            $('#field-password').show();
            $('#field-con-password').show();
        }else{
            $('#pass-old').show();
            $('#re-pass').show();
            $('#field-password').hide();
            $('#field-con-password').hide();
        }

    });
    $(".btn").popover({ trigger: "manual" , html: true, animation:false})
        .on("mouseenter", function () {
            var _this = this;
            $(this).popover("show");
            $(".popover").on("mouseleave", function () {
                $(_this).popover('hide');
            });
        }).on("mouseleave", function () {
        var _this = this;
        setTimeout(function () {
            if (!$(".popover:hover").length) {
                $(_this).popover("hide");
            }
        }, 300);
    });


    $(".form-control").tooltip();
    $('input:disabled, button:disabled').after(function (e) {
        d = $("<div>");
        i = $(this);
        d.css({
            height: i.outerHeight(),
            width: i.outerWidth(),
            position: "absolute",
        })
        d.css(i.offset());
        d.attr("title", i.attr("title"));
        d.tooltip();
        return d;
    });

    function validation() {
        $('#user-re-password').on('keyup', function () {
            if ($(this).val() == $('#edit-user-password').val()) {

                $('#user-show-message').html('');
                document.getElementById("user-btn-disabled").disabled = false;
                return false;
            }
            else $('#user-show-message').html('confirm password do not match with new password,please check.').css('color', 'red');
            document.getElementById("user-btn-disabled").disabled = true;
        });
    }
    //edit-user...........
    $("#user-jq-validation-form").validate({

        ignore: '.ignore, .select2-input',
        focusInvalid: false,
        rules: {
            'jq-validation-email': {
                required: true,
                email: true
            },
            'jq-validation-password': {
                required: true,
                minlength: 6,
                maxlength: 20
            },
            'jq-validation-password-confirmation': {
                required: true,
                minlength: 6,
                equalTo: "#jq-validation-password"
            },
            'jq-validation-required': {
                required: true
            },
            'jq-validation-url': {
                required: true,
                url: true
            },
            'jq-validation-phone': {
                required: true,
                phone_format: true
            },
            'email': {
                required: true,
                email: true
            },
            'currency_id': {
                required: true
            },
            'status': {
                required: true
            },'pBranch': {
                required: true
            },

            'jq-validation-multiselect': {
                required: true,
                minlength: 2
            },
            'jq-validation-select2': {
                required: true
            },
            'jq-validation-select2-multi': {
                required: true,
                minlength: 2
            },
            'jq-validation-text': {
                required: true
            },
            'jq-validation-simple-error': {
                required: true
            },
            'jq-validation-dark-error': {
                required: true
            },
            'jq-validation-radios': {
                required: true
            },
            'jq-validation-checkbox1': {
                require_from_group: [1, 'input[name="jq-validation-checkbox1"], input[name="jq-validation-checkbox2"]']
            },
            'jq-validation-checkbox2': {
                require_from_group: [1, 'input[name="jq-validation-checkbox1"], input[name="jq-validation-checkbox2"]']
            },
            'jq-validation-policy': {
                required: true
            }
        },
        messages: {
            'jq-validation-policy': 'You must check it!'
        }
    });


</script>