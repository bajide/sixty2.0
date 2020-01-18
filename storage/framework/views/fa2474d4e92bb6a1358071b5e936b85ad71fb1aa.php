<?php $adminURL = config('constants.ADMIN_URL'); ?>

<?php echo $__env->make('admin.include.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="breadcrumb-range-picker">
                    <span><i class="icon-calender"></i></span>
                    <span class="ml-1">Plan List</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                	<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Plan</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Plan List</a></li>
                </ol>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card">
					<?php if(session('success_msg')): ?>
                        <div class="card-header row">
							<div class="alert alert-success alert-dismissible col-md-12 mb-0">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h4><i class="icon fa fa-check"></i> Alert!</h4>
								<?php echo e(session('success_msg')); ?>

							</div>
                        </div>
					<?php endif; ?>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="plan_list" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Plan Title</th>
                                        <th>Plan Expiry Date</th>
                                        <th>Plan Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$pages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php $k++;?>
    									<tr class="<?php echo e($plan->id); ?>">
    										<td><?php echo e($k); ?></td>
    										<td><?php echo e($plan->plan_title); ?></td>
    										<td><?php echo e(date('m/d/Y',$plan->plan_expiry_date)); ?></td>
    										<td><?php echo e($plan->plan_price); ?></td>
    										<td>
    											<div class="btn-group">
    												<button type="button" class="btn btn-info btn-xs">Action</button>
    												<button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
    													<span class="caret"></span> <span class="sr-only">Toggle Dropdown</span>
    												</button>
    												<ul class="dropdown-menu" role="menu">
    													<li><a href="<?php echo e(url($adminURL.'update-plan/'.$plan->id)); ?>">Edit</a></li>
    													<li><a href="<?php echo e(url($adminURL.'view-plan/'.$plan->id)); ?>">View</a></li>
    													<li><a href="#" class="delete_plan" data-id="<?php echo e($plan->id); ?>">Delete</a></li>
    												</ul>
    											</div>
											</td>
    									</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Plan Title</th>
                                        <th>Plan Expiry Date</th>
                                        <th>Plan Price</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="modal modal-default fade" id="modal-warning">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Warning</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to delete this <b>category</b> ?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-success deleteConfirm" id="modelConfirm" data-row-id='' data-dismiss="modal">Save changes</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!--**********************************
    Content body end
***********************************-->

<script type="text/javascript">

	$(function (){
    	$('#plan_list').DataTable()({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false
		})
	});

	$(document).ready(function(){
		$('#modal-warning').on('click', '.deleteConfirm', function(){
            var id = $(this).attr('data');
            var token = '<?php echo e(csrf_token()); ?>';
            var ths = $(this).attr('data');
            var data_row_id = $(this).attr('data-row-id');

			if (id != '') 
			{
				$.ajax({
                    type: 'post',
                    url: "<?php echo e(url('Admin/delete-plan')); ?>",
                    data: 'id=' + id + '&_token=' + token,
					beforeSend: function() { },
					success: function (data) {
						organizerTable.ajax.reload();
					}
				});
			}
		});

		$('.delete_category').on('click', function(){
            var id = $(this).attr('data-id');
            $('#modelConfirm').attr('data', id);
            $('#modelConfirm').attr('data-row-id', $(this).closest('tr').attr('data-row'));
            $('#modal-warning').modal();
            return false;
		});
	});
</script>
<?php echo $__env->make('admin.include.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>