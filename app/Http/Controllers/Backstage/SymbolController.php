<?php

namespace App\Http\Controllers\Backstage;

use App\Http\Controllers\Controller;
use App\Models\Symbol;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;

class SymbolController extends Controller
{
    use WithFileUploads;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backstage.symbols.index', [
            'symbols' => Symbol::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if has more than ten symbols, then redirect to index
        if (Symbol::count() >= 10) {
            session()->flash('warning', 'You can only have 10 symbols.');
            return redirect()->route('backstage.symbols.index');
        }

        return view('backstage.symbols.create', [
            'symbol' => new Symbol(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $this->validate($request, [
            'name' => 'required|max:255',
            'image' => 'required|image|max:2048', // 2MB Max
            'x3_points' => 'required|numeric',
            'x4_points' => 'required|numeric',
            'x5_points' => 'required|numeric',
        ]);

        $imagePath = $request->file('image')->store('public/symbols');

        $data['image'] = basename($imagePath);

        // Create the symbol
        $symbol = Symbol::create($data);

        // Redirect with success message
        session()->flash('success', 'The symbol has been added!');

        return redirect('/backstage/symbols');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Symbol  $symbol
     * @return \Illuminate\Http\Response
     */
    public function show(Symbol $symbol)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Symbol  $symbol
     * @return \Illuminate\Http\Response
     */
    public function edit(Symbol $symbol)
    {
        return view('backstage.symbols.edit', [
            'symbol' => $symbol,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Symbol  $symbol
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Symbol $symbol)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Symbol  $symbol
     * @return \Illuminate\Http\Response
     */
    public function destroy(Symbol $symbol)
    {
        // remove the image
        $imagePath = public_path('storage/symbols/' . $symbol->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // delete the symbol
        $symbol->delete();

        // redirect with success message
        session()->flash('success', 'The symbol has been deleted!');

        return redirect()->route('backstage.symbols.index');
    }
}
