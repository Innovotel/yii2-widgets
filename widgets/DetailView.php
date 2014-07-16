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

use yii\helpers\ArrayHelper;
use innovotel\helpers\Html;


class DetailView extends \yii\widgets\DetailView
{

    public $columns = 1;
    public $sectionTemplate = '<tr><th colspan="{columns}"><h3 class="panel-title detail-view-section-header">{value}</h3></th></tr>';
    //public $sectionTemplate = '<tr><th colspan="2" class="detail-view-section-header">{value}</th></tr>';
    public $options = ['class' => 'table table-striped table-bordered detail-view'];
    public $rowTemplate = '<tr>{row}</tr>';
    public $template = '<th class="detail-view-label-{columns}"{labelwidth}>{label}</th><td colspan="{colspan}"{width}>{value}</td>';
    public $widthTemplate = ' style="width: {width}"';


    public function init()
    {
        parent::init();
        DetailViewAsset::register($this->getView());
    }

    /**
     * Renders a single attribute.
     *
     * @param array $attribute the specification of the attribute to be rendered.
     * @param integer $index the zero-based index of the attribute in the [[attributes]] array
     * @return string the rendering result
     */
    protected function renderAttribute($attribute, $index)
    {
        if (is_string($this->sectionTemplate) && !empty($attribute['type']) && $attribute['type'] == 'section') {
            // FIXME: I'm not thrilled with the formatting of this, but it works for now.
            return strtr(
                $this->sectionTemplate,
                [
                    '{columns}' => $this->columns * 2,
                    '{label}' => $attribute['label'],
                    '{value}' => $this->formatter->format($attribute['value'], $attribute['format']),
                    '{width}' => empty($attribute['width']) ? '' : strtr(
                            $this->widthTemplate,
                            ['{width}' => $attribute['width']]
                        ),
                    '{labelwidth}' => empty($attribute['labelWidth']) ? '' : strtr(
                            $this->widthTemplate,
                            ['{width}' => $attribute['labelWidth']]
                        ),
                ]
            );
        } else {
            if (is_string($this->template)) {
                return strtr(
                    $this->template,
                    [
                        '{columns}' => $this->columns,
                        '{label}' => $attribute['label'],
                        '{colspan}' => empty($attribute['columns']) ? 1 : $attribute['columns'] * 2 - 1,
                        '{value}' => $this->formatter->format($attribute['value'], $attribute['format']),
                        '{width}' => empty($attribute['width']) ? '' : strtr(
                                $this->widthTemplate,
                                ['{width}' => $attribute['width']]
                            ),
                        '{labelwidth}' => empty($attribute['labelWidth']) ? '' : strtr(
                                $this->widthTemplate,
                                ['{width}' => $attribute['labelWidth']]
                            ),
                    ]
                );
            } else {
                return call_user_func($this->template, $attribute, $index, $this);
            }
        }
    }

    public function run()
    {
        $rows = [];
        $i = 0;
        $s = 0;
        $n = 0;
        $cols = '';
        foreach ($this->attributes as $attribute) {
            if ($i && !empty($attribute['type']) && $attribute['type'] == 'section') {
                if (!empty($cols)) {
                    if ($n) {
                        $cols .= strtr('<td colspan={colspan}>&nbsp;</td>', ['{colspan}' => ($this->columns - $n) * 2]);
                    }
                    // Close the row before doing the section
                    $rows[$s][] = strtr(
                        $this->rowTemplate,
                        [
                            '{row}' => $cols,
                        ]
                    );
                    $cols = '';
                    $n = 0;
                }
                $s++;

                // Add the section
                $rows[$s][] = $this->renderAttribute($attribute, $i++);
            }
            // Multicolumn attribute check
            if (!empty($attribute['columns'])) {
                if ($attribute['columns'] > $this->columns) {
                    $attribute['columns'] = $this->columns;
                }
                if ($n && $n + $attribute['columns'] >= $this->columns) {
                    // We would exceed the max columns for this table,
                    // close the row and then proceed.

                    // Finish off the row.
                    $cols .= strtr('<td colspan={colspan}>&nbsp;</td>', ['{colspan}' => ($this->columns - $n) * 2]);

                    $rows[$s][] = strtr(
                        $this->rowTemplate,
                        [
                            '{row}' => $cols,
                        ]
                    );
                    $cols = '';
                    $n = 0;
                }
            }
            $cols .= $this->renderAttribute($attribute, $i);
            if (!empty($attribute['columns'])) {
                $n += $attribute['columns'];
            } else {
                $n++;
            }
            if ($n == $this->columns) {
                // Close the row.
                // Close the row before doing the section
                $rows[$s][] = strtr(
                    $this->rowTemplate,
                    [
                        '{row}' => $cols,
                    ]
                );
                $cols = '';
                $n = 0;
            }

            //$rows[$s][] = $this->renderAttribute($attribute, $i++);
        }
        // If we're still open, close the row
        if (!empty($cols)) {
            // Close the row before doing the section
            if ($n) {
                $cols .= strtr('<td colspan={colspan}>&nbsp;</td>', ['{colspan}' => ($this->columns - $n) * 2]);
            }
            $rows[$s][] = strtr(
                $this->rowTemplate,
                [
                    '{row}' => $cols,
                ]
            );
        }

        // Now setup the table itself.
        for ($s = 0; $s < count($rows); $s++) {
            $opts = $this->options;
            if ($s /*< count($rows)*/) {
                if (!empty($opts['class'])) {
                    $opts['class'] .= ' detail-view-section';
                } else {
                    $opts['class'] = 'detail-view-section';
                }
            } else {
                if (!empty($opts['class'])) {
                    $opts['class'] .= ' detail-view-first';
                } else {
                    $opts['class'] = 'detail-view-first';
                }
            }
            $tag = ArrayHelper::remove($this->options, 'tag', 'table');
            echo Html::tag($tag, implode("\n", $rows[$s]), $opts);
        }
        //foreach($rows as $section) {
        //	$tag = ArrayHelper::remove($this->options, 'tag', 'table');
        //	echo Html::tag($tag, implode("\n", $section), $this->options);
        //}
        //$tag = ArrayHelper::remove($this->options, 'tag', 'table');
        //echo Html::tag($tag, implode("\n", $rows), $this->options);
    }

}
