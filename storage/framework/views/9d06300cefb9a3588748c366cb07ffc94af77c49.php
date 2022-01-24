<?php $__env->startSection('title'); ?>
    Employees
<?php $__env->stopSection(); ?>
<?php $__env->startSection('employees'); ?>
    active
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header'); ?>
    <link href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
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
                                                <?php $__currentLoopData = \App\Companies::get_field(['id','name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <a href="<?php echo e(route('employees.create')); ?>" class="btn btn-primary float-right">Add New Employee</a>
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

            <?php $__currentLoopData = App\Employees::orderBy('id','desc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <div class="modal fade" id="edit<?php echo e($item->id); ?>" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Employee</h4>
                            </div>
                            <div class="modal-body">
                                <form action="<?php echo e(url('admin/employees/'.$item->id)); ?>" method="POST">
                                    <?php echo method_field('PUT'); ?>
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group">
                                        <label>First Name <span class="text-danger">*</span></label>
                                        <input type="text" value="<?php echo e($item->first_name); ?>" class="form-control" name="first_name">
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name <span class="text-danger">*</span></label>
                                        <input type="text" value="<?php echo e($item->last_name); ?>" class="form-control" name="last_name">
                                    </div>
                                    <div class="form-group">
                                        <label>Company</label>
                                        <select class="form-control" name="company">
                                            <?php $__currentLoopData = App\Companies::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($item_company->id); ?>" <?php echo e($item_company->id == $item->company ? "selected" : ""); ?>><?php echo e($item_company->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" value="<?php echo e($item->email); ?>" class="form-control" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" value="<?php echo e($item->phone); ?>" class="form-control" name="phone">
                                    </div>

                                    <a type="button" class="btn btn-warning float-right ml-2" data-dismiss="modal">CANCEL</a>
                                    <button class="btn btn-success float-right">UPDATE</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="modal fade" id="delete<?php echo e($item->id); ?>" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Delete Employee</h4>
                            </div>
                            <div class="modal-body">Are you sure want to delete data?</div>
                            <div class="modal-footer">
                                <form method="POST" action="<?php echo e(url('admin/employees/'.$item->id)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button  class="btn btn-danger">YES</button>
                                </form>
                                <button type="button" class="btn btn-warning" data-dismiss="modal">NO, CANCEL</button>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div><!-- /.container-fluid -->
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(function() {
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '<?php echo e(route('get.employees')); ?>',
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
                    'url': '<?php echo e(url('admin/get/employees/search')); ?>' + '?email=' + $('#email').val() + '&first_name=' + $('#first_name').val() + '&last_name=' + $('#last_name').val() + '&company=' + $('#company').val(),
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/laravel-ashr/resources/views/admin/pages/employees/index.blade.php ENDPATH**/ ?>