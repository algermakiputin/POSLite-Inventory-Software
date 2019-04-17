<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Items
            <span class="pull-right">Total Inventory Value: ₱<span id="total"><?php echo $total; ?></span></span>
        </h1> 
    </div>
    <div class="col-md-12">
        <?php 
        echo $this->session->flashdata('errorMessage');
        echo $this->session->flashdata('successMessage');

        ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12" style="padding-bottom: 10px;">
        <div style="background: #eee;padding: 10px;border:solid 1px #ddd;border-radius: 0.5em">
            <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#filter-options">
            <i class="fa fa-cog"></i> Filter Options
        </button>
        <a class="pull-right btn btn-default" href="<?php echo base_url('items/new') ?>">
            <i class="fa fa-plus"></i>
        Add Product</a>
        <div style="padding: 10px 0 0 0;" id="filter-options" class="collapse">
            <div class="row">
                <div class="col-md-3">
                    <div>
                        <select name="category" class="form-control filter-items" data-column="2">
                            <option value="">Filter By Category</option>
                            <?php foreach ($categories as $key => $category): ?>
                                <option value="<?php echo ucwords($category->name) ?>"><?php echo ucwords($category->name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div>
                        <select  name="supplier" class="form-control filter-items" data-column="7">
                            <option value="">Filter By Supplier</option>
                            <?php foreach ($suppliers as $key => $supplier): ?>
                                <option value="<?php echo $supplier->name; ?>"><?php echo ucwords($supplier->name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div>
                        <select name="price" class="form-control filter-items" data-column="4">
                            <option value="">Filter By Price</option>
                            <option value="DESC">Highest to Lowest</option>
                            <option value="ASC">Lowest to Highest</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div>
                        <select name="stocks" class="form-control filter-items" data-column="5">
                            <option value="">Filter By Stocks</option>
                            <option value="DESC">Highest to Lowest</option>
                            <option value="ASC">Lowest to Highest</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <button style="margin-top: 5px" class="btn btn-info" id="clear-filter">Clear Filter</button>
                </div>
            </div>
        </div>
        </div>

    </div>
    <div class="col-lg-12">
       <div class="panel panel-default">

           <div class="panel-heading">
               Items List

           </div>

           <!-- /.panel-heading -->
           <div class="panel-body">
               <table class="table table-responsive table-hover table-bordered" id="item_tbl">
                 <thead>
                    <tr>
                        <th width="8%">&nbsp;</th>
                        <th width="20%">Item Name</th>
                        <th width="10%">Category</th> 
                        <th width="11%">Capital Per/Item</th>
                        <th width="11%">Retail Price</th>
                        <th width="10%">Stocks</th>
                        <th width="10%">Total</th>
                        <th width="10%">Supplier</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $key => $item): ?>
                        <?php 
                        $stocks = $orderingLevel->getQuantity($item->id)->quantity; 
                        $item_price = $price->getPrice($item->id);
                        $capital = $item_price * $stocks;
                        $capitalPerItem = $this->db->where('item_id', $item->id)->get('prices')->row()->capital;
                        ?>
                        <tr>
                            <td>
                                <?php if ($item->image && file_exists('./uploads/' . $item->image) ): ?>
                                    <div class="product-thumbnail">
                                        <img src="<?php echo base_url('uploads/' . $item->image)  ?>" data-preview-image="<?php echo base_url('uploads/' . $item->image) ?>">
                                    </div>

                                    <?php else: ?>
                                        <div class="product-thumbnail">
                                            <span style="color: rgba(0,0,0,0.4);font-size: 11px;">No Image</span>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo ucwords($item->name) ?></td>
                                <td><?php echo ucwords($categoryModel->getName($item->category_id)); ?></td> 
                                <td><?php echo '₱' . number_format($capitalPerItem,2) ?></td>
                                <td><?php echo '₱'. number_format($item_price,2) ?></td>
                                <td><?php echo $orderingLevel->getQuantity($item->id)->quantity ? $orderingLevel->getQuantity($item->id)->quantity : '<span class="text-danger">Out of stock</span>'; ?></td>
                                <td><?php echo '₱'. number_format($capital,2) ?></td>
                                <td><?php echo $item->supplier_name; ?></td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">Actions <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href='<?php echo base_url("items/stock-in/$item->id") ?>'>
                                                    <i class="fa fa-plus"></i> Stock In</a>
                                            </li>
                                                    <li><a href='<?php echo base_url("items/edit/$item->id") ?>'><i class="fa fa-edit"></i> Edit</a> 
                                                    </li>
                                                    <li>
                                                        <a class="delete-item" href='#' data-link="<?php echo base_url('ItemController/delete/') ?>" data-id="<?php echo $item->id; ?>">
                                                            <i class="fa fa-trash"></i>
                                                        Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
