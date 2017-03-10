<?php
$data = $this->get('data');
$router = new Router_Module();
$config = $this->get('config');
$lang = $this->get('lang');

$itemUrl = $router->findUrl('dvelum_articles_item');

echo '<div class="blockItem">';

if($config['show_title'])
    echo '<div class="blockTitle">' .$config['title'] .'</div>';

echo '<div class="blockContent">';

echo '<div class="dv_article block article">';


foreach ($data as $article)
{

    $articleUrl = Request::url(array($itemUrl , $article['url']));


    echo '<div class="item">';
    echo '<div class="date">'.date($this->get('date_format'),strtotime($article['date_published'])).'</div>';

    if(!empty($article['image']) && isset($article['image']) && !empty($article['image']))
    {
        echo '<div class="pic"><a href="'.$articleUrl.'"><img src="'.$article['image'].'" title="'.$article['title'].'"/></a></div>';
        echo '<div class="title"><a href="'.$articleUrl.'">'.$article['title'].'</a></div>';

    }else{
        echo '<div class="title">
                <a href="'.$articleUrl.'">'.$article['title'].'</a>
              </div>';
    }

    echo '</div>
          <div class="clear"></div>';

}
echo '
   <div class="showMore">
        <a href="'.Request::url(array('articles')).'">'.$lang->get('more_articles').'</a>
    </div>
    <div class="clear"></div>
';

echo '</div> </div></div>';