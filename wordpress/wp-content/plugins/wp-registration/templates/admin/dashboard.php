<?php 

/*
** Template the show dashboard user activity
*/

    // not run if accessed directly
    if( ! defined("ABSPATH" ) )
        die("Not Allewed");
    
$main_dashboard       = WPRDASHBOARD();
$total_user_pie_chart = $main_dashboard->show_users_on_pie_chart();
$total_users          = $main_dashboard->total_users();

$last_weak_users     = $main_dashboard->count_last_weak_users();
$last_month_users    = $main_dashboard->count_last_month_users();
$last_year_users     = $main_dashboard->count_last_year_users();
$inactive_user       = $main_dashboard->inactive_user();
$active_user         = $main_dashboard->active_user();


$posts_form = get_posts([
    'post_type' => 'wpr',
    'post_status' => 'publish',
    'numberposts' => -1
]); 

?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<div class="container-fluid wpr-dashboard-wrapper wrap">
	<h1 class="wp-heading-inline"><?php _e('WP Registration Dashboard' , 'wp-registration'); ?></h1>
		
    <div class="row wpr_migrate_form">
    <?php  
        if (get_option('wpr_migrate_controle') != '1' ) { ?>
        <div class="col-lg-6 col-md-6 wpr-users-state-overview">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    <span><?php _e('Maigration' , 'wp-registration'); ?></span>    
                </div>
                <div class="panel-body">
                    <div class="wpr-migration-text" style="font-family: -webkit-body;">
                        <h6><?php _e('We detected that some users are registered with an old version fields, Please click "Migration" button to shift them into new form. New form will be created with title "Migrated Form" ' , 'wp-registration') ?></h6>
                    </div>
                    <div>
                        <input type="hidden"  id="previous_form_key" value="wpregistration_meta">
                        <input class="btn btn-primary wpr_migrate_btn" type="submit" value="Migrate" style="float: right;">
                        <span id="" class="wpr-pass-alert"></span>

                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    <?php } ?>
        <!-- users register on last weak, last month and last year    -->
        <div class="col-lg-6 col-md-6 wpr-show-users-by-dates">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    <span><?php _e('Registration Over Period', 'wp-registration'); ?></span>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="wpr-users-last-wise">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h3><?php _e('Last Weak' , 'wp-registration'); ?>
                                        <span class="label label-info">
                                            <?php echo $last_weak_users; ?>
                                        </span>
                                    </h3>
                                </li>
                                <li class="list-group-item">
                                    <h3><?php _e('Last Month' , 'wp-registration'); ?>
                                        <span class="label label-info">
                                            <?php echo $last_month_users; ?>
                                        </span>
                                    </h3>
                                </li>
                                <li class="list-group-item">
                                    <h3><?php _e('Last Year' , 'wp-registration'); ?>
                                        <span class="label label-info">
                                            <?php echo $last_year_users; ?>
                                        </span>
                                    </h3>
                                </li>
                            </ul>
                        </div>
                        <div class="wpr-custom-btn">
                            <button class="btn btn-primary"><?php _e('Custom Period' , 'wp-registration'); ?></button>
                        </div>

                        <div class="col-md-8 wpr_users_date_query_wrapper" style="display: none;">
                            <form id="wpr_dashboard_date_form">
                                <input type="hidden" name="action" value="get_users_by_given_range">
                                <div class="form-group">
                                    <label for="date"><?php _e('Start Date:' , 'wp-registration'); ?></label>
                                    <input type="date" name="wpr_date_start" value="" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="date"><?php _e('End Date:' , 'wp-registration'); ?></label>
                                    <input type="date" name="wpr_date_end" value="" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <?php echo WPRDASHBOARD()->users_role(); ?>
                                </div>

                                <input type="submit" value="Get Stats" class="btn btn-info" style="float: right;">
                                <span class="wpr-date-query-result label label-info"></span>
                            </form>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div> 
    <?php do_action('wpr_migrate_form_show' , $main_dashboard); ?>  
</div>