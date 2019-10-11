<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Suppliers </h1>
  </div>
  <!-- /.col-lg-12 -->
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
       Purchase Order
      </div> 
      <div class="panel-body">
        <table class="table" id="products-table">
          <thead>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Sub Total</th>
          </thead>
          <tbody>
            <tr>
              <td><?php $this->load->view('components/product_selector') ?></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table> 
        <div>
          <button class="btn btn-sm btn-default" id="new-line"><i class="fa fa-plus"></i> Add New Line</button>
        </div>
      </div> 
    </div> 
  </div> 
</div>

<div style="display: none;">
  <tr id="line">
    <td><?php $this->load->view('components/product_selector') ?></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</div>

