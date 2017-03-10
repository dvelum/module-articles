<?php

/**
 * Backend Controller for Articles module
 */
class Dvelum_Backend_Articles_Controller extends Backend_Controller_Crud_Vc
{
    protected $_listFields = [
        "id",
        "title",
        "url",
        "allow_comments",
        "meta_keywords",
        "image",
        "main_category",
        "date_created",
        "date_published",
        "date_updated",
        "author_id",
        "editor_id",
        "published",
        "brief",
        "published_version",
        "last_version"
    ];

    protected $_listLinks = [
        'category_title'=>'main_category'
    ];

    protected $_canViewObjects = [
        'dvelum_article_category'
    ];

    public function getModule()
    {
        return 'Dvelum_Articles';
    }

    public function getObjectName()
    {
        return 'Dvelum_Article';
    }

    /**
     * Find staging URL
     * @param Db_Object $object
     * @return string
     */
    public function getStagingUrl(Db_Object $object)
    {
        $routerClass =  $this->_configMain->get('frontend_router');
        $router = new $routerClass();

        $stagingUrl = $router->findUrl(strtolower('dvelum_articles_item'));

        if(!strlen($stagingUrl))
            return Request::url(array('404'));

        return Request::url(array($stagingUrl , $object->get('url')));
    }

    protected function _getList()
    {
        $data =  parent::_getList();
        /**
         * @var Model_Dvelum_Article
         */
        $articleModel = Model::factory('Dvelum_Article');

        if(empty($data))
            return [];

        $list = $data['data'];
        $list = $articleModel->addImagePaths($list, 'medium', 'image');

        $routerClass =  $this->_configMain->get('frontend_router');
        $router = new $routerClass();
        $stagingUrl = $router->findUrl('dvelum_articles_item');

        foreach($list as $k=>&$v) {
            $v['staging_url'] = Request::url([$stagingUrl, $v['url']]);
        }unset($v);

        $data['data'] = $list;

        return $data;
    }

    /**
     * Save article on drop event
     */
    public function dropAction()
    {
        $this->_checkCanEdit();
        $this->_checkCanPublish();

        $id = Request::post('id', Filter::FILTER_INTEGER, false);
        $published = Request::post('published', Filter::FILTER_BOOLEAN, false);

        try{
            $article = Db_Object::factory('dvelum_article', $id);
        }catch (Exception $e){
            Response::jsonError($this->_lang->get('WRONG_REQUEST'));
        }

        $this->_checkOwner($article);

        $acl = $article->getAcl();
        if($acl && !$acl->canPublish($article))
            Response::jsonError($this->_lang->CANT_PUBLISH);

        if($published)
        {
            $versionControlModel = Model::factory('Vc');
            $version = $versionControlModel->getLastVersion($this->_objectName , $id);

            if(!$article->publish($version)){
                Response::jsonError($this->_lang->get('CANT_EXEC'));
            }

            Response::jsonSuccess(['published_version'=>$version]);
        }else{
            if(!$article->unpublish()){
                Response::jsonError($this->_lang->get('CANT_EXEC'));
            }
            Response::jsonSuccess(['published_version'=>0]);
        }
    }

    /**
     * Get list of categories for combobox filter
     */
    public function categoriesAction()
    {
        $model = Model::factory('dvelum_article_category');
        $list = $model->getList(['sort'=>'title','dir'=>'ASC'],false,['id','title']);
        Response::jsonSuccess($list);
    }
}