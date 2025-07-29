<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('category/image', $filename, 'public');
                return response()->json([
                    'path' => $filename,
                    'url' => Storage::url($path),
                    'success' => true
                ]);
            }

            return response()->json([
                'error' => 'No file uploaded.',
                'success' => false
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'File upload failed: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }

    public function revert(Request $request)
    {
        try {
            $filename = $request->getContent();
            $path = "category/image/" . $filename;
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
                return response('File deleted successfully', 200);
            }

            return response('File not found', 404);
        } catch (\Exception $e) {
            return response('Revert failed', 500);
        }
    }
}
