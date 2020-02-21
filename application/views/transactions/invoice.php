<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Invoice</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">   
    <div class="col-lg-12">
        <div style="background-color: #eee;padding: 10px;margin-bottom: 20px;">
            <label>Select Store:</label>
            <?php 
                echo store_selector_component(['form-control', 'limit'], "invoice-store-filter");
            ?>
        </div>
    </div>
    <div class="col-lg-12"> 
        <?php if ($this->session->flashdata('success')): ?>
            <div class="form-group"> 
                <div class="alert alert-success">
                    <?php echo $this->session->flashdata('success') ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="wrapper"> 
            <table class="table table-striped table-bordered" id="invoice_tbl">
                <thead>
                    <tr>
                        <th>Invoice Date</th>
                        <th>Invoice No:</th> 
                        <th>Type</th> 
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
        border: solid 1px #ddd; 
        padding: 20px;
        border-radius: 5px;
    }
     legend {
        margin-bottom: 10px;
        padding: 0;
    }
</style>
 

