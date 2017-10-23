<?php

class HomePage extends Page 
{
    private static $db = array(
    );

    private static $has_one = array(
    );

    private static $has_many = array(
        'GalleryImages' => 'GalleryImage'
    );

    private static $description = "Home Page with Images";

    public function getCMSFields() {
        $fields = parent::getCMSFields();

        $fields->removeByName('GalleryImages');

        $gridConfig = GridFieldConfig_RecordEditor::create();
        $gridConfig->addComponent(new GridFieldSortableRows('SortOrder'));
        $galleryImages = new GridField('GalleryImages', 'Gallery Images', $this->GalleryImages(),
            $gridConfig);

        $gridConfig->getComponentByType('GridFieldDataColumns')->setDisplayFields(
                [
                    'Thumbnail' => 'Image'
                ]
        );

        $fields->addFieldToTab('Root.Gallery', $galleryImages);
        return $fields;
    }
}

