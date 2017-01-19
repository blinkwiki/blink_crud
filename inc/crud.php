<?php
/**
* CRUD Functions.
*
* @package    crud.php
* @subpackage 
* @author     BlinkWiki
* @version    1.0
* Copyright 2016 BlinkWiki
* 
*/
?>
<?php
function get_create_sql($post, $tbl, $conn)
{
    // get the columns in the table
    {
        $sql_col = 'SHOW COLUMNS FROM '.$tbl;
        $rs_col = mysql_query($sql_col, $conn) or die(mysql_error());
        $row_col = mysql_fetch_assoc($rs_col);
        $total_cols = mysql_num_rows($rs_col);
    }
    
    // the first column is (should be) the table primary key field; so we save it
    $key_fld = $row_col['Field'];
    
    // intiate the update query
    $sql = "INSERT INTO `".$tbl."` (";

    // loop through building the rest of the update query
    for ($i=0; $i<$total_cols; $i++)
    {
        // append the separator comma
        if ($i > 0)
        {
            $sql .= ", ";
        }
        
        // append the table and column pair
        $sql .= "`".$tbl."`.`".$row_col['Field']."`";
    }
    
    // continue to the value section of the insert query
    $sql .= ") VALUES (";
    
    for ($i=0; $i<$total_cols; $i++)
    {
        // append the separator comma
        if ($i > 0)
        {
            $sql .= ", ";
        }
        
        $sql .= mysql_real_escape_string($post[$row_col['Field']]);
    }
    
    // close up the value section
    $sql .= ")";
        
    return $sql;
    
}

function get_update_sql($post, $tbl, $conn)
{
    // get the columns in the table
    {
        $sql_col = 'SHOW COLUMNS FROM '.$tbl;
        $rs_col = mysql_query($sql_col, $conn) or die(mysql_error());
        $row_col = mysql_fetch_assoc($rs_col);
        $total_cols = mysql_num_rows($rs_col);
    }
    
    // the first column is (should be) the table primary key field; so we save it
    $key_fld = $row_col['Field'];
    
    // intiate the update query
    $sql = "UPDATE `".$tbl."` SET";
    
    // loop through building the rest of the update query
    for ($i=0; $i<$total_cols; $i++)
    {
        $sql .= " `".$tbl."`.`".$row_col['Field']."` = ".mysql_real_escape_string($post[$row_col['Field']]);
    }
    
    // append the where clause
    $sql .= " WHERE 1";
    
    // complete the where clause : AND tbl.keyfld = 'post_val'
    $sql .= " AND `".$tbl."`.`".$key_fld."`=".mysql_real_escape_string($post[$key_fld]);
    
    return $sql;
}

function get_read_sql($tbl)
{
    switch($tbl)
    {
        case 'tbl_aircraft':
            $sql = 'SELECT *'
                .' FROM'
                    .' tbl_aircraft'
                    .', tbl_manu'
                    .', tbl_states'
                .' WHERE 1'
                    // relate the aircraft to the manufacturer
                    .' AND tbl_aircraft.ac_manu_id = tbl_manu.manu_id'
                    // relate the owner to the state of location
                    .' AND tbl_manu.manu_state_id = tbl_states.state_id'
            ;
            break;
        case 'tbl_owner_reg':
            $sql = 'SELECT *'
                .' FROM'
                    .' tbl_owner_reg'
                    .', tbl_states'
                .' WHERE 1'
                    // relate the owner to the state of location
                    .' AND tbl_owner_reg.owner_state_id = tbl_states.state_id'
            ;
            break;
        case 'tbl_manu':
            $sql = 'SELECT *'
                .' FROM'
                    .' tbl_ac_owner_map'
                    .', tbl_aircraft'
                    .', tbl_owner_reg'
                    .', tbl_states'
                .' WHERE 1'
                    // relate the normalised tables to the aircraft
                    .' AND tbl_ac_owner_map.ac_id = tbl_aircraft.ac_id'
                    // relate the normalised tables to the owner
                    .' AND tbl_ac_owner_map.owner_id = tbl_owner_reg.owner_id'
                    // relate the owner to the state of location
                    .' AND tbl_owner_reg.owner_state_id = tbl_states.state_id'
            ;
            break;
        case 'tbl_states':
            $sql = 'SELECT * FROM `tbl_states` WHERE 1';
            break;
        case 'tbl_ac_owner_map':
        default:
            $sql = 'SELECT *'
                .' FROM'
                    .' tbl_ac_owner_map'
                    .', tbl_aircraft'
                    .', tbl_owner_reg'
                    .', tbl_manu'
                    .', tbl_states'
                .' WHERE 1'
                    // relate the normalised tables to the aircraft
                    .' AND tbl_ac_owner_map.ac_id = tbl_aircraft.ac_id'
                    // relate the normalised tables to the owner
                    .' AND tbl_ac_owner_map.owner_id = tbl_owner_reg.owner_id'
                    // relate the aircraft to the manufacturer
                    .' AND tbl_aircraft.ac_manu_id = tbl_manu.manu_id'
                    // relate the owner to the state of location
                    .' AND tbl_owner_reg.owner_state_id = tbl_states.state_id'
            ;
            
    }
    return $sql;
}

function get_delete_sql($post, $conn)
{}

?>