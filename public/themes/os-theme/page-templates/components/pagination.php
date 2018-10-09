<?php
if ( ! empty( $paginator ) && $paginator->getNumPages() > 1 ): ?>
    <nav id="pagination" aria-label="Page navigation" role="navigation">
        <span class="sr-only">Page navigation</span>
        <ul class="pagination justify-content-center ft-wpbs">
			<?php if ( $paginator->getPrevUrl() ): ?>

				<?php
				if ( $paginator->getCurrentPage() > 2 ): ?>
                    <li class="page-item"><a class="page-link" href="<?php echo preg_replace( '~/page/1~', '', $paginator->getPageUrl( 1 ) ); ?>">&laquo; First</a></li>
				<?php endif; ?>
                <li class="page-item"><a class="page-link" href="<?php echo preg_replace( '~/page/1([^\d]|$)~', '$1', $paginator->getPrevUrl() ); ?>">&lt; Previous</a></li>
			<?php endif; ?>

			<?php foreach ( $paginator->getPages() as $page ): ?>
				<?php if ( $page['url'] ): ?>
                    <li <?php echo $page['isCurrent'] ? 'class="page-item active"' : ''; ?>>
                        <a class="page-link" href="<?php echo preg_replace( '~/page/1([^\d]|$)~', '$1', $page['url'] ); ?>"><?php echo $page['num']; ?></a>
                    </li>
				<?php else: ?>
                    <li class="page-item disabled"><span class="page-link"><?php echo $page['num']; ?></span></li>
				<?php endif; ?>
			<?php endforeach; ?>

			<?php if ( $paginator->getNextUrl() ): ?>

                <li class="page-item"><a class="page-link" href="<?php echo $paginator->getNextUrl(); ?>">Next &gt;</a></li>

				<?php if ( $paginator->getCurrentPage() < $paginator->getNumPages() - 2 ): ?>
                    <li class="page-item"><a class="page-link" href="<?php echo $paginator->getPageUrl( $paginator->getNumPages() ); ?>">Last &raquo;</a></li>
				<?php endif; ?>
			<?php endif; ?>
        </ul>
    </nav>
<?php endif;