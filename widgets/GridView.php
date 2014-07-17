<?php
namespace innovotel\widgets;

/**
 * This displays a billing summary for the specified customer.
 * TODO:  If no customer is specified, it gets the customer ID from
 * the session.
 */

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use innovotel\helpers\Html;

class GridView extends \kartik\grid\GridView
{

	public $nav = '';

	// Change a few defaults from kartik's gridview
	public $condensed = true;
	public $hover = true;
	public $floatHeader = true;
	public $export = false;


	const CS_TEMPLATE = <<< HTML
<div class="panel {type}">{nav}
	<div class="panel-heading">
		<h3 class="panel-title">{heading}</h3>
	</div>
	{before}
	{items}
	{after}
	<div class="pull-right">{summary}</div>
	<div class="clearfix"></div>
	<div class="panel-footer">
		{footer}
		<div class="kv-panel-pager pull-right">{pager}</div>
		<div class="clearfix"></div>
	</div>
</div>
HTML;


	protected function renderPanel()
	{
		$nav = ArrayHelper::getValue($this->panel, 'nav', '');

		$layout = strtr(self::CS_TEMPLATE, [
			'{nav}' => $nav,
		]);

		$this->panel['layout'] = $layout;

		/*
		$showFooter = ArrayHelper::getValue($this->panel, 'showFooter', false);
		$template = ($showFooter) ? self::TEMPLATE_1 : self::TEMPLATE_2;
		$layout = ArrayHelper::getValue($this->panel, 'layout', $template);
		$nav = ArrayHelper::getValue($layout, 'nav', '');
		$this->panel = strtr(GridViewNav::CS_TEMPLATE, [
			'{nav}' => 'wtf' . $nav,
		]);*/
		parent::renderPanel();
	}

}
