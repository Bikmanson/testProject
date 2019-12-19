<?php
namespace app\widgets\newDynamicForm;

use yii\web\AssetBundle;

class SortableAsset extends AssetBundle
{
    public $js = [
        'sortable-jquery-ui.min.js',
    ];
    public $css = [
        'sortable-jquery-ui.min.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        parent::init();
    }

    /**
     * Sets the source path if empty
     * @param string $path the path to be set
     */
    protected function setSourcePath($path)
    {
        if (empty($this->sourcePath)) {
            $this->sourcePath = $path;
        }
    }
}
