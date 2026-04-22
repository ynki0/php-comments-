<?php

namespace App\Controllers;

use App\Models\CommentModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\HTTP\ResponseInterface;

class Home extends BaseController
{
    private const COMMENTS_PER_PAGE = 3;

    public function index(): string
    {
        return view('comments/index', $this->getCommentsViewData());
    }

    public function list(): ResponseInterface
    {
        $data = $this->getCommentsViewData();

        return $this->response->setJSON([
            'html'          => view('comments/_section', $data),
            'page'          => $data['page'],
            'totalPages'    => $data['totalPages'],
            'sortBy'        => $data['sortBy'],
            'sortDir'       => $data['sortDir'],
            'totalComments' => $data['totalComments'],
        ]);
    }

    public function create(): ResponseInterface
    {
        $rules = [
            'name'         => 'required|valid_email|max_length[255]',
            'text'         => 'required|min_length[3]|max_length[1000]',
            'comment_date' => 'required|regex_match[/^\d{4}-\d{2}-\d{2}$/]',
            'comment_time' => 'required|regex_match[/^(?:[01]\d|2[0-3]):[0-5]\d$/]',
        ];

        $messages = [
            'name' => [
                'required'    => 'Укажите email.',
                'valid_email' => 'Введите корректный email.',
                'max_length'  => 'Email не должен быть длиннее 255 символов.',
            ],
            'text' => [
                'required'   => 'Введите текст комментария.',
                'min_length' => 'Комментарий должен содержать минимум 3 символа.',
                'max_length' => 'Комментарий не должен быть длиннее 1000 символов.',
            ],
            'comment_date' => [
                'required'    => 'Укажите дату комментария.',
                'regex_match' => 'Выберите дату в корректном формате.',
            ],
            'comment_time' => [
                'required'    => 'Укажите время комментария.',
                'regex_match' => 'Введите время в формате ЧЧ:ММ.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'message' => 'Проверьте данные формы.',
                    'errors'  => $this->validator->getErrors(),
                ]);
        }

        $commentDateInput = (string) $this->request->getPost('comment_date');
        $commentTimeInput = (string) $this->request->getPost('comment_time');
        $commentDate      = Time::createFromFormat('Y-m-d H:i', $commentDateInput . ' ' . $commentTimeInput, 'Europe/Moscow');

        if ($commentDate === false) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'message' => 'Проверьте данные формы.',
                    'errors'  => [
                        'comment_time' => 'Введите дату и время в корректном формате.',
                    ],
                ]);
        }

        if ($commentDate->getTimestamp() < Time::now('Europe/Moscow')->getTimestamp()) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'message' => 'Проверьте данные формы.',
                    'errors'  => [
                        'comment_time' => 'Нельзя выбрать прошедшую дату или время.',
                    ],
                ]);
        }

        $commentModel = new CommentModel();
        $commentModel->insert([
            'name'         => (string) $this->request->getPost('name'),
            'text'         => (string) $this->request->getPost('text'),
            'comment_date' => $commentDate->toDateTimeString(),
        ]);

        return $this->response->setJSON([
            'message' => 'Комментарий добавлен.',
        ]);
    }

    public function delete(int $id): ResponseInterface
    {
        $commentModel = new CommentModel();
        $comment      = $commentModel->find($id);

        if ($comment === null) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'message' => 'Комментарий не найден.',
                ]);
        }

        $commentModel->delete($id);

        return $this->response->setJSON([
            'message' => 'Комментарий удалён.',
        ]);
    }

    private function getCommentsViewData(): array
    {
        $commentModel = new CommentModel();
        $sortBy       = $this->normalizeSortBy((string) $this->request->getGet('sort_by'));
        $sortDir      = $this->normalizeSortDir((string) $this->request->getGet('sort_dir'));
        $page         = max(1, (int) ($this->request->getGet('page') ?? 1));
        $totalComments = $commentModel->getCommentsCount();
        $totalPages    = max(1, (int) ceil($totalComments / self::COMMENTS_PER_PAGE));
        $page          = min($page, $totalPages);

        return [
            'comments'      => $commentModel->getPaginatedComments(
                $sortBy,
                $sortDir,
                self::COMMENTS_PER_PAGE,
                ($page - 1) * self::COMMENTS_PER_PAGE
            ),
            'page'          => $page,
            'pageNumbers'   => range(1, $totalPages),
            'sortBy'        => $sortBy,
            'sortDir'       => $sortDir,
            'totalComments' => $totalComments,
            'totalPages'    => $totalPages,
        ];
    }

    private function normalizeSortBy(string $sortBy): string
    {
        return in_array($sortBy, ['id', 'comment_date'], true) ? $sortBy : 'comment_date';
    }

    private function normalizeSortDir(string $sortDir): string
    {
        return in_array(strtolower($sortDir), ['asc', 'desc'], true) ? strtolower($sortDir) : 'desc';
    }
}
