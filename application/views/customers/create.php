<?php if (!empty($flash)) : ?>
  <?= fMessage($flash['msg'], $flash['type']) ?>
<?php endif; ?>
<form id="frmCustomerCreate" class="form-horizontal" method="post">
  <div class="form-group <?= !empty(form_error('name')) ? 'has-error' : '' ?>">
    <label for="txtName" class="col-sm-2 control-label required"><?= lang('name') ?></label>
    <div class="col-sm-10">
      <input type="text" name="name" class="form-control" id="txtName" placeholder="<?= lang('name') ?>" data-rule="required|maxLength:150" value="<?= set_value('name')  ?>">
      <?= form_error('name') ?>
    </div>
  </div>

  <div class="form-group <?= !empty(form_error('phone')) ? 'has-error' : '' ?>">
    <label for="txtPhone" class="col-sm-2 control-label required"><?= lang('phone') ?></label>
    <div class="col-sm-10">
      <input type="text" name="phone" class="form-control" id="txtPhone" placeholder="<?= lang('phone') ?>" data-rule="required|maxLength:20" value="<?= set_value('phone')  ?>">
      <?= form_error('phone') ?>
    </div>
  </div>

  <div class="form-group <?= !empty(form_error('email')) ? 'has-error' : '' ?>">
    <label for="txtEmail" class="col-sm-2 control-label"><?= lang('email') ?></label>
    <div class="col-sm-10">
      <input type="email" name="email" class="form-control" id="txtEmail" placeholder="<?= lang('email') ?>" data-rule="maxLength:150" value="<?= set_value('email')  ?>">
      <?= form_error('email') ?>
    </div>
  </div>

  <div class="form-group <?= !empty(form_error('address')) ? 'has-error' : '' ?>">
    <label for="txtAddress" class="col-sm-2 control-label"><?= lang('address') ?></label>
    <div class="col-sm-10">
      <input type="text" name="address" class="form-control" id="txtAddress" placeholder="<?= lang('address') ?>" data-rule="maxLength:200" value="<?= set_value('address')  ?>">
      <?= form_error('address') ?>
    </div>
  </div>

  <div class="form-group <?= !empty(form_error('note')) ? 'has-error' : '' ?>">
    <label for="txtNote" class="col-sm-2 control-label"><?= lang('note') ?></label>
    <div class="col-sm-10">
      <input type="text" name="note" class="form-control" id="txtNote" placeholder="<?= lang('note') ?>" data-rule="maxLength:200" value="<?= set_value('note')  ?>">
      <?= form_error('note') ?>
    </div>
  </div>

  <div class="text-right">
    <a class="btn btn-default" href="<?= base_url('products') ?>"><?= lang('cancel') ?></a>
    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> <?= lang('save') ?></button>
  </div>
</form>