<?php
/**
 * Template for displaying search forms in WeekMate
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */

?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text">
			<?php
			/* translators: Hidden accessibility text. */
			echo _x( 'Search for:', 'label', 'weekmate' );
			?>
		</span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'weekmate' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	<button type="submit" class="search-submit"><span class="screen-reader-text">
		<?php
		/* translators: Hidden accessibility text. */
		echo _x( 'Search', 'submit button', 'weekmate' );
		?>
	</span></button>
</form>
