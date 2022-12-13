<?php

include_once __DIR__ . '/../utility/utility.php';

$counter = 0;
?>
<form action='index.php?action=loadMachineView' method="post">
    <input type="hidden" name="action" value="createProduct">
    <?php foreach ($result['productType'] as $types): ?>
        <select name="<?php echo "productName" . $counter; ?>">
            <br>
            <?php foreach ($result['productType'] as $types2): ?>
                <option value="<?php echo $types2['productTypeName']; ?>"><?php echo $types2['productTypeName']; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" min="0" name="<?php echo "productQuantity" . $counter; ?>"
               class="<?php echo showLoadInputRed($array, $counter, 'Quantity'); ?>"
               value="<?php echo showLoadInput($array, $counter, 'Quantity'); ?>" placeholder="Quantity">
        <input type="date" class="<?php echo showLoadInputRed($array, $counter, 'Date'); ?>"
               value="<?php echo showLoadInput($array, $counter, 'Date'); ?>"
               name="<?php echo "productExpireDate" . $counter; ?>">
        <input type="number" min="0" name="<?php echo "productPrice" . $counter; ?>"
               class="<?php echo showLoadInputRed($array, $counter, 'Price'); ?>"
               value="<?php echo showLoadInput($array, $counter, 'Price'); ?>"
               placeholder="Price">
        <br>
        <?php $counter++;
    endforeach; ?>
    <select name="machineId">
        <?php foreach ($result['machineData'] as $machine): ?>
            <option value="<?php echo $machine['vendingMachineId']; ?>"> <?php echo $machine['vendingMachineId'] ?></option>
        <?php endforeach; ?>
        <br>
    </select>
    <input type="submit" value="Add Products">
</form>