<?php if ( $title ) echo $before_title . $title . $after_title; ?>

<div class="padd10">
		<?php if ($image && $yt_url): ?>
		<a class="" rel="prettyPhoto" href="http://www.youtube.com/watch?v=<?php echo $yt_url; ?>">
            <img src="<?php echo $image; ?>"/>
        </a>
		<?php endif; ?>
</div>

<?php 