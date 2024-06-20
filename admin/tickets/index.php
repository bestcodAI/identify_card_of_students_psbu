<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">List of Tickets</h3>
		<div class="card-tools">
			<a href="./?page=tickets/manage_ticket" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="25%">
					<col width="20%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Created</th>
						<th>Code</th>
						<th>Total Amount</th>
						<th>Encoded By</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					if($_settings->userdata('type') == 1):
						$qry = $conn->query("SELECT *, COALESCE((SELECT concat(lastname,', ', firstname, COALESCE(concat(middlename,' '),'')) FROM `users` where id = ticket_list.user_id),'(User has been deleted)') as `user` from `ticket_list` order by abs(unix_timestamp(date_created)) desc ");
					else:
						$qry = $conn->query("SELECT *, COALESCE((SELECT concat(lastname,', ', firstname, COALESCE(concat(middlename,' '),'')) FROM `users` where id = ticket_list.user_id),'(User has been deleted)') as `user` from `ticket_list` where user_id = '{$_settings->userdata('id')}' order by abs(unix_timestamp(date_created)) desc ");
					endif;
						while($row = $qry->fetch_assoc()):
							$total = ($row['adult_price'] * $row['adult_no']) + ($row['child_price'] * $row['child_no']);
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td><?php echo $row['code'] ?></td>
							<td class="text-right"><?php echo format_num($total,2) ?></td>
							<td><?= $row['user'] ?> <?= $_settings->userdata('id') == $row['user_id'] ? "<small>(You)</small>" : '' ?></td>
							<td align="center">
								 <button type="button" class="btn btn-flat p-1 btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item" href="./?page=tickets/view_ticket&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item" href="./?page=tickets/manage_ticket&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this ticket permanently?","delete_ticket",[$(this).attr('data-id')])
		})
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [5] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
	function delete_ticket($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_ticket",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>