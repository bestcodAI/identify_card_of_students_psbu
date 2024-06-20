<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `ticket_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<style>
	#ticket-logo{
		max-width:100%;
		max-height:20em;
		object-fit:scale-down;
		object-position:center center;
	}
</style>
<div class="content py-5 px-3 bg-gradient-olive">
	<h2><b><?= isset($id) ? "Update Ticket's Details" : "New Ticket Entry" ?></b></h2>
</div>
<div class="row mt-lg-n4 mt-md-n4 justify-content-center">
	<div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
		<div class="card rounded-0">
			<div class="card-body">

				<div class="container-fluid">
					<form action="" id="ticket-form">
						<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
						<div class="form-group">
							<label for="adult_price" class="control-label">Ticket Price for Adult.</label>
							<input type="number" name="adult_price" id="adult_price" class="form-control form-control-sm rounded-0 text-right" value="<?php echo isset($adult_price) ? $adult_price : ($_settings->info('adult_price') ? $_settings->info('adult_price') : 0); ?>"  required readonly/>
						</div>
						<div class="form-group">
							<label for="adult_no" class="control-label">Number of Adult.</label>
							<input type="number" name="adult_no" id="adult_no" class="form-control form-control-sm rounded-0 text-right" value="<?php echo isset($adult_no) ? $adult_no : 0; ?>"  required/>
						</div>
						<div class="form-group">
							<label for="child_price" class="control-label">Ticket Price for Child</label>
							<input type="number" name="child_price" id="child_price" class="form-control form-control-sm rounded-0 text-right" value="<?php echo isset($child_price) ? $child_price : ($_settings->info('child_price') ? $_settings->info('child_price') : 0); ?>"  required readonly/>
						</div>
						<div class="form-group">
							<label for="child_no" class="control-label">Number of Child</label>
							<input type="number" name="child_no" id="child_no" class="form-control form-control-sm rounded-0 text-right" value="<?php echo isset($child_no) ? $child_no : 0; ?>"  required/>
						</div>
						<div class="form-group">
							<label for="total" class="control-label">Ticket Price for Child</label>
							<input type="number" id="total" class="form-control form-control-sm rounded-0 text-right" value="<?php echo isset($id) ? (($adult_price * $adult_no) + ($child_price * $child_no)) : 0; ?>"  required readonly/>
						</div>
					</form>
				</div>
			</div>
			<div class="card-footer py-1 text-center">
				<button class="btn btn-primary btn-sm bg-gradient-primary btn-flat" form="ticket-form"><i class="fa fa-save"></i> Save</button>
				<a class="btn btn-light btn-sm bg-gradient-light border btn-flat" href="./?page=tickets"><i class="fa fa-times"></i> Cancel</a>
			</div>
		</div>
	</div>
</div>
<script>
	function calc_total(){
		var ap = $('#adult_price').val()
		var an = $('#adult_no').val()
		var cp = $('#child_price').val()
		var cn = $('#child_no').val()
		an = an > 0 ? an : 0;
		cn = cn > 0 ? cn : 0;
		var total = (parseFloat(parseFloat(ap) * parseFloat(an)) + parseFloat(parseFloat(cp) * parseFloat(cn)))
		$('#total').val(total)
	}
	function displayImg(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#ticket-logo').attr('src', e.target.result);
	        	$(input).siblings('.custom-file-label').html(input.files[0].name)
	        }
	        reader.readAsDataURL(input.files[0]);
	    }else{
			$('#ticket-logo').attr('src', '<?= validate_image(isset($image_path) ? $image_path : '') ?>');
			$(input).siblings('.custom-file-label').html(input.files[0].name)
		}
	}
	$(document).ready(function(){
		$('#adult_no, #child_no'). on('input change', function(){
			calc_total()
		})
		if('<?= isset($id) ?>' == 1){
			calc_total()
		}
		$('#ticket-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_ticket",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.replace('./?page=tickets/view_ticket&id='+resp.tid)
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})

	})
</script>