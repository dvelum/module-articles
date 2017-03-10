<?php return array (
  'table' => 'dvelum_article',
  'engine' => 'InnoDB',
  'rev_control' => true,
  'save_history' => true,
  'link_title' => 'title',
  'fields' => 
  array (
    'text' => 
    array (
      'type' => '',
      'unique' => '',
      'db_isNull' => true,
      'required' => false,
      'validator' => '',
      'db_type' => 'longtext',
      'db_default' => false,
      'is_search' => false,
      'allow_html' => true,
    ),
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
    'brief' => 
    array (
      'type' => '',
      'unique' => '',
      'db_isNull' => true,
      'required' => false,
      'validator' => '',
      'db_type' => 'longtext',
      'db_default' => false,
      'is_search' => false,
      'allow_html' => false,
    ),
    'allow_comments' => 
    array (
      'type' => '',
      'unique' => '',
      'db_isNull' => false,
      'required' => false,
      'validator' => '',
      'db_type' => 'boolean',
      'db_default' => 0,
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
    'image' => 
    array (
      'type' => 'link',
      'unique' => '',
      'db_isNull' => true,
      'required' => false,
      'validator' => '',
      'link_config' => 
      array (
        'link_type' => 'object',
        'object' => 'medialib',
      ),
      'db_type' => 'bigint',
      'db_default' => false,
      'db_unsigned' => true,
    ),
    'main_category' => 
    array (
      'type' => 'link',
      'unique' => '',
      'db_isNull' => false,
      'required' => true,
      'validator' => '',
      'link_config' => 
      array (
        'link_type' => 'object',
        'object' => 'dvelum_article_category',
      ),
      'db_type' => 'bigint',
      'db_default' => false,
      'db_unsigned' => true,
    ),
    'tags' => 
    array (
      'type' => '',
      'unique' => '',
      'db_isNull' => true,
      'required' => false,
      'validator' => '',
      'db_type' => 'varchar',
      'db_default' => '',
      'db_len' => 255,
      'is_search' => true,
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
      'db_len' => 150,
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
    'date_published' => 
    array (
      'columns' => 
      array (
        0 => 'date_published',
      ),
      'unique' => false,
      'fulltext' => false,
      'PRIMARY' => false,
    ),
  ),
  'disable_keys' => false,
  'connection' => 'default',
  'locked' => false,
  'readonly' => false,
  'primary_key' => 'id',
  'use_db_prefix' => true,
  'acl' => false,
  'slave_connection' => 'default',
  'parent_object' => '',
  'log_detalization' => 'default',
); 