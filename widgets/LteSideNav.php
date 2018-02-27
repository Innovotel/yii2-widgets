<?php
namespace innovotel\widgets;

use innovotel\helpers\Html;

class LteSideNav extends \kartik\sidenav\SideNav
{
    
    /**
     * Allowed panel stypes
     */
    private static $_validTypes = [
        self::TYPE_DEFAULT,
        self::TYPE_PRIMARY,
        self::TYPE_INFO,
        self::TYPE_SUCCESS,
        self::TYPE_DANGER,
        self::TYPE_WARNING,
    ];
    
    public function init()
    {
        parent::init();
        LteSideNavAsset::register($this->getView());
    }
    
    public function run()
    {
        $heading = '';
        if (isset($this->heading) && $this->heading != '') {
            Html::addCssClass($this->headingOptions, 'box-header');
            $heading = Html::tag('div', '<h3 class="box-title">' . $this->heading . '</h3>', $this->headingOptions);
        }
        $body = Html::tag('div', $this->renderMenu(), ['class' => 'table']);
        $type = in_array($this->type, self::$_validTypes) ? $this->type : self::TYPE_DEFAULT;
        Html::addCssClass($this->containerOptions, "sidenav box box-{$type}");
        echo Html::tag('div', $heading . $body, $this->containerOptions);
    }
}