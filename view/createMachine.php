<?php
include_once __DIR__ . '/../utility/utility.php';

?>
<form action='index.php?action=createMachineView' method="post">
        <input type="hidden" name="action" value="createMachine">
        Machine Rows:<br>
        <input type="number" class="<?php echo showInputRed($array, 'Rows'); ?>"
               value="<?php echo showInput($array, 'Rows'); ?>" step="1" min="0" pattern="[0-9]"
               name="machineRows">
        <br> Machine Columns:<br>
        <input type="number" class="<?php echo showInputRed($array, 'Columns'); ?>"
               value="<?php echo showInput($array, 'Columns'); ?>" step="1" min="0" pattern="[0-9]"
               name="machineColumns">
        <br>
        Machine Size:<br>
        <input type="number" class="<?php echo showInputRed($array, 'Size'); ?>"
               value="<?php echo showInput($array, 'Size'); ?>" step="1" min="0" pattern="[0-9]" name="machineSize">
        <br>
        Machine Name:<br>
        <input type="text" class="<?php echo showInputRed($array, 'Name'); ?>"
               value="<?php echo showInput($array, 'Name'); ?>" name="machineName">
        <br>
        Machine Description:<br>
        <textarea name="machineDesc"
                  class="<?php echo showInputRed($array, 'Desc'); ?>"><?php echo showInput($array, 'Desc'); ?></textarea>
        <br>
        Status: <br>
        <div class="<?php echo showInputRed($array, 'Status'); ?>">
            <?php
            foreach ($array['status'] as $value): ?>
                <input type="radio" value="<?php echo $value['statusId'] ?>" <?php
                if (isset($array['validValues']['validStatus'])) {
                    if ($value['statusId'] == $array['validValues']['validStatus']) {
                        echo 'checked="checked"';
                    }
                }
                ?> name="machineStatus"> <?php echo $value['status'] ?>
                <br>
            <?php endforeach; ?>
        </div>
        <br>
        Active Days:<br>
        <div class="<?php echo showInputRed($array, 'Days'); ?>">
            <?php foreach ($array['days'] as $value): ?>
                <input type="checkbox" value="<?php echo $value['dayId'] ?>" <?php
                if (isset($array['validValues']['validDays'])) {
                    foreach ($array['validValues']['validDays'] as $validDay) {
                        if ($value['dayId'] == $validDay) {
                            echo 'checked="checked"';
                        }
                    }
                }
                ?> name="days[]"> <?php echo $value['days'] ?>
                <br>
            <?php endforeach; ?>
        </div>
        <input type="submit" value="Create Machine">
    </form>