<?php

namespace App\Repositories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Collection;

class RecipeRepository
{
    public function __construct(public Recipe $recipe) {}
    
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->recipe::with(['comments'])->get()
            ->map(function ($recipe) {
                return $recipe;
            });
    }

    /**
     * @param  Recipe  $recipe
     * @return Recipe
     */
    public function show($recipe): Recipe
    {
        return $this->recipe->find($recipe->id);
    }

    /**
     * @param  array  $data
     * @return Recipe
     */
    public function store(array $data): Recipe
    {
        return $this->recipe->create($data);
    }
    
    /**
     * @param array $data
     * @param Recipe $recipe
     * @return Recipe
     */
    public function update(array $data, $recipe): Recipe
    {
        $recipe->update($data);

        return $recipe;
    }

    /**
     * @param Recipe $recipe
     * @return Recipe
     */
    public function destroy(Recipe $recipe): Recipe
    {
        $recipe->delete();

        return $recipe;
    }
}