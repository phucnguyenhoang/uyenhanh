<div class="panel-body text-right">
	<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalAddOrder">
        <span class="glyphicon glyphicon-plus"></span> <?= lang('create_order') ?>
    </button>
</div>

<form id="frmOrderView" class="form-horizontal" method="get">
    <div class="form-group">
        <label for="txtOrderDate" class="col-sm-2 control-label"><?= lang('order_date') ?></label>
        <div class="col-sm-10">
            <div class="datepicker-box">
                <div class="input-group">
                    <input type="text" name="date" id="txtOrderDate" value="<?= $date ?>" class="form-control datepicker" readonly>
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-date" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</form>

<?php if (!empty($flash)) : ?>
  <?= fMessage($flash['msg'], $flash['type']) ?>
<?php endif; ?>

<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover">
    <thead>
    	<tr>
    		<th class="text-center w50">#</th>
    		<th><?= lang('customer') ?></th>
            <th><?= lang('type') ?></th>
    		<th><?= lang('status') ?></th>
    		<th><?= lang('note') ?></th>
    		<th class="w80"></th>
    	</tr>
    </thead>
    <tbody>
    	<?php if (empty($orders)) : ?>
    		<tr>
    			<td colspan="6" class="text-center danger"><?= lang('order_empty') ?></td>
    		</tr>
    	<?php else : ?>
            <?php foreach ($orders as $key => $order) : ?>
                <tr <?= !empty($order->deleted_by) ? 'class="danger"' : '' ?>>
                    <td class="text-center"><?= $key + 1 ?></td>
                    <td><?= $order->name ?></td>
                    <td><?= orderType($order->type) ?></td>
                    <td><?= orderStatus($order->status) ?></td>
                    <td><?= $order->note ?></td>
                    <td class="text-center">
                        <?php if (empty($order->deleted_by)) : ?>
                            <a class="btn btn-info btn-xs" href="<?= base_url('orders/view/'.$order->id) ?>"><span class="glyphicon glyphicon-eye-open"></span></a>
                            <button class="btn btn-danger btn-xs" data-href="<?= base_url('orders/delete/'.$order->id.'/'.$order->order_date) ?>"  data-name="<?= $order->name ?>" data-toggle="modal" data-target="#confirmDelete"><span class="glyphicon glyphicon-trash"></span></button>
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

<form method="post" action="<?= base_url('orders/create') ?>">
    <div class="modal fade" id="modalAddOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog  modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="panel-title"><?= lang('create_order') ?></strong>
                </div>
                <div class="modal-body">                      
                    <div class="form-group">
                        <label class="control-label"><?= lang('type') ?></label>
                        <div class="radio">
                            <label>
                                <input type="radio" name="type" value="1" checked><?= lang('import') ?>
                            </label>
                            <label>
                                <input type="radio" name="type" value="2"><?= lang('export') ?>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="txtDate" class="control-label"><?= lang('order_date') ?></label>
                        <div class="input-group">
                            <input type="text" name="date" id="txtDate" value="<?= $date ?>" class="form-control datepicker" readonly>
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-date" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cboCustomer" class="control-label"><?= lang('customer') ?></label>
                        <select class="form-control" id="cboCustomer" name="customer">
                            <?php foreach ($customers as $customer) : ?>
                                <option value="<?= $customer->id ?>"><?= $customer->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="txtNote" class="control-label"><?= lang('note') ?></label>
                        <textarea name="note" class="form-control" id="txtNote" placeholder="<?= lang('note') ?>"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('cancel') ?></button>
                    <button type="button" class="btn btn-primary btn-ok"><span class="glyphicon glyphicon-floppy-disk"></span> <?= lang('save') ?></button>
                </div>
            </div>
        </div>
    </div>
</form>