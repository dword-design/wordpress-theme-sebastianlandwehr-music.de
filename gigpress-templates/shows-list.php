<?php
/*
	STOP! DO NOT MODIFY THIS FILE!
	If you wish to customize the output, you can safely do so by COPYING this file into a new folder called 'gigpress-templates' in your 'wp-content' directory	and then making your changes there. When in place, that file will load in place of this one.
	
	This template displays all of our individual show data in the main shows listing (upcoming and past).

	If you're curious what all variables are available in the $showdata array, have a look at the docs: http://gigpress.com/docs/
*/
?>

<div class="termine__item <?php echo $class; ?>">

	<div class="termine__date-and-time">
		<div class="termine__date">
			<?php echo $showdata['date']; ?>
			<?php if($showdata['end_date']) : ?> - <?php echo $showdata['end_date']; ?><?php endif; ?>
		</div>
		<?php if($showdata['time']) : ?>
			<div class="termine__time">
				<?php echo $showdata['time']; ?>
			</div>
		<?php endif; ?>
	</div>

	<div class="termine__infos">
<?php if((!$artist && $group_artists == 'no') && $total_artists > 1) : ?>
		<div class="termine__artist">
			<?php echo $showdata['artist']; ?>
		</div>
<?php endif; ?>

		<div class="termine__venue-and-notes">
			<div class="termine__venue">
				<a target="_blank" href="<?php echo $showdata['address_url']; ?>"><?php echo $showdata['city']; if(!empty($showdata['state'])) echo ', '.$showdata['state']; ?>, <?php echo $showdata['venue']; ?></a>
			</div>
			<?php if($showdata['address_plain']) : ?>
				<div class="termine__address">
					<a target="_blank" href="<?php echo $showdata['address_url']; ?>"><?php echo $showdata['address_plain']; ?></a>
				</div>
			<?php endif; ?>
			<div class="termine__notes">
				<?php echo $showdata['notes']; ?>
			</div>
		</div>
	</div>
</div>