<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Standby Orders</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">   
    <div class="col-lg-12">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="form-group"> 
                <div class="alert alert-success">
                    <?php echo $this->session->flashdata('success') ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="form-group"> 
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('error') ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-lg-12"> 

        <div class="wrapper"> 
            <table class="table table-striped table-bordered" id="standby_orders_tbl">
                <thead>
                    <tr>
                        <th>Invoice No:</th> 
                        <th>Invoice Date</th>  
                        <th>Customer Name</th>
                        <th>Amount</th> 
                        <th>Note</th>
                        <th>Status</th>
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
        border: solid 1px #ddd; 
        padding: 20px;
        border-radius: 5px;
    }
     legend {
        margin-bottom: 10px;
        padding: 0;
    }
</style>
 
