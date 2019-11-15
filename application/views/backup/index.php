<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Backup</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-7">
		<div class="panel panel-default">
			<div class="panel-heading">
				Backup History
			</div>
			<div class="panel-body">
				<table class="table table-bordered table-hover table-striped datatable">
					<thead>
						<tr>
							<th>Date & Time</th> 
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($backups as $backup): ?>
							<tr>
								<td><?php echo $backup->date_time ?></td> 
								<td><a class="" href="<?php echo base_url($backup->filename); ?>" download="<?php echo "backup-" . $backup->date_time ?>">Download</a> &nbsp;
									<a class="text-danger" href="<?php echo base_url('BackupController/delete/'. $backup->id) ?>">Delete</a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<div class="col-lg-5">
		<div class="panel panel-default">
			<div class="panel-heading">
				Create Backup
			</div>
			<div class="panel-body">
				<?php if ($this->session->flashdata('success')): ?>
			 		<div class="form-group"> 
			 			<div class="alert alert-success">
			 				<?php echo $this->session->flashdata('success') ?>
			 			</div>
			 		</div>
			 	<?php endif; ?>
			 	<?php if ($this->session->flashdata('error')): ?>
			 		<div class="form-group"> 
			 			<div class="alert alert-danger">
			 				<?php echo $this->session->flashdata('error') ?>
			 			</div>
			 		</div>
			 	<?php endif; ?>
				<?php echo form_open("BackupController/dump"); ?>
					<div class="form-group">
						<p>
							Click backup data button to create a database backup on the current date and time.
						</p>
						<button type="submit" class="btn btn-default">
							<i class="fa fa-database"></i> Backup Data
						</button> 
					</div>
				<?php echo form_close(); ?>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				Restore Backup
			</div>
			<div class="panel-body">
				 
				<?php echo form_open_multipart("BackupController/import"); ?>
					<div class="form-group">
						<input type="file" class="form-control" name="file">
					</div>
					<div class="form-group">
						<input type="submit" value="Restore" name="submit" class="btn btn-default">
					</div>
				<?php echo form_close(); ?>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>  
