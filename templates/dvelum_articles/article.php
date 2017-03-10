<?php
$data = $this->get('data');
$relatedArticles = $this->get('related_articles');
$page = $this->get('page');

$categoryInfo = $this->get('category_info');

$categoryLink = '';
if(!empty($categoryInfo) && $categoryInfo['published']){
    $categoryLink = '<span class="categoryLink"><a href="'.$categoryInfo['url'].'">'.$categoryInfo['title'].'</a></span>';
}


?>
<div class="dv_article">
        <article class="article">
            <h1><?php echo $page->page_title;?></h1>
            <div>
                <span class="date"><?php echo date($this->get('date_format'), strtotime($data['date_published']))?></span>
                <?php echo $categoryLink;?>
            </div>
            <?php
            if(!empty($data['image']))
                echo '<div class="pic article"><img itemprop="image" src="'.$data['image'].'"/></a></div>';
            ?>
            <div class="articleBody">
                <?php echo $data['text']; ?>
            </div>

        </article>
        <div class="clear empty"></div>
    <div class="sep"></div>
    <div class="clear empty"></div>
    <?php
    if(!empty($relatedArticles)){

        $template = new Template();
        $template->disableCache();
        $template->set('lang', $this->get('lang'));
        $template->set('list', $relatedArticles);
        echo $template->render('dvelum_articles/related_articles.php');
    }?>
</div>
