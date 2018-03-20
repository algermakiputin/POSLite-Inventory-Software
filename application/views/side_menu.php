<div class="col-sm-2" id="side-menu">
	<div>
		<ul class="list-side-menu">
			<?php
				$location = $this->uri->segment(1); 
			?>
			<li class="list-side-group-item <?php if ($location === 'inventory' || $location === 'item') {echo 'active-link';}?> ">

				<a class="<?php if ($location === 'inventory') {echo 'active-text';}?>" href="<?php echo base_url("inventory") ?>">
				<span class="glyphicon glyphicon-folder-close"></span><br>Inventory</a>
			</li>
			<li class="list-side-group-item <?php if ($location === 'new_item') {echo 'active-link';}?> ">
				<a class="<?php if ($location === 'new_item') {echo 'active-link';}?>" href="<?php echo base_url("new_item") ?>"><i class="fa fa-plus fa-big" aria-hidden="true"></i><br>New Item</a>
			</li>
			<li class="list-side-group-item <?php if ($location === 'sales') {echo 'active-link';}?>">
				<a class="<?php if ($location === 'sales') {echo 'active-link';}?>" href="<?php echo base_url("daily_sales_report") ?>"><span class="glyphicon 	glyphicon glyphicon-list-alt"></span><br>Sales</a>
			</li>
			<li class="list-side-group-item <?php if ($location === 'categories') {echo 'active-link';}?> "><a class="<?php if ($location === 'categories') {echo 'active-link';}?>" href="<?php echo base_url("categories") ?>"><span class="glyphicon glyphicon glyphicon-tags"></span><br>Categories</a></li>
			<?php 
			if ($this->session->userdata('account_type') == 'Admin') {
				?>
			<li class="list-side-group-item <?php if ($location === 'accounts') {echo 'active-link';}?> ">
				<a class="<?php if ($location === 'accounts') {echo 'active-link';}?>" href="<?php echo base_url("accounts") ?>"><span class="glyphicon glyphicon glyphicon-user"></span><br>Accounts</a>
			</li>
			<?php
			}
			 ?>
			<li id="log-out" class="list-side-group-item <?php if ($location === 'lagout') {echo 'active-link';}?> "><a href="<?php echo base_url("logout/out") ?>"><span class="glyphicon glyphicon glyphicon-log-out"></span><br>Lagout</a></li>
		</ul>
	</div>
</div>
