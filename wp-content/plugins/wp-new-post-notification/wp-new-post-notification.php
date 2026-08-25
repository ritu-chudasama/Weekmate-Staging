<?php
/**
 * Plugin Name: WP New Post Email Notification
 * Description: Send email notifications to site administrator when a new post is published
 * Version: 1.0
 * Author: Elsner Technologies Pvt. Ltd.
 * Author URI: http://www.elsner.com/
*/

function get_new_post_notification_emails(){
	return array('pankaj@elsner.com', 'kartavya@elsner.com', 'tarun@elsner.com', 'sales@weekmate.in');
}

/*add_action( 'publish_post', 'send_new_post_email_notification', 10, 2 );

function send_new_post_email_notification( $post_id, $post ) {
	$sent_admin_notification = get_post_meta($post_id, 'sent_admin_notification', true);
	
	if(!$sent_admin_notification){
		$author = $post->post_author;
		$name = get_the_author_meta( 'display_name', $author );
		$title = $post->post_title;
		$permalink = get_permalink( $post_id );

		$meta_title = get_the_title($post_id);
		if (!empty($post->post_excerpt)) {
            $meta_description = $post->post_excerpt;
        } else {
            $meta_description = wp_trim_words($post->post_content, 30, '...');
        }

		$publish_date = get_the_date( 'F j, Y', $post_id );
		$to[] = sprintf( '%s <%s>', $name, $email );
		$subject = sprintf( $_SERVER['HTTP_HOST'].' - New Blog Published [ %s ]', $publish_date );
		$message = '<h1>' . esc_html($meta_title) . '</h1>';
        $message .= '<p>' . esc_html($meta_description) . '  <strong><a href="' . esc_url($permalink) . '">Read it now!</a></strong></p>';
        
		add_filter('wp_mail_content_type', function() { return 'text/html'; });
		wp_mail( get_new_post_notification_emails(), $subject, $message );
		remove_filter('wp_mail_content_type', 'text/html');
		
		update_post_meta($post_id, 'sent_admin_notification', 1);
	}
}*/

function send_email_only_on_first_publish($new_status, $old_status, $post) {

    if (
        $old_status !== 'publish' &&
        $new_status === 'publish' &&
        $post->post_type === 'post'
    ) {
		$post_id = $post->ID;
        $sent_admin_notification = get_post_meta($post_id, 'sent_admin_notification', true);
	
		//if(!$sent_admin_notification){
			$author = $post->post_author;
			$name = get_the_author_meta( 'display_name', $author );
			$title = $post->post_title;
			$permalink = get_permalink( $post_id );

			$meta_title = get_the_title($post_id);
			if (!empty($post->post_excerpt)) {
				$meta_description = $post->post_excerpt;
			} else {
				$meta_description = wp_trim_words($post->post_content, 30, '...');
			}

			$publish_date = get_the_date( 'F j, Y', $post_id );
			// $to[] = sprintf( '%s <%s>', $name, $email );
			$subject = sprintf( $_SERVER['HTTP_HOST'].' - New Blog Published by %s ', $name );
			$message = '<h1>' . esc_html($meta_title) . '</h1>';
			$message .= '<p>' . esc_html($meta_description) . '  <strong><a href="' . esc_url($permalink) . '">Read it now!</a></strong></p>';
			
			add_filter('wp_mail_content_type', function() { return 'text/html'; });
			wp_mail( get_new_post_notification_emails(), $subject, $message );
			remove_filter('wp_mail_content_type', 'text/html');
			
			update_post_meta($post_id, 'sent_admin_notification', 1);
		//}
    }
}
add_action('transition_post_status', 'send_email_only_on_first_publish', 10, 3);
