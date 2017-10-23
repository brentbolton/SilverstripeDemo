 <?php
 
class GalleryImage extends DataObject {

        private static $db = array(
                'SortOrder' => 'Int'
        );

        private static $has_one = array(
                'Image' => 'Image',
                'Page' => 'Page'
        );

	public static $default_sort = 'SortOrder ASC';

        public function getCMSFields() {
            $fields = parent::getCMSFields();
            $fields->removeByName('SortOrder');
            return $fields;
       }

       public function Thumbnail() {
           if ($this->Image()) {
               return $this->Image()->setWidth(100);
           }
       }
}

