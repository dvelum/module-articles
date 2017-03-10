<?php
/**
 * Top articles
 */
class Block_Dvelum_Articles extends Block
{
    protected $_template = 'dvelum_articles/block_articles.php';

    const cacheable = false;
    const dependsOnPage = false;
    const CACHE_KEY = 'block_dvelum_articles_';


    static public function getCacheKey($id){
        return md5(self::CACHE_KEY . '_' . $id);
    }

    /**
     * (non-PHPdoc)
     * @see Block_Abstract::render()
     */
    public function render()
    {
        $articlesConfig = Config::storage()->get('articles.php');
        $appConfig = Config::storage()->get('main.php');
        $externalsConfig = $appConfig->get('externals');
        Resource::getInstance()->addCss($externalsConfig['resources_root'] . 'dvelum_articles/css/style.css', 100);

        // Add localization dictionary loader
        Lang::addDictionaryLoader('dvelum_articles', $appConfig->get('language').'/dvelum_articles.php');

        $data = Model::factory('Dvelum_Article')->getTop(false , $articlesConfig->get('block_count'), $articlesConfig->get('block_image_size'));

        $tpl = new Template();
        $tpl->setData([
            'config' => $this->_config,
            'place' => $this->_config['place'],
            'data' => $data,
            'date_format' => $articlesConfig->get('date_format'),
            'lang' => Lang::lang('dvelum_articles')
        ]);

        return $tpl->render($this->_template);
    }
}