<?php
$time_open  = ! empty($settingInfo['time_open'])
    ? $settingInfo['time_open']
    : '';
$time_close = ! empty($settingInfo['time_close'])
    ? $settingInfo['time_close']
    : '';
?>
<div class="hide hour" id="storeHour">
    <div class="col-sm-10">
        <div class="input-group" style="padding-bottom: 10px;">
            <input class="input-sm form-control clockpicker"
                   name="time_open"
                   value="<?php echo $time_open; ?>">
            <span class="input-group-addon">to</span>
            <input class="input-sm form-control clockpicker"
                   name="time_close"
                   value="<?php echo $time_close; ?>">
        </div>
    </div>
    <div class="col-sm-2">
        <button type="button" class="btn btn-sm btn-danger remove-hour">Remove
        </button>
    </div>
</div>

