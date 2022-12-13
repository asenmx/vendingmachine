<table id="machinelist" class="display" cellspacing="0" width="100%">
    <tr>
        <th>Cell Row</th>
        <th>Cell Columns</th>
        <th>Product Name</th>
        <th>Product Count</th>
    </tr>
    <?php
    foreach ($machineData as $value): ?>
        <tr>
            <td> <?php echo $value['cell_row']; ?> </td>
            <td> <?php echo $value['cell_column']; ?> </td>
            <td> <?php echo $value['product_type_name']; ?> </td>
            <td> <?php echo $value['product_counter']; ?> </td>
        </tr>
    <?php endforeach; ?>
</table>
