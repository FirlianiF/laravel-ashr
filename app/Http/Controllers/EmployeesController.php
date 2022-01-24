<?php

namespace App\Http\Controllers;

use App\Companies;
use App\Employees;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class EmployeesController extends Controller
{
    public function get_employees()
    {
        $data = Employees::orderBy('id', 'desc');
        return DataTables::of($data)
            ->editColumn('company', function($data) {
                return Companies::object_field('name', $data->company);
            })
            ->addColumn('action', function ($data){
                $edit = '<a class="btn btn-warning" data-toggle="modal" data-target="#edit'.$data->id.'">edit</a>';
                $delete = '<a class="btn btn-danger" data-toggle="modal" data-target="#delete'.$data->id.'">delete</a>';
                return '<div class="btn btn-group">'.$edit.$delete.'</div>';
            })
            ->rawColumns(['company','action'])
            ->make(true);
    }

    public function get_employees_search(Request $request)
    {
        $query = Employees::select('*');
        $query->when($request->email != "", function ($q) use ($request) {
            return $q->where('email', $request->email);
        });
        $query->when($request->first_name, function ($q) use ($request) {
            return $q->where('first_name', 'LIKE', '%'.$request->first_name.'%');
        });
        $query->when($request->last_name, function ($q) use ($request) {
            return $q->where('last_name', 'LIKE', '%'.$request->last_name.'%');
        });
        $query->when($request->company, function ($q) use ($request) {
            return $q->where('company', $request->company);
        });

        $data = $query->orderBy('id', 'desc');
        return DataTables::of($data)
            ->editColumn('company', function($data) {
                return Companies::object_field('name', $data->company);
            })
            ->addColumn('action', function ($data){
                $edit = '<a class="btn btn-warning" data-toggle="modal" data-target="#edit'.$data->id.'">edit</a>';
                $delete = '<a class="btn btn-danger" data-toggle="modal" data-target="#delete'.$data->id.'">delete</a>';
                return '<div class="btn btn-group">'.$edit.$delete.'</div>';
            })
            ->rawColumns(['company','action'])
            ->make(true);
    }

    public function get_employees_detail($id)
    {
        return Employees::find($id);
    }

    public function index()
    {
        return view('admin.pages.employees.index');
    }

    public function create()
    {
        return view('admin.pages.employees.add');
    }

    public function destroy($id)
    {
        Employees::where('id', $id)->delete();
        return redirect()->back()->withAlert('Data deleted');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
        ]);

        if ($validator->fails())
        {
            $messages = '';
            foreach ($validator->getMessageBag()->toArray() as $key => $value)
            {
                $messages .= $value[0].' ';
            }
            return redirect()->back()->withDanger($messages);
        }

        $simpan = new Employees;
        $simpan->first_name = $request->first_name;
        $simpan->last_name = $request->last_name;
        $simpan->company = $request->company;
        $simpan->email = $request->email;
        $simpan->phone = $request->phone;
        $simpan->save();

        return redirect()->route('employees.index')->withAlert('Data saved');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
        ]);

        if ($validator->fails())
        {
            $messages = '';
            foreach ($validator->getMessageBag()->toArray() as $key => $value) {
                $messages .= $value[0] .' ';
            }
            return redirect()->back()->withDanger($messages);
        }

        Employees::where('id', $id)
            ->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'company' => $request->company,
                'email' => $request->email,
                'phone' => $request->phone
            ]);

        return redirect()->route('employees.index')->withAlert('Data updated');
    }
}
