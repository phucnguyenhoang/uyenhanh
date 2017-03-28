<div class="panel-body text-right">
	<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalAddQuotation">
        <span class="glyphicon glyphicon-plus"></span> <?= lang('create_quotation') ?>
    </button>
</div>

<?php if (!empty($flash)) : ?>
  <?= fMessage($flash['msg'], $flash['type']) ?>
<?php endif; ?>

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <thead>
    	<tr>
    		<th class="text-center w50">#</th>
    		<th><?= lang('name') ?></th>
            <th class="text-center"><?= lang('created_date') ?></th>
    		<th><?= lang('note') ?></th>
    		<th class="w80"></th>
    	</tr>
    </thead>
    <tbody>
    	<?php if (empty($quotations)) : ?>
    		<tr>
    			<td colspan="5" class="text-center danger"><?= lang('quotation_empty') ?></td>
    		</tr>
    	<?php else : ?>
            <?php foreach ($quotations as $key => $quotation) : ?>
                <tr <?= !empty($quotation->deleted_by) ? 'class="danger"' : '' ?>>
                    <td class="text-center"><?= $key + 1 ?></td>
                    <td><?= $quotation->name ?></td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($quotation->created_date)) ?></td>
                    <td><?= $quotation->note ?></td>
                    <td class="text-center">
                        <?php if (empty($quotation->deleted_by)) : ?>
                            <a class="btn btn-info btn-xs" href="<?= base_url('quotations/view/'.$quotation->id) ?>"><span class="glyphicon glyphicon-eye-open"></span></a>
                            <button class="btn btn-danger btn-xs" data-href="<?= base_url('quotations/delete/'.$quotation->id) ?>"  data-name="<?= $quotation->name ?>" data-toggle="modal" data-target="#confirmDelete"><span class="glyphicon glyphicon-trash"></span></button>
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

<form id="frmAddQuotation" method="post" action="<?= base_url('quotations/create') ?>">
    <div class="modal fade" id="modalAddQuotation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog  modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="panel-title"><?= lang('create_quotation') ?></strong>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="txtQuotationProductName" class="control-label required"><?= lang('name') ?></label>
                        <input type="text" name="name" id="txtQuotationProductName" class="form-control" data-rule="required|maxLength:150">
                    </div>
                    
                    <div class="form-group">
                        <label for="txtNote" class="control-label"><?= lang('note') ?></label>
                        <textarea name="note" class="form-control" id="txtNote" placeholder="<?= lang('note') ?>" data-rule="maxLength:200"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('cancel') ?></button>
                    <button type="submit" class="btn btn-primary btn-ok"><span class="glyphicon glyphicon-floppy-disk"></span> <?= lang('save') ?></button>
                </div>
            </div>
        </div>
    </div>
</form>