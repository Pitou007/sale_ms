<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $items = Employee::query()
            ->when($q, function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('phone', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%");
            })
            ->with('position')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.employees.index', compact('items', 'q'));
    }

    public function create()
    {
        $positions = Position::orderBy('name')->get();
        return view('admin.employees.create', compact('positions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'position_id' => ['required','exists:positions,id'],
            'phone' => ['nullable','string','max:50'],
            'email' => ['nullable','email','max:255'],
            'start_date' => ['nullable','date'],
        ]);

        Employee::create($data);

        return redirect()->route('admin.employees.index')->with('ok', 'Employee created');
    }

    public function edit(Employee $employee)
    {
        $positions = Position::orderBy('name')->get();
        return view('admin.employees.edit', compact('employee','positions'));
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'position_id' => ['required','exists:positions,id'],
            'phone' => ['nullable','string','max:50'],
            'email' => ['nullable','email','max:255'],
            'start_date' => ['nullable','date'],
        ]);

        $employee->update($data);

        return redirect()->route('admin.employees.index')->with('ok', 'Employee updated');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return back()->with('ok', 'Employee deleted');
    }
}
