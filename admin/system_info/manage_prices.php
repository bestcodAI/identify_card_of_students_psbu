<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="content py-5 px-3 bg-gradient-olive">
	<h2><b>Manage Ticket Prices</b></h2>
</div>
<div class="row mt-lg-n4 mt-md-n4 justify-content-center">
	<div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
        <div class="card rounded-0 shadow">
            <div class="card-body">
                <form action="" id="system-frm">
                    <div id="msg" class="form-group"></div>
                    <div class="form-group">
                        <label for="adult_price" class="control-label">Adult Price</label>
                        <input type="number" class="form-control form-control-sm rounded-0 text-right" name="adult_price" id="adult_price" value="<?php echo ($_settings->info('adult_price') > 0) ? $_settings->info('adult_price') : 0 ?>">
                    </div>
                    <div class="form-group">
                        <label for="child_price" class="control-label">Child Price</label>
                        <input type="number" class="form-control form-control-sm rounded-0 text-right" name="child_price" id="child_price" value="<?php echo  ($_settings->info('child_price') > 0) ? $_settings->info('child_price') : 0 ?>">
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="col-md-12">
                    <div class="row">
                        <button class="btn btn-sm btn-primary" form="system-frm">Update Prices</button>
                    </div>
                </div>
            </div>

        </div>
	</div>
</div>
<script>
</script>