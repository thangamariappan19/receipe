<?php 

/*
**Setting of email design meta
*/
    // not run if accessed directly
    if( ! defined("ABSPATH" ) )
        die("Not Allewed");

    $member_dir     = WPRMEMBERDIRECTORY();
    $users_by_role  = $member_dir->get_users_by_role();

    $show_member_role = WPR_Settings()->get_option('show_members_role');
    $show_member_email = WPR_Settings()->get_option('show_member_email');



 ?>
<div class="row">
<?php 
if ($users_by_role ) {
    
    foreach ($users_by_role as $key => $value) {

        $user    = new WPR_User( $value->ID );
        $img_url = wpr_upload_dir_url($value->ID);
        $profile_photo = wpr_files_setup_get_directory($value->ID).'wpr_profile_photo.png';
        $first_letter =  ucfirst(substr($user->first_name, 0, 1));
        $card_grid = WPR_Settings()->get_option('wpr_member_dir_gird') ? WPR_Settings()->get_option('wpr_member_dir_gird') : 'col-md-3'; 
        
?>          
<div class="<?php echo $card_grid; ?> col-sm-6" style="margin-top: 5px;">
    <div class="wpr-card">
    
        <?php if (file_exists($profile_photo)) {
            $html = '';
            $html .= '<img class="img-gird img-thumbnail" src=" '. $img_url.'wpr_profile_photo.png">';
            echo $html; 
                           
        }
        else {
                $html = '';
                $html .= '<span class="img-gird wpr-first-letter" >' .$first_letter. '</span>';
                echo $html; 
        } ?>
        <div class="wpr-card-body">
           <span><?php _e('First Name:' , 'wp-registration'); ?></span>
                <p><?php echo esc_attr($user->first_name); ?></p>
            <br>    
            <span><?php _e('Last Name:' , 'wp-registration'); ?></span>
                <p><?php echo esc_attr($user->last_name); ?></p>
             <br>
            <?php if ($show_member_email == 'on') { 
    
                $html = '';
                // $html .='<span>'._e('Email:' , 'wp-registration').'</span>';
                $html .='<p class="wpr-member-email">'.$user->email.'</p>';
                $html .='<br>';
                echo $html; 
            }

            if ($show_member_role == 'on') {
    
                $html = '';
                $html .='<p class="wpr-role">'.$user->role.'</p>';
                echo $html; 
            }
            ?> 
            <a href="<?php echo $user->profile_url; ?>" target="_blank" class="btn wpr-profile-btn">view profile</a>
        </div>
    </div>
</div>        

<?php } }?>

</div>