<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Suppliers </h1>
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
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
       Purchase Order
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
              <td><?php $this->load->view('components/product_selector') ?></td>
              <td><input type="text" class="form-control" name="quantity[]"></td>
              <td><input type="text" class="form-control" name="price[]"></td>
              <td><input type="text" class="form-control" name="sub[]" readonly="readonly"></td>
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
          <button class="btn btn-sm btn-default" id="new-line"><i class="fa fa-plus"></i> Add New Line</button> &nbsp;
          <button class="btn btn-sm btn-default" id="remove-line"><i class="fa fa-close"></i> Remove Line</button>
        </div>
      </div> 
    </div> 
  </div> 
</div>


