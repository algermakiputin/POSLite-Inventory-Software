<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Credit</h1>
	</div> 
    <div class="col-md-12">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="row">

    <div class="col-lg-12">
       <div class="panel panel-default">
           <div class="panel-heading">
                Transaction Credit
           </div> 
           <div class="panel-body"> 
                <div class="row">
                    <div class="col-md-6">
                        <h4>CREDIT DETAILS</h4>
                        <table width="100%" style="margin-bottom: 10px;">
                            <tr>
                                <td width="20%">Credit No:</td>
                                <td style="padding: 5px 0;"><input type="text" class="form-control" style="max-width: 250px" name="" readonly="readonly" value="<?php echo $credit->transaction_number; ?>"></td>
                            </tr> 
                            <tr>
                                <td width="20%">Date:</td>
                                <td style="padding: 5px 0;"><input type="text" class="" style="max-width: 250px" name="" readonly="readonly" value="<?php echo date('Y-m-d', strtotime($credit->date_time)); ?>"></td>
                            </tr>
                            <tr>
                                <td width="20%">Customer:</td>
                                <td style="padding: 5px 0;"><input type="text" class="form-control" style="max-width: 250px" name="" readonly="readonly" value="<?php echo $credit->customer_name; ?>"></td>
                            </tr>
                        </table> 
                    </div>

                    <div class="col-md-12">
                        <h4>ORDER DESCRIPTION</h4>
                        <div id="order-tbl">
                            <table class="table table-bordered has-footer">
                            <thead>
                                <tr>
                                    <td width="10%">Qty</td>
                                    <td width="60%">Description</td>
                                    <td width="15%" class="text-right">Unit Price</td>
                                    <td width="15%" class="text-right">Amount</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orderline as $order): ?>
                                    <tr>
                                        <td><?php echo $order->quantity; ?></td>
                                        <td><?php echo $order->name; ?></td>
                                        <td class="text-right"><?php echo currency() . number_format($order->price,2); ?></td>
                                        <td class="text-right"><?php echo currency() . number_format($order->quantity * $order->price, 2); ?></td>
                                    </tr>
                                    <?php $total+= $order->quantity * $order->price; ?>
                                <?php endforeach; ?>
                                
                            </tbody> 
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="tfoot" ></td>
                                    <td colspan="1" class="text-left" ><b>AMOUNT PAID</b></td>
                                    <td class="text-right" ><?php echo currency() . ($paid > 0 ? number_format($paid,2) : 0)  ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"  class="no-border tfoot">Note: <input readonly="readonly" id="note" type="text" value="<?php echo $credit->note; ?>" style="max-width: 550px;" class="form-control editable" name="note"></td
>                                    <td colspan="1"  class="text-left tfoot"><b>TOTAL</b></td>
                                    <td class="text-right no-border"><?php echo currency() . number_format($total,2) ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="no-border tfoot"></td>
                                    <td colspan="1" class="text-left no-border tfoot"><b>BALANCE</b></td>
                                    <td class="text-right no-border tfoot"><?php echo currency() . number_format($total,2) ?></td>
                                </tr>
                            </tfoot>
                            
                        </table> 
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4>PAYMENTS RECORDS</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>DATE</th>
                                    <th>AMOUNT</th>
                                    <th>NOTE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($payments_history): ?>
                                    <?php foreach ($payments_history as $history): ?>
                                    <tr>
                                        <td><?php echo $history->date ?></td>
                                        <td><?php echo $history->amount ?></td>
                                        <td><?php echo $history->note ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="2" class="text-right">TOTAL</td>
                                        <td class="text-right"><?php echo currency() . ($paid > 0 ? number_format($paid,2) : 0) ?></td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center">No payment record exist</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12" style="margin-top: 20px;">
                        <a href="<?php echo base_url('payments/new/' . $credit->transaction_number) ?>" class="btn btn-default"><i class="fa fa-money"></i> ADD PAYMENT</a>
                        <a href="<?php echo base_url('TransactionsController/pdf_invoice/' . $credit->transaction_number) ?>" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> GENERATE INVOICE</a>

                        <button id="edit-note" class="btn btn-default"><i class="fa fa-edit"></i> Edit Note</button> 
                        <button id="save-note" class="btn btn-primary"><i class="fa fa-save"></i> Save Note</button>
                    </div>

                </div>
            </div> 
        </div> 
    </div>

</div>

<style type="text/css">
    #order-tbl tfoot td {
        border:0 !important;
        padding: 3px!important;
        line-height: 1.5;
    }

    #order-tbl tfoot tr:first-child td {
        border-top: solid 1px #ddd!important;
        padding-top: 10px!important;
    }

    #order-tbl .table-bordered {
        border-bottom: 0;
        border-right:0;
        border-left: 0;
    }

    input[readonly] {
        background-color: #fff!important;
    }

    #order-tbl .table-bordered tr td:first-child {
        border-left: solid 1px #ddd;
    }

    #order-tbl .table-bordered tr td:last-child {
        border-right: solid 1px #ddd;
    }

    .editable {
        padding: 0;
        border:0;
    }

    .editable:focus, .editable:active {
       outline: none;
       border-color: inherit;
  -webkit-box-shadow: none;
  box-shadow: none;
    }
    .editable:hover {
        cursor: unset;
    }

    .editable-na:hover {
        cursor: text;
    }

    #save-note {
        display: none;
    }

</style>

<script type="text/javascript">
    
    $(document).ready(function(e) {

        var base_url = $("meta[name='base_url']").attr('content');  
        var csrfName = $("meta[name='csrfName']").attr('content');
        var csrfHash = $("meta[name='csrfHash']").attr("content");

        $("#edit-note").click(function(e) {

            $(".editable").addClass("editable-na").removeClass("editable").removeAttr("readonly").focus();

            $(this).hide();

            $("#save-note").show();

        });

         
        $("#save-note").click(function(e) {
            
            var data = {};
            data[csrfName] = csrfHash;
            data['note'] = $("#note").val();
            data['id'] = '<?php echo $credit->id ?>';
            $.ajax({
                type: "POST",
                url : base_url + "TransactionsController/update_note",
                data: data,
                success : function(e) {

                    $(".editable-na").addClass("editable").removeClass("editable-na").attr("readonly", "readonly");

                    alert("Note saved successfully");

                    $("#save-note").hide();

                    $("#edit-note").show();
                }
            });
        })
    })
</script>

