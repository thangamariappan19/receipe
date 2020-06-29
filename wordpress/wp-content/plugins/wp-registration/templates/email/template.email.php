<?php
/**
 * Email template
 * 
 * */
 if( ! defined("ABSPATH" ) )
        die("Not Allewed");
        
    if ($form == 'not exist') {
        $header_text =  'WP Registration';
        $footer_text =  'Any problem contact with admin';
        $header_clr  =  '#63b1bb';
        $body_clr    =  '#ffffffc7';
        $fooetr_clr  =  '#e2e2e2';
        $font_clr    = '';
        $font_faimly = '';
        
    }else {
         
        $header_text = $form->get_option('wpr_email_header')== '' ? 'WP Registration' : $form->get_option('wpr_email_header');
        $footer_text = $form->get_option('wpr_email_footer') == '' ? 'Any problem contact with admin' : $form->get_option('wpr_email_footer');
        $header_clr  = $form->get_option('wpr_email_hd_bg_clr') == '' ? '#63b1bb' : $form->get_option('wpr_email_hd_bg_clr');
        $body_clr    = $form->get_option('wpr_email_bofy_bg_clr') == ''? '#ffffffc7': $form->get_option('wpr_email_bofy_bg_clr');
        $fooetr_clr  = $form->get_option('wpr_email_ft_bg_clr')== ''? '#e2e2e2': $form->get_option('wpr_email_ft_bg_clr');
        $font_clr    = $form->get_option('wpr_email_font_clr');
        $font_faimly = $form->get_option('wpr_email_font_family');
        
    }
    

// style Email
$tmp_container = "-webkit-box-shadow:0 0 0 3px rgba(0,0,0,0.025) !important;
       box-shadow:0 0 0 3px rgba(0,0,0,0.025) !important;
       -webkit-border-radius:6px !important;
       border-radius:6px !important;
       background-color: #fafafa;
       border-radius:6px !important;";
$tmp_header = "
        color: #f1f1f1;
        font-family:Arial;
        font-weight:bold;
        line-height:100%;
        vertical-align:middle;";
$tmp_email_logo = "
        margin: 0;
        font-size: 20px;
        text-align: center;
        line-height: 150%;
        color: #ffffff;
        font-variant: petite-caps;";
$tmp_body = "color: #4e4c4c;
        font-family:Arial;
        font-size: 14px;
        line-height:150%;
        text-align:left;";
$tmp_footer = "border-top:1px solid #E2E2E2;
        -webkit-border-radius:0px 0px 6px 6px;
        -o-border-radius:0px 0px 6px 6px;
        -moz-border-radius:0px 0px 6px 6px;
        border-radius:0px 0px 6px 6px;
        line-height: 0%;";
$tmp_footer_inner = "border: 0;
        border: 0;
        color: #777;
        font-family: Arial;
        font-size: 11px;
        line-height: 0%;
        text-align: center;
        padding: 0px;";
 ?>
<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
    <tbody style="color:<?php echo esc_attr($font_clr); ?> font-family:<?php echo esc_attr($font_faimly); ?>" >
        <tr>
            <td align="center" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" width="776" id="template_container" style="<?php echo esc_attr($tmp_container); ?>" class="wpr_template_container">
                    <tbody style="background-color: #f7e8bc40; border: 2px solid #82a8c51a;">
                        <tr>
                            <td align="center" valign="top">
                                <!-- Header -->
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_header" style="<?php echo esc_attr($tmp_header);?> background-color:<?php echo  esc_attr($header_clr); ?>" >
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h1 style="<?php echo esc_attr($tmp_email_logo); ?>" id="logo">
                                                    <a style="color: #f1f1f1;text-decoration: none;" title="Developer site" target="_self"><?php echo $header_text; ?></a>
                                               </h1>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- End Header -->
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="top">
                                <!-- Body -->
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_body">
                                    <tbody>
                                        <tr>
                                            <td valign="top" style="background-color:<?php echo esc_attr($body_clr) ?>;" id="mailtpl_body_bg">
                                                <!-- Content -->
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                    <tbody>
                                                        <tr>
                                                            <td valign="top">
                                                                <div style="<?php echo esc_attr($tmp_body); ?>" id="mailtpl_body" >

                
                                                                    <h4>%WPR_EMAIL_CONTENT%</h4>

                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!-- End Content -->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- End Body -->
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="top" style = "background-color:<?php echo esc_attr($fooetr_clr) ?>;">
                            <!-- Footer -->
                               <table border="0" cellpadding="10" cellspacing="0" width="100%"  style="<?php echo esc_attr($tmp_footer); ?>" id="template_footer">
                                    <tbody>
                                        <tr>
                                            <td valign="top">
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="2" valign="middle" style="<?php echo esc_attr($tmp_footer_inner); ?> " id="credit">
                                                                <?php echo esc_attr($footer_text); ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- End Footer -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>