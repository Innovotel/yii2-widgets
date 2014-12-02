<?php
namespace innovotel\widgets;

/**
 * This displays a specialized grid view with Navigation on the right
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

	public $panelHeadingTemplate = <<< HTML
	    <div class="panel-nav">{nav}</div>
		<div class="panel-title"><h3 class="panel-title">{heading}</h3></div>
HTML;

	public $panelFooterTemplate = <<< HTML
		{footer}
		<div class="kv-panel-pager pull-right">{pager}</div>
		<div class="clearfix"></div>
HTML;

	public $toolbar = [];

	public function init()
	{
		parent::init();

		$nav = ArrayHelper::getValue($this->panel, 'nav', '');

		$this->panelHeadingTemplate = strtr(
			$this->panelHeadingTemplate,
			[
				'{nav}' => $nav,
			]
		);

		GridViewAsset::register($this->getView());
	}
}

