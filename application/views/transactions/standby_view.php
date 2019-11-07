<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">STANDBY ORDER: <?php echo $transaction->transaction_number; ?></h1>
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
  <?php echo form_open("TransactionsController/update_standby_order"); ?>
  <input type="hidden" name="sales_id" value="<?php echo $transaction->id; ?>">
  <div class="col-lg-12">
    <div style="border:border-radius: 5px;">
      <table style="font-size: 15px;line-height: 1.6;">
        <tr>
          <td>CUSTOMER NAME: &nbsp;</td>
          <td><?php echo $transaction->customer_name; ?></td>
        </tr>
        <tr>
          <td>DATE & Time: &nbsp;</td>
          <td><?php echo date('m/d/Y h:i A', strtotime($transaction->date_time)); ?></td>
        </tr>
        <tr>
          <td>STAFF: &nbsp;</td>
          <td>Staff Name</td>
        </tr> 
        <tr>
          <td>STATUS: &nbsp;</td>
          <td><?php echo $transaction->status ? "<span class='badge badge-success'>Complete</span>" : "<span class='badge badge-warning'>Pending Payment</span>"?></td>
        </tr> 
      </table>
      <br/>
      <h4>ORDER DETAILS</h4>     
      <table class="table table-bordered" id="products-table" style="border-bottom: solid 1px #ddd;table-layout: fixed;"> 
        <thead>
          <th>Product Name</th>
          <th>Quantity</th>
          <th>Unit Price</th>
          <th>Sub Total</th>
          <th width="50px"></th>
        </thead>
        <tbody>
          
            <?php foreach ($orderline as $order): ?>
              <tr> 
              <td>
                <input type="text" autocomplete="off" class="form-control product" required="required" name="product[]" value="<?php echo $order->name; ?>">
                <input type="hidden" name="product_id[]" value="<?php echo $order->product_id; ?>">
              </td>
              <td>
                <input type="number" value="<?php echo $order->quantity; ?>" required="required" autocomplete="off" class="form-control quantity" name="quantity[]">
              </td>
              <td>
                <input type="text" value="<?php echo $order->price; ?>" required="required" autocomplete="off" class="form-control" name="price[]"></td>
              <td>
                <input type="text" autocomplete="off" value="<?php echo currency() . number_format($order->price * $order->quantity); ?>" class="form-control" name="sub[]" readonly="readonly"></td>
              <td><i class="fa fa-trash delete-row"></i></td>
            </tr>
            <?php $total+= $order->price * $order->quantity; ?>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3" class="text-right"><b>Total:</b></td>
            <td class="text-right" style="font-size: 16px;"><span id="grand-total"><?php echo currency() . number_format($total) ?> </span></td>
            <td></td>
          </tr>
        </tfoot>
      </table> 
      <div class="actions"> 
        <button type="button" class="btn btn-sm btn-default" id="new-line"><i class="fa fa-plus"></i> Add New Line</button> &nbsp;
        <button type="button" class="btn btn-sm btn-default" id="remove-line"><i class="fa fa-close"></i> Remove Line</button>
      </div>
    </div>
  </div> 

  <div class="col-md-3 col-md-offset-9">
    <div style="width: ">
      <div class="form-group text-right">
        <label>ENTER PAYMENT:</label>
        <input type="text" autocomplete="off" name="" id="payment" class="form-control">
      </div>
      <div class="form-group text-right">
        <label>CHANGE:</label>
        <input type="text" autocomplete="off" name="" id="change" readonly="readonly" class="form-control">
      </div>
    </div>
  </div>

  <div class="col-md-12 text-right">
    <hr>
    <div class="form-group"> 
      <button type="button" class="btn btn-default" id="complete-transaction"><i class="fa fa-save"></i> Complete Transaction</button>
      <button type="submit" class="btn btn-default"><i class="fa fa-refresh"></i> Update</button>
    </div>
  </div>
  <?php echo form_close(); ?>
  <?php echo form_open("TransactionsController/complete", ['id' => 'transaction-form', 'style' => 'display:none']) ?>
    <input type="hidden" name="sales_id" value="<?php echo $transaction->id; ?>">
    <input type="submit" name="">
  <?php echo form_close(); ?>
