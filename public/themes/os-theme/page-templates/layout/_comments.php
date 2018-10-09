<?php if ( ! defined( 'ABSPATH' ) ) exit( 'restricted access' ); ?>
<div id="comments">
	<?php if ( post_password_required() ) : ?>
        <p>
            This post is password protected. Enter the password to view any comments
        </p>
		<?php
		echo '</div>';

		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */

		return;
	endif;
	$post_id  = get_the_ID();
	$comments = get_comments( compact( 'post_id' ) );

	$comments_count = count( $comments );
	if ( $comments_count > 0 ) : ?>

        <h4 class="text-muted">
			<?php echo $comments_count > 1 ? "$comments_count Comments" : "$comments_count Comment" ?>
        </h4>

        <div class="comments-list mb-5">
			<?php
			wp_list_comments( [
				'style'        => 'div',
				//'type'         => 'comment',
				'short_ping'   => true,
				'avatar_size'  => '54',
				'end-callback' => function() {
					echo '</div><!-- .media-body --> </div><!-- .media -->';
				},

				'walker' => new NY\WP_Bootstrap_Comments_Walker(),
			], $comments );

			// paginate_comments_links();
			?>
        </div>
	<?php
	/* If there are no comments and comments are closed, let's leave a little note, shall we?
	 * But we don't want the note on pages or post types that do not support comments.
	 */
    elseif ( ! comments_open( $post_id ) && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
        <p>
			<?php echo __( 'Comments are closed', 'wah' ) ?>
        </p>
	<?php
	endif;

	/*
	 * Adding bootstrap support to comment form,
	 * and some form validation using javascript.
	 */
	ob_start();
	$commenter = wp_get_current_commenter();
	$req       = true;
	$aria_req  = ( $req ? " aria-required='true'" : '' );

	$comments_arg = [
		'form'                => [
			'class' => 'form-horizontal',
		],
		'fields'              => apply_filters( 'comment_form_default_fields', [
			'autor' => '<div class="form-group">' . '<label for="author">' . __( 'Name', 'wah' ) . '</label> ' . ( $req ? '<span>*</span>' : '' ) .
			           '<input id="author" name="author" class="form-control" type="text" value="" size="30"' . $aria_req . ' />' .
			           '<p id="d1" class="text-danger"></p>' . '</div>',
			'email' => '<div class="form-group">' . '<label for="email">' . __( 'Email', 'wah' ) . '</label> ' . ( $req ? '<span>*</span>' : '' ) .
			           '<input id="email" name="email" class="form-control" type="text" value="" size="30"' . $aria_req . ' />' .
			           '<p id="d2" class="text-danger"></p>' . '</div>',
			'url'   => '',
		] ),
		'comment_field'       => '<div class="form-group">' . '<label for="comment">' . __( 'Comment', 'wah' ) . '</label><span>*</span>' .
		                         '<textarea id="comment" class="form-control" name="comment" rows="3" aria-required="true"></textarea><p id="d3" class="text-danger"></p>' . '</div>',
		'comment_notes_after' => '',
		'class_submit'        => 'btn btn-primary',
	];
	comment_form( $comments_arg );
	echo str_replace( 'class="comment-form"', 'class="comment-form" name="commentForm" onsubmit="return validateForm();"', ob_get_clean() );
	?>
    <script>
        /* basic javascript form validation */
        function validateForm() {
            var form = document.forms[ "commentForm" ],
                x    = form[ "author" ].value,
                y    = form[ "email" ].value,
                z    = form[ "comment" ].value,
                flag = true,
                d1   = document.getElementById("d1"),
                d2   = document.getElementById("d2"),
                d3   = document.getElementById("d3");

            if (x == null || x == "") {
                d1.innerHTML = "<?php echo __( 'Name is required', 'wah' ); ?>";
                flag         = false;
            } else {
                d1.innerHTML = "";
            }

            if (y == null || y == "") {
                d2.innerHTML = "<?php echo __( 'Email is required', 'wah' ); ?>";
                flag         = false;
            } else {
                d2.innerHTML = "";
            }

            if (z == null || z == "") {
                d3.innerHTML = "<?php echo __( 'Comment is required', 'wah' ); ?>";
                flag         = false;
            } else {
                d3.innerHTML = "";
            }

            if (flag == false) {
                return false;
            }

        }
    </script>
</div>