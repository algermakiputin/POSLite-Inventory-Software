<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Stock Out Items</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Out of Stocks Items
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
					 
						<hr>
					</div>
				 	<?php foreach ($items as $item): ?>
				 		<?php echo form_open('ItemController/add_stocks', ['methods' => 'POST']) ?> 
							<div class="col-md-6 form-group">
								<div class="col-md-4">
									<?php echo ucwords($item->name) ?>:
									<input type="hidden" name="item_id" value="<?php echo $item->id ?>">
									<input type="hidden" name="item_name" value="<?php echo $item->name ?>">
								</div>
								<div class="col-md-8">

                                        <div class="input-group">
                                            <input type="number" <?php if (SITE_LIVE) echo 'max="500"'; ?> data-parsley-errors-container="#error<?php echo $item->id ?>" required autocomplete="off" name="stocks" class="form-control" placeholder="Stocks to add">
                                            <span class="input-group-btn">
								        <button class="btn btn-default" type="submit">Stock-in</button>
								      </span>
                                        </div>

                                    <div id="error<?php echo $item->id ?>"></div>
								</div>
								 
							</div>
						<?php echo form_close() ?>
					<?php endforeach; ?>
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>  


 


