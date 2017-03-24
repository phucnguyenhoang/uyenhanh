<div class="panel-body text-right">
	<a class="btn btn-primary" href="<?= base_url('orders').'?date='.date('d-m-Y', strtotime($order->order_date)) ?>">
        <span class="glyphicon glyphicon-hand-left"></span> <?= lang('back') ?>
    </a>
</div>

<?php if (!empty($flash)) : ?>
  <?= fMessage($flash['msg'], $flash['type']) ?>
<?php endif; ?>

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<strong class="panel-title"><?= lang('order_info') ?></strong>
			</div>
			<div class="panel-body" id="panOrderInfo">
				<form class="form-horizontal">
				  	<div class="form-group">
				    	<label class="col-sm-3 control-label"><?= lang('order_date') ?></label>
				    	<div class="col-sm-9">
				      		<input type="text" class="form-control" disabled value="<?= date('d-m-Y', strtotime($order->order_date)) ?>">
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label class="col-sm-3 control-label"><?= lang('customer') ?></label>
				    	<div class="col-sm-9">
				      		<input type="text" class="form-control" disabled value="<?= $order->name ?>">
				    	</div>
				  	</div>
				  	<div class="form-group">
                        <label class="control-label col-sm-3"><?= lang('type') ?></label>
                        <div class="radio col-sm-9">
                            <label>
                                <input type="radio" name="type" value="1" <?= $order->type == 1 ? 'checked' : '' ?>><?= lang('import') ?>
                            </label>
                            <label>
                                <input type="radio" name="type" value="2" <?= $order->type == 2 ? 'checked' : '' ?>><?= lang('export') ?>
                            </label>
                        </div>
                    </div>
				  	<div class="form-group">
				    	<label for="txtNote" class="col-sm-3 control-label"><?= lang('note') ?></label>
				    	<div class="col-sm-9">
				      		<textarea class="form-control" id="txtNote" name="note"><?= $order->note ?></textarea>
				    	</div>
				  	</div>
				</form>
			</div>
			<div class="panel-footer text-right">
				<button type="button" class="btn btn-danger" data-href="<?= base_url('orders/delete/'.$order->id.'/'.$order->order_date) ?>"  data-name="<?= $order->name ?>" data-toggle="modal" data-target="#confirmDelete"><span class="glyphicon glyphicon-trash"></span> <?= lang('delete') ?></button> 
			    <button type="button" class="btn btn-primary" id="btnSaveOrder" data-id="<?= $order->id ?>"><span class="glyphicon glyphicon-floppy-disk"></span> <?= lang('save') ?></button>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<strong class="panel-title"><?= lang('add_product_to_order') ?></strong>
				<div class="pull-right">
					<a class="btn-collapse" data-toggle="collapse" href="#panAddProductToOrders" aria-expanded="false" aria-controls="panAddProductToOrders"><span class="glyphicon glyphicon-triangle-bottom"></span></a>
				</div>
			</div>
			<div class="panel-body collapse" id="panAddProductToOrders">
				<form class="form-horizontal">
					<div class="form-group">
					    <label for="txtProduct" class="col-sm-3 control-label required"><?= lang('product') ?></label>
					    <div class="col-sm-9">
					      	<input type="text" class="form-control" id="txtProduct" placeholder="<?= lang('product') ?>" data-provide="typeahead" autocomplete="off">
					    </div>
				  	</div>

					<div class="form-group">
					    <label for="txtPrice" class="col-sm-3 control-label required"><?= lang('price') ?></label>
					    <div class="col-sm-9">
					    	<div class="input-group">
					      		<input type="text" class="form-control auto-number text-right" id="txtPrice">
					      		<span class="input-group-addon">đ/kg</span>
					      	</div>
					    </div>
				  	</div>

				  	<div class="form-group">
					    <label for="txtQuantity" class="col-sm-3 control-label required"><?= lang('quantity') ?></label>
					    <div class="col-sm-9">
					      	<div class="input-group">
					      		<input type="text" class="form-control auto-number text-right" id="txtQuantity">
					      		<span class="input-group-addon">kg</span>
					      	</div>
					    </div>
				  	</div>

				  	<div class="form-group">
					    <label for="txtShip" class="col-sm-3 control-label"><?= lang('ship') ?></label>
					    <div class="col-sm-9">
					    	<div class="input-group">
					      		<input type="text" class="form-control auto-number text-right" id="txtShip">
					      		<span class="input-group-addon">đ</span>
					      	</div>
					    </div>
				  	</div>

				  	<div class="form-group">
					    <label for="txtProductNote" class="col-sm-3 control-label"><?= lang('note') ?></label>
					    <div class="col-sm-9">
					      	<input type="text" class="form-control" id="txtProductNote" placeholder="<?= lang('note') ?>">
					    </div>
				  	</div>
				</form>

				<div class="text-right">
					<button type="button" class="btn btn-primary" id="btnAddProduct" data-id="<?= $order->id ?>"><span class="glyphicon glyphicon-ok"></span> <?= lang('add') ?></button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="panel panel-primary">
	<div class="panel-heading">
		<strong class="panel-title"><?= lang('order_detail') ?></strong>
		<div class="pull-right pan-share-order-control <?= empty($products) ? 'hidden' : '' ?>">
			<div class="btn-group btn-group-xs" role="group" aria-label="...">
				<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalSendEmail"><span class="glyphicon glyphicon-envelope"></span></button>
  				<a href="<?= base_url('exports?type=order&id='.$order->id.'&file=don-hang-'.date('dmY', strtotime($order->order_date)).'.pdf') ?>" target="_blank" class="btn btn-info"><span class="glyphicon glyphicon-print"></span></a>
			</div>
		</div>
	</div>
	<div class="table-responsive" id="panOrderHasProduct">
	  	<table class="table table-bordered table-striped table-hover">
		    <thead>
		    	<tr>
		    		<th class="text-center w50">#</th>
		    		<th class="text-center"><?= lang('product') ?></th>
		    		<th class="text-center"><?= lang('price') ?> (đ/kg)</th>
		    		<th class="text-center"><?= lang('quantity') ?> (kg)</th>
		    		<th class="text-center"><?= lang('ship') ?> (đ)</th>
    				<th class="text-center"><?= lang('money') ?> (đ)</th>
		    		<th class="text-center"><?= lang('note') ?></th>
		    		<th class="w80"></th>
		    	</tr>
		    </thead>
		    <tbody>
		    	<?php if (empty($products)) : ?>
		    		<tr>
		    			<td colspan="8" class="text-center danger"><?= lang('product_empty') ?></td>
		    		</tr>
		    	<?php else : ?>
		    		<?php
		    			$total = 0;
		    			$quantity = 0;
		    			$ship = 0;
		    		?>
		            <?php foreach ($products as $key => $product) : ?>
		                <tr>
		                    <td class="text-center"><?= $key + 1 ?></td>
		                    <td><?= $product->name ?></td>
		                    <td class="text-right"><?= number_format($product->price, 0, '.', ',') ?></td>
		                    <td class="text-right"><?= number_format($product->quantity, 2, '.', ',') ?></td>
		                    <td class="text-right"><?= number_format($product->ship, 0, '.', ',') ?></td>
		                    <td class="text-right">
		                    	<?php $money = $product->price*$product->quantity + $product->ship; ?>
		                    	<strong><?= number_format($money, 0, '.', ',') ?></strong>            	
		                    </td>
		                    <td><em><?= $product->note ?></em></td>
		                    <td class="text-center">
		                        <button type="button" class="btn btn-info btn-xs" data-id="<?= $product->id ?>" data-name="<?= $product->name ?>" data-toggle="modal" data-target="#modalEditProduct"><span class="glyphicon glyphicon-edit"></span></button> 
		                        <button type="button" class="btn btn-danger btn-xs" data-href="<?= base_url('orders/'.$order->id.'/delete/'.$product->id) ?>"  data-name="<?= $product->name ?>" data-toggle="modal" data-target="#confirmDelete"><span class="glyphicon glyphicon-trash"></span></button>
		                    </td>
		                </tr>
		                <?php 
		                	$total += $money;
		                	$quantity += $product->quantity;
		                	$ship += $product->ship;
		                ?>
		            <?php endforeach; ?>
		            <tr class="success">
		            	<td class="text-right" colspan="3"><strong><?= lang('total') ?></strong></td>
		            	<td class="text-right"><strong><?= number_format($quantity, 2, '.', ',') ?></strong></td>
		            	<td class="text-right"><strong><?= number_format($ship, 0, '.', ',') ?></strong></td>
		            	<td class="text-right"><strong><?= number_format($total, 0, '.', ',') ?></strong></td>
		            	<td colspan="2"></td>
		            </tr>
		    	<?php endif; ?>
		    </tbody>
		</table>
	</div>
