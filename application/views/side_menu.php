<div class="col-sm-2" id="side-menu">
	<ul class="nav ">
		<?php
			$location = $this->uri->segment(1); 
			$report = $this->uri->segment(2);
		?>
		<li class="nav-item">
			<a class="nav-link" href="<?php echo base_url("items") ?>">
				<i class="glyphicon glyphicon-folder-close"></i> <span>Items</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="<?php echo base_url("items/new") ?>">
				<i class="fa fa-plus fa-big" aria-hidden="true"></i> <span>Register Item</span>
			</a>
		</li>
		<li class="nav-item ">
			<a class="nav-link" href="<?php echo base_url("customers") ?>">
				<i class="fa fa-users fa-big" aria-hidden="true"></i> <span>Customers</span>
			</a>
		</li>
		<li class="nav-item ">
			<a class="nav-link" href="<?php echo base_url("suppliers") ?>">
				<i class="fa fa-industry fa-big" aria-hidden="true"></i> <span>Suppliers</span>
			</a>
		</li>
		<li class="nav-item ">
			<a class="nav-link" href="<?php echo base_url("deliveries") ?>">
				<i class="fa fa-truck fa-big" aria-hidden="true"></i> <span>Deliveries</span>
			</a>
		</li>
		<li class="nav-item ">
			<a class="nav-link" href="<?php echo base_url("new-delivery") ?>">
				<i class="fa fa-shopping-cart fa-big" aria-hidden="true"></i> <span>New Delivery</span>
			</a>
		</li>
		<li class="nav-item ">
			<a class="nav-link" href="<?php echo base_url("sales/daily") ?>">
				<i class="glyphicon glyphicon glyphicon-list-alt"></i> <span>Sales</span>
			</a>
		</li>
		<li class="nav-item ">
			<a class="nav-link" href="<?php echo base_url("categories") ?>">
				<i class="glyphicon glyphicon glyphicon-tags"></i> <span>Categories</span>
			</a>
		</li>
		<?php 
		if ($this->session->userdata('account_type') == 'Admin') {
			?>
		<li class="nav-item ">
			<a class="nav-link" href="<?php echo base_url("users") ?>">
				<i class="glyphicon glyphicon glyphicon-user"></i> 
				<span>Accounts</span>
			</a>
		</li>
		<?php
		}
		 ?>
		<li class="nav-item " id="log-out" > 
			<a class="nav-link " href="<?php echo base_url("logout") ?>">
				<i class="glyphicon glyphicon glyphicon-log-out"></i> 
				<span>Logout</span>
			</a>
		</li>
	</ul>
</div>
