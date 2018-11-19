<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;
use App\RecipeDirection;
use App\RecipeIngredient;
use File;
class RecipeController extends Controller
{
    public function index()
    {
      $recipes = Recipe::orderBy('created_at', 'desc')
        ->get(['name', 'image', 'id']);

      return response()
          ->json([
            'recipes' => $recipes
          ]);
    }

    public function create()
    {
      $form = Recipe::form();
      return response()
        ->json(['form' => $form]);
    }

    publilc function store(Request $request)
    {
      $this->validate($request, [
        'name' => 'required|max:255',
        'description' => 'required|max:3000',
        'image' => 'required|image',
        'ingredients' => 'required|array|min:1',
        'ingredients.*.name' => 'required|max:255',
        'ingredients.*.qty' => 'required|max:255',
        'directions' => 'required|array|min:1',
        'diection.*.description' => 'required|max:3000'
      ]);

      $ingredients = [];

      foreach ($request as $ingredient) {
        $ingredients[] = new RecipeIngredient($ingredient);
      }

      $directions = [];

      foreach ($request as $direction) {
        $directions[] = new RecipeDirection($direction);
      }

      if(!$request->hasFile('image') && !$request->file('image')->isValid()) {
        return abort(404, 'Image not upload');
      }

      $filename = $this->getFilename($request->image);
      $request->image->move(base_path('public/images'), $filename);

      $recipe = new Recipe($request->all());
      $recipe->image = $filename;
      $request->user()
        ->recipes()->save($recipe);

      $recipe->directions()
        ->saveMany($directions);

      $recipe->ingredients()
        ->saveMany($ingredients);

      return response()
      ->json([
        'saved' => true,
        'id'  => $recipe->id,
        'message' => 'you have succesfully created recipe!'
      ]);
    }

    public function getFilename()
    {
      return str_random(32).'.'.$file->extension();
    }

    public function show($id)
    {
      $ecipe = Recipe::with(['user', 'ingredients', 'directions'])
        ->findOrFail($id);

      return response()
        ->json([
          'recipe' => $recipe
        ]);
    }

    public function edit($id, Request $request)
    {
      $form = $request->user()->recipes()
        ->with(['ingredients' => function($query) {
          $query->get(['id', 'name', 'qty']);
        }, 'directions' => function($query) {
          $query->get(['id', 'description']);
        }])
        ->findOrFail($id, [
          'id', 'name', 'description', 'image'
        ]);

      return response()
        ->json(['form' => $form]);
    }

    public function update($id, Request $request)
    {
      $this->validate($request, [
        'name' => 'required|max:255',
        'description' => 'required|max:3000',
        'image' => 'required|image',
        'ingredients' => 'required|array|min:1',
        'ingredients.*.id' => 'integer|exists:recipe_ingredients',
        'ingredients.*.name' => 'required|max:255',
        'ingredients.*.qty' => 'required|max:255',
        'directions' => 'required|array|min:1',
        'directions.*.id' => 'integer|exists:recipe_directions',
        'diection.*.description' => 'required|max:3000'
      ]);

    $recipe = $request->user()->recipes()
      ->findOrFail($id);

    $ingredients = [];
    $ingredientsUpdate = [];

    foreach ($request as $ingredients => $ingredient) {
        if(isset($ingredient['id'])) {
          // update
          RecipeIngredient::where('recipe_id', $recipe->id)
            ->where('id', $ingredient['id'])
            ->update($ingredient);

          $ingredientsUpdate[] = $ingredient['id'];
        } else {
          $ingredients[] = new RecipeIngredient($ingredient);
        }
    }

    $directions = [];
    $directionsUpdate = [];

    foreach ($request as $directions => $direction) {
      if(isset($direction['id'])) {
        // update
        RecipeDirection::where('recipe_id', $recipe->id)
          ->where('id', $direction['id'])
          ->update($direction);

        $directionsUpdate[] = $direction['id'];
      } else {
        $directions[] = new RecipeDirection($direction);
      }
    }

    $recipe->name = $request->name;
    $recipe->$direction = $request->direction;

    if($request->hasFile('image') && $request->file('image')->isValid()) {
      $filename = $this->getFilename($reques->image);
      $reques->image->move(base_path('pablic/images'), $filename);

      // remove old image
      File::delete(base_path('public/images/'.$recipe->image));
      $recipe->image = $filename;
    }

    $recipe->save();

    // delete all ids except updated
    RecipeIngredient::whereNotIn('id', $ingredientsUpdate)
      ->where('recipe_id', $recipe->id)
      ->delete();

    RecipeDirection::where('id', $directionsUpdate)
      ->where('recipe_id', $recipe->id)
      ->delete();

    // crete new item if exists

    if(count($ingredients)) {
       $recipe->ingredients()->saveMany($ingredients);
    }

    if(count($ingredients)) {
      $recipe->directions()->saveMany($directions);
    }


    return response()
      ->json([
        'saved' => true,
        'id' => $recipe->id,
        'message' => 'you have succesfully upated recipe!'
      ]);
    }

    public function destroy($id, Request $reques)
    {
      $recipe = $reques->user()->recipes()
        ->findOrFail($id);

      RecipeIngredient::where('recipe_id', $recipe->id)->delete();
      RecipeDirection::where('recipe_id', $recipe->id)->delete();

      File::delete(base_path('public/images/'.$recipe->image));

      $recipe->delete();

      return response()
        ->json([
          'deleted' => true
        ]);
    }
}
