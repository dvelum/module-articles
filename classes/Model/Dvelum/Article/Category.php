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

        if($this->_cache){
            $cacheKey = $this->getCacheKey(['published']);
            $list  = $this->_cache->load($cacheKey);

            if(!empty($list))
                return $list;
        }

        $list = $this->getList(false,['published'=>true]);

        if(!empty($list))
            $list = Utils::rekey('url', $list);

        if($this->_cache)
            $this->_cache->save($list , $cacheKey);

        return $list;
    }

    /**
     * Reset cache of published categories
     */
    public function resetPublishedCache()
    {
        if(!$this->_cache)
            return;

        $this->_cache->remove($this->getCacheKey(['published']));
    }
}