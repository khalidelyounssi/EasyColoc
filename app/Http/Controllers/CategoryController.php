<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request, Colocation $colocation)
{
    $request->validate([
        'name' => 'required|string|max:50'
    ]);

    Category::create([
        'name' => $request->name,
        'colocation_id' => $colocation->id
    ]);

    return back()->with('success', 'Catégorie ajoutée avec succès !');
}
}