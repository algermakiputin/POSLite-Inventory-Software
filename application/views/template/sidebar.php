<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
            <a href="#"><i class="glyphicon glyphicon-folder-close fa-fw"></i> Items<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?php echo base_url('items') ?>">View Items</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('items/new') ?>">Register Item</a>
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
                        <a href="<?php echo base_url('deliveries') ?>">View Deliveries</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('new-delivery') ?>">New Delivery</a>
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
                <a href="<?php echo base_url('users') ?>"><i class="fa fa-user fa-fw"></i> Users</a>
            </li>
            <li>
                <a href="<?php echo base_url("logout") ?>"><i class="glyphicon glyphicon glyphicon-log-out fa-fw"></i> Log Out</a>
            </li>
            
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>