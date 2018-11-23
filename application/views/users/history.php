<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Users</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Login History
			</div>
			<div class="panel-body">
				<div class="row">
					 
					<div class="col-lg-12"> 
						<table class="table table-striped table-hover table-bordered" id="history_table">
							<thead>
								<tr>
									<th width="25%">Date & Time</th>
									<th width="15%">Username</th>
									<th width="15%">Account Type</th> 
									<th width="45%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($history as $hist): ?>
									<tr>
										<td><?php echo date('Y-m-d h:i:s a', strtotime($hist->date)) ?></td>
										<td><?php echo $hist->username ?></td>
										<td><?php echo $hist->account_type ?></td>
										<td><?php echo $hist->action ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- /.row (nested) -->
		</div>
		<!-- /.panel-body -->
	</div>
	<!-- /.panel -->
</div>
<!-- /.col-lg-12 -->



