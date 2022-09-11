<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">New Order</h1> 
    </div> 
</div> 
<div class="row">   
    <div class="col-lg-12">
        <div class="panel panel-default" style="padding:20px">
            <form>
                <div class="row">
                    <div class="col-md-6 ">
                        <div style="background-color: #f4f4f5;padding: 20px">
                            <table id="order-details" width="100%" >
                                <tr>
                                    <td>Order Number: &nbsp;</td>
                                    <td><input type="text" value="TRN1001910" readonly class="form-control"/></td>
                                </tr>
                                <tr>
                                    <td>Customer: &nbsp;</td>
                                    <td><input type="text" value="John Doe"  class="form-control"/></td>
                                </tr>
                            </table>
                        </div> 
                    </div> 
                    <div class="col-md-6">
                        <div style="background-color: #f4f4f5;padding: 20px"> 
                            <table id="order-details" width="100%" >
                                <tr>
                                    <td>Date: &nbsp;</td>
                                    <td><input type="text" value="2022-10-10" readonly class="form-control"/></td>
                                </tr>
                                <tr>
                                    <td>Remarks: &nbsp;</td>
                                    <td><input type="text" value="New customer order"  class="form-control"/></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <hr/>
                <h3>Order Details</h3>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Lucky Me pancit canton</td>
                            <td>7.50</td>
                            <td><span class="pull-right">5</span></td>
                            <td><span class="pull-right">30</span></td>
                        </tr>
                        <tr>
                            <td>Lucky Me pancit canton</td>
                            <td>7.50</td>
                            <td><span class="pull-right">5</span></td>
                            <td><span class="pull-right">30</span></td>
                        </tr>
                        <tr>
                            <td>Lucky Me pancit canton</td>
                            <td>7.50</td>
                            <td><span class="pull-right">5</span></td>
                            <td><span class="pull-right">30</span></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"><span class="pull-right">Total</span></td>
                            <td><span class="pull-right">300</span></td>
                        </tr>
                    </tfoot>
                </table>
                <div style="background-color: #f4f4f5;padding: 20px">
                    <label>Custom Field</label>
                    <table id="order-details" width="100%" >
                        <tr>
                            <td width="40%" style="padding-right:20px"><input type="text" placeholder="ex. Tracking Number"  class="form-control"/></td>
                            <td><input type="text" placeholder="1100100"  class="form-control"/></td>
                        </tr> 
                    </table>
                    <button class="btn btn-primary btn-sm" type="button">Add Custom Field</button>
                </div>
                <br/>
                <button class="btn btn-success pull-right">Create Order</button>
                <div class="clear-both"></div>
                <br/>
                <br/>
            </form>
        </div>
    </div> 
</div>
