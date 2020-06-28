<?php
/**
 * The template for displaying the footer.
 *
 * @package cartel
 */

?>  
            </div>

            <footer class="footer" role="contentinfo">
                 <?php
                /**
                 * Functions hooked in to cartel_footer action.
                 *
                 * @hooked cartel_template_copyright -10
                 */ 
                    do_action('cartel_footer'); 
                ?>
            </footer>

        <?php wp_footer(); ?>
    </body>

</html>