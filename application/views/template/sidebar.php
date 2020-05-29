<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-table fa-fw"></i> Dashboard</a>
            </li>
            <li data-step="1" data-intro="In this menu you can select view products and register new product." data-hintPosition="middle-right">
            <a href="#"><i class="glyphicon glyphicon-folder-close fa-fw"></i> Products<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?php echo base_url('items') ?>"><i class="fa fa-circle-o"></i> View Products</a>
                    </li>
                    <?php if ( is_admin()): ?>
                    <li>
                        <a href="<?php echo base_url('items/new') ?>"><i class="fa fa-circle-o"></i> Register Product</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('barcodes/print') ?>" target="__blank"><i class="fa fa-circle-o"></i> Print Barcode</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <!-- /.nav-second-level -->
            </li>

            <li data-step="2" data-intro="This menu takes you to the customer page where you can manage your customers.">
                <a href="<?php echo base_url('customers') ?>"><i class="fa fa-table fa-fw"></i> Customers</a>
            </li>
            <?php if (is_admin()): ?>
            <li data-step="3" data-intro="This menu will takes you to the suppliers page where you can manage your suppliers.">
                <a href="<?php echo base_url('suppliers') ?>"><i class="fa fa-industry fa-fw"></i> Suppliers</a>
            </li>
            <?php endif; ?>
            <?php if ($this->session->userdata('account_type') == "Admin"): ?>
                <li data-step="4" data-intro="If you have products delivered, you can save it here.">
                    <a href="#"><i class="fa fa-truck fa-fw"></i> Deliveries<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php echo base_url('deliveries') ?>"><i class="fa fa-circle-o"></i> View Deliveries</a>
                        </li>
                        
                        <?php if ($this->session->userdata('account_type') == "Admin"): ?>
                            <li>
                                    <a href="<?php echo base_url('new-delivery') ?>"><i class="fa fa-circle-o"></i> New Delivery</a>
                                </li>
                        <?php endif; ?>
                         
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
            <?php endif; ?>
            <?php if ($this->session->userdata('account_type') == "Admin"): ?>
                <li data-step="5" data-intro="Here you can record your expenses like rent, travel cost, repair to a equipment, etc.">
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
            <?php endif; ?>
            <?php if ($this->session->userdata('account_type') == "Admin" ||
                        $this->session->userdata('account_type') == "Cashier"
                ): ?>
                <li data-step="6" data-intro="In this menu you can view your sales reports, total profit and expenses.">
                   <a href="#"><i class="fa fa-line-chart fa-fw"></i> Reports<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php echo base_url('sales') ?>"><i class="fa fa-circle-o"></i> Sales</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('returns') ?>"><i class="fa fa-circle-o"></i> Returns</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            <li data-step="7" data-intro="To organize your inventory you can manage your inventory categories.">
                <a href="<?php echo base_url('categories') ?>"><i class="glyphicon glyphicon glyphicon-tags fa-fw"></i> Categories</a>
            </li>

            <?php if ($this->session->userdata('account_type') == "Admin"): ?>
            <li data-step="8" data-intro="Here you can add users like cashier">
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
            <?php endif; ?>

            <li data-step="8" data-intro="Here you can add users like cashier">
                <a href="#"><i class="fa fa-cog fa-fw"></i> System <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?php echo base_url('backups') ?>"><i class="fa fa-circle-o"></i> Backups</a>
                    </li> 
                </ul>
            </li>

            <?php if (!SITE_LIVE): ?>
                <li>
                    <a href="<?php echo base_url('license') ?>"><i class="fa fa-legal"></i> License</a>
                </li>
            <!-- <li>
                <a href="<?php echo base_url('backups') ?>"><i class="fa fa-database"></i> Backup</a>
            </li> -->
            <?php endif; ?>
            
            <li data-step="9" data-intro="Logout takes you out of the system.">
                <a href="<?php echo base_url("logout") ?>"><i class="glyphicon glyphicon glyphicon-log-out fa-fw"></i> Log Out</a>
            </li>
            
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>