@extends('admin.layout')
@section('title')
    Employees
@endsection
@section('employees')
    active
@endsection
@section('header')
    <link href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0">Search</h5>
                        </div>
                        <div class="card-body">
                            <form id="form-search">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" id="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" name="first_name" id="first_name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" name="last_name" id="last_name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Company</label>
                                            <select name="company" id="company" class="form-control">
                                                <option value=""></option>
                                                @foreach(\App\Companies::get_field(['id','name']) as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group float-right">
                                            <button class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0">Employees</h5>
                            <a href="{{route('employees.create')}}" class="btn btn-primary float-right">Add New Employee</a>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table" id="datatable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First name</th>
                                    <th>Last name</th>
                                    <th>Company</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            @foreach(App\Employees::orderBy('id','desc')->get() as $item)
                {{-- EDIT --}}
                <div class="modal fade" id="edit{{$item->id}}" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Employee</h4>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('admin/employees/'.$item->id)}}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div class="form-group">
                                        <label>First Name <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$item->first_name}}" class="form-control" name="first_name">
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$item->last_name}}" class="form-control" name="last_name">
                                    </div>
                                    <div class="form-group">
                                        <label>Company</label>
                                        <select class="form-control" name="company">
                                            @foreach(App\Companies::all() as $item_company)
                                                <option value="{{$item_company->id}}" {{$item_company->id == $item->company ? "selected" : ""}}>{{$item_company->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" value="{{$item->email}}" class="form-control" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" value="{{$item->phone}}" class="form-control" name="phone">
                                    </div>

                                    <a type="button" class="btn btn-warning float-right ml-2" data-dismiss="modal">CANCEL</a>
                                    <button class="btn btn-success float-right">UPDATE</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DELETE --}}
                <div class="modal fade" id="delete{{$item->id}}" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Delete Employee</h4>
                            </div>
                            <div class="modal-body">Are you sure want to delete data?</div>
                            <div class="modal-footer">
                                <form method="POST" action="{{url('admin/employees/'.$item->id)}}">
                                    @csrf
                                    @method('DELETE')
                                    <button  class="btn btn-danger">YES</button>
                                </form>
                                <button type="button" class="btn btn-warning" data-dismiss="modal">NO, CANCEL</button>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div><!-- /.container-fluid -->
    </div>
@endsection
@section('footer')
    <script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(function() {
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('get.employees')}}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'first_name', name: 'first_name' },
                    { data: 'last_name', name: 'last_name' },
                    { data: 'company', name: 'company' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });

        $("#form-search").on('submit', function (e) {
            $('#datatable').DataTable().destroy();
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    'url': '{{url('admin/get/employees/search')}}' + '?email=' + $('#email').val() + '&first_name=' + $('#first_name').val() + '&last_name=' + $('#last_name').val() + '&company=' + $('#company').val(),
                    'type': 'get'
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'first_name', name: 'first_name' },
                    { data: 'last_name', name: 'last_name' },
                    { data: 'company', name: 'company' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });

            e.preventDefault();
        });
    </script>
@endsection
