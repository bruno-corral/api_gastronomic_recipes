<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Recipe;
use App\Repositories\CommentRepository;

class CommentController extends Controller
{
    /**
     * @param CommentRepository $commentRepository
     */
    public function __construct(public CommentRepository $commentRepository)
    {
        
    }

    public function store(CommentRequest $request, Recipe $recipe)
    {
        $data = $request->only([
            'author',
            'comment',
            'note'
        ]);

        $data['recipe_id'] = $recipe->id;

        $comment = $this->commentRepository->store($data);

        return response()->json([
            'message' => 'Comment created successfully.',
            'comment' => [
                'id' => $comment->id,
                'author' => $comment->author,
                'comment' => $comment->comment,
                'note' => $comment->note,
                'recipe' => [
                    'id' => $comment->recipe->id,
                    'title' => $comment->recipe->title
                ]
            ],
        ], 201);
    }
}
