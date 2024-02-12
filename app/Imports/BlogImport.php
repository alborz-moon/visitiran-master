<?php

namespace App\Imports;

use App\Models\Blog;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class BlogImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Blog([
            'header' => $row['header'],
            'alt' => isset($row['alt']) ? $row['alt'] : null,
            'slug' => isset($row['slug']) ? $row['slug'] : null,
            'digest' => $row['digest'],
            'keywords' => isset($row['keywords']) ? $row['keywords'] : null,
            'description' => $row['description'],
            'tags' => isset($row['tags']) ? $row['tags'] : null,
            'article_tags' => isset($row['seo_tags']) ? $row['seo_tags'] : null,
            'visibility' => $row['visibility'],
            'priority' => $row['priority'],
        ]);
    }

    public function rules(): array
    {
        return [
            'header' => 'required|string|min:2',
            'slug' => 'nullable|string|min:2|unique:blogs',
            'description' => 'required|string|min:2',
            'digest' => 'required|string|min:2',
            'keywords' => 'nullable|string|min:2',
            'alt' => 'nullable|string|min:2',
            'tags' => 'nullable|string|min:2',
            'seo_tags' => 'nullable|string|min:2',
            'visibility' => 'required|boolean',
            'priority' => 'required|integer|min:1'
        ];
    }
}
