<?php
namespace innovotel\widgets;

use rmrevin\yii\fontawesome\component\Icon;
use Yii;
use yii\base\Widget;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;

/*
 * 'boxTools' => Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) . ' ' . Html::a(
                        'Delete',
                        ['delete', 'id' => $model->id],
                        [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]
                    )
 */

class BoxTools extends Widget
{
    public $items;

    public function run()
    {
        //print_r($this->items);
        //exit;
        return $this->renderItems($this->items);
    }

    public function renderItems($items)
    {
        $ret = '';
        foreach ($items as $item) {
            if (empty($item['role']) || Yii::$app->user->can($item['role'])) {
                if (!empty($ret)) $ret .= ' ';
                $ret .= $this->renderItem($item);
            }
        }
        return $ret;
    }

    public function renderItem($item)
    {
        // Make sure they have permission to do this
        if (!empty($item['role']) && !Yii::$app->user->can($item['role'])) return '';


        // Render the item.
        $label = '';
        if (isset($item['icon'])) {
            $label .= '<i class="fa fa-' . $item['icon'] . '"></i>';
        }
        if (isset($item['label'])) {
            $label .= $item['label'];
        }
        
        $class = 'boxnavitem';
        if (isset($item['class'])) {
            $class .= ' ' . $item['class'];
        }

        if (!empty($item['items'])) {
            return ButtonDropdown::widget([
                'label' => $label,
                'encodeLabel' => false,
                'dropdown' => [
                    'items' => $item['items'],
                ],
            ]);
        } else {
            $url = empty($item['url']) ? ['#'] : $item['url'];
            $options = empty($item['options']) ? [] : $item['options'];
            return Html::tag('span', Html::a($label, $url, $options), $class);
        }
    }
}