</div>
<style type="text/css">
.delete-row:hover {
  cursor: pointer;
}
</style>

<script src="<?php echo base_url('assets/js/jquery-autocomplete.js') ?>"></script> 
<script type="text/javascript">
  $(document).ready(function() { 
    
    var status = '<?php echo $transaction->status ?>';

    if (status) {

      $('input').attr("readonly", "readonly");
      $('.delete-row').hide();
      $("#complete-transaction").hide();
      $("button[type='submit']").hide();
      $("#remove-line").hide();
      $("#new-line").hide();
    }
    // Romove row when trash icon is clicked
    $("body").on("click", ".delete-row", function() { 
      var confirm = window.confirm("Action cannot be undo.. Are you sure you want to delete that order?");

      if (confirm) {
        $(this).parents("tr").remove();
        calculate_total_po_order();
      }

    });

    $("#complete-transaction").click(function() {
      var grand_total = parseFloat(no_format($("#grand-total").text()));
      var payment = parseFloat($("#payment").val()) || 0;
      
      if (payment >= grand_total) {
        $("#transaction-form").submit();
        alert("good")
      }else {
        alert("Insufficient payment amount")
      }
       
    })

    $("#payment").keyup(function(e) {
      var grand_total = parseFloat(no_format($("#grand-total").text()));

      var payment = parseFloat($(this).val()) || 0;

      if (payment >= grand_total) {
        $("#change").val(payment - grand_total);
      }else {
        $("#change").val("Insufficient payment amount");
      }


    })

    var row = $("#products-table tbody tr:first-child").html();
    var tbody = $("#products-table tbody");
    var index = 1;
    var products = JSON.parse('<?php echo $products ?>');
    var total = 0;
    var currency = "<?php echo currency(); ?>";
    var image = "<?php echo $image_base64 ?>"; 

    $(".product").autocomplete({
      lookup: products,
      onSelect: function(suggestion) { 
        $(this).parents("tr").find("input[name='price[]']").val(suggestion.capital)
        $(this).parents("td").find("input[name='product_id[]']").val(suggestion.data);
      }
    });



    $("#new-line").click(function(e) {

      tbody.append("<tr id='row"+index+"'>"+ '<td><input type="text" autocomplete="off" class="form-control product" required="required" name="product[]"><input type="hidden" name="product_id[]"></td><td><input type="number" required="required" autocomplete="off" class="form-control quantity" name="quantity[]"></td><td><input type="text" required="required" autocomplete="off" class="form-control" name="price[]"></td><td><input type="text" autocomplete="off" class="form-control" name="sub[]" readonly="readonly"></td><td><i class="fa fa-trash delete-row"></i></td>' +"</tr>");
      var rowIndex =  $("#row" + index);
      
      rowIndex.find(".product").autocomplete({
        lookup: products,
        onSelect: function(suggestion) {
          $(this).parents("tr").find("input[name='price[]']").val(suggestion.capital)
          $(this).parents("td").find("input[name='product_id[]']").val(suggestion.data);
        }
      }) 
      index++;

      calculate_total_po_order();

    });  

    $("body").on("keyup", ".quantity", function() {
      calculate_total_po_order();
    }); 

    function calculate_total_po_order() {
      var rows = $("#products-table tbody tr");
      var length = rows.length;
      var subtotal = 0; 

      for (i = 0; i < length; i++) {

        var order_row = $(rows[i]);
        var item_id = order_row.find("input[name='product_id[]']").val();
        var price = parseFloat(order_row.find("input[name='price[]']").val()) || 0;
        var qty = parseInt(order_row.find("input[name='quantity[]']").val()) || 0;
        var sub = price * qty;
         
        subtotal += sub
        order_row.find("input[name='sub[]']").val(currency + number_format(sub)); 

      } 
    
      $("#grand-total").text(currency + number_format(subtotal));

    }
 

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

    function no_format(str) {

      return parseFloat(((str.slice(1).replace(/,/g, ""))));
    }


  })

</script>