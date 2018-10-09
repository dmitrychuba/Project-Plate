<?php
$url    = isset( $url ) ? ' href="' . $url . '"' : '';
$title  = isset( $title ) ? $title : '';
$target = !preg_match( '~' . get_bloginfo( 'url' ) . '~i', $url ) ? ' target="_blank"' : '';
echo '<a' . $url . $target . ' class="button-style">' . $title . '</a>';