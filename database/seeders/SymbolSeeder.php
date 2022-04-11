<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Symbol;

class SymbolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Symbol::truncate();

        // Create ten fruit symbols
        Symbol::create([
            'name' => 'Apple',
            'image' => 'apple.png',
            'x3_points' => 1.50,
            'x4_points' => 3.00,
            'x5_points' => 6.00,
        ]);
        Symbol::create([
            'name' => 'Banana',
            'image' => 'banana.png',
            'x3_points' => 1.50,
            'x4_points' => 3.00,
            'x5_points' => 6.00,
        ]);
        Symbol::create([
            'name' => 'Cherry',
            'image' => 'cherry.png',
            'x3_points' => 1.50,
            'x4_points' => 3.00,
            'x5_points' => 6.00,
        ]);
        Symbol::create([
            'name' => 'Grapes','image' => 'grapes.png'            
        ]);
        Symbol::create([
            'name' => 'Lemon','image' => 'lemon.png'            
        ]);
        Symbol::create([
            'name' => 'Orange','image' => 'orange.png'            
        ]);
        Symbol::create([
            'name' => 'Peach','image' => 'peach.png'            
        ]);
        Symbol::create([
            'name' => 'Pear','image' => 'pear.png'            
        ]);
        Symbol::create([
            'name' => 'Strawberry','image' => 'strawberry.png'            
        ]);
        Symbol::create([
            'name' => 'Watermelon','image' => 'watermelon.png'            
        ]);

        // Copy fruit images from resources/images/symbols to storage/app/public/symbols
        $symbols = Symbol::all();
        foreach ($symbols as $symbol) {
            copy(
                resource_path('images/symbols/' . $symbol->image),
                storage_path('app/public/symbols/' . $symbol->image)
            );
        }
    }
}
