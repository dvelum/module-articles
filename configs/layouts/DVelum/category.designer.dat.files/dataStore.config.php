<?php return array (
  'id' => 'dataStore',
  'class' => 'Ext_Data_Store',
  'extClass' => 'Data_Store',
  'name' => 'dataStore',
  'state' => 
  array (
    'config' => 
    array (
      'autoLoad' => true,
      'model' => 'Dvelum_Article_CategoryModel',
      'remoteSort' => true,
    ),
    'state' => 
    array (
    ),
    'fields' => 
    array (
    ),
    'proxy' => 
    array (
      'class' => 'Ext_Virtual',
      'extClass' => 'Data_Proxy_Ajax',
      'state' => 
      array (
        'config' => 
        array (
          'directionParam' => 'pager[dir]',
          'limitParam' => 'pager[limit]',
          'simpleSortMode' => true,
          'sortParam' => 'pager[sort]',
          'startParam' => 'pager[start]',
          'url' => '[%wroot%][%admp%][%-%]dvelum_articles_category[%-%]list',
          'reader' => false,
          'type' => 'ajax',
        ),
      ),
    ),
    'reader' => 
    array (
      'class' => 'Ext_Virtual',
      'extClass' => 'Data_Reader_Json',
      'state' => 
      array (
        'config' => 
        array (
          'rootProperty' => 'data',
          'totalProperty' => 'count',
          'type' => 'json',
        ),
      ),
    ),
    'writer' => '',
  ),
); 