<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    //funkcija za prikaz liste
    public function index()
    {
        $employees = Employee:: all();
        return response()->json($employees);
    }

    //funkcija za prikaz jednog objekta
    public function show($id)
    {
        $employee = Employee:: find($id);
        if (is_null($employee)) { 
            return response()->json('Data not found', 404); 
 
        } 
        return response()->json($employee); 
    }

    //funkcija za kreiranje i cuvanje zaposlenog
    public function store(Request $request)
    {
        //Validacija
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max: 100',
            'last_name' => 'required|string|max: 100',
            'phone_number' => 'required|string|max: 11',
            'mail'=> 'required|string|max:255|email|unique:users',
            'position' => 'required|string|max: 100',
        ]);

        //nije uspesna validacija
        if($validator ->fails()){
            return response()->json($validator->errors());
        }

        //kreiranje novog zaposlenog
        $employee= Employee::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'mail'=> $request->mail,
            'position'=> $request->position,
        ]);

        
        return response()->json(['message'=> 'Employee created successfully','employee'=> $employee]);
    }

    //funkcija za update-ovanje i cuvanje zaposlenog
    public function update(Request $request, $id)
    {
        //Validacija
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max: 100',
            'last_name' => 'required|string|max: 100',
            'phone_number' => 'required|string|max: 11',
            'mail'=> 'required|string|max:255|email|unique:users',
            'position' => 'required|string|max: 100',
        ]);

        //nije uspesna validacija
        if($validator ->fails()){
            return response()->json($validator->errors());
        }

        //Trazimo zaposlenog sa datim ID-em
        $employee=Employee::find($id);

        //nije pronadjen zaposleni
        if(!$employee){
            return response() ->json(['error'=> 'Employee not found.']);
        }

        //kreiranje novog zaposlenog
        $employee= Employee::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'mail'=> $request->mail,
            'position'=> $request->position,
        ]);

        
        return response()->json(['message'=> 'Employee updated successfully','employee'=> $employee]);


    }

    public function destroy($id)
    {
        Employee::destroy($id);
        return response()->json(null);
    }
}
