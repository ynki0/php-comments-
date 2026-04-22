<?php if ($totalComments > 0): ?>
    <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between mb-3">
        <h2 class="h4 mb-2 mb-sm-0">Комментарии</h2>
        <span class="text-muted">Всего: <?= esc((string) $totalComments) ?></span>
    </div>

    <?php foreach ($comments as $comment): ?>
        <div class="card comment-card mb-3">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start mb-3">
                    <div class="mb-3 mb-md-0">
                        <div class="font-weight-bold text-break"><?= esc($comment['name']) ?></div>
                        <small class="text-muted">ID: <?= esc((string) $comment['id']) ?></small>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge badge-light border mr-2 px-3 py-2"><?= esc(date('d.m.Y H:i', strtotime($comment['comment_date']))) ?></span>
                        <button type="button" class="btn btn-outline-danger btn-sm" data-delete-id="<?= esc((string) $comment['id']) ?>">Удалить</button>
                    </div>
                </div>
                <p class="comment-text mb-0"><?= nl2br(esc($comment['text'])) ?></p>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if ($totalPages > 1): ?>
        <nav aria-label="Навигация по комментариям">
            <ul class="pagination justify-content-center flex-wrap mb-0">
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="#" data-page="<?= esc((string) max(1, $page - 1)) ?>">&laquo;</a>
                </li>
                <?php foreach ($pageNumbers as $pageNumber): ?>
                    <li class="page-item <?= $page === $pageNumber ? 'active' : '' ?>">
                        <a class="page-link" href="#" data-page="<?= esc((string) $pageNumber) ?>"><?= esc((string) $pageNumber) ?></a>
                    </li>
                <?php endforeach; ?>
                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="#" data-page="<?= esc((string) min($totalPages, $page + 1)) ?>">&raquo;</a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
<?php else: ?>
    <div class="card comment-card">
        <div class="card-body text-center py-5">
            <h2 class="h4 mb-2">Комментариев пока нет</h2>
            <p class="text-muted mb-0">Станьте первым, кто оставит запись.</p>
        </div>
    </div>
<?php endif; ?>
