<?php
class Dvelum_Frontend_Articles_Controller extends Frontend_Controller
{
    /**
     * @avr Model_Dvelum_Article_Category $categoryModel
     */
    protected $categoryModel;
    /**
     * @var Model_Dvelum_Article $articleModel
     */
    protected $articleModel;
    /**
     * Article categories ifo
     * @var array
     */
    protected $categories;
    /**
     * Articles config
     * @var Config_Abstract $config
     */
    protected $config;

    public function __construct()
    {
        parent::__construct();

        $externalsConfig = $this->_configMain->get('externals');
        $this->_resource->addCss($externalsConfig['resources_root'] . 'dvelum_articles/css/style.css', 100);
        $this->categoryModel = Model::factory('Dvelum_Article_Category');
        $this->articleModel = Model::factory('Dvelum_Article');
        $this->categories = $this->categoryModel->getPublished();
        $this->config = Config::storage()->get('articles.php');

        // add localization dictionary
        Lang::addDictionaryLoader('dvelum_articles', $this->_configMain->get('language').'/dvelum_articles.php', Config::File_Array);
    }

    public function indexAction()
    {
        $category = Request::getInstance()->getPart(1);

        if(isset($this->categories[$category])){
            $this->listCategory($category);
        }else{
            $this->listTop();
        }
    }

    /**
     * Show category page list
     * @param $category
     */
    protected function listCategory($category)
    {
        $page =  intval(Request::getInstance()->getPart(2));

        $category = $this->categories[$category];

        if(!$page || $page<0)
            $page = 1;

        $count = $this->articleModel->getPublishedCount($category['id']);
        $articles = [];
        if($count)
        {
            $articles = $this->articleModel->getTop(
                $category['id'],
                $this->config->get('list_count') ,
                ($this->config->get('list_count') * ($page-1)),
                $this->config->get('preview_image_size')
            );

            $articleItemUrl = $this->_router->findUrl('dvelum_articles_item');

            if(!empty($articles)){
                foreach($articles as &$item){
                    $item['url'] = Request::url([$articleItemUrl , $item['url']]);
                }unset($item);
            }
        }

        $categoryUrl = $this->_router->findUrl('dvelum_articles');

        $categories = [];
        foreach ($this->categories as $code => $item) {
            $item['url'] = Request::url([$categoryUrl , $item['url']]);
            $categories[$code] = $item;
        }

        $pager = new Paginator();
        $pager->curPage = $page;
        $pager->numLinks = 5;
        $pager->pageLinkTpl = Request::url([$categoryUrl ,$category['url'] , '[page]']);
        $pager->numPages = ceil($count / $this->config->get('list_count'));


        $template = new Template();
        $template->setProperties(array(
            'articles' => $articles,
            'page' => $this->_page,
            'pager' => $pager,
            'category' => $category,
            'cat_list' => $categories,
            'date_format' => $this->config->get('date_format'),
        ));


        $scheme = 'http://';
        if(Request::isHttps()){
            $scheme = 'https://';
        }

        $this->_page->page_title = $category['title'];
        $this->_page->html_title = $category['title'];
        $this->_page->meta_keywords = $category['meta_keywords'];
        $this->_page->meta_description = $category['meta_description'];

        $this->_page->setOgProperty('title', $category['title']);
        $this->_page->setOgProperty('url', $scheme . Request::server('HTTP_HOST', Filter::FILTER_STRING, '').Request::url([$categoryUrl, $category['url']]));
        $this->_page->setOgProperty('description', $category['meta_description']);

        $this->_page->text = $template->render('dvelum_articles/category.php');
    }

    /**
     * show main page list
     * @throws Exception
     */
    protected function listTop()
    {
        $page =  intval(Request::getInstance()->getPart(1));

        if(!$page || $page<0)
            $page = 1;

        $categoryUrl = $this->_router->findUrl('dvelum_articles');

        $categories = [];

        foreach ($this->categories as $code => $item) {
            $item['url'] = Request::url([$categoryUrl , $item['url']]);
            $categories[$code] = $item;
        }

        $count = $this->articleModel->getPublishedCount();

        $pager = new Paginator();
        $pager->curPage = $page;
        $pager->numLinks = 5;
        $pager->pageLinkTpl = Request::url([$categoryUrl ,'[page]']);
        $pager->numPages = ceil($count / $this->config->get('list_count'));

        $articles = $this->articleModel->getTop(
            false,
            $this->config->get('list_count') , (
            $this->config->get('list_count')*($page-1)),
            $this->config->get('preview_image_size')
        );

        $articleItemUrl = $this->_router->findUrl('dvelum_articles_item');

        if(!empty($articles)){
            foreach($articles as &$item){
                $item['url'] = Request::url([$articleItemUrl , $item['url']]);
            }unset($item);
        }

        $template = new Template();
        $template->setData(array(
            'cat_list' => $categories,
            'articles' => $articles,
            'pager' => $pager,
            'itemUrl' => $this->_router->findUrl('dvelum_articles_item'),
            'lang' =>Lang::lang('dvelum_articles'),
            'date_format' => $this->config->get('date_format')
        ));

        $this->_page->text.= $template->render('dvelum_articles/main.php');
    }
}