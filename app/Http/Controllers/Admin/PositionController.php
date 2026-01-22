<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $items = Position::query()
            ->when($q, function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.positions.index', compact('items', 'q'));
    }

    public function create()
    {
        return view('admin.positions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255','unique:positions,name'],
            'base_salary' => ['required','numeric','min:0'],
        ]);

        Position::create($data);

        return redirect()->route('admin.positions.index')->with('ok', 'Position created');
    }

    public function edit(Position $position)
    {
        return view('admin.positions.edit', compact('position'));
    }

    public function update(Request $request, Position $position)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255','unique:positions,name,' . $position->id],
            'base_salary' => ['required','numeric','min:0'],
        ]);

        $position->update($data);

        return redirect()->route('admin.positions.index')->with('ok', 'Position updated');
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return back()->with('ok', 'Position deleted');
    }
}
