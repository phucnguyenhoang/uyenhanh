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
                        <button type="button" class="btn btn-danger btn-xs" data-href="<?= base_url('orders/'.$orderId.'/delete/'.$product->id) ?>"  data-name="<?= $product->name ?>" data-toggle="modal" data-target="#confirmDelete"><span class="glyphicon glyphicon-trash"></span></button>
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