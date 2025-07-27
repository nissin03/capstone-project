<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Storage::makeDirectory('category/image');

        $sampleImage = file_get_contents('https://placehold.co/200x200.png');
        $imagePath = 'category/image/default.png';

        Storage::disk('public')->put($imagePath, $sampleImage);

        $parentCategories = [
            'Clothing',
            'Electronics',
            'Home & Living',
        ];

        foreach ($parentCategories as $parentName) {
            $parent = Category::create([
                'name' => $parentName,
                'slug' => Str::slug($parentName),
                'image' => $imagePath,
                'parent_id' => null,
            ]);

            for ($i = 1; $i <= 3; $i++) {
                $childName = $parentName . ' Sub ' . $i;

                Category::create([
                    'name' => $childName,
                    'slug' => Str::slug($childName),
                    'image' => $imagePath,
                    'parent_id' => $parent->id,
                ]);
            }
        }
    }
}
