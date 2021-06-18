<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Diagnoses</h1>
	</div>  
</div>
<div class="row">  
    <div class="col-lg-12">
     <div class="panel panel-default">
         <div class="panel-heading">
            Diagnose
        </div> 
        <div class="panel-body">  
            <div id="exTab1" class="container"> 
                <ul  class="nav nav-pills">
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
                      <h4>These products are not selling well in the last 7 days</h4>
                      <hr>
                      <table class="table table-bordered table-hover table-striped datatable" width="100%"> 
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
                      <h4>Time to restock</h4>
                      <hr>
                      <table class="table table-bordered table-hover table-striped datatable" width="100%"> 
                          <thead>
                              <tr>
                                    <th>Barcode</th>
                                    <th>Name</th>
                                    <th>Stocks</th> 
                              </tr>
                          </thead>
                          <tbody>
                              <?php foreach ($low_stocks as $item): ?>
                                <tr>
                                    <td><?php echo $item->barcode ?></td>
                                    <td><?php echo $item->name ?></td>
                                    <td><?php echo $item->quantity ?> Remaining</td> 
                                </tr>
                              <?php endforeach; ?>
                          </tbody>
                      </table>
                  </div> 
                  <div class="tab-pane <?php echo $active == "3" ? 'active' : '' ?>" id="out_of_stocks">
                      <h4>Run out of stocks</h4>
                      <hr>
                      <table class="table table-bordered table-hover table-striped datatable" width="100%"> 
                          <thead>
                              <tr>
                                    <th>Barcode</th>
                                    <th>Name</th>
                                    <th>Stocks</th> 
                              </tr>
                          </thead>
                          <tbody>
                              <?php foreach ($out_of_stocks as $item): ?>
                                <tr>
                                    <td><?php echo $item->barcode ?></td>
                                    <td><?php echo $item->name ?></td>
                                    <td><?php echo $item->quantity ?> Remaining</td> 
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
</div>
 
