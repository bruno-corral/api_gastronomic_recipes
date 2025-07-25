<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Recipe;
use App\Repositories\CommentRepository;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * @param CommentRepository $commentRepository
     */
    public function __construct(public CommentRepository $commentRepository) {}

    /**
     * @param  CommentRequest  $request
     * @param  Recipe  $recipe
     * @return JsonResponse
     */
    public function store(CommentRequest $request, Recipe $recipe): JsonResponse
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
