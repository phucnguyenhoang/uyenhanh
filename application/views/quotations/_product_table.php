<table class="table table-bordered table-striped table-hover">
    <thead>
    	<tr>
    		<th class="text-center w50">#</th>
    		<th class="text-center"><?= lang('product') ?></th>
    		<th class="text-center"><?= lang('price') ?> (đ/kg)</th>
    		<th class="text-center"><?= lang('note') ?></th>
    		<th class="w80"></th>
    	</tr>
    </thead>
    <tbody>
    	<?php if (empty($products)) : ?>
    		<tr>
    			<td colspan="5" class="text-center danger"><?= lang('quotation_empty') ?></td>
    		</tr>
    	<?php else : ?>
            <?php foreach ($products as $key => $product) : ?>
                <tr>
                    <td class="text-center"><?= $key + 1 ?></td>
                    <td><?= $product->name ?></td>
                    <td class="text-right"><?= number_format($product->price, 0, '.', ',') ?></td>
                    <td><em><?= $product->note ?></em></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-info btn-xs" data-id="<?= $product->id ?>" data-name="<?= $product->name ?>" data-toggle="modal" data-target="#modalEditQuotationProduct"><span class="glyphicon glyphicon-edit"></span></button> 
                        <button type="button" class="btn btn-danger btn-xs" data-href="<?= base_url('quotations/'.$quotationId.'/delete/'.$product->id) ?>"  data-name="<?= $product->name ?>" data-toggle="modal" data-target="#confirmDelete"><span class="glyphicon glyphicon-trash"></span></button>
                    </td>
                </tr>
            <?php endforeach; ?>
    	<?php endif; ?>
    </tbody>
</table>