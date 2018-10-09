<?php

namespace NY;

/**
 * A custom WordPress comment walker class to implement the Bootstrap 4 Media object in wordpress comment list.
 *
 * @package     WP Bootstrap 4 Comment Walker
 * @version     1.0.0
 * @author      Aymene Bourafai <bourafai.a@gmail.com> <www.aymenebourafai.com>
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link        https://github.com/bourafai/wp-bootstrap-4-comment-walker
 * @link        https://v4-alpha.getbootstrap.com/layout/media-object/
 */
class WP_Bootstrap_Comments_Walker extends \Walker_Comment {

	function html5_comment( $comment, $depth, $args ) {
		$comment_classes = get_comment_class( ( $this->has_children ? 'has-children media' : ' media' ) . ' mb-5 pt-3' . ( $depth == 1 ? '' : '' ) );
		$comment_classes = ! empty( $comment_classes ) ? 'class="' . implode( ' ', $comment_classes ) . '"' : '';
		echo '<' . ( $args['style'] === 'div' ? 'div' : 'li' ) . ' id="comment-' . get_comment_ID() . '" ' . $comment_classes . '>';
		?>


		<?php if ( $args['avatar_size'] != 0 ): ?>
			<?php echo get_avatar( $comment, $args['avatar_size'], 'mm', '', [ 'class' => "comment_avatar rounded-circle mr-3" ] ); ?>
		<?php endif; ?>

		<?php
		// .media-body closes at
		echo '<div class="media-body">' ?>

        <h5 class="mt-0">
			<?php echo get_comment_author_link() ?>
            <time class="float-right small text-muted" datetime="<?php comment_time( 'c' ); ?>">
                <small><?php comment_date() ?>, <?php comment_time() ?></small>
            </time>
        </h5>
        <div class="comment-content">
            <div class="float-right">
				<?php edit_comment_link( __( 'Edit' ), '', '&nbsp;&nbsp;' ); ?>
            </div>
			<?php comment_text(); ?>
            <div>


				<?php
				comment_reply_link( array_merge( $args, [
					'add_below' => 'div',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<i class="fa fa-reply mr-1 text-muted"></i>',
					'after'     => '',
				] ) );
				?>
            </div>
        </div><!-- .comment-content -->

		<?php if ( '0' == $comment->comment_approved ) : ?>
            <p class="card-text comment-awaiting-moderation label label-info text-secondary small"><?php _e( 'This comment is awaiting moderation.' ); ?></p>
		<?php endif; ?>


		<?php
		// echo '<div>';
	}

	protected function ping( $comment, $depth, $args ) {
		$comment_classes = get_comment_class( ( $this->has_children ? 'has-children media' : ' media' )  . ( $depth == 1 ? '' : '' ) );
		$comment_classes = ! empty( $comment_classes ) ? 'class="' . implode( ' ', $comment_classes ) . '"' : '';
		echo '<' . ( $args['style'] === 'div' ? 'div' : 'li' ) . ' id="comment-' . get_comment_ID() . '" ' . $comment_classes . '>';
		// .media-body closes at
		echo '<div class="media-body">' ?>
        <div class="comment-content">
            <div class="float-right">
	            <?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
            </div>
	        <?php _e( 'Pingback:' ); ?> <?php comment_author_link( $comment ); ?>
        </div><!-- .comment-content -->
		<?php
	}
	/*/



	/*/
}

