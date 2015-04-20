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
use innovotel\widgets\DetailView;
use innovotel\helpers\Html;
use yii\bootstrap\Nav;

class DetailPanel extends Widget {

	const DETAILVIEW_PREBODY = 0;
	const DETAILVIEW_POSTBODY = 1;

    public $panelType = 'default';
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
    public $postFooter = '';
	public $detailViewPosition = self::DETAILVIEW_PREBODY;

    public $bodyTemplate = '<div class="panel-body">{body}</div>';
    public $footerTemplate = '<div class="panel-footer">{footer}</div>';

    const PANEL_TEMPLATE = <<< HTML
<div class="panel panel-{type}">
	<div class="panel-heading">
	    <div class="panel-nav">{nav}</div>
		<div class="panel-title"><h3 class="panel-title" style="display: inline">{heading}</h3></div>
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
        $nav = '';
		if (!empty($this->navItems)) {
			$nav = Nav::widget([
				'options' => $this->navOpts,
				'items' => $this->navItems,
				'encodeLabels' => false,
			]);
		}

		// Create the detailview
		$dvdata = DetailView::widget([
			'model' => $this->model,
			'attributes' => $this->attributes,
			'options' => $this->detailOpts,
			'columns' => $this->columns,
		]);

		// Set the detailview's position
		if ($this->detailViewPosition == self::DETAILVIEW_PREBODY) {
			$this->preBody = $dvdata . $this->preBody;
		} else {
			$this->postBody = $dvdata . $this->postBody;
		}

        $footer = empty($this->footer) ? '' : preg_replace('/{footer}/', $this->footer, $this->footerTemplate);
        $body = empty($this->body) ? '' : preg_replace('/{body}/', $this->body, $this->bodyTemplate);

        return strtr(self::PANEL_TEMPLATE, [
                '{type}' => $this->panelType,
                '{nav}' => $nav,
                '{heading}' => $this->heading,
                '{preBody}' => $this->preBody,
                '{body}' => $body,
                '{postBody}' => $this->postBody,
                '{footer}' => $footer,
                '{postFooter}' => $this->postFooter,
            ]);

		// Render the panel
		return Html::panel([
			'heading' => '<div class="panel-nav">' . $nav . '</div><div class="panel-title"><h3 class="panel-title">' . $this->heading . '</h3></div>',
			'preHeading' => $preHeading,
			'preBody' => $this->preBody,
			'postBody' => $this->postBody,
			'footer' => $this->footer,
			'body' => $this->body,
		]);

	}
} 
