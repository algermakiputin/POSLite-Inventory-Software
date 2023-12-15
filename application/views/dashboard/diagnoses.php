<div class="row">
   <div class="col-lg-12">
      <h1 class="page-header">Diagnoses</h1>
   </div>
</div>
<div class="row">
   <div class="col-lg-12">
      <div id="exTab1">
         <ul  class="nav nav-pills" style="margin-bottom:10px">
            <li class="<?php echo $active == "" ? 'active' : '' ?>">
               <a  href="#not_selling" data-toggle="tab">Not Selling</a>
            </li>
            <li class="<?php echo $active == "2" ? 'active' : '' ?>"><a href="#short_stocks" data-toggle="tab">Short Stocks</a>
            </li>
            <li class="<?php echo $active == "3" ? 'active' : '' ?>"><a href="#out_of_stocks" data-toggle="tab">Out of Stocks</a>
            </li>
         </ul>
         <div class="tab-content clearfix" id="diagnoses_tab">
            <div class="tab-pane <?php echo $active == "" ? 'active' : '' ?>" id="not_selling">
               <p>These products are not selling well in the last 30 days</p>
               <table id="notSellingTable" class="table table-bordered table-hover table-striped" width="100%">
                  <thead>
                     <tr>
                        <th width="15%">Barcode</th>
                        <th width="45%">Name</th>
                        <th width="20%">Stocks</th>
                        <th width="20%">Price</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($not_selling as $item): ?>
                     <tr>
                        <td><?php echo $item->barcode ?></td>
                        <td><?php echo $item->name ?></td>
                        <td><?php echo $item->quantity ?></td>
                        <td><?php echo currency() . number_format($item->price,2) ?></td>
                     </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>
            <div class="tab-pane <?php echo $active == "2" ? 'active' : '' ?>" id="short_stocks">
               <p>Time to restock</p>
               <table id="shortStocksTable" class="table table-bordered table-hover table-striped" width="100%">
                  <thead>
                     <tr>
                        <th>Barcode</th>
                        <th>Name</th>
                        <th>Stocks</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($low_stocks as $item): ?>
                     <tr>
                        <td><?php echo $item->barcode ?></td>
                        <td><?php echo $item->name ?></td>
                        <td><?php echo $item->quantity ?> Remaining</td>
                        <td><a class="btn btn-sm btn-primary" href="<?php echo base_url('/purchase/new?supplier_id='. $item->supplier_id) ?>">reorder</a></td>
                     </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>
            <div class="tab-pane <?php echo $active == "3" ? 'active' : '' ?>" id="out_of_stocks">
               <p>Run out of stocks</p>
               <table class="table table-bordered table-hover table-striped" id="outOfStocksTable" width="100%">
                  <thead>
                     <tr>
                        <th>Barcode</th>
                        <th>Name</th>
                        <th>Stocks</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($out_of_stocks as $item): ?>
                     <tr>
                        <td><?php echo $item->barcode ?></td>
                        <td><?php echo $item->name ?></td>
                        <td><?php echo $item->quantity ?> Remaining</td>
                        <td><a class="btn btn-sm btn-primary" href="<?php echo base_url('/purchase/new?supplier_id='. $item->supplier_id) ?>">reorder</a></td>
                     </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
</div>