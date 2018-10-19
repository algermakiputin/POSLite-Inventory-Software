<?php
class Get extends CI_Controller {
	public function __construct() {
		parent::__construct();
		if (!$this->session->userdata('log_in')) {
			$this->session->set_flashdata('errorMessage','<div class="alert alert-danger">Login Is Required</div>');
			redirect(base_url('login'));
		}
	}
	public function item_info() {
		$name = "";
		$price = "";
		$description = "";
		$item_name = $this->input->post('item_name');
		$this->load->model('PriceModel');

		$this->load->model('ajax_model');

		if ($item_info = $this->ajax_model->item_info($item_name)) {

			$name = $item_info->name;
			$price = $this->PriceModel->getPrice($item_info->id);
			$description = $item_info->description;
			?>
			<div class="lb">
			<label id="name">Item Name : <?php echo $name ?></label>
			</div>
			<div class="lb">
				<label id="prc">Price : ₱<span id="price"><?php echo $this->PriceModel->getPrice($item_info->id) ?></span></label>
				<input type="hidden" name="price_id" id="price_id" value="<?php echo $item_info->id ?>">
			</div>
			<div class="lb">
				<label id="description">Description : <?php echo $description ?></label>
			</div>
			<?php
		}else {
			?>
			<div class="lb">
			<label id="name">No Item Found</label>
			</div>
			<?php
		}
		

		
	}

	public function cart() {
		$item_name = $this->input->post('item_name');
		$price = $this->input->post('price');
		$quantity = $this->input->post('quantity');
		$total = $this->input->post('total');
		$price_id  = $this->input->post('price_id');
		$this->load->model('ajax_model');

		if ($item_info = $this->ajax_model->item_info($item_name)) {
			$id = $item_info->id;
		$sub_total = (double)substr($price,0) * (double)$quantity;
		$amount_due = (double)$total + $sub_total;
		$cart = [$id,$item_name,$quantity,$price,$sub_total];
		$json = json_encode($cart);
		echo "

		<tr>
			<td>$id</td>
			<td>$item_name</td>
			<td>$quantity</td>
			<td>₱$price</td>
			<td>₱$sub_total</td>
			<input type='hidden' class='price_id' value='$price_id'>
		</tr>

		";
		echo "<script>

		$('#amount_due').html('₱' +$amount_due);
		</script>";
		}else {
			echo "
			<script>
				alert('No Item Found');
			</script>
			";

		}
		
	}
}

?>
