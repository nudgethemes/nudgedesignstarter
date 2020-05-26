<?php
/**
 * Displays the featured image
 *
 * @package WordPress
 * @subpackage Nudgedesignstarter
 * @since 1.0.0
 */

if ( has_post_thumbnail() && ! post_password_required() ) { ?>

	<figure class="featured-media">

		<div class="featured-media-inner">

			<?php if ( ! is_singular() ) { ?>

				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

					<?php the_post_thumbnail( 'nudgedesignstarter-post-archive' ); ?>

				</a>

				<?php
			} else {

				the_post_thumbnail();

				$caption = get_the_post_thumbnail_caption();

				if ( $caption ) {
					?>

					<figcaption class="wp-caption-text"><?php echo esc_html( $caption ); ?></figcaption>

					<?php
				}
			}
			?>

		</div><!-- .featured-media-inner -->

	</figure><!-- .featured-media -->

	<?php
}
