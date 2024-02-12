<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Seller;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class ProductImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'name' => $row['name'],
            'slug' => isset($row['slug']) ? $row['slug'] : null,
            'guarantee' => isset($row['guarantee']) ? $row['guarantee'] : null,
            'alt' => isset($row['alt']) ? $row['alt'] : null,
            'digest' => isset($row['digest']) ? $row['digest'] : null,
            'keywords' => isset($row['keywords']) ? $row['keywords'] : null,
            'description' => isset($row['description']) ? $row['description'] : null,
            'introduce' => isset($row['introduce']) ? $row['introduce'] : null,
            'tags' => isset($row['tags']) ? $row['tags'] : null,
            'is_in_top_list' => $row['is_in_top_list'],
            'visibility' => $row['visibility'],
            'priority' => $row['priority'],
            'price' => $row['price'],
            'category_id' => Category::where('name', '=', $row['category'])->first()->id,
            'brand_id' => Brand::where('name', '=', $row['brand'])->first()->id,
            'seller_id' => isset($row['seller']) ? Seller::where('name', '=', $row['seller'])->first()->id : null
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2',
            'slug' => 'nullable|string|min:2|unique:products',
            'category' => 'required|exists:categories,name',
            'brand' => 'required|exists:brands,name',
            'seller' => 'nullable|exists:sellers,name',
            'description' => 'nullable|string|min:2',
            'introduce' => 'nullable|string|min:2',
            'digest' => 'nullable|string|min:2',
            'keywords' => 'nullable|string|min:2',
            'tags' => 'nullable|string|min:2',
            'guarantee' => 'nullable|integer|min:0',
            'price' => 'required|integer|min:0',
            'priority' => 'required|integer|min:0',
            'is_in_top_list' => 'required|boolean',
            'visibility' => 'required|boolean',
            'alt' => 'nullable|string|min:2',
        ];
    }
}
