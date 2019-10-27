<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Invoices</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">  

    <div class="col-lg-12">
        
        <ul class="nav nav-tabs">
          <li role="presentation" ><a href="<?php echo base_url('transactions') ?>">Customer Credits</a></li> 
          <li role="presentation" class="active"><a >Invoice</a></li>
          <li role="presentation"><a href="<?php echo base_url('reports/category') ?>">Standby Order</a></li> 
        </ul>   
        <div class="wrapper">
          
            <table class="table table-striped table-bordered" id="invoice_tbl">
                <thead>
                    <tr>
                        <th>Invoice No:</th> 
                        <th>Invoice Date</th>  
                        <th>Customer Name</th>
                        <th>Amount</th> 
                        <th>Note</th>
                        <th>Action</th>                                 
                    </tr>
                </thead>
                <tbody> 
                </tbody> 
            </table> 
        </div>
    </div>

</div>

<style type="text/css">
    .wrapper {
        border-right: solid 1px #ddd;
        border-left: solid 1px #ddd;
        border-bottom: solid 1px #ddd;
        padding: 20px 10px 10px 10px;
    }
     legend {
        margin-bottom: 10px;
        padding: 0;
    }
</style>
 

