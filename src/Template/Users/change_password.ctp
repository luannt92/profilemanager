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
                                    echo $this->Form->create(null, [
                                        "id"          => "changePassword",
                                        "class"       => "form-login",
                                        "data-toggle" => "validator",
                                        "role"        => "form",
                                    ]);
                                    echo $this->Form->control("oldPassword", [
                                        "type"                => "password",
                                        "class"               => "form-control",
                                        "placeholder"         => __("Please enter your current password"),
                                        "label"               => __("Old password"),
                                        "required"            => true,
                                        "data-required-error" => __("Please enter your current password"),
                                    ]);
                                    echo $this->Form->control("password", [
                                        "type"                => "password",
                                        "class"               => "form-control",
                                        "placeholder"         => __("New password"),
                                        "label"               => __("New password"),
                                        "required"            => true,
                                        "data-minlength"      => MIN_LENGTH_PASSWORD,
                                        "data-required-error" => __(PLACEHOLDER_PASSWORD),
                                        "data-error"          => __(VALIDATE_INPUT_4,
                                            __(PASSWORD),
                                            MIN_LENGTH_PASSWORD),
                                    ]);
                                    echo $this->Form->control("confirmPassword",
                                        [
                                            "type"                => "password",
                                            "class"               => "form-control",
                                            "placeholder"         => __("Confirm new password"),
                                            "label"               => __("Confirm new password"),
                                            "required"            => true,
                                            "data-minlength"      => MIN_LENGTH_PASSWORD,
                                            "data-match"          => "#password",
                                            "data-error"          => __(USER_MSG_0046),
                                            "data-required-error" => __(PLACEHOLDER_CONFIRM_PASSWORD),
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
