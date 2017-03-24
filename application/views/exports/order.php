<style>
	table, th, td {
	    border: 1px solid black;
	    border-collapse: collapse;	
	    padding: 5px;   
	}
	th {
		height: 60px;
		vertical-align: middle;
		text-align: center;
	}
	.text-center {
		text-align: center;
	}
	.text-right {
		text-align: right;
	}
	.v-middle {
		vertical-align: middle;
	}
</style>

<h1 style="text-align: center; padding-bottom: 0px; margin-bottom: 0px;">Chi Tiết Đơn Hàng</h1>
<p style="text-align: center; padding-top: 0px; margin-top: 0px;">*****</p>
<p>
	<ul style="list-style-type: none;">
		<li>
			<strong>Ngày:</strong> <?= date('d/m/Y', strtotime($order->order_date)) ?>
		</li>
		<li>
			<strong>Đối tác:</strong> <?= $order->name ?>
		</li>
		<li>
			<strong>Ghi chú:</strong> <?= !empty($order->note) ? $order->note : '<em>n/a</em>' ?>
		</li>
	</ul>
</p>
<table width="100%">
	<thead>
		<tr class="text-center v-middle">
			<th style="width:6%;"><strong>STT</strong></th>
			<th style="width:25%;"><strong>Sản phẩm</strong></th>
			<th style="width:12%;"><strong>Đơn giá<br>(đ/kg)</strong></th>
			<th style="width:12%;"><strong>Số lượng<br>(kg)</strong></th>
			<th style="width:14%;"><strong>Vận chuyển<br>(đ)</strong></th>
			<th style="width:16%;"><strong>Thành tiền<br>(đ)</strong></th>
			<th style="width:15%;"><strong>Ghi chú</strong></th>
		</tr>
	</thead>
	<tbody>
    	<?php if (empty($products)) : ?>
    		<tr>
    			<td colspan="7" class="text-center"><?= lang('product_empty') ?></td>
    		</tr>
    	<?php else : ?>
    		<?php
    			$total = 0;
    			$quantity = 0;
    			$ship = 0;
    		?>
            <?php foreach ($products as $key => $product) : ?>
                <tr>
                    <td class="text-center" style="width:6%;"><?= $key + 1 ?></td>
                    <td style="width:25%;"><?= $product->name ?></td>
                    <td class="text-right" style="width:12%;"><?= number_format($product->price, 0, '.', ',') ?></td>
                    <td class="text-right" style="width:12%;"><?= number_format($product->quantity, 2, '.', ',') ?></td>
                    <td class="text-right" style="width:14%;"><?= number_format($product->ship, 0, '.', ',') ?></td>
                    <td class="text-right" style="width:16%;">
                    	<?php $money = $product->price*$product->quantity + $product->ship; ?>
                    	<strong><?= number_format($money, 0, '.', ',') ?></strong>            	
                    </td>
                    <td style="width:15%;"><em><?= $product->note ?></em></td>
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