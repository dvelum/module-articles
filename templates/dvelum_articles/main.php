<?php
$articles = $this->get('articles');
$catList = Utils::rekey('id', $this->get('cat_list'));
$itemUrl = $this->get('itemUrl');
$categoryUrl  = $this->get('categoryUrl');
$lang = $this->get('lang');


$template = new Template();
$template->set('categories', $catList);
$template->set('category_id' , false);

$template->render('dvelum_articles/menu.php');


echo '<div class="dv_article listPage">';

echo $template->render('dvelum_articles/menu.php');

echo '<div class="clear empty"></div>';

?>
<div class="articleCards">
    <?php
    foreach ($articles as $article)
    {
        if(!isset($catList[$article['main_category']]))
            continue;

        $date = date($this->get('date_format'), strtotime($article['date_published']));

        $image = '';
        if(!empty($article['image']) && !empty($article['image'])){
            $image = '<div class="pic"><a href="'.$article['url'].'"><img src="'.$article['image'].'" title="'.$article['title'].'"></a></div><div class="clear"></div>';
        }

        echo   '<div class="item">',
                   $image,
                   '<div class="content">',
                        '<a href="'.$article['url'].'"><div class="title">'.$article['title'].'</div></a>',
                        '<div class="brief">'.$article['brief'].'</div>',
                        '<div class="sign">',
                            '<span class="date">'.$date.'</span> ',
                            '<a class="category" href="'.$catList[$article['main_category']]['url'].'">'.$catList[$article['main_category']]['title'].'</a>',
                        '</div>',
                    '</div>',
                '</div>';
    }
    echo '<div class="clear empty"></div>'.$this->get('pager');
    ?>
</div>
<div class="clear empty"></div>
</div>