<?php

class Task_Sitemap extends Minion_Task
{
    protected $_options = array(
        'env'=>'PRODUCTION'
    );
    protected function _execute(array $params)
    {
        $generator = new Icamys\SitemapGenerator\SitemapGenerator('https://www.nege.kz');
        $generator->createGZipFile = true;
        $generator->maxURLsPerSitemap = 50000;
        $generator->sitemapFileName = "sitemap.xml";
        $generator->sitemapIndexFileName = "sitemap-index.xml";

        foreach (ORM::factory('Category')->where('show', '=', 1)->find_all() as $categoryItem) {
            $generator->addUrl($categoryItem->view_url(), null,null, null);
        }

        foreach (ORM::factory('Page')->find_all() as $categoryItem) {
            $generator->addUrl($categoryItem->view_url(), null,null, null);
        }

        foreach (ORM::factory('Author')->find_all() as $authorItem) {
            $generator->addUrl($authorItem->view_url(), null,null, null);
        }

        foreach (ORM::factory('News')->where('status', '=', 1)->where('lang', '=', I18n::$lang)->where('date', '<=', Date::formatted_time('now', 'Y-m-d H:i'))->order_by('id', 'DESC')->find_all() as $newsItem) {
            $generator->addUrl($newsItem->view_url(), null,null, null);
        }

        $generator->createSitemap();
        $generator->writeSitemap();
    }
}