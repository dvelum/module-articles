<?php
$catList = $this->get('categories');
$categoryId =  $this->get('category_id');

echo '<ul class="dv_article menu">';

foreach ($catList as $cat){
    $cls = '';
    if($cat['id'] === $categoryId){
        $cls = ' active';
    }
    echo '<li><a class="category' . $cls . '" href="' . $cat['url'] . '">' . $cat['title'] . '</a></li>';
}

echo '</ul>';
