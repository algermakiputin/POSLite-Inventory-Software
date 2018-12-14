<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
            <a href="#"><i class="glyphicon glyphicon-folder-close fa-fw"></i> Items<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?php echo base_url('items') ?>"><i class="fa fa-circle-o"></i> View Items</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('items/new') ?>"><i class="fa fa-circle-o"></i> Register Item</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>

            <li>
                <a href="<?php echo base_url('customers') ?>"><i class="fa fa-table fa-fw"></i> Customers</a>
            </li>
            <li>
                <a href="<?php echo base_url('suppliers') ?>"><i class="fa fa-industry fa-fw"></i> Suppliers</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-truck fa-fw"></i> Deliveries<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?php echo base_url('deliveries') ?>"><i class="fa fa-circle-o"></i> View Deliveries</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('new-delivery') ?>"><i class="fa fa-circle-o"></i> New Delivery</a>
                    </li>
                     
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-money fa-fw"></i> Expenses<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?php echo base_url('expenses') ?>"><i class="fa fa-circle-o"></i> View Expenses</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('expenses/new') ?>"><i class="fa fa-circle-o"></i> New Expenses</a>
                    </li>
                     
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="<?php echo base_url('sales') ?>"><i class="glyphicon glyphicon glyphicon-list-alt fa-fw"></i> Sales</a>
            </li>
            
            <li>
                <a href="<?php echo base_url('categories') ?>"><i class="glyphicon glyphicon glyphicon-tags fa-fw"></i> Categories</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-users fa-fw"></i> Users<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?php echo base_url('users') ?>"><i class="fa fa-circle-o"></i> View Users</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('users/history') ?>"><i class="fa fa-circle-o"></i> History</a>
                    </li>
                     
                </ul>
            </li>
            <li>
                <a href="<?php echo base_url("logout") ?>"><i class="glyphicon glyphicon glyphicon-log-out fa-fw"></i> Log Out</a>
            </li>
            
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>