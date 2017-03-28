<div class="panel-body text-right">
	<a class="btn btn-primary" href="<?= base_url('quotations') ?>">
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
				<strong class="panel-title"><?= lang('quotation_info') ?></strong>
			</div>
			<div class="panel-body" id="panQuotationInfo">
				<form class="form-horizontal">
				  	<div class="form-group">
				    	<label class="col-sm-3 control-label" for="txtQuotationName"><?= lang('name') ?></label>
				    	<div class="col-sm-9">
				      		<input type="text" id="txtQuotationName" class="form-control" value="<?= $quotation->name ?>">
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label for="txtNote" class="col-sm-3 control-label"><?= lang('note') ?></label>
				    	<div class="col-sm-9">
				      		<textarea class="form-control" id="txtNote" name="note"><?= $quotation->note ?></textarea>
				    	</div>
				  	</div>
				</form>
			</div>
			<div class="panel-footer text-right">
				<button type="button" class="btn btn-danger" data-href="<?= base_url('quotations/delete/'.$quotation->id) ?>"  data-name="<?= $quotation->name ?>" data-toggle="modal" data-target="#confirmDelete"><span class="glyphicon glyphicon-trash"></span> <?= lang('delete') ?></button> 
			    <button type="button" class="btn btn-primary" id="btnSaveQuotation" data-id="<?= $quotation->id ?>"><span class="glyphicon glyphicon-floppy-disk"></span> <?= lang('save') ?></button>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<strong class="panel-title"><?= lang('add_product_to_quotation') ?></strong>
				<div class="pull-right">
					<a class="btn-collapse" data-toggle="collapse" href="#panAddProductToQuotation" aria-expanded="false" aria-controls="panAddProductToQuotation"><span class="glyphicon glyphicon-triangle-bottom"></span></a>
				</div>
			</div>
			<div class="panel-body collapse" id="panAddProductToQuotation">
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
					    <label for="txtProductNote" class="col-sm-3 control-label"><?= lang('note') ?></label>
					    <div class="col-sm-9">
					      	<input type="text" class="form-control" id="txtProductNote" placeholder="<?= lang('note') ?>">
					    </div>
				  	</div>
				</form>

				<div class="text-right">
					<button type="button" class="btn btn-primary" id="btnAddQuotation" data-id="<?= $quotation->id ?>"><span class="glyphicon glyphicon-ok"></span> <?= lang('add') ?></button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="panel panel-primary">
	<div class="panel-heading">
		<strong class="panel-title"><?= lang('quotation_detail') ?></strong>
		<div class="pull-right pan-share-quotation-control <?= empty($products) ? 'hidden' : '' ?>">
			<div class="btn-group btn-group-xs" role="group" aria-label="...">
				<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalSendEmail"><span class="glyphicon glyphicon-envelope"></span></button>
  				<a href="<?= base_url('exports?type=quotation&id='.$quotation->id.'&file=bang-bao-gia.pdf') ?>" target="_blank" class="btn btn-info"><span class="glyphicon glyphicon-print"></span></a>
			</div>
		</div>
	</div>
	<div class="table-responsive" id="panQuotationHasProduct">
	  	<table class="table table-bordered table-striped table-hover">
		    <thead>
		    	<tr>
		    		<th class="text-center w50">#</th>
		    		<th class="text-center"><?= lang('product') ?></th>
		    		<th class="text-center"><?= lang('price') ?> (đ/kg)</th>
		    		<th class="text-center"><?= lang('note') ?></th>
		    		<th class="w80"></th>
		    	</tr>
		    </thead>
		    <tbody>
		    	<?php if (empty($products)) : ?>
		    		<tr>
		    			<td colspan="5" class="text-center danger"><?= lang('product_empty') ?></td>
		    		</tr>
		    	<?php else : ?>
		            <?php foreach ($products as $key => $product) : ?>
		                <tr>
		                    <td class="text-center"><?= $key + 1 ?></td>
		                    <td><?= $product->name ?></td>
		                    <td class="text-right"><?= number_format($product->price, 0, '.', ',') ?></td>
		                    <td><em><?= $product->note ?></em></td>
		                    <td class="text-center">
		                        <button type="button" class="btn btn-info btn-xs" data-id="<?= $product->id ?>" data-name="<?= $product->name ?>" data-toggle="modal" data-target="#modalEditQuotationProduct"><span class="glyphicon glyphicon-edit"></span></button> 
		                        <button type="button" class="btn btn-danger btn-xs" data-href="<?= base_url('quotations/'.$quotation->id.'/delete/'.$product->id) ?>"  data-name="<?= $product->name ?>" data-toggle="modal" data-target="#confirmDelete"><span class="glyphicon glyphicon-trash"></span></button>
		                    </td>
		                </tr>
		            <?php endforeach; ?>
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

<div class="modal fade" id="modalEditQuotationProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                    <input type="text" name="date" id="txtToEmail" class="form-control" placeholder="<?= lang('recever_email') ?>">
                </div>
                <div class="form-group">
                    <label for="txtReceverName" class="control-label"><?= lang('recever_name') ?></label>
                    <input type="text" name="date" id="txtReceverName" class="form-control" placeholder="<?= lang('recever_name') ?>">
                </div>          
                <div class="form-group">
                    <label for="txtEmailContent" class="control-label"><?= lang('content') ?></label>
                    <textarea class="form-control" id="txtEmailContent" placeholder="<?= lang('content') ?>" rows="4"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('cancel') ?></button>
                <a class="btn btn-primary btn-ok" data-id="<?= $quotation->id ?>" data-type="quotation"><span class="glyphicon glyphicon-envelope"></span> <?= lang('send') ?></a>
            </div>
        </div>
    </div>
</div>


<input type="hidden" id="hidQuotationId" value="<?= $quotation->id ?>">
