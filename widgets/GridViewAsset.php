<?php
/**
 * Written by R. Marc Lewis <marc@innovotel.com>
 *  (C)opyright 2014, R. Marc Lewis and Innovotel, LLC.
 *  All Rights Reserved
 *
 * Unpublished work.  No portion of this file may be reproduced in whole
 * or in part by any means, electronic or otherwise, without the express
 * written consent of R. Marc Lewis or Innovotel, LLC.
 */

namespace innovotel\widgets;

/**
 * Asset bundle for GridView Widget
 *
 * @author Marc Lewis <marc@innovotel.com>
 */
class GridViewAsset extends \yii\web\AssetBundle
{

	public function init()
	{
		$this->setSourcePath(__DIR__ . '/assets');
		$this->setupAssets('css', ['css/gridview']);
		//$this->setupAssets('js', ['js/sidenav']);
		parent::init();
	}
}
