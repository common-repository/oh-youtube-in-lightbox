<div class="wrapper">

    <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:',$this->loc); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>


    <p><label for="<?php echo $this->get_field_id( 'yt_url' ); ?>"><?php _e( 'Insert Your Youtube ID:'); ?></label>
        <input id="<?php echo $this->get_field_id( 'yt_url' ); ?>" name="<?php echo $this->get_field_name( 'yt_url' ); ?>" type="text" value="<?php echo $yt_url; ?>" /></p>

		
	<p><label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'Image:',$this->loc); ?></label>
        <input class="widefat file-upload" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" type="text" value="<?php echo $image; ?>" />
    <span><?php _e('Click on the text box above to open file upload dialog.',$this->loc) ?></span>
    </p>

</div><!-- /wrapper -->
<script>
    jQuery(document).ready( function() {
        var original_send_to_editor = window.send_to_editor;

        jQuery('#<?php echo $this->get_field_id( 'image' );?>').click(function(e) {
            e.preventDefault();
            formfield =  jQuery(this);
            tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
            window.send_to_editor = function(html) {
                imgurl = jQuery('img',html).attr('src');
                formfield.val(imgurl);
                tb_remove();
                window.send_to_editor = original_send_to_editor;

            }
            return false;
        });
    });



</script>