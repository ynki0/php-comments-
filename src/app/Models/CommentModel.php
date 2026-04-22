<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table            = 'comments';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['name', 'text', 'comment_date'];

    public function getCommentsCount(): int
    {
        return (int) $this->builder()->countAllResults();
    }

    public function getPaginatedComments(string $sortBy, string $sortDir, int $limit, int $offset): array
    {
        return $this->builder()
            ->select(['id', 'name', 'text', 'comment_date'])
            ->orderBy($sortBy, $sortDir)
            ->limit($limit, $offset)
            ->get()
            ->getResultArray();
    }
}
