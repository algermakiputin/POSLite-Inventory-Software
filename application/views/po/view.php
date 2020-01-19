<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">P.O. NO. <?php echo $po->po_number ?></h1>
	</div> 
    <div class="col-md-12">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success') ?>
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
</div>
<div class="row">
    

    <div class="col-lg-12">
       <div class="panel panel-default">
           <div class="panel-heading">
               Purchase Order
           </div> 
           <div class="panel-body" style="line-height: 1.5;padding: 40px 40px 60px 40px"> 
            <div class="row">
                <div class="col-md-6">
                    <div><b>Hardware Shop</b></div>
                    <div>WYC Bldg., J. Hernandez St.</div>
                    <div>Naga City, Camarines Sur 4400</div>
                    <div>PH</div>
                    <div>test@example.com</div>
                    <div>www.test.com</div>
                </div> 
                <div class="col-md-12">
                    <h3>PURCHASE ORDER</h3>
                </div>
                <div class="col-md-4">
                    <div><b>REQUEST FROM</b></div> 
                    <div><?php echo $po->store_name ?></div>
                </div>
                <div class="col-md-4">
                    <div><b>REQUEST TO</b></div>
                    <div><?php echo $po->requested_store_name ?></div>
                </div>
                <div class="col-md-4 text-left">
                    <div><b>P.O NO.</b>&nbsp; <?php echo $po->po_number; ?></div>
                    <div><b>DATE</b> <?php echo $po->po_date; ?></div>
                </div>
                <br/>
                <div class="col-md-12">
                    <div style="border-bottom: solid 2px #ddd;margin: 20px 0"></div>
                    <div><b>SHIP VIA</b></div>
                    <div><?php echo $po->shipvia; ?></div>
                    <div>&nbsp;</div>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>PRODUCT</th>
                                <th>QTY</th>
                                <th>PRICE</th>
                                <th>AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orderline as $line): ?>
                                <tr>
                                    <td><?php echo $line->product_name ?></td>
                                    <td><?php echo $line->quantity ?></td>
                                    <td><?php echo $line->price ?></td>
                                    <td><?php echo currency() . number_format($line->quantity * $line->price,2); $total+= $line->quantity * $line->price ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <?php echo str_replace("?", "&#x20B1;", $po->note) ?>
                </div>
                <div class="col-md-4 text-right">  
                    <div><b>TOTAL</b></div>
                </div>
                <div class="col-md-2 text-right">
                    <div><?php echo currency() . number_format($total,2); ?></div>
                </div> 
                <div class="col-md-12">
                    <br/>
                    <div class="form-group">
                       <!--  <button class="btn btn-default" id="pdf"><i class="fa fa-file-pdf-o"></i> PDF</button>
                        &nbsp;
                        <a href="<?php echo base_url("PurchaseOrderController/edit/$po->po_number") ?>"  class="btn btn-default"><i class="fa fa-edit"></i> Edit</a> -->
                    </div>
                </div>
            </div>
           </div> 
       </div> 
   </div> 
</div>

<script src="<?php echo base_url('assets/js/po.js') ?>"></script>

<script type="text/javascript">
    
    $(document).ready(function(e) {
  
        var supplier = {
          name:  '<?php echo $supplier->name; ?>',
          company:  '<?php echo $supplier->company; ?>',
          address:  '<?php echo $supplier->address; ?>',
          province:  '<?php echo $supplier->province; ?>',
          city:  '<?php echo $supplier->city; ?>',
          country:  '<?php echo $supplier->country; ?>'
        };
 
        var po_number = "<?php echo $po->po_number ?>";
        var po_date = "<?php echo $po->po_date ?>";
        var shipvia = "<?php echo $po->shipvia ?>";
        var image = "<?php echo $image_base64 ?>";
        var note = "<?php echo str_replace("?", "₱", $po->note) ?>"
         
        var items = [
          [ {text: 'PRODUCT', bold: true, fillColor:"#4f90bb", color: "#fff"}, 
            {text: 'QTY', bold: true, fillColor:"#4f90bb", color: "#fff"}, 
            {text: 'PRICE', bold: true, fillColor:"#4f90bb", color: "#fff", alignment: "right"}, 
            {text: 'AMOUNT', bold: true, fillColor:"#4f90bb", color: "#fff", alignment: "right"}]
          ];
        var orderline = JSON.parse('<?php echo json_encode($orderline) ?>');

        $.each(orderline, function(key, value) {
            items.push([value.product_name, value.quantity, {text: value.price, alignment:'right'}, {text: value.quantity * value.price, alignment: 'right'}]);
        });
  
        var total = '<?php echo currency() . number_format($total,2); ?>';

        $("#pdf").click(function(e) {
            var docDefinition = generate_pdf(items, total, po_number,po_date, shipvia,supplier, image, note);
     
            var pdf = pdfMake.createPdf(docDefinition);
            pdf._openPdf();
        })
        

       
    });
</script>
