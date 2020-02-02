<?php return array (
  'id' => 'categoryFilter',
  'class' => 'Ext_Virtual',
  'extClass' => 'Form_Field_Combobox',
  'name' => 'categoryFilter',
  'state' => 
  array (
    'config' => 
    array (
      'store' => 'categoryStore',
      'valueField' => 'id',
      'displayField' => 'title',
      'forceSelection' => true,
      'queryMode' => 'local',
      'emptyText' => '[js:] appLang.ALL',
      'triggers' => '{clear: {cls: \'x-form-clear-trigger\',tooltip:appLang.RESET, handler:function(){this.childObjects.categoryFilter.reset();this.setViewFilter(\'filter[main_category]\',\'\')},scope:this}}',
      'name' => 'categoryFilter',
      'isExtended' => false,
    ),
  ),
); 