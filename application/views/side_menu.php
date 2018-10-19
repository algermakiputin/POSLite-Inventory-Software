<div class="col-sm-2" id="side-menu">
	<ul class="nav ">
		<?php
			$location = $this->uri->segment(1); 
			$report = $this->uri->segment(2);
		?>
		<li class="nav-item">

			<a class="nav-link  <?php if ($location === 'inventory') {echo 'active-text';}?>" href="<?php echo base_url("inventory") ?>">
				<i class="glyphicon glyphicon-folder-close"></i> <span>Items</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link  <?php if ($location === 'new_item') {echo 'active-link';}?>" href="<?php echo base_url("new_item") ?>">
				<i class="fa fa-plus fa-big" aria-hidden="true"></i> <span>Register Item</span>
			</a>
		</li>
		<li class="nav-item ">
			<a class="nav-link" href="<?php echo base_url("customers") ?>">
				<i class="fa fa-users fa-big" aria-hidden="true"></i> <span>Customers</span>
			</a>
		</li>
		<li class="nav-item ">
			<a class="nav-link  <?php if ($location === 'suppliers') {echo 'active-link';}?>" href="<?php echo base_url("suppliers") ?>">
				<i class="fa fa-industry fa-big" aria-hidden="true"></i> <span>Suppliers</span>
			</a>
		</li>
		<li class="nav-item ">
			<a class="nav-link  <?php if ($location === 'delivery') {echo 'active-link';}?>" href="<?php echo base_url("delivery") ?>">
				<i class="fa fa-truck fa-big" aria-hidden="true"></i> <span>Delivery</span>
			</a>
		</li>
		<li class="nav-item ">
			<a class="nav-link <?php if ($report === 'daily' || $report === 'weekly' || $report === 'monthly' || $report === 'yearly') {echo 'active-link';}?>" href="<?php echo base_url("sales/daily") ?>">
				<i class="glyphicon glyphicon glyphicon-list-alt"></i> <span>Sales</span>
			</a>
		</li>
		<li class="nav-item ">
			<a class="nav-link <?php if ($location === 'categories') {echo 'active-link';}?>" href="<?php echo base_url("categories") ?>">
				<i class="glyphicon glyphicon glyphicon-tags"></i> <span>Categories</span>
			</a>
		</li>
		<?php 
		if ($this->session->userdata('account_type') == 'Admin') {
			?>
		<li class="nav-item ">
			<a class="nav-link <?php if ($location === 'accounts') {echo 'active-link';}?>" href="<?php echo base_url("accounts") ?>">
				<i class="glyphicon glyphicon glyphicon-user"></i> 
				<span>Accounts</span>
			</a>
		</li>
		<?php
		}
		 ?>
		<li class="nav-item " id="log-out" > 
			<a class="nav-link " href="<?php echo base_url("logout/out") ?>">
				<i class="glyphicon glyphicon glyphicon-log-out"></i> 
				<span>Logout</span>
			</a>
		</li>
	</ul>
</div>
