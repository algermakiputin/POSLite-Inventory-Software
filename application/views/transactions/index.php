<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Customer Credits</h1>
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
                <div class="alert alert-dangerr">
                    <?php echo $this->session->flashdata('error') ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-lg-12">
         
        <div class="wrapper">
          
            <table class="table table-striped table-bordered" id="credits_tbl">
                <thead>
                    <tr> 
                        <th>Credit No:</th> 
                        <th>Credit Date</th>
                        <th>Sales Person</th>
                        <th>Customer Name</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Note</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($descriptions as $description): ?>
                        <tr>
                            <td><?php echo $description->transaction_number ?></td>
                            <td><?php echo date('Y-m-d', strtotime($description->date_time)) ?></td>
                            <td><?php echo $description->username ?></td>
                            <td><?php echo currency() . number_format($description->total,2) ?></td>
                            <?php 
                                $total_sales += $description->total;
                            ?>
                        </tr>
                    <?php endforeach; ?>
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
 

