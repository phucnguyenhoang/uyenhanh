<p>
  	Xin chào, <?= $receverName ?>!
</p>
<p>
	<?php if (!empty($content)) : ?>
		<?= $content ?><br>
	<?php else : ?>
		Tôi xin gửi bạn đơn hàng ngày <strong><?= $orderDate ?></strong>.<br>
	<?php endif; ?>
  	
  	Vui lòng xem đơn hàng trong tập tin đính kèm bên dưới!
</p>
<p>
  	Chúc bạn một ngày làm việc may mắn và hiệu quả!<br>
  	Thân!
</p>