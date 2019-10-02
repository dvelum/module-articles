<?php
/**
 *  DVelum project https://github.com/dvelum/dvelum
 *  Copyright (C) 2011-2017  Kirill Yegorov
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/*
 * Sitemap module adapter
 */

namespace Dvelum\Sitemap\Adapter;

use Dvelum\Orm\Model;
use Dvelum\Request;
use Dvelum\Sitemap\AbstractAdapter;

class Articles extends AbstractAdapter
{
    public function getItemsXML()
    {
        $articlesModel = Model::factory('dvelum_article');

        $list = $articlesModel->query()
                              ->params([
                                    'sort' => 'id',
                                    'dir' => 'DESC',
                                    'start' => 0,
                                    'limit' => 30000
                                ])
                                ->filters([
                                    'published' => true,
                                ])->fields([
                                    'url',
                                    'date_updated' => ' DATE_FORMAT(date_updated,"%Y-%m-%d")',
                                    'date_created' => ' DATE_FORMAT(date_created,"%Y-%m-%d")'
                                ])
                                ->fetchAll();
        $curDate = date('Y-m-d');

        $xml = '';
        $articlesPage = $this->router->findUrl('dvelum_articles_item');

        $request = Request::factory();
        foreach($list as $k => $v)
        {
            $url = $request->url([$articlesPage , $v['url']]);

            if(strlen($v['date_updated'])) {
                $xml .= $this->createItemXML($url, $v['date_updated'], self::CHANGEFREQ_WEEKLY, 0.8);
            }else {
                $xml .= $this->createItemXML($url, $v['date_created'], self::CHANGEFREQ_WEEKLY, 0.8);
            }
        }
        return $xml;
    }
}