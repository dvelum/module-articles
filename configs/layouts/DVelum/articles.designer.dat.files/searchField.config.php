<?php return array (
  'id' => 'searchField',
  'class' => 'Ext_Virtual',
  'extClass' => 'Form_Field_Text',
  'name' => 'searchField',
  'state' => 
  array (
    'config' => 
    array (
      'triggers' => '{clear: {cls: \'x-form-clear-trigger\',tooltip:appLang.RESET, handler:function(){this.childObjects.searchField.reset();this.setViewFilter(\'search\',\'\')},scope:this}}',
      'name' => 'searchField',
      'isExtended' => false,
    ),
  ),
); 