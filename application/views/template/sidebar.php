<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
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
                    <?php endif; ?>
                </ul>
                <!-- /.nav-second-level -->
            </li>

            <li data-step="2" data-intro="This menu takes you to the customer page where you can manage your customers.">
                <a href="<?php echo base_url('customers') ?>"><i class="fa fa-table fa-fw"></i> Customers</a>
            </li>
            <?php if (is_admin()): ?> 

            <li data-step="3" data-intro="This menu will takes you to the suppliers page where you can manage your suppliers.">
            <a href="#"><i class="fa fa-industry fa-fw"></i> Suppliers<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?php echo base_url('suppliers') ?>"><i class="fa fa-circle-o"></i> View Suppliers</a>
                    </li> 
                     
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <?php endif; ?>
            <?php if ($this->session->userdata('account_type') == "Admin"): ?>
                <li data-step="4" data-intro="If you have products delivered, you can save it here.">
                    <a href="#"><i class="fa fa-truck fa-fw"></i> Purchases<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php echo base_url('deliveries') ?>"><i class="fa fa-circle-o"></i> View Purchases</a>
                        </li>
                        
                        <?php if ($this->session->userdata('account_type') == "Admin"): ?>
                            <li>
                                    <a href="<?php echo base_url('new-delivery') ?>"><i class="fa fa-circle-o"></i> New Purchase</a>
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
            <li data-step="5" data-intro="Here you can record your expenses like rent, travel cost, repair to a equipment, etc.">
                    <a href="#"><i class="fa fa-credit-card fa-fw"></i> Payments<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php echo base_url('payments') ?>"><i class="fa fa-circle-o"></i> View Payments</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('payments/new') ?>"><i class="fa fa-circle-o"></i> New Payment</a>
                        </li>
                         
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
         
                <li>
                   <a href="#"><i class="fa fa-exchange fa-fw"></i> Transactions <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level"> 
                        <li>
                            <a href="<?php echo base_url('invoice') ?>"><i class="fa fa-circle-o"></i> Invoice</a>
                        </li>   
                        <li>
                            <a href="<?php echo base_url('purchase-orders') ?>"><i class="fa fa-circle-o"></i> Internal PO</a>
                        </li>  
                        <li>
                            <a href="<?php echo base_url('supplier/po') ?>"><i class="fa fa-circle-o"></i> New Internal PO</a>
                        </li>  
                    </ul>
                </li>   
                <li>
                   <a href="#"><i class="fa fa-archive fa-fw"></i> Stocks Transfer <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level"> 
                        <li>
                            <a href="<?php echo base_url('transfer/internal-po') ?>"><i class="fa fa-circle-o"></i> Internal PO</a>
                        </li>  
                        <li>
                            <a href="<?php echo base_url('transfer/delivery-notes') ?>"><i class="fa fa-circle-o"></i> Delivery Notes</a>
                        </li>     
                    </ul>
                </li> 
                <li >
                   <a href="#"><i class="fa fa-terminal fa-fw"></i> Sales<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php echo base_url('sales/new') ?>"><i class="fa fa-circle-o"></i> Enter Sales</a>
                        </li> 
                    </ul>
                </li>
                
            <?php if ($this->session->userdata('account_type') == 'Admin'): ?>
                 <li data-step="6" data-intro="In this menu you can view your sales reports, total profit and expenses.">
                   <a href="#"><i class="fa fa-line-chart fa-fw"></i> Reports<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php echo base_url('reports/sales') ?>"><i class="fa fa-circle-o"></i> Sales</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('reports/cash') ?>"><i class="fa fa-circle-o"></i> Cash</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('reports/credit') ?>"><i class="fa fa-circle-o"></i> Receivables</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('denomination') ?>"><i class="fa fa-circle-o"></i> Denomination</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('external-po') ?>"><i class="fa fa-circle-o"></i> View External PO</a>
                        </li> 
                        <li>
                            <a href="<?php echo base_url('external_po/new') ?>"><i class="fa fa-circle-o"></i> New External PO</a>
                        </li> 
                    </ul>
                </li>
            <?php endif; ?>
            <li data-step="5" data-intro="Here you can record your expenses like rent, travel cost, repair to a equipment, etc.">
                <a href="#"><i class="fa fa-undo fa-fw"></i> Returns / Refunds<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?php echo base_url('returns') ?>"><i class="fa fa-circle-o"></i> View Returns / Refunds</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('returns/new') ?>"><i class="fa fa-circle-o"></i> New Return / Refund</a>
                    </li>
                     
                </ul>
                <!-- /.nav-second-level -->
            </li> 
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
            
            <?php if ($this->session->userdata('account_type') == "Admin"): ?>
            <li>
                <a href="<?php echo base_url('stores') ?>"><i class="fa fa-bank"></i> Stores</a>
            </li>
            <?php endif; ?>

            <?php if (!SITE_LIVE): ?>
               <!--  <li>
                    
                </li> -->
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