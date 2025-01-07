<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    //prikazi sve zaposlene
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

    //pretraga zaposlenog po ID
    public function show($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 400);
        }

        return response()->json($employee);
    }

    //novi zaposleni
    public function store(Request $request)
    {
        //validacija podataka
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'mail' => 'required|string|email|max:255|unique:employees',
            'position' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        //kreiranje zaposlenog
        $employee = Employee::create($request->all());

        return response()->json($employee, 200);
    }


    //azuriranje zaposlenog
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 400);
        }

        //validacija podataka
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'mail' => 'required|string|email|max:255|unique:employees,mail,' . $id,
            'position' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        //azuriranje zaposlenog
        $employee->update($request->all());

        return response()->json($employee);
    }


    //brisanje zaposlenog
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 400);
        }

        $employee->delete();
        return response()->json(['message' => 'Uspesno ste izbrisali zaposlenog']);
    }


    //pretraga zaposlenih
    public function search(Request $request)
    {
        $query = Employee::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('mail')) {
            $query->where('mail', 'like', '%' . $request->mail . '%');
        }

        if ($request->has('position')) {
            $query->where('position', 'like', '%' . $request->position . '%');
        }
        

        $employees = $query->get();

        return response()->json($employees);
    }
 
    //dodeljivanje projekta zapsolenom
    public function assignProject(Request $request, $employeeId)
    {
        //nalazimo zaposlenog
        $employee = Employee::find($employeeId);
        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 400);
        }

        //validacija da li projekat postoji
        $request->validate([
            'project_id' => 'required|exists:projects,id',
        ]);

        //povezivanje zaposlenog i projekta
        $employee->projects()->attach($request->project_id);

        return response()->json(['message' => 'Uspesna dodela projekta']);
    }


    public function projects($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 400);
        }

        $projects = $employee->projects;

        return response()->json($projects);
    }


}
