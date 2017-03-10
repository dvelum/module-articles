<?php
class Trigger_Dvelum_Article_Category extends Trigger
{
    public function onAfterPublish(Db_Object $object)
    {
        parent::onAfterPublish($object);
        $this->clearTopCache($object);
    }

    public function onAfterUnpublish(Db_Object $object)
    {
        parent::onAfterUnpublish($object);
        $this->clearTopCache($object);
    }

    public function onAfterDelete(Db_Object $object)
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