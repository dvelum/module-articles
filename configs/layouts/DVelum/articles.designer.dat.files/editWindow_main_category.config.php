<?php return array (
  'id' => 'editWindow_main_category',
  'class' => 'Ext_Virtual',
  'extClass' => 'Form_Field_Combobox',
  'name' => 'editWindow_main_category',
  'state' => 
  array (
    'config' => 
    array (
      'store' => 'categoryStore',
      'valueField' => 'id',
      'displayField' => 'title',
      'forceSelection' => true,
      'allowBlank' => false,
      'name' => 'main_category',
      'isExtended' => false,
      'fieldLabel' => '[js:] dvelum_articlesLang.category',
    ),
  ),
); 