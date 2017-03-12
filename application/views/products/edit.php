<?php if (!empty($flash)) : ?>
  <?= fMessage($flash['msg'], $flash['type']) ?>
<?php endif; ?>
<form id="frmProductEdit" class="form-horizontal" method="post">
  <div class="form-group <?= !empty(form_error('name')) ? 'has-error' : '' ?>">
    <label for="txtName" class="col-sm-2 control-label required"><?= lang('name') ?></label>
    <div class="col-sm-10">
      <input type="text" name="name" class="form-control" id="txtName" placeholder="<?= lang('name') ?>" data-rule="required|maxLength:150" value="<?= !empty(set_value('name')) ? set_value('name') : $product->name  ?>">
      <?= form_error('name') ?>
    </div>
  </div>
  
  <div class="form-group <?= !empty(form_error('spec')) ? 'has-error' : '' ?>">
    <label for="txtSpec" class="col-sm-2 control-label"><?= lang('spec') ?></label>
    <div class="col-sm-10">
      <input type="text" name="spec" class="form-control" id="txtSpec" placeholder="<?= lang('spec') ?>" data-rule="maxLength:150" value="<?= !empty(set_value('spec')) ? set_value('spec') : $product->spec  ?>">
      <?= form_error('spec') ?>
    </div>
  </div>

  <div class="form-group <?= !empty(form_error('note')) ? 'has-error' : '' ?>">
    <label for="txtNote" class="col-sm-2 control-label"><?= lang('note') ?></label>
    <div class="col-sm-10">
      <input type="text" name="note" class="form-control" id="txtNote" placeholder="<?= lang('note') ?>" data-rule="maxLength:250" value="<?= !empty(set_value('note')) ? set_value('note') : $product->note  ?>">
      <?= form_error('note') ?>
    </div>
  </div>

  <div class="text-right">
    <a class="btn btn-default" href="<?= base_url('products') ?>"><?= lang('cancel') ?></a>
    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> <?= lang('save') ?></button>
  </div>
</form>