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
                    <li class="active">
                        <a  href="#not_selling" data-toggle="tab">Not Selling</a>
                    </li>
                    <li><a href="#short_stocks" data-toggle="tab">Short Stocks</a>
                    </li> 
                </ul>

                <div class="tab-content clearfix">
                  <div class="tab-pane active" id="not_selling">
                      <h3>Number of products that are not selling for the last 7 days</h3>
                      <table class="table table-bordered table-hover table-striped datatable"> 
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
                  <div class="tab-pane" id="short_stocks">
                      <h3>Number of products that stocks are below 15</h3>
                      <table class="table table-bordered table-hover table-striped datatable"> 
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
              </div>
          </div>
      </div>

  </div> 
</div> 
</div>

<style type="text/css">
    
    .nav-pills>li { 
        display: inline-block;
        width: 48%;
        background-color: #f4f4f5;
    }
</style>
