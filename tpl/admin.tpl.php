<div class="wrap">

	<?php screen_icon('tools'); ?><h2><?php _e('Wordpress Performance Enhancer','wp-performance-enhancer'); ?></h2>
	<p><?php _e('Make sure you always got a fresh backup before running the Wordpress Performance Enhancer. We take absolutely no responsibility for any damage this plugin may cause.','wp-performance-enhancer'); ?></p>
	
	<h3><?php _e('Optimize database','wp-performance-enhancer'); ?></h3>
	<p><?php echo sprintf(__('Your database is %s kb overhead','wp-performance-enhancer'), '<strong>' . self::database_calculate_overhead() . '</strong>' ); ?>.</p>
	<p><a class="button-primary" href="admin.php?page=wppe-settings&do=optimize-db" title="<?php _e('Optimize database','wp-performance-enhancer') ?>"><?php _e('Optimize database','wp-performance-enhancer') ?></a></p>
	<p>&nbsp;</p>
	
	<h3><?php _e('Orphan postmeta','wp-performance-enhancer'); ?></h3>
	<p><?php echo sprintf(__('This blog has %s orphan postsmeta entries','wp-performance-enhancer'), '<strong>' . self::findOrphanPostmeta() . '</strong>' ); ?>.</p>
	<p><a class="button-primary" href="admin.php?page=wppe-settings&do=remove-orphan-postmeta" title="<?php _e('Remove orphan postsmeta','wp-performance-enhancer') ?>"><?php _e('Remove orphan postsmeta','wp-performance-enhancer') ?></a></p>
	<p>&nbsp;</p>

</div>