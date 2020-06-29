<?php
/**
 * Settings
 **/

    // not run if accessed directly
    if( ! defined("ABSPATH" ) )
         die("Not Allewed");
         

?>

<table id="customers" style="font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif; border-collapse: collapse; 
            width: 55%; font-size: 14px; font-weight: bold;margin: 0px auto;">
    <tr>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 12px;padding-bottom: 12px; background-color: #5ab1d8;color: white;">Label Title</th>
        <th style="border: 1px solid #ddd;padding: 8px;padding-top: 12px;padding-bottom: 12px; background-color: #5ab1d8;color: white;"> Label Value</th>
  </tr>
  <?php foreach($message as $field_index => $field_value){ ?>
  <tr>
        <?php if( is_array($field_value['value']) ) {?>
                <td style=" border: 1px solid #ddd; padding: 8px;"><?php echo $field_value['title']; ?></td>
                <td style=" border: 1px solid #ddd; padding: 8px;">
                    <?php foreach($field_value['value'] as $value){ ?>
                    <span><?php echo $value; ?></span>,
                    <?php } ?>
                </td>
            <?php  }else { ?>
    <td style=" border: 1px solid #ddd; padding: 8px;"><?php echo $field_value['title']; ?></td>
    <td style=" border: 1px solid #ddd; padding: 8px;"><?php echo $field_value['value']; ?></td> <?php } ?>
  </tr> 
  <?php } ?>
</table>