<style >

.sf_si_prmium_head{    margin-bottom: 23px;}
.sf_si_prmium_head span{font-weight:normal;}
.sfsi_row_table{float: left;}
h4.bannerTitle {font-weight: 700;min-height: 48px;}
h4.bannerTitle span{ font-size: 16px;font-weight: 500;}

.sf_si_all_features_premium a{color:#12a252 !important;font-size:18.9px;font-weight:bold;border-bottom: 1px solid #12a252;text-decoration: none;}

.banner_icon_img {padding:5px 10px 5px 0px;vertical-align: middle;width: 50px; height: 50px;}

.sf_si_prmium_head h2{
    font-size: 26px;
    color: #000;
    font-weight: bold;
    margin-top: 0;
}
.sf_si_our_prmium_plugin-add{
    float: left;
    width: 70%;
    padding: 25px 38px 35px 40px;
    background: #f3faf6;
    border: 1px solid #12a252;
}
.banner_view_more{
    background: #17b15b !important;
    color: #fff !important;
    padding: 6px 43px;
    text-align: center;
    font-size: 18px;
    text-decoration: none;   
}

@media (min-width:1024px) and (max-width: 1366px) and (orientation:portrait) {
    .sf_si_our_prmium_plugin-add {
        width: 97%;
        padding: 25px 11px 35px 7px;
    }
    h4.bannerTitle{
        min-height: 70px;
    }
}
@media (min-width:1024px) and (max-width: 1366px) and (orientation:landscape) {
    .sf_si_our_prmium_plugin-add {
        width: 95%;
        padding: 25px 11px 35px 26px;
    }    
}

@media (min-width:768px) and (max-width: 1024px) and (orientation:portrait){
    h4.bannerTitle {
        min-height: 30px;
    }      
} 
@media (min-width:768px) and (max-width: 1024px) and (orientation:landscape) {
    .sf_si_our_prmium_plugin-add {
        width: 97%;
        padding: 25px 11px 35px 8px;
    }
    h4.bannerTitle {
        min-height: 70px;
    }  
}
</style>
<div class="sf_si_our_prmium_plugin-add">
    
    <div class="sf_si_prmium_head">
        <h2>New: <span>In our Premium Plugin we added:</span></h2>
    </div>

    <?php 

        $arrDefaultImages = array(
            'default1_facebook.png','default1_pinterest.png', 'default1_twitter.png',
            'default2_facebook.png','default2_pinterest.png', 'default2_twitter.png',
            'default3_facebook.png','default3_pinterest.png', 'default3_twitter.png'
        );

        $arrThemeImages = array(
            'theme1_facebook.png','theme1_pinterest.png', 'theme1_twitter.png',
            'theme2_facebook.png','theme2_pinterest.png', 'theme2_twitter.png',
            'theme3_facebook.png','theme3_pinterest.png', 'theme3_twitter.png'
        );

        $arrAnimateImages = array(
            'animated_facebook.gif','animated_follow.gif','animated_instagram.gif',
            'animated_linkedin.gif','animated_pinterest.gif','animated_twitter.gif',
            'animated_whatsapp.gif','animated_youtube.gif' , 'animated_email.gif'
        );

    function sfsi_banner_sub_section($sectionTitle,$arrImages,$hrefViewMore)
    { ?>

        <div class="row">
            <h4 class="bannerTitle"><?php echo $sectionTitle; ?></h4>
        </div>

        <?php 

        $imgBasePath = SFSI_PLUS_PLUGURL."images/banner/";
        $arrImages   = array_chunk($arrImages, 3);

        foreach ($arrImages as $key => $arrImg) : ?>

            <div class="row zeropadding">

               <?php  foreach ($arrImg as $key => $img):                

                    $src = $imgBasePath.$img;?>    

                <div class="sfsi_row_table">
                    <img class="banner_icon_img" src="<?php echo $src; ?>" />
                </div>

                <?php endforeach; ?>

            </div>

        <?php endforeach; ?>

        <div class="row sf_si_all_features_premium" style="padding-left:50px;">
            <a  style="font-weight: unset;" target="_blank" href="<?php echo $hrefViewMore; ?>">View all</a>
        </div> 
        
    <?php } ?>

    <div class="col-md-12 sf_si_default_design">

        <div class="col-md-4 zeropadding"><?php sfsi_banner_sub_section("A) More default design styles",$arrDefaultImages,"https://www.ultimatelysocial.com/extra-icon-styles/");?></div>

        <div class="col-md-4 zeropadding"><?php sfsi_banner_sub_section("B) Themed styles<br> <span>(to match the content of your the site)</span>",$arrThemeImages,"https://www.ultimatelysocial.com/themed-icons-search/"); ?></div>

        <div class="col-md-4 zeropadding"><?php sfsi_banner_sub_section("C) Animated icons<br> <span>(eye-catching moving icons)</span>",$arrAnimateImages,"https://www.ultimatelysocial.com/animated-social-media-icons/"); ?> </div>
        
    </div>

	<div class="row" style="text-align:center">
		<a class="banner_view_more" href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmplus_settings_page&utm_campaign=more_icons_designs&utm_medium=banner" target="_blank">Go premium to get all of those</a>
	</div>
</div>