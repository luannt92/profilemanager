<?php
$btnBack = $this->Html->link(__("Skip"),
    ["controller" => "Users", "action" => "account"],
    ["class" => "btn btn-leave"]);
$this->Form->setTemplates([
    "inputContainer" => "<div class=\"form-group\">{{content}}<div class=\"help-block with-errors\"></div></div>",
]);
?>
<div class="content" id="content">
    <div class="container">
        <div class="row content-account">
            <?php echo $this->element("Front/Users/menuAccount"); ?>
            <div class="col-xs-12 col-md-9">
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <div class="text-header-content">
                            <p><?php echo __("Edit user information"); ?></p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12">
                        <div class="edit-account-content">
                            <div class="row">
                                <div class="col-sm-6 col-sm-offset-3">
                                    <?php
                                    echo $this->Form->create($user, [
                                        "id"          => "edit-account",
                                        "data-toggle" => "validator",
                                        "role"        => "form",
                                    ]);

                                    /*hidden*/
                                    echo $this->Form->control('phone_code', [
                                        'type'  => 'hidden',
                                        'value' => '84',
                                        'id'    => 'phone_number',
                                    ]);

                                    echo $this->Form->control("full_name", [
                                        "class"               => "form-control",
                                        "placeholder"         => __("Display name"),
                                        "label"               => __("Display name"),
                                        "required"            => true,
                                        "data-required-error" => __(VALIDATE_INPUT_1,
                                            __("Display name")),
                                    ]);
                                    echo $this->Form->control("email", [
                                        "type"                => "email",
                                        "class"               => "form-control",
                                        "placeholder"         => __(EMAIL),
                                        "required"            => true,
                                        "data-required-error" => __(PLACEHOLDER_EMAIL),
                                        "data-error"          => __(VALIDATE_INPUT_2,
                                            __(EMAIL)),
                                    ]);
                                    echo $this->Form->control("phone_number", [
                                        "type"                => "tel",
                                        "class"               => "form-control",
                                        "placeholder"         => __(PHONE_TEXT),
                                        "label"               => __(PHONE_TEXT),
                                        "required"            => true,
                                        "data-required-error" => __(PLACEHOLDER_PHONE_NUMBER),
                                    ]);
                                    echo "<div class=\"btn-account\">{$btnBack}"
                                        .
                                        $this->Form->button(__("Save"), [
                                            "type"  => "submit",
                                            "class" => "btn btn-save",
                                        ]) . "</div>";
                                    echo $this->Form->end();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main-content -->
    </div>
</div>
<?php echo $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
//<script>
    $(document).ready(function () {
        $("input[type='tel']").intlTelInput({
            initialCountry: 'vn',
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js",
            separateDialCode: true
        });

        $("input[type='tel']").on("countrychange", function (e, countryData) {
            $("#phone_number").val($("input[type='tel']").intlTelInput("getSelectedCountryData").dialCode);
        });
    });
    <?php echo $this->Html->scriptEnd(); ?>

