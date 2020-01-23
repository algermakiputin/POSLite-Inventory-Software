<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">New Sale </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div style="display: none;">
    <tr id="line">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</div>

<div class="row">
    <div class="col-lg-12">
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
    <?php echo form_open("PurchaseOrderController/save_po"); ?>
        <div class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Details
                </div>
                <div class="panel-body"> 
                    <div class="form-group">
                        <label>Enter Invoice Number</label>
                        <input type="text" required="required" class="form-control" id="invoice-number" name="invoice_number">
                        <input type="hidden" name="store_number" id="store-number">
                        <input type="hidden" name="type" value="internal">
                    </div> 
                    <div class="form-group">
                        <label>Customer Name:</label>
                        <input type="text" readonly required="required" class="form-control" name="customer_name" id="customer_name">
                        <input type="hidden" name="customer_id" readonly required="required" id="customer_id">
                    </div> 

                    <div class="form-group">
                        <label>Transaction Type</label>
                        <select class="form-control" name="type">
                            <option value="cash">Cash</option>
                            <option value="credit">Credit</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Note</label>
                        <input type="text" class="form-control" name="note">
                    </div>
                    <div class="form-group ">
                        <button class="btn btn-default btn-sm" type="button" id="enter-invoice">Enter</button>
                    </div>
                </div> 
            </div>
        </div>
        <div class="col-lg-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Items
                </div>
                <div class="panel-body">
                    <table class="table" id="products-table" style="border-bottom: solid 1px #ddd;table-layout: fixed;">
                        <thead>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Sub Total</th>
                            <th width="50px">&nbsp;</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" readonly="readonly" autocomplete="off" class="form-control product" required="required" name="product[]">
                                    <input type="hidden" name="product_id[]">
                                </td>
                                <td>
                                    <input type="number" required="required" autocomplete="off" class="form-control quantity" name="quantity[]">
                                </td>
                                <td>
                                    <input type="text" required="required" autocomplete="off" class="form-control" name="price[]">
                                </td>
                                <td>
                                    <input type="text" autocomplete="off" class="form-control" name="sub[]" readonly="readonly">
                                </td>
                                <td><i class="fa fa-trash delete-row"></i> &nbsp;</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right"><b>Total:</b></td>
                                <td><span id="grand-total">0.0</span></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="actions">
                        <!-- <button type="button" class="btn btn-sm btn-default" id="new-line"><i class="fa fa-plus"></i> Add New Line</button> &nbsp;
            <button type="button" class="btn btn-sm btn-default" id="remove-line"><i class="fa fa-close"></i> Remove Line</button> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-right">
            <hr>
            <div class="form-group">
           <!--      <button class="btn btn-info" type="button" id="pdf">PDF</button> -->
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        <?php echo form_close(); ?>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        
        function number_format(number, decimals, dec_point, thousands_point) {

            if (number == null || !isFinite(number)) {
                throw new TypeError("number is not valid");
            }

            if (!decimals) {
                var len = number.toString().split('.').length;
                decimals = len > 1 ? len : 0;
            }

            if (!dec_point) {
                dec_point = '.';
            }

            if (!thousands_point) {
                thousands_point = ',';
            }

            number = parseFloat(number).toFixed(decimals);

            number = number.replace(".", dec_point);

            var splitNum = number.split(dec_point);
            splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
            number = splitNum.join(dec_point);

            return number;
        }
 

    })
</script>