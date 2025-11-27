<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>

<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
    <ul class="pagination">
        <?php if ($pager->hasPrevious()) : ?>
            <li class="page-item">
                <a class="page-link bg-dark text-light border-dark" href="<?= $pager->getFirst() ?>" aria-label="第一页">
                    <span aria-hidden="true"><i class="bi bi-skip-backward"></i></span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link bg-dark text-light border-dark" href="<?= $pager->getPrevious() ?>" aria-label="上一页">
                    <span aria-hidden="true"><i class="bi bi-skip-start"></i></span>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link <?= $link['active'] ? 'bg-dark text-white' : 'bg-light text-dark border-dark' ?>" href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li class="page-item">
                <a class="page-link bg-dark text-light border-dark" href="<?= $pager->getNext() ?>" aria-label="下一页">
                    <span aria-hidden="true"><i class="bi bi-skip-end"></i></span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link bg-dark text-light border-dark" href="<?= $pager->getLast() ?>" aria-label="最后一页">
                    <span aria-hidden="true"><i class="bi bi-skip-forward"></i></span>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>