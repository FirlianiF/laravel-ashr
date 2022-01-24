@extends('admin.layout')
@section('title')
    Companies
@endsection
@section('companies')
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" id="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="name" id="name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Website</label>
                                            <input type="text" name="website" id="website" class="form-control">
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
                            <h5 class="m-0">Companies</h5>
                            <a href="{{route('companies.create')}}" class="btn btn-primary float-right">Add New Company</a>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table" id="datatable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Logo</th>
                                        <th>Website</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            @foreach(App\Companies::orderBy('id','desc')->get() as $item)
                {{-- EDIT --}}
                <div class="modal fade" id="edit{{$item->id}}" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Company</h4>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('admin/companies/'.$item->id)}}" method="POST" enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$item->name}}" class="form-control" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" value="{{$item->email}}" class="form-control" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label>Logo</label>
                                        <input type="file" class="form-control" name="file">
                                    </div>
                                    <div class="form-group">
                                        <label>Website</label>
                                        <input type="text" value="{{$item->website}}" class="form-control" name="website">
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
                                <h4 class="modal-title">Delete Company "{{$item->name}}"</h4>
                            </div>
                            <div class="modal-body">Are you sure want to delete data?</div>
                            <div class="modal-footer">
                                <form method="POST" action="{{url('admin/companies/'.$item->id)}}">
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
                ajax: '{{route('get.companies')}}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'logo', name: 'logo', orderable: false, searchable: false },
                    { data: 'website', name: 'website' },
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
                    'url': '{{url('admin/get/companies/search')}}' + '?email=' + $('#email').val() + '&name=' + $('#name').val() + '&website=' + $('#website').val(),
                    'type': 'get'
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'logo', name: 'logo', orderable: false, searchable: false },
                    { data: 'website', name: 'website' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });

            e.preventDefault();
        });
    </script>
@endsection
