<?php
/**
 * CallSphere
 *
 * Written by R. Marc Lewis <marc@innovotel.com>
 *  (C)opyright 2007-2014, R. Marc Lewis and Innovotel, LLC.
 *  All Rights Reserved
 *
 * Unpublished work.  No portion of this file may be reproduced in whole
 * or in part by any means, electronic or otherwise, without the express
 * written consent of R. Marc Lewis or Innovotel, LLC.
 */


namespace innovotel\widgets;

use yii\base\Widget;
use yii\bootstrap\Nav;
use innovotel\helpers\Html;

class Panel extends Widget {

	const DETAILVIEW_PREBODY = 0;
	const DETAILVIEW_POSTBODY = 1;

	public $heading = '';
	public $navItems = array();
	public $navOpts = ['class' => 'navbar-nav navbar-right navbar-nav-small'];
	public $panelOpts = array();
	public $model = null;
	public $attributes = array();
	public $detailOpts = ['class' => 'table table-striped table-bordered table-condensed detail-view'];
	public $columns = 1;

	public $footer = '';
	public $preBody = '';
	public $body = '';
	public $postBody = '';
	public $detailViewPosition = self::DETAILVIEW_PREBODY;

	public function init()
	{
		// FIXME: Put some validation in here
	}

	public function run()
	{
		// Create the panel options
		$preHeading = '';
		if (!empty($this->navItems)) {
			$preHeading = Nav::widget([
				'options' => $this->navOpts,
				'items' => $this->navItems,
				'encodeLabels' => false,
			]);
		}

		// Render the panel
		return Html::panel([
			'heading' => '<h3 class="panel-title">' . $this->heading . '</h3>',
			'preHeading' => $preHeading,
			'preBody' => $this->preBody,
			'postBody' => $this->postBody,
			'footer' => $this->footer,
			'body' => $this->body,
		]);

	}
} 
