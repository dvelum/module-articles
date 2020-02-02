<?php return array (
  'id' => 'dataGrid',
  'class' => 'Ext_Grid',
  'extClass' => 'Grid',
  'name' => 'dataGrid',
  'state' => 
  array (
    'config' => 
    array (
      'store' => 'dataStore',
      'columnLines' => true,
      'viewConfig' => '{enableTextSelection: true}',
      'title' => '[js:] dvelum_articlesLang.article_categories',
      'minHeight' => 400.0,
      'isExtended' => true,
    ),
    'state' => 
    array (
      '_advancedPropertyValues' => 
      array (
        'groupHeaderTpl' => '{name} ({rows.length})',
        'startCollapsed' => false,
        'clicksToEdit' => 2,
        'rowBodyTpl' => '',
        'enableGroupingMenu' => true,
        'hideGroupedHeader' => false,
        'expander_rowbodytpl' => '',
        'paging' => true,
      ),
    ),
    'columns' => 
    array (
      'published' => 
      array (
        'id' => 'published',
        'parent' => 0,
        'class' => 'Ext_Grid_Column',
        'name' => 'published',
        'extClass' => 'Grid_Column',
        'order' => 0,
        'state' => 
        array (
          'config' => 
          array (
            'align' => 'center',
            'dataIndex' => 'published',
            'renderer' => 'Ext_Component_Renderer_System_Publish',
            'text' => '[js:] appLang.STATUS',
            'itemId' => 'published',
            'width' => 50.0,
          ),
        ),
      ),
      'id' => 
      array (
        'id' => 'id',
        'parent' => 0,
        'class' => 'Ext_Grid_Column',
        'name' => 'id',
        'extClass' => 'Grid_Column',
        'order' => 1,
        'state' => 
        array (
          'config' => 
          array (
            'align' => 'center',
            'dataIndex' => 'id',
            'renderer' => 'Ext_Component_Renderer_System_Version',
            'text' => '[js:] appLang.VERSIONS_HEADER',
            'itemId' => 'id',
            'width' => 147.0,
          ),
        ),
      ),
      'title' => 
      array (
        'id' => 'title',
        'parent' => 0,
        'class' => 'Ext_Grid_Column',
        'name' => 'title',
        'extClass' => 'Grid_Column',
        'order' => 2,
        'state' => 
        array (
          'config' => 
          array (
            'dataIndex' => 'title',
            'text' => '[js:] appLang.TITLE',
            'itemId' => 'title',
            'width' => 153.0,
          ),
        ),
      ),
      'url' => 
      array (
        'id' => 'url',
        'parent' => 0,
        'class' => 'Ext_Grid_Column',
        'name' => 'url',
        'extClass' => 'Grid_Column',
        'order' => 3,
        'state' => 
        array (
          'config' => 
          array (
            'dataIndex' => 'url',
            'text' => '[js:] dvelum_articlesLang.url_code',
            'itemId' => 'url',
            'width' => 110.0,
          ),
        ),
      ),
      'date_created' => 
      array (
        'id' => 'date_created',
        'parent' => 0,
        'class' => 'Ext_Grid_Column',
        'name' => 'date_created',
        'extClass' => 'Grid_Column',
        'order' => 4,
        'state' => 
        array (
          'config' => 
          array (
            'align' => 'center',
            'dataIndex' => 'date_created',
            'renderer' => 'Ext_Component_Renderer_System_Creator',
            'text' => '[js:] appLang.CREATED_BY',
            'itemId' => 'date_created',
            'width' => 224.0,
          ),
        ),
      ),
      'date_updated' => 
      array (
        'id' => 'date_updated',
        'parent' => 0,
        'class' => 'Ext_Grid_Column',
        'name' => 'date_updated',
        'extClass' => 'Grid_Column',
        'order' => 5,
        'state' => 
        array (
          'config' => 
          array (
            'align' => 'center',
            'dataIndex' => 'date_updated',
            'renderer' => 'Ext_Component_Renderer_System_Updater',
            'text' => '[js:] appLang.UPDATED_BY',
            'itemId' => 'date_updated',
            'width' => 217.0,
          ),
        ),
      ),
      'dataGrid_actions' => 
      array (
        'id' => 'dataGrid_actions',
        'parent' => 0,
        'class' => 'Ext_Grid_Column_Action',
        'name' => 'dataGrid_actions',
        'extClass' => 'Grid_Column_Action',
        'order' => 6,
        'state' => 
        array (
          'config' => 
          array (
            'align' => 'center',
            'text' => '[js:] appLang.ACTIONS',
            'width' => 50.0,
          ),
          'actions' => 
          array (
            'dataGrid_actions_delete' => 
            array (
              'id' => 'dataGrid_actions_delete',
              'parent' => 0,
              'name' => 'dataGrid_actions_delete',
              'class' => 'Ext_Grid_Column_Action_Button',
              'extClass' => 'Grid_Column_Action_Button',
              'order' => false,
              'state' => 
              array (
                'config' => 
                array (
                  'isDisabled' => 'function(){return !this.canDelete;}',
                  'icon' => '[%wroot%]i/system/delete.png',
                  'text' => 'dg_action_delete',
                  'tooltip' => '[js:] appLang.DELETE',
                ),
              ),
            ),
          ),
        ),
      ),
    ),
  ),
); 