<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Backup</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<p>To protect your business data incase of damage PC/Computer or hardrive failure you can create backup data anytime and save it on your personal storage like cloud storage or in a USB storage and restore it anytime.</p>
	</div>
	<div class="col-lg-7">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-history fa-fw"></i> Backup History
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
								<td>
									<?php if (!SITE_LIVE): ?>
									<a class="" href="<?php echo base_url($backup->filename); ?>" download="<?php echo "backup-" . $backup->date_time ?>">Download</a> &nbsp;
									<a class="text-danger" disabled="disabled" href="<?php echo base_url('BackupController/delete/'. $backup->id) ?>">Delete</a>
									<?php else: ?>
										no actions
									<?php endif; ?>
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
				<i class="fa fa-hdd-o fa-fw"></i> Create Backup
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
					<fieldset <?php echo SITE_LIVE ? 'disabled="disabled"' : '' ?>>
					<div class="form-group">
						<p>
							Click backup data button to create a database backup on the current date and time.
						</p>
						<button type="submit" class="btn btn-default">
							<i class="fa fa-database"></i> Backup Data
						</button> 
					</div>
					</fieldset>
				<?php echo form_close(); ?>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-undo fa-fw"></i> Restore Backup
			</div>
			<div class="panel-body">
				 
				<?php echo form_open_multipart("BackupController/import"); ?>
					<fieldset <?php echo SITE_LIVE ? 'disabled="disabled"' : '' ?>>
						<div class="form-group">
							<input type="file" class="form-control" name="file">
						</div>
						<div class="form-group">
							<input type="submit" value="Restore" name="submit" class="btn btn-default">
						</div>
					</fieldset>
				<?php echo form_close(); ?>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>  
