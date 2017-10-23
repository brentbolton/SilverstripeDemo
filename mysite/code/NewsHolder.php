<?php
class NewsHolder extends Page {
    private static $allowed_children = array('NewsPage');

    private static $db = array (
        'StoriesPerPage' => 'Int',
        'HighlightEveryNthStory' => 'Int'
    );

    private static $description = 'List of news pages';
 
    public function getCMSFields() {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab('Root.Main', new NumericField('StoriesPerPage'), 'Content');
        $fields->addFieldToTab('Root.Main', new NumericField('HighlightEveryNthStory'), 'Content');
        $fields->removeByName('Content');

        return $fields;
    }
}

class NewsHolder_Controller extends Page_Controller {

    /**
     * Returns a paginated list of all pages in the site.
     */
    public function PaginatedPages() {
        $list = NewsPage::get()->filter('ParentID', $this->ID)
                               ->sort(array('Published' => 'DESC', 'ID' => 'DESC'));

        $pages = new PaginatedList($list, $this->getRequest());
        $pages->setPageLength($this->StoriesPerPage);

        return $pages;
    }

    public function PaginationOffset() {
        $start = $this->getRequest()->getVar('start');
        if (empty($start)) {
            $start = 0;
        }
        $start++;

        return $start;
    }
}
