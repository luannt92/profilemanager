<?php
$store_hours = $item->store_hours;
$time_open   = ! empty($settingInfo['time_open'])
    ? $settingInfo['time_open']
    : '';
$time_close  = ! empty($settingInfo['time_close'])
    ? $settingInfo['time_close']
    : '';

if ($item->type_hour == DAILY_TIME) { ?>
    <div class="daily form-group">
        <label class="col-sm-2">
            <input type="checkbox"
                   class="i-checks"
                   checked> Daily
        </label>
        <div class="col-sm-10">
            <div class="row">
                <?php foreach ($store_hours[2] as $k => $store_hour) {
                    $check_time_open  = ! empty($store_hour['time_open'])
                        ? $store_hour['time_open']->format('H:i') : $time_open;
                    $check_time_close = ! empty($store_hour['time_close'])
                        ? $store_hour['time_close']->format('H:i')
                        : $time_close;
                    ?>
                    <div class="hour">
                        <div class="col-sm-10">
                            <div class="input-group"
                                 style="padding-bottom: 10px;">
                                <input class="input-sm form-control clockpicker"
                                       name="dailytime[<?php echo $k; ?>][time_open]"
                                       value="<?php echo $check_time_open; ?>">
                                <span class="input-group-addon">to</span>
                                <input class="input-sm form-control clockpicker"
                                       name="dailytime[<?php echo $k; ?>][time_close]"
                                       value="<?php echo $check_time_close; ?>">
                            </div>
                        </div>
                        <?php if ($k == 0) { ?>
                            <div class="col-sm-2">
                                <button type="button"
                                        class="btn btn-sm btn-success daily-add-hour"
                                        data-attr="<?php echo count($store_hours[2]); ?>">
                                    <i class="fa fa-plus"></i>
                                    Add Peroid
                                </button>
                            </div>
                        <?php } else { ?>
                            <div class="col-sm-2">
                                <button type="button"
                                        class="btn btn-sm btn-danger remove-hour">
                                    Remove
                                </button>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php echo $this->element('Admin/Store/hour'); ?>
            </div>
        </div>
    </div>
    <?php
    foreach ($storeHours as $k => $storeHour) {
        ?>
        <div class="custom form-group hide"
             id="<?php echo $storeHour; ?>">
            <label class="col-sm-2">
                <input type="checkbox"
                       class="i-checks"
                       name="customtime[<?php echo $storeHour; ?>][check]"
                       checked> <?php echo $k; ?>
            </label>
            <div class="col-sm-10">
                <div class="row">
                    <div class="hour">
                        <div class="col-sm-10">
                            <div class="input-group"
                                 style="padding-bottom: 10px;">
                                <input class="input-sm form-control clockpicker"
                                       name="customtime[<?php echo $storeHour; ?>][0][time_open]"
                                       value="<?php echo $time_open; ?>">
                                <span class="input-group-addon">to</span>
                                <input class="input-sm form-control clockpicker"
                                       name="customtime[<?php echo $storeHour; ?>][0][time_close]"
                                       value="<?php echo $time_close; ?>">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <button type="button"
                                    class="btn btn-sm btn-success add-hour"
                                    data-attr="<?php echo $storeHour; ?>">
                                <i class="fa fa-plus"></i>
                                Add Peroid
                            </button>
                        </div>
                    </div>
                    <?php echo $this->element('Admin/Store/hour'); ?>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="daily form-group hide">
        <label class="col-sm-2">
            <input type="checkbox"
                   class="i-checks"
                   checked> Daily
        </label>
        <div class="col-sm-10">
            <div class="row">
                <div class="hour">
                    <div class="col-sm-10">
                        <div class="input-group"
                             style="padding-bottom: 10px;">
                            <input class="input-sm form-control clockpicker"
                                   name="dailytime[0][time_open]"
                                   value="<?php echo $time_open; ?>">
                            <span class="input-group-addon">to</span>
                            <input class="input-sm form-control clockpicker"
                                   name="dailytime[0][time_close]"
                                   value="<?php echo $time_close; ?>">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button type="button"
                                class="btn btn-sm btn-success daily-add-hour"
                                data-attr="1">
                            <i class="fa fa-plus"></i>
                            Add Peroid
                        </button>
                    </div>
                </div>
                <?php echo $this->element('Admin/Store/hour'); ?>
            </div>
        </div>
    </div>

    <?php foreach ($store_hours as $k => $store_hour) {
        $checkDay = ($store_hour[0]['status'] == ACTIVE) ? 'checked' : '';
        ?>
        <div class="custom form-group"
             id="<?php echo $k; ?>">
            <label class="col-sm-2">
                <input type="checkbox" class="i-checks"
                       name="customtime[<?php echo $k; ?>][check]"
                    <?php echo $checkDay; ?>> <?php echo $textDay[$k]; ?>
            </label>
            <div class="col-sm-10">
                <div class="row">
                    <?php foreach ($store_hour as $j => $hour) {
                        $check_time_open  = ! empty($hour['time_open'])
                            ? $hour['time_open']->format('H:i') : $time_open;
                        $check_time_close = ! empty($hour['time_close'])
                            ? $hour['time_close']->format('H:i')
                            : $time_close; ?>
                        <div class="hour">
                            <div class="col-sm-10">
                                <div class="input-group"
                                     style="padding-bottom: 10px;">
                                    <input class="input-sm form-control clockpicker"
                                           name="customtime[<?php echo $k; ?>][<?php echo $j; ?>][time_open]"
                                           value="<?php echo $check_time_open; ?>">
                                    <span class="input-group-addon">to</span>
                                    <input class="input-sm form-control clockpicker"
                                           name="customtime[<?php echo $k; ?>][<?php echo $j; ?>][time_close]"
                                           value="<?php echo $check_time_close; ?>">
                                </div>
                            </div>

                            <?php if ($j == 0) { ?>
                                <div class="col-sm-2">
                                    <button type="button"
                                            class="btn btn-sm btn-success add-hour"
                                            data-attr="<?php echo $k; ?>">
                                        <i class="fa fa-plus"></i>
                                        Add Peroid
                                    </button>
                                </div>
                            <?php } else { ?>
                                <div class="col-sm-2">
                                    <button type="button"
                                            class="btn btn-sm btn-danger remove-hour">
                                        Remove
                                    </button>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php echo $this->element('Admin/Store/hour'); ?>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>

