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
        max-height: 20em;
        object-fit:scale-down;
        object-position:center center;
    }
</style>
<div class="content py-5 px-3 bg-gradient-olive">
	<h2><b>Ticket Details</b></h2>
</div>
<div class="row mt-lg-n4 mt-md-n4 justify-content-center">
	<div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
		<div class="card rounded-0">
			<div class="card-body">
                <div class="container-fluid" id="printout">
                    <div class="d-flex w-100 mb-2">
                        <div class="col-auto pr-1">Ticket:</div>
                        <div class="col-auto flex-shrink-1 flex-grow-1 font-weight-bolder"><?= isset($code) ? $code : '' ?></div>
                    </div>
                    <div class="d-flex w-100 mb-2">
                        <div class="col-auto pr-1">Visit Date:</div>
                        <div class="col-auto flex-shrink-1 flex-grow-1 font-weight-bolder"><?= isset($date_created) ? date('M d, Y h:i A', strtotime($date_created)) : '' ?></div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center px-2 py-1"></th>
                                <th class="text-center px-2 py-1">Ticket Price</th>
                                <th class="text-center px-2 py-1">Ticket of Ticket</th>
                                <th class="text-center px-2 py-1">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="px-2 py-1">Adult</th>
                                <td class="px-2 py-1 text-right"><?= format_num(isset($adult_price) ? $adult_price : 0) ?></td>
                                <td class="text-right px-2 py-1"><?= format_num(isset($adult_no) ? $adult_no : 0) ?></td>
                                <td class="text-right px-2 py-1"><?= format_num(isset($adult_price) ? ($adult_price * $adult_no) : 0) ?></td>
                            </tr>
                            <tr>
                                <th class="px-2 py-1">Child</th>
                                <td class="px-2 py-1 text-right"><?= format_num(isset($child_price) ? $child_price : 0) ?></td>
                                <td class="text-right px-2 py-1"><?= format_num(isset($child_no) ? $child_no : 0) ?></td>
                                <td class="text-right px-2 py-1"><?= format_num(isset($child_price) ? ($child_price * $child_no) : 0) ?></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-center px-2 py-1">Total</th>
                                <th class="text-right px-2 py-1"><?= format_num(isset($id) ? (($adult_price * $adult_no) + ($child_price * $child_no)) : 0, 2) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
			<div class="card-footer py-1 text-center">
				<button class="btn btn-navy btn-sm bg-gradient-navy rounded-0" type="button" id="print"><i class="fa fa-print"></i> Print</button>
				<a class="btn btn-primary btn-sm bg-gradient-primary rounded-0" href="./?page=tickets/manage_ticket&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-edit"></i> Edit</a>
				<button class="btn btn-danger btn-sm bg-gradient-danger rounded-0" type="button" id="delete_data"><i class="fa fa-trash"></i> Delete</button>
				<a class="btn btn-light btn-sm bg-gradient-light border rounded-0" href="./?page=tickets"><i class="fa fa-angle-left"></i> Back to List</a>
			</div>
		</div>
	</div>
</div>
<noscript id="print-header">
    <div>
        <div style="line-height:1em">
            <div class="text-center font-weight-bold"><large><?= $_settings->info('name') ?></large></div>
            <div class="text-center font-weight-bold"><large>Ticket Details</large></div>
        </div>
    </div>
</noscript>
<script>
    function print_t(){
        var h = $('head').clone()
        var el = $('#printout').clone()
        var ph = $($('noscript#print-header').html()).clone()
        h.find('title').text("Ticket Details - Print View")
        var nw = window.open("", "_blank", "width="+($(window).width() * .8)+",left="+($(window).width() * .1)+",height="+($(window).height() * .8)+",top="+($(window).height() * .1))
            nw.document.querySelector('head').innerHTML = h.html()
            nw.document.querySelector('body').innerHTML = ph[0].outerHTML
            nw.document.querySelector('body').innerHTML += el[0].outerHTML
            nw.document.close()
            start_loader()
            setTimeout(() => {
                nw.print()
                setTimeout(() => {
                    nw.close()
                    end_loader()
                }, 200);
            }, 300);
    }
    $(function(){
        $('#print').click(function(){
            print_t()
        })
        
		$('#delete_data').click(function(){
			_conf("Are you sure to delete this Ticket permanently?","delete_ticket", ["<?= isset($id) ? $id :'' ?>"])
		})
    })
    function delete_ticket($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_ticket",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.replace("./?page=tickets");
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>
