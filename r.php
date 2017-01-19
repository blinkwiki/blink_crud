<?php //*********************************************READ ?>
    

    <hr>
    
    <strong>Read Aircraft Ownership Records</strong><br><br>
    
    <?php
    
        // build the read query for the ownership register
        $sql = get_read_sql('tbl_ac_owner_map');
        $rs = mysql_query($sql, $conn) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        $total_rows = mysql_num_rows($rs);
    
    ?>
    
    <?php // display the table ?>
    <table width="100%">
        <thead class="fw_b" valign="top">
            <tr>
                <td width="5%">SN</td>
                <td width="10%">Manufacturer</td>
                <td width="10%">AC Code</td>
                <td width="20%">Aircraft Model</td>
                <td width="35%">Owner Information</td>
                <td width="10%">Actions</td>
            </tr>
        </thead>
        <tbody valign="top">
            <?php
                $count = 0;
                do {
                    $count++;
            ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $row['manu_code']; ?></td>
                    <td><?php echo $row['ac_code']; ?></td>
                    <td><?php echo $row['ac_model']; ?></td>
                    <td><?php echo $row['owner_name'] . ' ('.$row['state_code'].')'; ?></td>
                    <td><a href="?a=u&rid=<?php echo $row['ao_map_id']; ?>">edit record</a></td>
                </tr>
            <?php } while($row = mysql_fetch_assoc($rs)); ?>
        </tbody>
    </table>
    
    <div align="center"><br><a href="?a=c">add new aircraft ownership record</a><br><br></div>
    
    <?php // display the table ?>
    
<?php //*********************************************READ ?>