<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeRequest;
use App\Models\Recipe;
use App\Repositories\RecipeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    /**
     * @param RecipeRepository $recipeRepository
     */
    public function __construct(public RecipeRepository $recipeRepository)
    {
        
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $recipes = $this->recipeRepository->index();
        
        if (!$recipes) {
            return response()->json([
                'message' => 'Recipes not found.',
            ], 200);
        }

        return response()->json([
            'message' => 'Recipes found successfully.',
            'recipe'  => $recipes->map(function ($recipe) {
                return [
                    'id' => $recipe->id,
                    'title' => $recipe->title,
                    'description' => $recipe->description,
                    'user' => [
                        'id' => $recipe->user->id,
                        'name' => $recipe->user->name,
                        'email' => $recipe->user->email,
                    ],
                    'comments' => $recipe->comments->map(function ($comment) {
                        return [
                            'id' => $comment->id,
                            'author' => $comment->author,
                            'comment' => $comment->comment,
                            'note' => $comment->note
                        ];
                    }),
                    'average_note' => number_format($recipe->average_note, 1, ',', '.'),
                ];
            })
        ], 200);
    }

    /**
     * @param  Recipe  $recipe
     * @return JsonResponse
     */
    public function show(Recipe $recipe): JsonResponse
    {
        $recipe = $this->recipeRepository->show($recipe);

        return response()->json([
            'message' => 'Recipe created successfully.',
            'recipe'    => [
                'id' => $recipe->id,
                'title' => $recipe->title,
                'description' => $recipe->description,
                'user' => [
                    'id' => $recipe->user->id,
                    'name' => $recipe->user->name,
                    'email' => $recipe->user->email,
                ]
            ],
        ], 200);
    }

    /**
     * @param  RecipeRequest  $request
     * @return JsonResponse
     */
    public function store(RecipeRequest $request): JsonResponse
    {
        $data = $request->only(
            'title', 
            'description'
        );

        $data['user_id'] = Auth::user()->id;

        $recipe = $this->recipeRepository->store($data);

        return response()->json([
            'message' => 'Recipe created successfully.',
            'recipe'    => [
                'id' => $recipe->id,
                'title' => $recipe->title,
                'description' => $recipe->description,
                'user' => [
                    'id' => $recipe->user->id,
                    'name' => $recipe->user->name,
                    'email' => $recipe->user->email,
                ]
            ],
        ], 201);
    }

    /**
     * @param  RecipeRequest  $request
     * @param  Recipe $recipe
     * @return JsonResponse
     */
    public function update(RecipeRequest $request, Recipe $recipe): JsonResponse
    {        
        $data = $request->only(
            'title', 
            'description'
        );

        $data['user_id'] = Auth::user()->id;

        $recipe = $this->recipeRepository->update($data, $recipe);

        return response()->json([
            'message' => 'Recipe updated successfully.',
            'recipe'    => [
                'id' => $recipe->id,
                'title' => $recipe->title,
                'description' => $recipe->description,
                'user' => [
                    'id' => $recipe->user->id,
                    'name' => $recipe->user->name,
                    'email' => $recipe->user->email,
                ]
            ],
        ], 200);
    }

    /**
     * @param  Recipe $recipe
     * @return JsonResponse
     */
    public function destroy(Recipe $recipe): JsonResponse
    {
        $recipe = $this->recipeRepository->destroy($recipe);

        return response()->json([
            'message' => 'Recipe deleted successfully.',
        ], 200);
    }
}
