<?php
function fMessage($msg, $type = 'danger') {
	if (empty($msg)) return '';
	
	$html = '<div class="alert alert-'.$type.' alert-dismissible fade in" role="alert">';
	$html .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
	$html .= $msg;
	$html .= '</div>';
	
	return $html;
}