<?php
class Trigger_Dvelum_Article_Category extends Trigger
{
    public function onAfterPublish(\Dvelum\Orm\ObjectInterface $object)
    {
        parent::onAfterPublish($object);
        $this->clearTopCache($object);
    }

    public function onAfterUnpublish(\Dvelum\Orm\ObjectInterface $object)
    {
        parent::onAfterUnpublish($object);
        $this->clearTopCache($object);
    }

    public function onAfterDelete(\Dvelum\Orm\ObjectInterface $object)
    {
        parent::onAfterDelete($object);
        $this->clearTopCache($object);
    }

    public function clearTopCache($object)
    {
        if(!$this->_cache)
            return;

        $model = Model::factory('Dvelum_Article_Category');

        $this->_cache->remove($model->getCacheKey(['item', 'url', $object->url]));
        $model->resetPublishedCache();
    }

}