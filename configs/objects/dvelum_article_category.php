<?php return array (
  'table' => 'articles_category',
  'engine' => 'InnoDB',
  'connection' => 'default',
  'rev_control' => true,
  'save_history' => true,
  'link_title' => 'title',
  'disable_keys' => false,
  'readonly' => false,
  'locked' => false,
  'primary_key' => 'id',
  'use_db_prefix' => true,
  'fields' => 
  array (
    'title' => 
    array (
      'type' => '',
      'unique' => '',
      'db_isNull' => false,
      'required' => true,
      'validator' => '',
      'db_type' => 'varchar',
      'db_default' => '',
      'db_len' => 255,
      'is_search' => true,
      'allow_html' => false,
    ),
    'meta_keywords' => 
    array (
      'type' => '',
      'unique' => '',
      'db_isNull' => true,
      'required' => false,
      'validator' => '',
      'db_type' => 'text',
      'db_default' => false,
      'is_search' => false,
      'allow_html' => false,
    ),
    'meta_description' => 
    array (
      'type' => '',
      'unique' => '',
      'db_isNull' => true,
      'required' => false,
      'validator' => '',
      'db_type' => 'text',
      'db_default' => false,
      'is_search' => false,
      'allow_html' => false,
    ),
    'url' => 
    array (
      'type' => '',
      'unique' => 'url',
      'db_isNull' => false,
      'required' => true,
      'validator' => 'Validator_Pagecode',
      'db_type' => 'varchar',
      'db_default' => '',
      'db_len' => 255,
      'is_search' => true,
      'allow_html' => false,
    ),
  ),
  'indexes' => 
  array (
    'url' => 
    array (
      'columns' => 
      array (
        0 => 'url',
      ),
      'unique' => true,
      'fulltext' => false,
      'PRIMARY' => false,
    ),
  ),
  'acl' => false,
  'slave_connection' => 'default',
  'parent_object' => '',
  'log_detalization' => 'default',
); 