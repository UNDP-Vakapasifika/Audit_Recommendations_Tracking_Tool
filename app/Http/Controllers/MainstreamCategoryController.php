<?php

namespace App\Http\Controllers;
use App\Models\MainstreamCategory;

use Illuminate\Http\Request;

class MainstreamCategoryController extends Controller
{
    //
    public function index(){
        $mainstream_categories = MainstreamCategory::all();
        return view('main_stream_category.index', compact('mainstream_categories'));
    }

    public function create(){
        return view('main_stream_category.create');
    }

    // Store a newly created client type
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $mainstream_category = new MainstreamCategory;
        $mainstream_category->name = $request->name;
        $mainstream_category->save();

        return redirect()->route('mainstream_category.index')->with('success', 'Mainstream Category created successfully.');
    }

    public function edit($id)
    {
        $category = MainstreamCategory::findOrFail($id);
    
        return view('main_stream_category.edit', [
            'category' => $category,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $category = MainstreamCategory::findOrFail($id);
        $category->name = $request->name;
        $category->save();
    
        return redirect()->route('mainstream_category.index')->with('success', 'Mainstream Category updated successfully.');
    }
    
    public function destroy($id)
    {
        $category = MainstreamCategory::findOrFail($id);
        $category->delete();
    
        return redirect()->route('mainstream_category.index')->with('success', 'Mainstream Category deleted successfully.');
    }
    
}
