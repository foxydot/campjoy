<?php
/**
 * Genesis Framework.
 *
 *
 * @package Genesis\Templates
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */

msdlab_maybe_structural_wrap( 'site-inner', 'close' );
echo '</div>'; //* end .site-inner or #inner

do_action( 'genesis_before_footer' );
do_action( 'genesis_footer' );
do_action( 'genesis_after_footer' );

echo '</div>'; //* end .site-container or #wrap

do_action( 'genesis_after' );
wp_footer(); //* we need this for plugins
?>
</body>
</html>
