<?php
/**
 * Created by PhpStorm.
 * User: guoxiaosong
 * Date: 2016/10/24
 * Time: 17:46
 */
namespace mztest\infiniteLevel;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class InfiniteLevel extends InputWidget
{
    /**
     * @var array the HTML attributes for the container, if hideInput is set to true. The following special options
     * are recognized:
     * - `tag`: string, the HTML tag for rendering the container. Defaults to `div`.
     */
    public $containerOptions = ['class' => 'row'];
    /**
     * @var array|false the HTML attributes for the wrapper of the input tag.
     * - `tag`: string, the HTML tag for rendering the container. Defaults to `div`.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $inputContainerOptions = ['class' => 'col-md-4'];
    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $inputOptions = ['class' => 'form-control'];
    /**
     * @var array
     * As Javascript will auto sort the json data that is indexed by the number, we store the data like this.
     * Like [0 => [['value' => 'VALUE', 'label' => 'LABEL'], ['value' => 'VALUE', 'label' => 'LABEL']]]
     */
    public $items = [];
    /**
     * @var array
     */
    public $itemParents = [];
    /**
     * @var int All categories are its descendant.
     */
    public $rootLevel = 0;

    public function init()
    {
        parent::init();
        if (!isset($this->containerOptions['id'])) {
            $this->containerOptions['id'] = $this->getId(). '-'. $this->options['id'] .'-container';
        }

        if (!isset($this->inputOptions['prompt'])) {
            $this->inputOptions['prompt'] = Yii::t('app', 'Please Choose');
        }

        $this->inputOptions = ArrayHelper::merge($this->inputOptions, ['id' => false]);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        InfiniteLevelAsset::register($this->getView());
        $id = $this->containerOptions['id'];
        $options = Json::htmlEncode([
            'items' => $this->items,
            'itemParents' => $this->itemParents
        ]);
        $this->getView()->registerJs("jQuery('#$id').infinityLevel($options)");
        echo $this->renderWidget();
    }

    /**
     * Renders the AutoComplete widget.
     * @return string the rendering result.
     */
    protected function renderWidget()
    {
        if ($this->hasModel()) {
            $hidden = Html::activeHiddenInput($this->model, $this->attribute);
        } else {
            $hidden = Html::hiddenInput($this->name, $this->value);
        }

        $inputContainerTag = ArrayHelper::remove($this->inputContainerOptions, 'tag', 'div');
        $input = Html::tag(
            $inputContainerTag,
            Html::dropDownList(null, $this->getRoot(), $this->getRootList(), $this->inputOptions),
            $this->inputContainerOptions);

        $containerTag = ArrayHelper::remove($this->containerOptions, 'tag', 'div');

        return Html::tag($containerTag, $hidden . $input, $this->containerOptions);
    }

    /**
     * @return array
     */
    protected function getRootList()
    {
        $result = [];
        if (isset($this->items[$this->rootLevel])) {
            foreach($this->items[$this->rootLevel] as $key => $value) {
                $result[$value['value']] = $value['label'];
            }
        }

        return $result;
    }
    /**
     * @return array
     */
    protected function getRoot()
    {
        return isset($this->itemParents[0]) ? $this->itemParents[0] : '';
    }

}