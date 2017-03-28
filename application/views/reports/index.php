<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<strong class="panel-title"><?= lang('option') ?></strong>
			</div>
			<div class="panel-body" id="panQuotationInfo">
				<form class="form-horizontal" method="get" id="frmReportOption">
				  	<div class="form-group">
				        <label for="txtFromDate" class="col-sm-3 control-label"><?= lang('from_date') ?></label>
				        <div class="col-sm-9">
				            <div class="datepicker-box">
				                <div class="input-group">
				                    <input type="text" name="fromdate" id="txtFromDate" class="form-control datepicker" value="<?= $fromDate ?>" readonly>
				                    <span class="input-group-btn">
				                        <button class="btn btn-default btn-date" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
				                    </span>
				                </div>
				            </div>
				        </div>
				    </div>
				  	<div class="form-group">
				        <label for="txtToDate" class="col-sm-3 control-label"><?= lang('to_date') ?></label>
				        <div class="col-sm-9">
				            <div class="datepicker-box">
				                <div class="input-group">
				                    <input type="text" name="todate" id="txtToDate" class="form-control datepicker" value="<?= $toDate ?>" readonly>
				                    <span class="input-group-btn">
				                        <button class="btn btn-default btn-date" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
				                    </span>
				                </div>
				            </div>
				        </div>
				    </div>
				    <div class="form-group">
				    	<label for="txtCustomer" class="col-sm-3 control-label"><?= lang('customer') ?></label>
				    	<div class="col-sm-9">
				    		<select class="form-control" id="txtCustomer" name="customer">
				    			<?php foreach($customers as $row) : ?>
				    				<option value="<?= $row->id ?>" <?= $row->id == $customer->id ? 'selected' : '' ?>><?= $row->name ?></option>
				    			<?php endforeach; ?>
				    		</select>
				    	</div>
				    </div>
				</form>
			</div>
			<div class="panel-footer text-right">
				<button type="submit" class="btn btn-primary" form="frmReportOption"><span class="glyphicon glyphicon-eye-open"></span> <?= lang('view') ?></button>
			</div>
		</div>
	</div>
</div>

<?php if (!empty($flash)) : ?>
  <?= fMessage($flash['msg'], $flash['type']) ?>
<?php endif; ?>

<div class="panel panel-primary">
	<div class="panel-heading">
		<strong class="panel-title"><?= lang('order_detail') ?></strong>
		<div class="pull-right pan-share-order-control <?= empty($data) ? 'hidden' : '' ?>">
			<div class="btn-group btn-group-xs" role="group" aria-label="...">
				<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalSendEmailReport"><span class="glyphicon glyphicon-envelope"></span></button>
  				<a href="<?= base_url('exports?type=report&fromDate='.$fromDate.'&toDate='.$toDate.'&customer='.$customer->id.'&file=don-hang-'.date('dmY', strtotime($fromDate)).'-den-'.date('dmY', strtotime($toDate)).'.pdf') ?>" target="_blank" class="btn btn-info"><span class="glyphicon glyphicon-print"></span></a>
			</div>
		</div>
	</div>
	<div class="table-responsive" id="panReportHasProduct">
	  	<table class="table table-bordered table-striped table-hover">
		    <thead>
		    	<tr>
		    		<th class="text-center w50">#</th>
		    		<th class="text-center"><?= lang('day') ?></th>
		    		<th class="text-center"><?= lang('product') ?></th>
		    		<th class="text-center"><?= lang('price') ?> (đ/kg)</th>
		    		<th class="text-center"><?= lang('quantity') ?> (kg)</th>
		    		<th class="text-center"><?= lang('ship') ?> (đ)</th>
    				<th class="text-center"><?= lang('money') ?> (đ)</th>
		    		<th class="text-center"><?= lang('note') ?></th>
		    	</tr>
		    </thead>
		    <tbody>
		    	<?php if (empty($data)) : ?>
		    		<tr>
		    			<td colspan="8" class="text-center danger"><?= lang('product_empty') ?></td>
		    		</tr>
		    	<?php else : ?>
		    		<?php
		    			$total = 0;
		    			$quantity = 0;
		    			$ship = 0;
		    		?>
		            <?php foreach ($data as $key => $product) : ?>
		                <tr>
		                    <td class="text-center"><?= $key + 1 ?></td>
		                    <td class="text-center"><?= $product->order_date?></td>
		                    <td><?= $product->name ?></td>
		                    <td class="text-right"><?= number_format($product->price, 0, '.', ',') ?></td>
		                    <td class="text-right"><?= number_format($product->quantity, 2, '.', ',') ?></td>
		                    <td class="text-right"><?= number_format($product->ship, 0, '.', ',') ?></td>
		                    <td class="text-right">
		                    	<?php $money = $product->price*$product->quantity + $product->ship; ?>
		                    	<strong><?= number_format($money, 0, '.', ',') ?></strong>            	
		                    </td>
		                    <td><em><?= $product->ohp_note ?></em></td>
		                </tr>
		                <?php 
		                	$total += $money;
		                	$quantity += $product->quantity;
		                	$ship += $product->ship;
		                ?>
		            <?php endforeach; ?>
		            <tr class="success">
		            	<td class="text-right" colspan="4"><strong><?= lang('total') ?></strong></td>
		            	<td class="text-right"><strong><?= number_format($quantity, 2, '.', ',') ?></strong></td>
		            	<td class="text-right"><strong><?= number_format($ship, 0, '.', ',') ?></strong></td>
		            	<td class="text-right"><strong><?= number_format($total, 0, '.', ',') ?></strong></td>
		            	<td></td>
		            </tr>
		    	<?php endif; ?>
		    </tbody>
		</table>
	</div>
</div>

<div class="modal fade" id="modalSendEmailReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <strong class="panel-title"><?= lang('send_email') ?></strong>
                <div class="pull-right"><span class="glyphicon glyphicon-send"></span></div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="txtToEmail" class="control-label required"><?= lang('recever_email') ?></label>
                    <input type="text" name="date" id="txtToEmail" class="form-control" value="<?= $customer->email ?>" placeholder="<?= lang('recever_email') ?>">
                </div>
                <div class="form-group">
                    <label for="txtReceverName" class="control-label"><?= lang('recever_name') ?></label>
                    <input type="text" name="date" id="txtReceverName" class="form-control" value="<?= $customer->name ?>" placeholder="<?= lang('recever_name') ?>">
                </div>          
                <div class="form-group">
                    <label for="txtEmailContent" class="control-label"><?= lang('content') ?></label>
                    <textarea class="form-control" id="txtEmailContent" placeholder="<?= lang('content') ?>" rows="4"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('cancel') ?></button>
                <a class="btn btn-primary btn-ok" data-from="<?= $fromDate ?>" data-to="<?= $toDate ?>" data-customer="<?= $customer->id ?>" data-type="report"><span class="glyphicon glyphicon-envelope"></span> <?= lang('send') ?></a>
            </div>
        </div>
    </div>
</div>