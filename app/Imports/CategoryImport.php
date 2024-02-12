<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class CategoryImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Category([
            'name' => $row['name'],
            'alt' => isset($row['alt']) ? $row['alt'] : null,
            'digest' => isset($row['digest']) ? $row['digest'] : null,
            'keywords' => isset($row['keywords']) ? $row['keywords'] : null,
            'tags' => isset($row['tags']) ? $row['tags'] : null,
            'show_in_first_page' => isset($row['show_in_first_page']) ? $row['show_in_first_page'] : false,
            'show_items_in_first_page' => isset($row['show_items_in_first_page']) ? $row['show_items_in_first_page'] : false,
            'priority' => $row['priority'],
            'parent_id' => isset($row['parent_name']) ? Category::where('name', '=', $row['parent_name'])->first()->id : null
        ]);
    }

    public function rules(): array
    {
        return [
            'priority' => 'required|integer',
            'show_in_first_page' => 'nullable|boolean',
            'show_items_in_first_page' => 'nullable|boolean',
            'parent_name' => 'nullable|exists:categories,name'
        ];
    }
}
