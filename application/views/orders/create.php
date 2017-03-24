<?php if (!empty($flash)) : ?>
  <?= fMessage($flash['msg'], $flash['type']) ?>
<?php endif; ?>

<div class="panel panel-default">
  <div class="panel-body">
    <form id="frmOrderCreate" class="form-horizontal" method="post">
      <div class="form-group">
        <label for="txtOrderDate" class="col-sm-2 control-label"><?= lang('order_date') ?></label>
        <div class="col-sm-10">
          <div class="input-group datepicker-box">
            <div class="input-group">
              <input type="text" name="date" id="txtOrderDate" value="<?= $date ?>" class="form-control datepicker" readonly>
              <span class="input-group-btn">
                <button class="btn btn-default btn-date" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
              </span>
            </div>
          </div>
        </div>
      </div>
      
      <div class="form-group <?= !empty(form_error('customer')) ? 'has-error' : '' ?>">
        <label for="cboCustomer" class="col-sm-2 control-label"><?= lang('customer') ?></label>
        <div class="col-sm-10">
          <select class="form-control" id="cboCustomer">
            <?php foreach ($customers as $customer) : ?>
              <option value="<?= $customer->id ?>"><?= $customer->name ?></option>
            <?php endforeach; ?>
          </select>
          <?= form_error('customer') ?>
        </div>
      </div>

      <div class="form-group <?= !empty(form_error('note')) ? 'has-error' : '' ?>">
        <label for="txtNote" class="col-sm-2 control-label"><?= lang('note') ?></label>
        <div class="col-sm-10">
          <input type="text" name="note" class="form-control" id="txtNote" placeholder="<?= lang('note') ?>" data-rule="maxLength:250" value="<?= set_value('note')  ?>">
          <?= form_error('note') ?>
        </div>
      </div>

      <div class="text-right">
        <a class="btn btn-default" href="<?= base_url('products') ?>"><?= lang('cancel') ?></a>
        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> <?= lang('save') ?></button>
      </div>
    </form>
  </div>
</div>