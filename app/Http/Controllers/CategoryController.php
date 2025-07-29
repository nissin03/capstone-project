<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->filter($request->only('search'))
            ->latest()
            ->paginate(5)
            ->withQueryString();
        return Inertia::render('Admin/Category/CategoryListView', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('id', 'name', 'parent_id')->get();

        return Inertia::render('Admin/Category/CategoryCreateView', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();
        Category::create($validated);
        return redirect()
            ->route('admin.categories.index')
            ->with('message', 'Category created successfully!');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::select('id', 'name', 'parent_id')->get();
        return Inertia::render('Admin/Category/CategoryEditView', [
            'category' => $category,
            'categories' => $categories,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return redirect()
            ->route('admin.categories.index')
            ->with('message', 'Category updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->parent_id && !$category->parent()->withTrashed()->first()->trashed()) {
            return back()->with('error', 'Cannot archive subcategory while parent is still active.');
        }
        $category->children()->delete();
        $category->delete();
        return back()->with('message', 'Category archived successfully!');
    }

    /**
     * Display a list of archives.
     */
    public function archive(Request $request)
    {
        $categories  = Category::onlyTrashed()->with('children')
            ->filter($request->only('search'))
            ->with('children')
            ->whereNull('parent_id')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Category/CategoryArchiveView', [
            'categories' => $categories,
        ]);
    }

    public function restore(Request $request)
    {
        $category = Category::onlyTrashed()->findOrFail($request->id);
        if ($category->parent_id) {
            $parent = Category::withTrashed()->find($category->parent_id);

            if ($parent && $parent->trashed()) {
                return back()->with('error', 'Cannot restore subcategory while its parent is still archived.');
            }
        }
        $category->restore();
        return redirect()->back()->with('message', 'Category restored successfully.');
    }
}
