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

<h1 style="text-align: center; padding-bottom: 0px; margin-bottom: 0px;">Bảng Báo Giá</h1>
<p style="text-align: center; padding-top: 0px; margin-top: 0px;">*****</p>
<p>
	<ul style="list-style-type: none;">
		<li>
			<strong>Ngày:</strong> <?= date('d/m/Y', strtotime($quotation->created_date)) ?>
		</li>
		<li>
			<strong>Ghi chú:</strong> <?= !empty($quotation->note) ? $quotation->note : '<em>n/a</em>' ?>
		</li>
	</ul>
</p>
<table width="100%">
	<thead>
		<tr class="text-center v-middle">
			<th style="width:6%;"><strong>STT</strong></th>
			<th style="width:30%;"><strong>Sản phẩm</strong></th>
			<th style="width:24%;"><strong>Đơn giá (đ/kg)</strong></th>
			<th style="width:40%;"><strong>Ghi chú</strong></th>
		</tr>
	</thead>
	<tbody>
    	<?php if (empty($products)) : ?>
    		<tr>
    			<td colspan="4" class="text-center"><?= lang('product_empty') ?></td>
    		</tr>
    	<?php else : ?>
            <?php foreach ($products as $key => $product) : ?>
                <tr>
                    <td class="text-center" style="width:6%;"><?= $key + 1 ?></td>
                    <td style="width:30%;"><?= $product->name ?></td>
                    <td class="text-right" style="width:24%;"><?= number_format($product->price, 0, '.', ',') ?></td>
                    <td style="width:40%;"><em><?= $product->note ?></em></td>
                </tr>
            <?php endforeach; ?>
    	<?php endif; ?>
    </tbody>
</table>