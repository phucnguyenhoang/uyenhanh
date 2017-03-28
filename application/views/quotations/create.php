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
				    	<label class="col-sm-3 control-label" name="name"><?= lang('name') ?></label>
				    	<div class="col-sm-9">
				      		<input type="text" class="form-control">
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label for="txtNote" class="col-sm-3 control-label"><?= lang('note') ?></label>
				    	<div class="col-sm-9">
				      		<textarea class="form-control" id="txtNote" name="note"></textarea>
				    	</div>
				  	</div>
				</form>
				<div class="text-right">
			    	<button type="button" class="btn btn-primary" id="btnSaveQuotation"><span class="glyphicon glyphicon-floppy-disk"></span> <?= lang('save') ?></button>
			    </div>
			</div>
			<div class="panel-footer">
				<h4><?= lang('add_product_to_quotation') ?></h4><hr>
			    <form class="form-horizontal">
				  	<div class="form-group">
				    	<label class="col-sm-3 control-label"><?= lang('product') ?></label>
				    	<div class="col-sm-9">
				      		<input type="text" class="form-control">
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label for="txtNote" class="col-sm-3 control-label"><?= lang('note') ?></label>
				    	<div class="col-sm-9">
				      		<textarea class="form-control" id="txtNote" name="note"></textarea>
				    	</div>
				  	</div>
				</form>
			</div>
		</div>
	</div>
</div>