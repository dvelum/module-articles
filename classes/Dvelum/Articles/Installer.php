<?php
namespace Dvelum\Articles;

use Dvelum\App\Model\Permissions;
use Dvelum\Config;
use Dvelum\Config\ConfigInterface;
use Dvelum\App\Session\User;
use Dvelum\Orm\Model;
use Dvelum\Lang;
use Dvelum\Orm\Record;

class Installer extends \Dvelum\Externals\Installer
{
    /**
     * Install
     * @param ConfigInterface $applicationConfig
     * @param ConfigInterface $moduleConfig
     * @return bool
     */
    public function install(ConfigInterface $applicationConfig, ConfigInterface $moduleConfig) : bool
    {
        Lang::addDictionaryLoader('dvelum_articles', $applicationConfig->get('language').'/dvelum_articles.php', Config\Factory::File_Array);

        // Add article pages and blocks
        if(!$this->addPages() || !$this->addBlocks()){
            return false;
        }

        // Add permissions
        $userInfo = User::factory()->getInfo();
        /**
         * @var Permissions $permissionsModel
         */
        $permissionsModel = Model::factory('Permissions');
        if(!$permissionsModel->setGroupPermissions($userInfo['group_id'], 'Dvelum_Articles' , 1 , 1 , 1 , 1)){
            return false;
        }
        if(!$permissionsModel->setGroupPermissions($userInfo['group_id'], 'Dvelum_Articles_Category' , 1 , 1 , 1 , 1)){
            return false;
        }
        if(!$this->addCategory() || !$this->addArticle()){
            return false;
        }

        return true;
    }

    /**
     * Uninstall
     * @param ConfigInterface $applicationConfig
     * @param ConfigInterface $moduleConfig
     * @return bool
     */
    public function uninstall(ConfigInterface $applicationConfig, ConfigInterface $moduleConfig) : bool
    {
        $pagesModel = Model::factory('Page');
        $pageItems = $pagesModel->query()->filters(['func_code' => 'dvelum_articles'])->fetchAll();

        foreach($pageItems as $item)
        {
            try{
                $page = Record::factory('Page', $item['id']);
                $page->unpublish();
            }catch (\Exception $e){
                $this->errors[] = $e->getMessage();
                return false;
            }
        }

        $pageItems = $pagesModel->query()->filters(['func_code' => 'dvelum_articles_item'])->fetchAll();
        foreach($pageItems as $item)
        {
            try{
                $page = Record::factory('Page', $item['id']);
                $page->unpublish();
            }catch (\Exception $e){
                $this->errors[] = $e->getMessage();
                return false;
            }
        }
    }

    /**
     * Add article pages
     * @return bool
     * @throws \Exception
     */
    protected function addPages() : bool
    {
        $userId = User::factory()->getId();
        $lang = Lang::lang('dvelum_articles');

        $pagesModel = Model::factory('Page');
        $pageItem = $pagesModel->query()->filters(['func_code' => 'dvelum_articles'])->fetchAll();

        if(empty($pageItem))
        {
            try{
                $articlesPage = Record::factory('Page');
                $articlesPage->setValues([
                    'code'=>'articles',
                    'is_fixed'=>1,
                    'html_title'=>$lang->get('articles'),
                    'menu_title'=>$lang->get('articles'),
                    'page_title'=>$lang->get('articles'),
                    'meta_keywords'=>'',
                    'meta_description'=>'',
                    'parent_id'=>null,
                    'text' =>'',
                    'func_code'=>'dvelum_articles',
                    'order_no' => 1,
                    'show_blocks'=>true,
                    'published'=>false,
                    'published_version'=>0,
                    'editor_id'=>$userId,
                    'date_created'=>date('Y-m-d H:i:s'),
                    'date_updated'=>date('Y-m-d H:i:s'),
                    'author_id'=>$userId,
                    'blocks'=>'',
                    'theme'=>'default',
                    'date_published'=>date('Y-m-d H:i:s'),
                    'in_site_map'=>true,
                    'default_blocks'=>true
                ]);

                if(!$articlesPage->saveVersion())
                    throw new \Exception('Cannot create articles page');

                if(!$articlesPage->publish())
                    throw new \Exception('Cannot publish articles page');

            }catch (\Exception $e){
                $this->errors[] = $e->getMessage();
                return false;
            }
            $articlesPageId = $articlesPage->getId();
        }else{
            $articlesPageItem = $pageItem[0];
            $articlesPageId = $articlesPageItem['id'];
        }

        $pageItem = $pagesModel->query()->filters(['func_code' => 'dvelum_articles_item'])->fetchAll();
        if(empty($pageItem))
        {
            try{
                $page = Record::factory('Page');
                $page->setValues(array(
                    'code'=>'article',
                    'is_fixed'=>1,
                    'html_title'=>$lang->get('article_page'),
                    'menu_title'=>$lang->get('article_page'),
                    'page_title'=>$lang->get('article_page'),
                    'meta_keywords'=>'',
                    'meta_description'=>'',
                    'parent_id'=>$articlesPageId,
                    'text' =>'',
                    'func_code'=>'dvelum_articles_item',
                    'order_no' => 1,
                    'show_blocks'=>true,
                    'published'=>false,
                    'published_version'=>0,
                    'editor_id'=>$userId,
                    'date_created'=>date('Y-m-d H:i:s'),
                    'date_updated'=>date('Y-m-d H:i:s'),
                    'author_id'=>$userId,
                    'blocks'=>'',
                    'theme'=>'default',
                    'date_published'=>date('Y-m-d H:i:s'),
                    'in_site_map'=>false,
                    'default_blocks'=>true
                ));

                if(!$page->saveVersion())
                    throw new \Exception('Cannot create article page');

                if(!$page->publish())
                    throw new \Exception('Cannot publish article page');

            }catch (\Exception $e){
                $this->errors[] = $e->getMessage();
                return false;
            }
        }
        return true;
    }

