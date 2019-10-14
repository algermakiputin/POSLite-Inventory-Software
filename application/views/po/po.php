<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">New Purchase Order </h1>
  </div>
  <!-- /.col-lg-12 -->
</div>
<div style="display: none;">
  <tr id="line">
    <td><?php $this->load->view('components/product_selector') ?></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</div>

<div class="row">
  <?php echo form_open("PurchaseOrderController/save_po"); ?>
  <div class="col-lg-3">

    <div class="panel panel-default">
      <div class="panel-heading">
       Details
     </div>  
     <div class="panel-body">
      <div class="form-group">
        <label>P.O. NO.:</label>
        <input type="text" value="<?php echo $po_number ?>" readonly="readonly"  required="required" class="form-control" name="po_number">
      </div>
      <div class="form-group">
        <label>Date:</label>
        <input type="date" required="required" class="form-control" name="date">
      </div>
      <div class="form-group">
        <label>Supplier</label>
        <select class="form-control" name="supplier" required="required">
          <option value="">Select Supplier</option>
          <?php foreach ($suppliers as $supplier): ?>
            <option value="<?php echo $supplier->id ?>"
              data-company="<?php echo $supplier->company ?>"
              data-address="<?php echo $supplier->address ?>"
              data-province="<?php echo $supplier->province ?>"
              data-city="<?php echo $supplier->city ?>"
              data-country="<?php echo $supplier->country ?>"
              ><?php echo $supplier->name; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label>Ship to:</label>
          <input type="text" required="required" class="form-control" name="shipto">
        </div>
        <div class="form-group">
          <label>Memo:</label>
          <textarea class="form-control" name="memo" rows="3"></textarea>
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
      <table class="table" id="products-table" style="border-bottom: solid 1px #ddd;">
        <thead>
          <th>Product Name</th>
          <th>Quantity</th>
          <th>Unit Price</th>
          <th>Sub Total</th>
        </thead>
        <tbody>
          <tr> 
            <td>
              <input type="text" autocomplete="off" class="form-control product" required="required" name="product[]">
              <input type="hidden" name="product_id[]"></td>
              <td><input type="number" required="required" autocomplete="off" class="form-control quantity" name="quantity[]"></td>
              <td><input type="text" required="required" autocomplete="off" class="form-control" name="price[]"></td>
              <td><input type="text" autocomplete="off" class="form-control" name="sub[]" readonly="readonly"></td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3" class="text-right"><b>Total:</b></td>
              <td><span id="grand-total">0.0</span></td>
            </tr>
          </tfoot>
        </table> 
        <div class="actions"> 
          <button type="button" class="btn btn-sm btn-default" id="new-line"><i class="fa fa-plus"></i> Add New Line</button> &nbsp;
          <button type="button" class="btn btn-sm btn-default" id="remove-line"><i class="fa fa-close"></i> Remove Line</button>
        </div>
      </div> 
    </div> 
  </div> 
  <div class="col-md-12 text-right">
    <hr>
    <div class="form-group">
      <button class="btn btn-info" type="button" id="pdf">PDF</button>
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </div>
  <?php echo form_close(); ?>
</div>


<script src="<?php echo base_url('assets/js/jquery-autocomplete.js') ?>"></script>
<script src="<?php echo base_url('assets/js/po.js') ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {
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

      tbody.append("<tr id='row"+index+"'>"+ row +"</tr>");
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
        var price = parseFloat(order_row.find("input[name='price[]']").val());
        var qty = parseInt(order_row.find("input[name='quantity[]']").val()) || 0;
        var sub = price * qty
        if (item_id && qty && price) {
          subtotal += sub;

          order_row.find("input[name='sub[]']").val(currency + number_format(sub));
        } 
      }

      total = subtotal;
      $("#grand-total").text(currency + number_format(total));

    }

    $("#pdf").click(function(e) {
      var supplier = $("select[name='supplier']");
      var supplier_option = supplier.find("option:selected")
      var supplier_data = {
        name: supplier_option.text(),
        address: supplier_option.data('address'),
        province: supplier_option.data('province'),
        city: supplier_option.data('city'),
        country: supplier_option.data('country'),
      } 
 
      var po_number = $("[name='po_number']").val();
      var po_date = $("[name='date']").val();
      var shipto = $("[name='shipto']").val();

      var items = [
      [ {text: 'PRODUCT', bold: true, fillColor:"#4f90bb", color: "#fff"}, 
        {text: 'QTY', bold: true, fillColor:"#4f90bb", color: "#fff"}, 
        {text: 'PRICE', bold: true, fillColor:"#4f90bb", color: "#fff"}, 
        {text: 'AMOUNT', bold: true, fillColor:"#4f90bb", color: "#fff"}]
      ];
      var total = 0;
      var order = $("#products-table tbody tr");

      for (i = 0; i < order.length; i++) { 
        var line = $(order[i]);
        var product = line.find("[name='product[]']").val();
        var qty = line.find("[name='quantity[]']").val();
        var price = line.find("[name='price[]']").val();
        var sub = line.find("[name='sub[]']").val();

        if (product && qty && price && sub) {


          items.push([product, qty, price, sub]);

          total += qty * price;
        } 
      }

      if (po_date == "") {
        return alert("Purchase Order date is required");
      }

      if (shipto == "") {
        return alert("Ship to is required");
      }

      if (supplier == "") {
        return alert("Supplier is required");
      } 

      if (items.length > 1) {
        var pdfmake = pdfMake; 

        var docDefinition = generate_pdf(items, 'PHP' + number_format(total), po_number,po_date, shipto,supplier_data, image);

        var pdf = pdfmake.createPdf(docDefinition);
        pdf._openPdf();
      }else {
        alert("Orders are empty please add at least one(1)");
      }
      
    })

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