<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
    $efav_html_li=array();
    if ($efav_post_ids){
        $efav_c = 0;
        if(is_string($efav_post_ids)){
            $efav_post_ids=json_decode($efav_post_ids,true);
        }
        if (!empty($efav_post_ids)) {
            $efav_post_ids = array_reverse($efav_post_ids);
            if(count($efav_post_ids)>0){
                foreach ($efav_post_ids as $efav_post_id) {
                    if ($efav_c++ == $efav_limit) break;
                    $efav_p = get_post($efav_post_id);
                    $efav_html_li[]="<li>
                                <a href='".get_permalink($efav_post_id)."' title='". $efav_p->post_title ."'>" . $efav_p->post_title . "</a>
                                </li>";
                }
            }
        }
    }else{
        $efav_html_li[]="<li>".__("Your favourite")."</li>";
    }
echo "<ul>".join($efav_html_li,"\n")."</ul>";

?>
