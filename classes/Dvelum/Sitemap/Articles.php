<?php
class Dvelum_Sitemap_Articles extends Dvelum_Sitemap_Adapter
{
    public function getItemsXML()
    {
        $articlesModel = Model::factory('dvelum_article');

        $list = $articlesModel->getList(array(
            'sort' => 'id',
            'dir' => 'DESC',
            'start'=>0,
            'limit'=>30000
        ) , array(
            'published' => true,
        ) , array(
            'url' ,
            'date_updated' => ' DATE_FORMAT(date_updated,"%Y-%m-%d")' ,
            'date_created' => ' DATE_FORMAT(date_created,"%Y-%m-%d")'
        ));

        $curDate = date('Y-m-d');

        $xml = '';
        $articlesPage = $this->router->findUrl('dvelum_articles_item');

        foreach($list as $k => $v)
        {
            $url = Request::url([$articlesPage , $v['url']]);

            if(strlen($v['date_updated'])) {
                $xml .= $this->createItemXML($url, $v['date_updated'], self::CHANGEFREQ_WEEKLY, 0.8);
            }else {
                $xml .= $this->createItemXML($url, $v['date_created'], self::CHANGEFREQ_WEEKLY, 0.8);
            }
        }
        return $xml;
    }
}