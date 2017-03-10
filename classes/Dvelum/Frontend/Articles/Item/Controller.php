<?php
class Dvelum_Frontend_Articles_Item_Controller extends Frontend_Controller
{
    /**
     * Articles config
     * @var Config_Abstract $config
     */
    protected $config;


    public function __construct()
    {
        parent::__construct();

        $this->config = Config::storage()->get('articles.php');
        $externalsConfig = $this->_configMain->get('externals');
        $this->_resource->addCss($externalsConfig['resources_root'] . 'dvelum_articles/css/style.css', 100);

        // add localization dictionary
        Lang::addDictionaryLoader('dvelum_articles', $this->_configMain->get('language').'/dvelum_articles.php', Config::File_Array);
    }

    public function indexAction()
    {
        $code = Request::getInstance()->getPart(1);
        $vers = Request::get('vers', 'integer' , false);

        if(empty($code)){
            Response::redirect('/');
            return;
        }

        /**
         * @var Model_Dvelum_Article
         */
        $articlesModel = Model::factory('Dvelum_Article');
        $categoriesModel = Model::factory('Dvelum_Article_Category');

        if($vers){
            $data = $articlesModel->getItemByUniqueField('url',$code);
        }else{
            $data = $articlesModel->getCachedItemByField('url',$code);
        }

        if($vers && User::getInstance()->isAuthorized()) {
            $data = Model::factory('Vc')->getData('Dvelum_Article', $data['id'] , $vers);
        } else {
            if(!empty($data) && !$data['published'])
                $data = [];
        }

        /*
         * Check if article is published
         */
        if(empty($data)){
            Response::notFound();
        }

        $scheme = 'http://';
        if(Request::isHttps()){
            $scheme = 'https://';
        }

        $pageUrl =  $scheme . Request::server('HTTP_HOST', 'string', '').Request::url(array($this->_router->findUrl('dvelum_articles_item'), $data['url']));

        if(empty($data['date_published'])){
            $data['date_published'] = date('Y-m-d H:i:s');
        }

        $this->_page->date_published = $data['date_published'];
        $this->_page->html_title = $data['title'];
        $this->_page->page_title = $data['title'];
        $this->_page->meta_keywords = $data['meta_keywords'];
        $this->_page->meta_description = $data['meta_description'];

        $this->_page->setOgProperty('title', $data['title']);
        $this->_page->setOgProperty('url', $pageUrl);
        $this->_page->setOgProperty('description', $data['brief']);
        $this->_page->setOgProperty('type', 'article');


        // Get article main category
        $categoryInfo = $categoriesModel->getCachedItem($data['main_category']);
        if(!empty($categoryInfo)){
            $categoryInfo['url'] = Request::url([
                $this->_router->findUrl('dvelum_articles'),
                $categoryInfo['url']
            ]);
        }

        // Get article image url
        if(!empty($data['image'])){
            $imgData = Model::factory('Medialib')->getCachedItem($data['image']);
            if(!empty($imgData)){
                $data['image'] = Model_Medialib::getImgPath($imgData['path'], $imgData['ext'],  $this->config->get('article_image_size'));
                //Open Graph property
                $this->_page->setOgProperty('image', $scheme . Request::server('HTTP_HOST', 'string', '').$data['image']);
            }else{
                $data['image']= '';
            }
        }

        // Article Item page code
        $itemUrl =  $this->_router->findUrl('dvelum_articles_item');

        // Get related articles
        $relatedCount = $this->config->get('related_count');
        $relatedArticles = [];
        if($relatedCount){
            $relatedArticles = $articlesModel->getRelated(
                $data['id'],
                $data['main_category'],
                $data['date_published'],
                $this->config->get('related_count')
            );
            if(!empty($relatedArticles)){
                // apply image urls
                $relatedArticles = $articlesModel->addImagePaths($relatedArticles, $this->config->get('related_image_size'),'image');
                // apply articles urls
                foreach($relatedArticles as &$item){
                    $item['url'] = Request::url([$itemUrl, $item['url']]);
                }unset($item);
            }
        }

        // Prepare template
        $template = new Template();
        $template->setData([
            'page' => $this->_page,
            'data' => $data,
            'related_articles' => $relatedArticles,
            'itemUrl' => $itemUrl,
            'lang' => Lang::lang('dvelum_articles'),
            'date_format' => $this->config->get('date_format'),
            'category_info' => $categoryInfo
        ]);

        /*
         * Render article content
         */
        $this->_page->text.= $template->render('dvelum_articles/article.php');


        if(isset($data['allow_comments']) && $data['allow_comments'] && $this->config['comments_tpl'])
        {
            $cTemplate = new Template([
                'itemUrl' => $itemUrl,
                'itemId'  => $data['id']
            ]);
            $this->_page->text.=  $cTemplate->render($this->config['comments_tpl']);
        }
    }
}