</div>


<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-sm">
        <div class="modal-content">
            <div class="modal-header text-danger">
                <strong class="panel-title"><?= lang('confirm_delete_title') ?></strong>
            </div>
            <div class="modal-body">
                <?= lang('confirm_delete_msg') ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('cancel') ?></button>
                <a class="btn btn-danger btn-ok"><span class="glyphicon glyphicon-trash"></span> <?= lang('delete') ?></a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong class="panel-title"><?= lang('edit_product') ?></strong>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
					<div class="form-group">
					    <label for="txtAddProduct" class="col-sm-3 control-label"><?= lang('product') ?></label>
					    <div class="col-sm-9">
					      	<input type="text" class="form-control" id="txtAddProduct" placeholder="<?= lang('product') ?>" disabled>
					    </div>
				  	</div>

					<div class="form-group">
					    <label for="txtAddPrice" class="col-sm-3 control-label required"><?= lang('price') ?></label>
					    <div class="col-sm-9">
					    	<div class="input-group">
					      		<input type="text" class="form-control auto-number text-right" id="txtAddPrice">
					      		<span class="input-group-addon">đ/kg</span>
					      	</div>
					    </div>
				  	</div>

				  	<div class="form-group">
					    <label for="txtAddQuantity" class="col-sm-3 control-label required"><?= lang('quantity') ?></label>
					    <div class="col-sm-9">
					      	<div class="input-group">
					      		<input type="text" class="form-control auto-number text-right" id="txtAddQuantity">
					      		<span class="input-group-addon">kg</span>
					      	</div>
					    </div>
				  	</div>

				  	<div class="form-group">
					    <label for="txtAddShip" class="col-sm-3 control-label"><?= lang('ship') ?></label>
					    <div class="col-sm-9">
					    	<div class="input-group">
					      		<input type="text" class="form-control auto-number text-right" id="txtAddShip">
					      		<span class="input-group-addon">đ</span>
					      	</div>
					    </div>
				  	</div>

				  	<div class="form-group">
					    <label for="txtAddProductNote" class="col-sm-3 control-label"><?= lang('note') ?></label>
					    <div class="col-sm-9">
					      	<input type="text" class="form-control" id="txtAddProductNote" placeholder="<?= lang('note') ?>">
					    </div>
				  	</div>
				</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('cancel') ?></button>
                <a class="btn btn-primary btn-ok"><span class="glyphicon glyphicon-floppy-disk"></span> <?= lang('save') ?></a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalSendEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <strong class="panel-title"><?= lang('send_email') ?></strong>
                <div class="pull-right"><span class="glyphicon glyphicon-send"></span></div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="txtToEmail" class="control-label required"><?= lang('recever_email') ?></label>
                    <input type="text" name="date" id="txtToEmail" class="form-control" placeholder="<?= lang('recever_email') ?>" value="<?= $order->email ?>">
                </div>
                <div class="form-group">
                    <label for="txtReceverName" class="control-label"><?= lang('recever_name') ?></label>
                    <input type="text" name="date" id="txtReceverName" class="form-control" placeholder="<?= lang('recever_name') ?>" value="<?= $order->name ?>">
                </div>          
                <div class="form-group">
                    <label for="txtEmailContent" class="control-label"><?= lang('content') ?></label>
                    <textarea class="form-control" id="txtEmailContent" placeholder="<?= lang('content') ?>" rows="4"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('cancel') ?></button>
                <a class="btn btn-primary btn-ok" data-id="<?= $order->id ?>"><span class="glyphicon glyphicon-envelope"></span> <?= lang('send') ?></a>
            </div>
        </div>
    </div>
</div>


<input type="hidden" id="hidOrderId" value="<?= $order->id ?>">