    /**
     * Add test category
     */
    protected function addCategory()
    {
        $lang = Lang::lang('dvelum_articles');
        $categoryModel = Model::factory('Dvelum_Article_Category');

        if($categoryModel->query()->filters(['url'=>'test_category'])->getCount())
            return true;

        try{
            $category = Record::factory('Dvelum_Article_Category');
            $category->setValues([
                'url' => 'test_category',
                'title' => $lang->get('test_category')
            ]);
            if(!$category->saveVersion())
                throw new \Exception('Cannot add test category');

            if(!$category->publish())
                throw new \Exception('Cannot publish test category');

        }catch (\Exception $e){
            $this->errors[] = $e->getMessage();
            return false;
        }
        return true;
    }

    /**
     * Add test article
     */
    protected function addArticle()
    {
        $lang = Lang::lang('dvelum_articles');

        $articleModel = Model::factory('Dvelum_Article');
        $categoryModel = Model::factory('Dvelum_Article_Category');
        $catInfo = $categoryModel->getItemByField('url','test_category');

        if($articleModel->query()->filters(['url'=>'test_article'])->getCount())
            return true;

        try{
            $article = Record::factory('Dvelum_Article');
            $article->setValues([
                'url' => 'test_category',
                'title' => $lang->get('test_article'),
                'brief' => 'DVelum is a quick development platform based on ExtJS framework and PHP + MySQL on the server side.',
                'allow_comments' => true,
                'main_category' => $catInfo['id'],
                'text' => 'DVelum is a quick development platform based on ExtJS framework and PHP + MySQL on the server side. The platform opportunities allow to create a ready-to-go application in minutes without using complex XML configuration files, all settings being adjusted in visual interfaces. Automatically generated interfaces are easy to modify with the help of built-in layout designer.'
            ]);
            if(!$article->saveVersion())
                throw new \Exception('Cannot add test article');
            if(!$article->publish())
                throw new \Exception('Cannot publish test article');
        }catch (\Exception $e){
            $this->errors[] = $e->getMessage();
            return false;
        }
        return true;
    }

    /**
     * Create page blocks
     */
    protected function addBlocks()
    {
        $articleBlock = Model::factory('Blocks')->query()->filters(['sys_name' => '\\Dvelum\\App\\Block\\Articles'])->getCount();

        if($articleBlock)
            return true;

        try{
            $articleBlock = Record::factory('Blocks');
            $articleBlock->setValues([
                'is_menu' => false,
                'is_system' => true,
                'show_title' => true,
                'sys_name' => '\\Dvelum\\App\\Block\\Articles',
                'title' => Lang::lang('dvelum_articles')->get('articles')
            ]);

            if(!$articleBlock->saveVersion())
                throw new \Exception('Cannot create article block');

            if(!$articleBlock->publish())
                throw new \Exception('Cannot publish article block');

        }catch (\Exception $e){
            $this->errors[] = $e->getMessage();
            return false;
        }
        return true;
    }
}