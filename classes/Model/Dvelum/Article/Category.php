<?php
class Model_Dvelum_Article_Category extends Model
{
    /**
     * Get list of published categories
     * @return array
     */
    public function getPublished()
    {
        static $list = false;

        if($list)
            return $list;

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