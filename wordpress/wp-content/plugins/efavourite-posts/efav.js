jQuery(document).ready( function($) {
    $('.efav-link').live('click', function() {
        efav_this = $(this);
        efav_do_js( efav_this, 1 );
        if (efav_this.hasClass('remove-parent')) {
            efav_this.parent("li").fadeOut();
        }
        return false;
    });
});

jQuery(document).ready(function($) {
        $('.tabs .tab-links a').on('click', function(e)  {
            var currentAttrValue = $(this).attr('href');
            $('.tabs ' + currentAttrValue).show().siblings().hide();
            $(this).parent('li').addClass('active').siblings().removeClass('active');
            e.preventDefault();
        });
    });

function efav_do_js( efav_this, efav_doAjax ) {
    loadingImg = efav_this.prev();
    loadingImg.show();
    beforeImg = efav_this.prev().prev();
    beforeImg.hide();
    url = document.location.href.split('#')[0];
    params = efav_this.attr('href').replace('?', '') + '&efav_ajax=1';
    if ( efav_doAjax ) {
        jQuery.get(url, params, function(data) {
                efav_this.parent().html(data);
                if(typeof efav_after_ajax == 'function') {
                    efav_after_ajax( efav_this ); 
                }
                loadingImg.hide();
            }
        );
    }
}
