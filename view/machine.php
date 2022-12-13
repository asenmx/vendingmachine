<table id="machinelist" class="display" cellspacing="0" width="100%">
    <tr>
        <th>Machine Id</th>
        <th>Machine Rows</th>
        <th>Machine Columns</th>
        <th>Machine Size</th>
        <th>Machine Name</th>
        <th>Machine Description</th>
        <th>Machine Status</th>
        <th>Machine Active Days</th>
    </tr>
    <?php
    foreach ($machineData['machineData'] as $value): ?>
        <tr>
            <td> <?php echo $value['vendingMachineId']; ?> </td>
            <td> <?php echo $value['vendingMachineRows']; ?> </td>
            <td> <?php echo $value['vendingMachineColumns']; ?> </td>
            <td> <?php echo $value['vendingMachineSize']; ?> </td>
            <td> <?php echo $value['vendingMachineName']; ?> </td>
            <td> <?php echo $value['vendingMachineDesc']; ?> </td>
            <td> <?php echo $value['vendingMachineStatus']; ?> </td>
            <td> <?php foreach ($value['vendingMachineDays'] as $activeDay) {
                    foreach ($machineData['daysList'] as $days) {
                        if ($activeDay['day_id'] == $days['dayId']) {
                            echo $days['days'] . ' ';

                        }
                    }
                } ?> </td>
            <td><a href="index.php?action=editMachineView&machineId= <?php echo $value['vendingMachineId']; ?>">Edit</a>
            <td><a href="index.php?action=showContent&machineId= <?php echo $value['vendingMachineId']; ?>">Show</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
