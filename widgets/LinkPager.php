<?php

namespace app\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class LinkPager extends \yii\widgets\LinkPager
{
    public $statisticPageLabel = '共 {totalPage}页 {totalRow} 条数据';
    public $statisticPageClass = 'page-total';
    public $hideOnSinglePage = false;

    public function init() {
        parent::init();

    }

    public function run()
    {
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }
        echo $this->renderPageButtons();
    }


    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        $totalCount = $this->pagination->totalCount;
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];
        $currentPage = $this->pagination->getPage();

        // statistic page
        $statisticPageLabel = $this->statisticPageLabel;
        if ($statisticPageLabel !== false) {

            $statisticPageLabel = str_replace(['{totalPage}', '{totalRow}'], [$pageCount, $totalCount], $this->statisticPageLabel);

            $buttons[] = $this->renderPageButton($statisticPageLabel, 0, $this->statisticPageClass, true, false);
        }

        // first page
        $firstPageLabel = $this->firstPageLabel === true ? '1' : $this->firstPageLabel;
        if ($firstPageLabel !== false) {
            $buttons[] = $this->renderPageButton($firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false);
        }

        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton($this->prevPageLabel, $page, $this->prevPageCssClass, $currentPage <= 0, false);
        }

        // internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->renderPageButton($i + 1, $i, null, $this->disableCurrentPageButton && $i == $currentPage, $i == $currentPage);
        }

        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        // last page
        $lastPageLabel = $this->lastPageLabel === true ? $pageCount : $this->lastPageLabel;
        if ($lastPageLabel !== false) {
            $buttons[] = $this->renderPageButton($lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'ul');

        return Html::tag($tag, implode("\n", $buttons), $options);
    }

}