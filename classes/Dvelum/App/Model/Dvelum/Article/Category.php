<?php
/**
 *  DVelum project https://github.com/dvelum/dvelum , https://github.com/k-samuel/dvelum , http://dvelum.net
 *  Copyright (C) 2011-2020  Kirill Yegorov
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
 *
 */
declare(strict_types=1);

namespace Dvelum\App\Model\Dvelum\Article;

use Dvelum\Orm\Model;
use Dvelum\Utils;

class Category extends Model
{
    /**
     * Get list of published categories
     * @return array
     */
    public function getPublished()
    {
        static $list = false;

        if(!empty($list)){
            return $list;
        }

        if($this->cache){
            $cacheKey = $this->getCacheKey(['published']);
            $list  = $this->cache->load($cacheKey);

            if(!empty($list))
                return $list;
        }

        $list = $this->query()->filters(['published'=>true])->fetchAll();

        if(!empty($list))
            $list = Utils::rekey('url', $list);

        if($this->cache)
            $this->cache->save($list , $cacheKey);

        return $list;
    }

    /**
     * Reset cache of published categories
     */
    public function resetPublishedCache()
    {
        if(!$this->cache)
            return;

        $this->cache->remove($this->getCacheKey(['published']));
    }
}