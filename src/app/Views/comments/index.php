<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Комментарии</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #050505;
            color: #f5f5f5;
        }

        .page-shell {
            min-height: 100vh;
        }

        .page-title {
            color: #ffffff;
            font-weight: 700;
        }

        .comment-card {
            border: 1px solid #1f1f1f;
            border-radius: 1rem;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
            background: #111111;
            color: #f5f5f5;
        }

        .comment-text {
            white-space: pre-line;
            word-break: break-word;
            color: #d4d4d4;
        }

        .sort-panel,
        .form-card {
            border: 1px solid #1f1f1f;
            border-radius: 1rem;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
            background: #111111;
            color: #f5f5f5;
        }

        label,
        .form-text,
        .text-muted,
        small {
            color: #9f9f9f !important;
        }

        .form-control {
            background: #181818;
            border: 1px solid #2c2c2c;
            color: #ffffff;
        }

        .form-control:focus {
            background: #1d1d1d;
            border-color: #6c5ce7;
            color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(108, 92, 231, 0.25);
        }

        .form-control::placeholder {
            color: #7d7d7d;
        }

        .btn-primary {
            background: linear-gradient(135deg, #7c3aed, #4f46e5);
            border: none;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
        }

        .btn-outline-danger {
            border-color: #ef4444;
            color: #f87171;
        }

        .btn-outline-danger:hover {
            background: #ef4444;
            color: #ffffff;
        }

        .badge-light {
            background: #1f1f1f;
            color: #d4d4d4;
            border-color: #2f2f2f !important;
        }

        .pagination .page-link {
            background: #111111;
            border-color: #2a2a2a;
            color: #f5f5f5;
        }

        .pagination .page-item.active .page-link {
            background: #6d28d9;
            border-color: #6d28d9;
        }

        .pagination .page-item.disabled .page-link {
            background: #0c0c0c;
            border-color: #1d1d1d;
            color: #6f6f6f;
        }

        .alert-success {
            background: #052e16;
            border-color: #166534;
            color: #dcfce7;
        }

        .alert-danger {
            background: #450a0a;
            border-color: #991b1b;
            color: #fee2e2;
        }
    </style>
</head>
<body>
<div
    class="container py-5 page-shell"
    id="comments-app"
    data-list-url="<?= esc(site_url('comments/list')) ?>"
    data-create-url="<?= esc(site_url('comments')) ?>"
    data-delete-base-url="<?= esc(site_url('comments')) ?>"
    data-page="<?= esc((string) $page) ?>"
    data-sort-by="<?= esc($sortBy) ?>"
    data-sort-dir="<?= esc($sortDir) ?>"
>
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-9">
            <div class="mb-4">
                <h1 class="h2 mb-0 page-title">Список комментариев</h1>
            </div>

            <div class="card sort-panel mb-4">
                <div class="card-body">
                    <div class="form-row align-items-end">
                        <div class="col-sm-6 col-md-4 mb-3 mb-md-0">
                            <label for="comment-sort-by">Сортировать по</label>
                            <select class="form-control" id="comment-sort-by">
                                <option value="comment_date" <?= $sortBy === 'comment_date' ? 'selected' : '' ?>>дате добавления</option>
                                <option value="id" <?= $sortBy === 'id' ? 'selected' : '' ?>>id</option>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-4 mb-3 mb-md-0">
                            <label for="comment-sort-dir">Направление</label>
                            <select class="form-control" id="comment-sort-dir">
                                <option value="desc" <?= $sortDir === 'desc' ? 'selected' : '' ?>>по убыванию</option>
                                <option value="asc" <?= $sortDir === 'asc' ? 'selected' : '' ?>>по возрастанию</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div id="form-feedback" class="mb-3" style="display: none;"></div>
            <div id="comments-section"><?= view('comments/_section', compact('comments', 'page', 'pageNumbers', 'sortBy', 'sortDir', 'totalComments', 'totalPages')) ?></div>

            <div class="card form-card mt-4">
                <div class="card-body p-4">
                    <h2 class="h4 mb-3">Добавить комментарий</h2>
                    <form id="comment-form" novalidate>
                        <div class="form-group">
                            <label for="comment-name">Email</label>
                            <input type="email" class="form-control" id="comment-name" name="name" placeholder="name@example.com" maxlength="255" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="comment-text">Текст комментария</label>
                            <textarea class="form-control" id="comment-text" name="text" rows="4" maxlength="1000" placeholder="Напишите комментарий" required></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="comment-date">Дата комментария</label>
                            <input type="date" class="form-control" id="comment-date" name="comment_date" autocomplete="off" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="comment-time">Время комментария</label>
                            <input type="text" class="form-control" id="comment-time" name="comment_time" placeholder="ЧЧ:ММ" inputmode="numeric" maxlength="5" autocomplete="off" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between">
                            <button type="submit" class="btn btn-primary px-4" id="comment-submit">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(function () {
        var $app = $('#comments-app');
        var $feedback = $('#form-feedback');
        var $commentsSection = $('#comments-section');
        var $form = $('#comment-form');
        var $submit = $('#comment-submit');
        var $sortBy = $('#comment-sort-by');
        var $sortDir = $('#comment-sort-dir');
        var $commentDate = $('#comment-date');
        var $commentTime = $('#comment-time');
        var state = {
            page: Number($app.data('page')) || 1,
            sortBy: String($app.data('sortBy') || 'comment_date'),
            sortDir: String($app.data('sortDir') || 'desc')
        };
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var timePattern = /^(?:[01]\d|2[0-3]):[0-5]\d$/;

        function getMoscowDateParts(date) {
            var formatter = new Intl.DateTimeFormat('sv-SE', {
                timeZone: 'Europe/Moscow',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });
            var parts = formatter.formatToParts(date);
            var values = {};

            $.each(parts, function (_, part) {
                if (part.type !== 'literal') {
                    values[part.type] = part.value;
                }
            });

            return values;
        }

        function getCurrentMoscowDateTime() {
            var values = getMoscowDateParts(new Date());

            return values.year + '-' + values.month + '-' + values.day + 'T' + values.hour + ':' + values.minute;
        }

        function getCurrentMoscowDate() {
            return getCurrentMoscowDateTime().split('T')[0];
        }

        function getCurrentMoscowTime() {
            return getCurrentMoscowDateTime().split('T')[1];
        }

        function syncCommentDateField() {
            var currentMoscowDate = getCurrentMoscowDate();

            $commentDate.attr('min', currentMoscowDate);

            if (!$commentDate.val() || $commentDate.val() < currentMoscowDate) {
                $commentDate.val(currentMoscowDate);
            }
        }

        function syncCommentTimeField() {
            if (!$commentTime.val()) {
                $commentTime.val(getCurrentMoscowTime());
            }
        }

        function normalizeCommentTimeInput() {
            var digits = $commentTime.val().replace(/\D/g, '').slice(0, 4);

            if (digits.length >= 3) {
                $commentTime.val(digits.slice(0, 2) + ':' + digits.slice(2));
                return;
            }

            $commentTime.val(digits);
        }

        function showMessage(type, text) {
            $feedback
                .removeClass('alert-success alert-danger')
                .addClass('alert alert-' + type)
                .text(text)
                .show();
        }

        function clearMessage() {
            $feedback.hide().removeClass('alert alert-success alert-danger').text('');
        }

        function setFieldError(fieldName, message) {
            var $field = $('[name="' + fieldName + '"]');
            $field.addClass('is-invalid');
            $field.siblings('.invalid-feedback').text(message || 'Проверьте значение.');
        }

        function clearFieldErrors() {
            $form.find('.is-invalid').removeClass('is-invalid');
            $form.find('.invalid-feedback').text('');
        }

        function validateEmailField() {
            var value = $('#comment-name').val().trim();

            $('#comment-name').removeClass('is-invalid');
            $('#comment-name').siblings('.invalid-feedback').text('');

            if (value.length === 0) {
                return false;
            }

            if (!emailPattern.test(value)) {
                setFieldError('name', 'Введите корректный email.');
                return false;
            }

            return true;
        }

        function validateCommentDateField() {
            var dateValue = $commentDate.val();
            var timeValue = $commentTime.val();
            var currentDate = getCurrentMoscowDate();
            var currentDateTime = getCurrentMoscowDateTime();

            $commentDate.removeClass('is-invalid');
            $commentDate.siblings('.invalid-feedback').text('');
            $commentTime.removeClass('is-invalid');
            $commentTime.siblings('.invalid-feedback').text('');

            if (dateValue.length === 0) {
                setFieldError('comment_date', 'Укажите дату комментария.');
                return false;
            }

            if (dateValue < currentDate) {
                setFieldError('comment_date', 'Нельзя выбрать прошедшую дату.');
                return false;
            }

            if (timeValue.length === 0) {
                setFieldError('comment_time', 'Укажите время комментария.');
                return false;
            }

            if (!timePattern.test(timeValue)) {
                setFieldError('comment_time', 'Введите время в формате ЧЧ:ММ.');
                return false;
            }

            if (dateValue + 'T' + timeValue < currentDateTime) {
                setFieldError('comment_time', 'Нельзя выбрать прошедшую дату или время.');
                return false;
            }

            return true;
        }

        function loadComments(page) {
            clearMessage();

            $.get($app.data('listUrl'), {
                page: page,
                sort_by: state.sortBy,
                sort_dir: state.sortDir
            }).done(function (response) {
                $commentsSection.html(response.html);
                state.page = Number(response.page) || 1;
                state.sortBy = response.sortBy || state.sortBy;
                state.sortDir = response.sortDir || state.sortDir;
                $sortBy.val(state.sortBy);
                $sortDir.val(state.sortDir);
            }).fail(function () {
                showMessage('danger', 'Не удалось загрузить комментарии.');
            });
        }

        $sortBy.on('change', function () {
            state.sortBy = $(this).val();
            loadComments(1);
        });

        $sortDir.on('change', function () {
            state.sortDir = $(this).val();
            loadComments(1);
        });

        $('#comment-name').on('input blur', validateEmailField);
        $commentDate.on('focus click', syncCommentDateField);
        $commentDate.on('change blur', validateCommentDateField);
        $commentTime.on('input', normalizeCommentTimeInput);
        $commentTime.on('blur change', validateCommentDateField);
        syncCommentDateField();
        syncCommentTimeField();

        $commentsSection.on('click', '[data-page]', function (event) {
            event.preventDefault();
            loadComments(Number($(this).data('page')) || 1);
        });

        $commentsSection.on('click', '[data-delete-id]', function () {
            var commentId = $(this).data('deleteId');

            if (!window.confirm('Удалить комментарий?')) {
                return;
            }

            clearMessage();

            $.post($app.data('deleteBaseUrl') + '/' + commentId + '/delete')
                .done(function (response) {
                    showMessage('success', response.message || 'Комментарий удалён.');
                    loadComments(state.page);
                })
                .fail(function (xhr) {
                    var response = xhr.responseJSON || {};
                    showMessage('danger', response.message || 'Не удалось удалить комментарий.');
                });
        });

        $form.on('submit', function (event) {
            event.preventDefault();
            clearMessage();
            clearFieldErrors();

            if (!validateEmailField()) {
                return;
            }

            if (!validateCommentDateField()) {
                return;
            }

            $submit.prop('disabled', true);

            $.ajax({
                url: $app.data('createUrl'),
                method: 'POST',
                data: $form.serialize()
            }).done(function (response) {
                $form.trigger('reset');
                syncCommentDateField();
                syncCommentTimeField();
                showMessage('success', response.message || 'Комментарий добавлен.');
                loadComments(1);
            }).fail(function (xhr) {
                var response = xhr.responseJSON || {};
                var errors = response.errors || {};

                $.each(errors, function (fieldName, message) {
                    setFieldError(fieldName, message);
                });

                showMessage('danger', response.message || 'Не удалось сохранить комментарий.');
            }).always(function () {
                $submit.prop('disabled', false);
            });
        });
    });
</script>
</body>
</html>
