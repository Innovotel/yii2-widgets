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

class ListGroupLteBox extends Widget {

	const LISTGROUP_PREBODY = 0;
	const LISTGROUP_POSTBODY = 1;

	public $heading = '';
	public $navItems = array();
	public $navOpts = ['class' => 'navbar-nav navbar-right navbar-nav-small'];
	public $panelOpts = array();
	public $data = null;
	public $attributes = array();

	public $footer = '';
	public $preBody = '';
	public $body = '';
	public $postBody = '';
	public $postFooter = '';
	public $panelType = 'default';
	public $nav = '';
	public $listGroupPosition = self::LISTGROUP_PREBODY;
    
    const PANEL_TEMPLATE = <<< HTML
<div class="box box-{type}">
	<div class="box-header">
	    <div class="box-tools pull-right">{nav}</div>
		<h3 class="box-title">{heading}</h3>
	</div>
	{preBody}
	{body}
	{postBody}
	{footer}
	{postFooter}
</div>
HTML;

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

		// Create the listgroup
		if (!empty($this->data)) {
			$lgdata = Html::listGroup($this->data);
		} else {
			$lgdata = '';
		}

		// Set the listgroups position
		if ($this->listGroupPosition == self::LISTGROUP_PREBODY) {
			$this->preBody = $lgdata . $this->preBody;
		} else {
			$this->postBody = $lgdata . $this->postBody;
		}
        
        return strtr(self::PANEL_TEMPLATE, [
            '{type}' => $this->panelType,
            '{heading}' => $this->heading,
            '{preBody}' => $this->preBody,
            '{body}' => $this->body,
            '{nav}' => $this->nav,
            '{postBody}' => $this->postBody,
            '{footer}' => $this->footer,
            '{postFooter}' => $this->postFooter,
        ]);
		
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
