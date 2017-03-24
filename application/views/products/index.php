<div class="panel-body text-right">
	<a class="btn btn-primary" href="<?= base_url('products/create') ?>"><span class="glyphicon glyphicon-plus"></span> <?= lang('create_product') ?></a>
</div>

<?php if (!empty($flash)) : ?>
  <?= fMessage($flash['msg'], $flash['type']) ?>
<?php endif; ?>

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <thead>
    	<tr>
    		<th class="text-center w50">#</th>
    		<th class="text-center"><?= lang('name') ?></th>
    		<th class="text-center"><?= lang('spec') ?></th>
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
                <tr <?= !empty($product->deleted_by) ? 'class="danger"' : '' ?>>
                    <td class="text-center"><?= $key + 1 ?></td>
                    <td><?= $product->name ?></td>
                    <td><?= $product->spec ?></td>
                    <td><?= $product->note ?></td>
                    <td class="text-center">
                        <?php if (empty($product->deleted_by)) : ?>
                            <a class="btn btn-primary btn-xs" href="<?= base_url('products/edit/'.$product->id) ?>"><span class="glyphicon glyphicon-edit"></span></a>
                            <button class="btn btn-danger btn-xs" data-href="<?= base_url('products/delete/'.$product->id) ?>"  data-name="<?= $product->name ?>" data-toggle="modal" data-target="#confirmDelete"><span class="glyphicon glyphicon-trash"></span></button>
                        <?php else : ?>
                            <span class="glyphicon glyphicon-trash"></span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
    	<?php endif; ?>
    </tbody>
  </table>
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