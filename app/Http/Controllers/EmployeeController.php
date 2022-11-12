<?php

namespace App\Http\Controllers;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Alert;
use App\EmployeeInventories;
use App\Employee;
use App\Department;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //
    public function employees()
    {
        $employeeInventories = EmployeeInventories::with('inventoryData.category')->get();
        $employees = Employee::with('dep')->get();
        $departments = Department::get();
        //employee API
       
       
        return view('employees',
        
        array(
        'subheader' => '',
        'header' => "Employees",
        'employees' => $employees,
        'employeeInventories' => $employeeInventories,
        'departments' => $departments
        )
    );
    }
}
