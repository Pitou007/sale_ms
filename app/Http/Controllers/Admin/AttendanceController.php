<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $items = Attendance::with('employee')
            ->when($q, function ($query) use ($q) {
                $query->whereHas('employee', function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $employees = Employee::orderBy('name')->get();

        return view('admin.attendances.index', compact('items', 'employees', 'q'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => ['required','exists:employees,id'],
            'date' => ['required','date'],
            'check_in' => ['nullable'],
            'check_out' => ['nullable'],
            'status' => ['required','in:Present,Late,Permission,Absent'],
        ]);

        Attendance::create($data);

        return back()->with('ok', 'Attendance recorded');
    }

    public function update(Request $request, Attendance $attendance)
    {
        $data = $request->validate([
            'employee_id' => ['required','exists:employees,id'],
            'date' => ['required','date'],
            'check_in' => ['nullable'],
            'check_out' => ['nullable'],
            'status' => ['required','in:Present,Late,Permission,Absent'],
        ]);

        $attendance->update($data);

        return back()->with('ok', 'Attendance updated');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return back()->with('ok', 'Attendance deleted');
    }
}
