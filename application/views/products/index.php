<div class="panel-body text-right">
	<a class="btn btn-primary" href="<?= base_url('products/create') ?>"><span class="glyphicon glyphicon-plus"></span> <?= lang('create_product') ?></a>
</div>
<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <thead>
    	<tr>
    		<th class="text-center w30">#</th>
    		<th class="text-center"><?= lang('name') ?></th>
    		<th class="text-center"><?= lang('spec') ?></th>
    		<th class="text-center"><?= lang('note') ?></th>
    		<th class="w50"></th>
    	</tr>
    </thead>
    <tbody>
    	<?php if (empty($products)) : ?>
    		<tr>
    			<td colspan="5" class="text-center danger"><?= lang('product_empty') ?></td>
    		</tr>
    	<?php else : ?>

    	<?php endif; ?>
    </tbody>
  </table>
</div>