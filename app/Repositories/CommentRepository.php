<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
    public function __construct(public Comment $comment) {}

    /**
     * @param  array  $data
     * @return Comment
     */
    public function store(array $data): Comment
    {
        return $this->comment->create($data);
    }
}