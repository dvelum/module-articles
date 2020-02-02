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

namespace Dvelum\App\Model\Dvelum;

use Dvelum\App\Model\Medialib;
use Dvelum\Orm\Model;
use Dvelum\Utils;

class Article extends Model
{
    /**
     * Article fields for lists
     * @var array
     */
    protected $topListFields = [
        'id',
        'main_category',
        'url',
        'title',
        'brief',
        'image',
        'date_published'
    ];

    /**
     * Get previous articles from category
     * @param integer $articleId
     * @param integer $categoryId
     * @param string $dataPublished
     * @param integer $count
     * @return array
     */
    public function getRelated($articleId, $categoryId, $dataPublished, $count) : array
    {
        $cacheKey =  $this->getCacheKey([
            'related_articles',
             $articleId,
        ]);

        $data = false;

        if($this->cache){
            $data = $this->cache->load($cacheKey);
        }

        if($data !==false)
            return $data;

        $sql = $this->dbSlave->select()->from(
                $this->table(),
                $this->topListFields
            )
            ->where('main_category =?', $categoryId)
            ->where('date_published < ?', $dataPublished)
            ->where('id !=?',$articleId)
            ->where('published = 1')
            ->order('date_published DESC')
            ->limit($count);

        $data = $this->dbSlave->fetchAll($sql);

        if($this->cache){
            $this->cache->save($data , $cacheKey);
            $list = [];
            if(!empty($data)){
                $list = Utils::fetchCol('id', $data);
            }
            $this->saveRelationsCache($articleId , $list);
        }
        return $data;
    }

    /**
     * Get image path to result set
     * @param array $data
     * @param string $imageSize - size name from media library config
     * @param string $key - array key for image path
     * @return array
     */
    public function addImagePaths($data, $imageSize, $key = 'image') : array
    {
        if(empty($data)){
            return [];
        }

        $mediaModel = Model::factory('Medialib');
        $imageIds = Utils::fetchCol('image', $data);

        if(!empty($imageIds))
        {
            $images = $mediaModel->getItems($imageIds,['id','path','ext'], true);

            if(!empty($images))
            {
                $images = Utils::rekey('id', $images);

                foreach($data as $k => &$v)
                {
                    if(!empty($v['image']) && isset($images[$v['image']])){
                        $img = $images[$v['image']];
                        $v[$key] = $mediaModel->getImgPath($img['path'], $img['ext'], $imageSize, true);
                    }else{
                        $v[$key] = '';
                    }
                }
            }
        }
        return $data;
    }


    /**
     * Cet count of published articles
     * @param integer | boolean $category, default false
     * @return bool|integer
     */
    public function getPublishedCount($category = false)
    {
        $data = false;

        if($this->cache){
            $key = $this->getCacheKey(['articles_published', $category]);
            $data = $this->cache->load($key);
        }

        if(!empty($data)){
            return $data;
        }

        $filters = array(
            'published' => 1,
        );

        if($category){
            $filters['main_category']= $category;
        }

        $count = $this->query()->filters($filters)->getCount();

        if($this->cache)
            $this->cache->save($count , $key);

        return $count;
    }

    /**
     * Reset related articles cache
     * @param $articleId
     */
    public function resetRelatedCache($articleId)
    {
        if(!$this->cache)
            return;

        $cacheKey =  $this->getCacheKey([
            'related_articles',
            $articleId,
        ]);

        $this->cache->remove($cacheKey);
    }

    /**
     * Reset latest articles cache
     * @param $category, optional default false
     */
    public function resetTopCache($category)
    {
        if(!$this->cache)
            return;

        $this->cache->remove($this->getCacheKey(array('top_100', intval($category))));
    }

    /**
     * Reset cache of published counter
     * @param integer | boolean $category, default false
     */
    public function resetPublishedCount($category = false)
    {
        if($this->cache){
            $key = $this->getCacheKey(['articles_published', $category]);
            $this->cache->remove($key);
        }
    }

    /**
     * Get list of top articles
     * @param integer|boolean $categoryId
     * @param integer $count
     * @param integer $offset
     * @param string $imageSize
     * @return array
     */
    public function getTop($categoryId = false, $count = 10 , $offset = 0, $imageSize = 'thumbnail')
    {
        $count = intval($count);
        $offset = intval($offset);

        $pager = [
            'sort'=>'date_published',
            'dir'=>'DESC',
            'start' =>$offset,
            'limit' =>$count
        ];

        $filter = array(
            'published' => true
        );

        if($categoryId) {
            $filter['main_category'] = $categoryId;
        }

        /*
         * Get from cache
         */
        if($this->cache && (($offset + $count) < 100)){
            $data = array_slice($this->getTop100($categoryId, $imageSize), $offset , $count);
        }else{
            $data = $this->query()->params($pager)->filters($filter)->fields($this->topListFields)->fetchAll();
            if(!empty($data)) {
                $data = $this->addImagePaths($data, $imageSize, 'image');
            }
        }
        return $data;
    }

    /**
     * Get top 100 Articles
     * @param integer|boolean $category
     * @param string $imageSize
     * @return array
     */
    public function getTop100($category = false, $imageSize = 'thumbnail')
    {
        $data = false;

        if($this->cache){
            $hash = $this->getCacheKey(array('top_100' , intval($category)));
            $data = $this->cache->load($hash);
        }

        if($data !==false){
            $data = $this->addImagePaths($data, $imageSize, 'image');
            return $data;
        }

        $pager = array(
            'sort'=>'date_published',
            'dir'=>'DESC',
            'start' =>0,
            'limit' =>100
        );

        $filter = array(
            'published' => true,
        );

        if($category)
            $filter['main_category'] = $category;

        $data = $this->query()->params($pager)->filters($filter)->fields($this->topListFields)->fetchAll();

        if($this->cache)
            $this->cache->save($data , $hash);

        if(!empty($data)) {
            $data =  $this->addImagePaths($data, $imageSize, 'image');
        }

        return $data;
    }

    /**
     * Save cache of article relations
     * @param integer $articleId
     * @param array $relatedArticles
     */
    public function saveRelationsCache($articleId, array $relatedArticles)
    {
        if(!$this->cache)
            return;

        foreach($relatedArticles as $id)
        {
            $relationKey = $this->getCacheKey(['article_related_to',$id]);
            $relations = $this->cache->load($relationKey);

            if(empty($relations) || !is_array($relations))
                $relations = [];

            if(!in_array($articleId, $relations, true))
                $relations[] = $articleId;

            $this->cache->save($relations, $relationKey);
        }
    }

    /**
     * Reset Related Articles cache which contains articleId
     * @param $articleId
     */
    public function resetRelationsCache($articleId)
    {
        if(!$this->cache)
            return;

        $relationKey = $this->getCacheKey(['article_related_to',$articleId]);
        $relations = $this->cache->load($relationKey);

        if(!empty($relations)){
            foreach($relations as $id){
                $cacheKey =  $this->getCacheKey([
                    'related_articles',
                    $id,
                ]);
                $this->cache->remove($cacheKey);
            }
        }
    }
}