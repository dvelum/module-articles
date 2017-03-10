<?php
$relatedArticles = $this->get('list');
$lang = $this->get('lang');
?>
<strong><?php echo $lang->get('more_articles');?></strong>

<ul class="relatedArticles">
    <?php
    foreach($relatedArticles as $article)
    {
        echo '<li class="item">';

        if(!empty($article['image'])){
            echo '<div class="pic"><a href="'.$article['url'].'"><img src="'.$article['image'].'"/></a></div>';
        }

        echo '<div class="content">'
                . '<a href="'.$article['url'].'"><div class="title">'.$article['title'].'</div></a>'
                . '<div class="brief">'.$article['brief'].'</div>'
            .'</div>';

        echo '</a></li>';
    }
    ?>
</ul>
<div class="clear empty"></div>