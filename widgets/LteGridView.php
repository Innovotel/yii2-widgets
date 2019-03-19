<?php
namespace innovotel\widgets;

/**
 * This displays a specialized grid view with Navigation on the right
 */

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use innovotel\helpers\Html;


class LteGridView extends \kartik\grid\GridView implements FilterStateInterface
{
    use FilterStateTrait;
    
	public $nav = '';

	// Change a few defaults from kartik's gridview
	public $condensed = true;
	public $hover = true;
	public $floatHeader = false;
	public $export = false;
    
    // Use AdminLTE styles instead of bootstrap
    public $panelPrefix = 'box box-';
	
	public $saveFilters = true;

	public $panelHeadingTemplate = <<< HTML
<div class="box-tools pull-right">{nav}</div>
<h3 class="box-title">{heading}</h3>
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
		$heading = ArrayHelper::getValue($this->panel, 'heading', '');

		$this->panelHeadingTemplate = strtr(
			$this->panelHeadingTemplate,
			[
				'{nav}' => $nav,
                '{heading}' => $heading,
			]
		);

		GridViewAsset::register($this->getView());
	}
	
	public function behaviors()
    {
        $b = []; //parent::behaviors();
        if ($this->saveFilters) $b[] =
            [
                'class' => FilterStateBehavior::className(),
            ]
        ;
        return $b;
    }
    
    /**
     * Sets the grid panel layout based on the [[template]] and [[panel]] settings.
     */
    protected function renderPanelBad()
    {
        if (!$this->bootstrap || !is_array($this->panel) || empty($this->panel)) {
            return;
        }
        $type = ArrayHelper::getValue($this->panel, 'type', self::TYPE_DEFAULT);
        $heading = ArrayHelper::getValue($this->panel, 'heading', '');
        $footer = ArrayHelper::getValue($this->panel, 'footer', '');
        $before = ArrayHelper::getValue($this->panel, 'before', false);
        $after = ArrayHelper::getValue($this->panel, 'after', false);
        $headingOptions = ArrayHelper::getValue($this->panel, 'headingOptions', []);
        $footerOptions = ArrayHelper::getValue($this->panel, 'footerOptions', []);
        $beforeOptions = ArrayHelper::getValue($this->panel, 'beforeOptions', []);
        $afterOptions = ArrayHelper::getValue($this->panel, 'afterOptions', []);
        $panelHeading = '';
        $panelBefore = '';
        $panelAfter = '';
        $panelFooter = '';
        
        if ($heading !== false) {
            static::initCss($headingOptions, 'box-header');
            $content = strtr($this->panelHeadingTemplate, ['{heading}' => $heading]);
            $panelHeading = Html::tag('div', $content, $headingOptions);
        }
        if ($footer !== false) {
            static::initCss($footerOptions, 'box-footer');
            $content = strtr($this->panelFooterTemplate, ['{footer}' => $footer]);
            $panelFooter = Html::tag('div', $content, $footerOptions);
        }
        if ($before !== false) {
            static::initCss($beforeOptions, 'kv-panel-before');
            $content = strtr($this->panelBeforeTemplate, ['{before}' => $before]);
            $panelBefore = Html::tag('div', $content, $beforeOptions);
        }
        if ($after !== false) {
            static::initCss($afterOptions, 'kv-panel-after');
            $content = strtr($this->panelAfterTemplate, ['{after}' => $after]);
            $panelAfter = Html::tag('div', $content, $afterOptions);
        }
        $this->layout = strtr(
            $this->panelTemplate,
            [
                '{panelHeading}' => $panelHeading,
                '{prefix}' => $this->panelPrefix,
                '{type}' => $type,
                '{panelFooter}' => $panelFooter,
                '{panelBefore}' => $panelBefore,
                '{panelAfter}' => $panelAfter,
            ]
        );
    }
}

