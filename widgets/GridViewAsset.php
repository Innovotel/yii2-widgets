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
    
    public $sourcePath = __DIR__ . '/assets';
    
    public $css = [
        'css/gridview.css',
    ];
    
    public $depends = [
        'kartik\grid\GridViewAsset',
    ];
}
