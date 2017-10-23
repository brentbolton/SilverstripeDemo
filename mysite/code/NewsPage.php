
<?php
class NewsPage extends Page {

    private static $db = array(
        'Published' => 'Date',
        'Author' => 'Text'
    );

    private static $has_one = array(
	'Image' => 'Image'
    );

   private static $can_be_root = false;

    private static $description = 'Page that displays a news item';

    public function getCMSFields() {
        $fields = parent::getCMSFields();

        $publishedField = new DateField('Published');
        $publishedField->setConfig('showcalendar', true);

        $imageUploadField = new UploadField(
                    $name = 'Image',
                    $title = 'Upload an image'
                );    

        $fields->addFieldToTab('Root.Main', $publishedField, 'Content');
        $fields->addFieldToTab('Root.Main', new TextField('Author'), 'Content');
        $fields->addFieldToTab('Root.Main', $imageUploadField, 'Content');

        return $fields;
    }
}

class NewsPage_Controller extends Page_Controller {

    function NextPublishedSibling() {
        $pages = NewsPage::get()
            ->filter(array(
                       'ParentID' => $this->ParentID,
                       'Published:GreaterThanOrEqual' => $this->Published))
            ->exclude('ID', $this->ID)
            ->exclude(array('Published' => $this->Published, 'ID:LessThan' => $this->ID))
            ->sort(array('Published' => 'ASC', 'ID' => 'ASC'));
    if($pages) return $pages->first();
  }
  function PreviousPublishedSibling() {
        $pages = NewsPage::get()
            ->filter(array(
                       'ParentID' => $this->ParentID,
                       'Published:LessThanOrEqual' => $this->Published))
            ->exclude('ID', $this->ID)
            ->exclude(array('Published' => $this->Published, 'ID:GreaterThan' => $this->ID))
            ->sort(array('Published' => 'DESC', 'ID' => 'DESC'));
    if($pages) return $pages->First();
  }
}
