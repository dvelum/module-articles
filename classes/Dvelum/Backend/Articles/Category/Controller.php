<?php 
class Dvelum_Backend_Articles_Category_Controller extends Backend_Controller_Crud_Vc
{
    protected $_listFields = [
        "title",
        "url",
        "id",
        "date_created",
        "date_published",
        "date_updated",
        "author_id",
        "editor_id",
        "published",
        "published_version",
        "last_version"
    ];

    protected $_listLinks = [];
    protected $_canViewObjects = [];

    public function getModule()
    {
        return 'Dvelum_Articles_Category';
    }

    public function getObjectName()
    {
        return 'Dvelum_Article_Category';
    }
}