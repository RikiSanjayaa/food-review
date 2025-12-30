<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function index()
  {
    // Top 5 recipes with most ratings for hero carousel (if needed)
    $topRatedRecipes = Recipe::where('rating_count', '>', 0)
      ->orderByDesc('rating_count')
      ->limit(5)
      ->get();

    // Popular recipes: highest average rating, limit 8 for horizontal scroll
    $popularRecipes = Recipe::orderByDesc('rating_avg')
      ->orderByDesc('rating_count')
      ->limit(8)
      ->get();

    $tags = Tag::withCount('recipes')->get();

    // Real-time stats
    $userCount = \App\Models\User::count();
    $recipeCount = Recipe::count();

    // Recent user avatars for social proof
    $recentUsers = \App\Models\User::latest()->limit(5)->get();

    // Rising Star: User with most recipes this month
    $risingStar = \App\Models\User::withCount([
      'recipes' => function ($query) {
        $query->whereMonth('created_at', now()->month);
      }
    ])
      ->orderByDesc('recipes_count')
      ->first();

    $diets = [
      'vegan' => 'Vegan',
      'vegetarian' => 'Vegetarian',
      'gluten-free' => 'Bebas Gluten',
      'halal' => 'Halal',
    ];

    return view('home', compact('topRatedRecipes', 'popularRecipes', 'tags', 'diets', 'userCount', 'recipeCount', 'recentUsers', 'risingStar'));
  }
}
