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
 * Asset bundle for LteSideNav Widget
 *
 * @author Marc Lewis <marc@innovotel.com>
 */
class LteSideNavAsset extends \yii\web\AssetBundle
{

    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/ltesidenav']);
        //$this->setupAssets('js', ['js/sidenav']);
        parent::init();
    }

    protected function setupAssets($type, $files = [])
    {
        $srcFiles = [];
        $minFiles = [];
        foreach ($files as $file) {
            $srcFiles[] = "{$file}.{$type}";
            $minFiles[] = "{$file}.min.{$type}";
        }
        if (empty($this->$type)) {
            $this->$type = YII_DEBUG ? $srcFiles : $minFiles;
        }
    }

    protected function setSourcePath($path)
    {
        if (empty($this->sourcePath)) {
            $this->sourcePath = $path;
        }
    }
}
