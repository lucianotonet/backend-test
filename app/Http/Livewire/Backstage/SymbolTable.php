<?php

namespace App\Http\Livewire\Backstage;

use App\Models\Symbol;

class SymbolTable extends TableComponent
{
    public $sortField = 'name';

    public function render()
    {
        $columns = [
            [
                'title' => 'name',
                'sort' => true,
            ],
            [
                'title' => 'image',
                'sort' => false,
                'type' => 'image',
            ],
            [
                'title' => '3x points',
                'attribute' => 'x3_points',
                'sort' => true,
            ],
            [
                'title' => '4x points',
                'attribute' => 'x4_points',
                'sort' => true,
            ],
            [
                'title' => '5x points',
                'attribute' => 'x5_points',
                'sort' => true,
            ],
            [
                'title' => 'tools',
                'sort' => false,
                'tools' => ['edit', 'delete'],
            ],
        ];

        return view('livewire.backstage.table', [
            'columns' => $columns,
            'resource' => 'symbols',
            'rows' => Symbol::orderBy($this->sortField, $this->sortAsc ? 'DESC' : 'ASC')
                ->paginate($this->perPage),
        ]);
    }
}
