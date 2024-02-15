<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of items with optional search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Item::query();

        // Dynamic search
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%");
        }

        return response()->json($query->get(), 200);
    }

    /**
     * Store a newly created item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request data
        $validated = $request->validate([
            'name' => 'required|string|unique:items|max:255',
            'description' => 'required|string',
            'price' => 'required|decimal:2',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id'
        ]);

        $item = Item::create($validated);

        return response()->json($item, 201);
    }

    /**
     * Display the specified item.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        return response()->json($item, 200);
    }

    /**
     * Update the specified item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        // Validate request data
        $validated = $request->validate([
            'name' => 'string|unique:items|max:255',
            'description' => 'string',
            'price' => 'decimal:2',
            'quantity' => 'integer',
            'category_id' => 'exists:categories,id'
        ]);

        $item->update($validated);

        return response()->json($item, 200);
    }

    /**
     * Remove the specified item from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Item deleted'], 200);
    }

    /**
     * Retrieve a list of items with their associated category details.
     * This method uses MongoDB's aggregation framework to perform a `$lookup`,
     * which joins the items collection with the categories collection.
     *
     * @return \Illuminate\Http\Response
     */
    public function getItemsWithCategories()
    {
        $itemsWithCategories = Item::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$lookup' => [
                        'from' => 'categories',
                        'localField' => 'category_id',
                        'foreignField' => 'id',
                        'as' => 'category'
                    ]
                ]
            ]);
        });

        return response()->json($itemsWithCategories, 200);
    }
}
