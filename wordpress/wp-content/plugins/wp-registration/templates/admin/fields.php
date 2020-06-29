<?php
/*
** all field render in model
*/

    // not run if accessed directly
    if( ! defined("ABSPATH" ) )
        die("Not Allewed");

    global $post;
    $wpr_saved_fields = wpr_get_form_fields($post->ID);
    $wpr_default_meta = $meta->meta_array();
    $wpr_field_index = 1;
    $core_fields_exist = wpr_check_wp_core_fields($wpr_saved_fields);
    
    if ($core_fields_exist) { ?>
       <div class="wpr-core-field-username">
            <p></p><?php _e('WP Core Field Username or Email Missing Without these Field User Not Rrgister','wp-registration') ?> </p>
        </div>
   <?php }
    
?>
            <!-- <p class="erro"> </p> -->

 <!-- Modal for all fields name render -->
<div class="modal fade wpr-fields-name-model" id="wpr_all_fields" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php _e('Select Registration Field', 'wp-registration'); ?></h4>
            </div>
            <div class="modal-body">
                <ul class="list-group list-inline">
                    <?php
                        foreach ($wpr_default_meta as $id => $save_data) {
                    ?> 
                    <li class="wpr_select_field list-group-item"  data-field-type="<?php echo esc_attr($id); ?>">
                        <span class="wpr-fields-icon"><?php echo $save_data['icon']; ?>
                        </span>
                        <span>
                            <?php echo $save_data['title'];  ?>    
                        </span>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close-model" data-dismiss="modal"><?php _e('Close' , 'wp-registration'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="wpr-main-field-wrapper">

    <!-- saving all fields via model -->
    <div class="wpr_save_fields_model">
        <?php 
        if ( $wpr_saved_fields ) {
            $f_index = 1;
            foreach ($wpr_saved_fields as $field_index => $field) {
            ?>
                <div class="modal fade wpr-slider wpr_sort_id_<?php echo $f_index; ?>" id="wpr_field_model_<?php echo $f_index; ?>" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            
                        <?php
                        foreach ($field as $field_type => $save_data) {

                            $wpr_field_meta = isset($wpr_default_meta[$field_type])? $wpr_default_meta[$field_type] : '';
                            $field_meta = $wpr_field_meta['field_meta'];
                            $field_title = $wpr_field_meta['title'];
                            $field_desc = $wpr_field_meta['description'];

                            $save_field_title = isset($save_data['title']) ? $save_data['title'] : '';
                            ?>
                            <div class="modal-header">
                                <h4 class="modal-title"><?php echo $field_title; ?></h4>
                            </div>
                            <div class="modal-body">
                            <?php
                            echo $meta->render_field_meta($field_meta, $field_type, $f_index, $save_data);
                        ?>
                            </div>
                            <div class="modal-footer">
                                <span class="wpr-req-field-id"></span>
                                <button type="button" class="btn btn-default close-model" data-dismiss="modal"><?php _e('Close', 'wp-registration'); ?></button>
                                <button class="btn btn-primary wpr-update-field" data-field-index='<?php echo esc_attr($f_index); ?>' data-field-type='<?php echo esc_attr($field_title); ?>' ><?php _e('Update Field', 'wp-registration'); ?></button>
                            </div>
                        <?php 
                        }

                        $wpr_field_index = $f_index;
                        $wpr_field_index++;
                        $f_index++;

                        ?> 
                        </div>
                    </div>
                </div>
            <?php
            }
        }

        echo '<input type="hidden" id="field_index" value="'.esc_attr($wpr_field_index).'">';
        ?>
    </div>
    <!-- all fields append on table -->
    <div class="table-responsive">    
        <table class="table wpr_field_table table-striped">
            <thead>
                <tr>            
                    <th colspan="6">
                        <button type="button" class="button button-primary" data-toggle="modal" 
                         data-target="#wpr_all_fields"><?php _e('Add field', 'wp-registration'); ?></button>
                        <button type="button" class="button wpr_remove_field"><?php _e('Remove', 'wp-registration'); ?></button>
                    </th>  
                </tr>
                <tr class="wpr-thead-bg">
                    <th></th>
                    <th class="wpr-check-all-field">
                        <input type="checkbox">
                    </th>
                    <th><?php _e('Field ID', 'wp-registration'); ?></th>
                    <th><?php _e('Type', 'wp-registration'); ?></th>
                    <th><?php _e('Title', 'wp-registration'); ?></th>
                    <th><?php _e('Placeholder', 'wp-registration'); ?></th>
                    <th><?php _e('Required', 'wp-registration'); ?></th>
                    <th><?php _e('Email', 'wp-registration'); ?></th>
                    <th><?php _e('Actions', 'wp-registration'); ?></th> 
                </tr>                       
            </thead>
            <tfoot>
                <tr class="wpr-thead-bg">
                    <th></th>
                    <th class="wpr-check-all-field">
                        <input type="checkbox">
                    </th>
                    <th><?php _e('Field ID', 'wp-registration'); ?></th>
                    <th><?php _e('Type', 'wp-registration'); ?></th>
                    <th><?php _e('Title', 'wp-registration'); ?></th>
                    <th><?php _e('Placeholder', 'wp-registration'); ?></th>
                    <th><?php _e('Required', 'wp-registration'); ?></th>
                    <th><?php _e('Email', 'wp-registration'); ?></th>
                    <th><?php _e('Actions', 'wp-registration'); ?></th>
                </tr>
            </tfoot>
            <tbody>
                <?php 
                if ( $wpr_saved_fields ) {
                    $f_index = 1;
                    foreach ($wpr_saved_fields as $field_index => $field) {

                        foreach ($field as $field_type => $save_data) {

                            $wpr_field_meta = isset($wpr_default_meta[$field_type])? $wpr_default_meta[$field_type] : '';
                            $field_title = isset($wpr_field_meta['title']) ? $wpr_field_meta['title'] : '';

                            $the_title = isset($save_data['title']) ? $save_data['title'] : '';
                            $the_field_id = isset($save_data['data_name']) ? $save_data['data_name'] : '';
                            $the_placeholder = isset($save_data['placeholder']) ? $save_data['placeholder'] : '';
                            $the_required = isset($save_data['required']) ? $save_data['required'] : '';
                            $email_req = isset($save_data['email_req']) ? $save_data['email_req'] : '';
                            if ($the_required) {
                                $_ok = 'Yes';
                            }else{
                                $_ok = 'No';
                            }
                            
                            if ($email_req) {
                                $_oks = 'Yes';
                            }else{
                                $_oks = 'No';
                            }
                        ?>
                        
                            <tr class="row_no_<?php echo esc_attr($f_index); ?>" id="wpr_sort_id_<?php echo $f_index; ?>" >
                                <td class="wpr-sortable-handle">
                                    <i class="fa fa-arrows" aria-hidden="true"></i>
                                </td>
                                <td class="wpr-check-one-field" >
                                    <input type="checkbox" value="<?php echo esc_attr($f_index); ?>" data-io="<?php echo $the_field_id; ?>" >
                                </td>
                                <td class="wpr_meta_field_id"><?php echo $the_field_id; ?></td>
                                <td class="wpr_meta_field_type"><?php echo $field_title; ?></td>
                                <td class="wpr_meta_field_title"><?php echo $the_title; ?></td>
                                <td class="wpr_meta_field_plchlder"><?php echo $the_placeholder; ?></td>
                                <td class="wpr_meta_field_req"><?php echo $_ok; ?></td> 
                                <td class="wpr_meta_email_field_req"><?php echo $_oks; ?></td> 
                                <td>
                                    <button class="button  wpr_copy_field" data-field-type="<?php echo esc_attr($field_type); ?>" title="<?php _e('Copy Field','wp-registration'); ?>"><i class="fa fa-clone" aria-hidden="true"></i></button>
                                    <button class="button wpr-edit-field" id="<?php echo esc_attr($f_index); ?>" title="<?php _e('Edit Field','wp-registration'); ?>"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                </td>
                            </tr>
                         <?php   
                        }

                        $wpr_field_index = $f_index;
                        $wpr_field_index++;
                        $f_index++;
                        ?>
                    <?php
                    }
                }

                echo '<input type="hidden" id="field_index" value="'.esc_attr($wpr_field_index).'">';
            ?>
            </tbody>
        </table>
    </div>
</div>

<div style ="display: none">
    <?php  $meta->render_field_settings(); ?>
</div>