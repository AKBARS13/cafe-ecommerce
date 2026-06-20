<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Table;
use Illuminate\Http\Request;

class AdminTableController extends BaseController
{
    public function index()
    {
        $tables = Table::orderBy('table_number')->paginate(20);
        return view('admin.tables.index', compact('tables'));
    }

    public function create()
    {
        return view('admin.tables.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_number' => 'required|string|max:10|unique:tables,table_number',
            'capacity' => 'required|integer|min:1|max:20',
            'location' => 'required|in:indoor,outdoor',
            'status' => 'required|in:available,occupied,reserved,maintenance',
            'notes' => 'nullable|string',
        ]);

        Table::create($validated);

        return $this->successRedirect('admin.tables.index', 'Meja berhasil ditambahkan!');
    }

    public function edit(Table $table)
    {
        return view('admin.tables.edit', compact('table'));
    }

    public function update(Request $request, Table $table)
    {
        $validated = $request->validate([
            'table_number' => 'required|string|max:10|unique:tables,table_number,' . $table->id,
            'capacity' => 'required|integer|min:1|max:20',
            'location' => 'required|in:indoor,outdoor',
            'status' => 'required|in:available,occupied,reserved,maintenance',
            'notes' => 'nullable|string',
        ]);

        $table->update($validated);

        return $this->successRedirect('admin.tables.index', 'Meja berhasil diupdate!');
    }

    public function destroy(Table $table)
    {
        $table->delete();
        return $this->successRedirect('admin.tables.index', 'Meja berhasil dihapus!');
    }

    public function updateStatus(Request $request, Table $table)
    {
        $request->validate([
            'status' => 'required|in:available,occupied,reserved,maintenance',
        ]);

        $table->update(['status' => $request->status]);

        return back()->with('success', 'Status meja berhasil diupdate!');
    }
}