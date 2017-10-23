<?php
class SitemapPage extends Page {

    private static $description = 'Sitemap of Pages';
 
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName('Content');
        return $fields;
    }
}

class SitemapPage_Controller extends Page_Controller {

    /**
     * Returns a list of every page on the site.
     */
    public function SiteList() {

        $list = GroupedList::create(Page::get()->sort(array('Title' => 'ASC')));

        return $list;
    }
}
