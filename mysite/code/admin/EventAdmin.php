<?php

class EventAdmin extends ModelAdmin
{

    protected $products_per_page = 50;

    private static $managed_models = [
        'EventPage'
    ];

    private static $menu_title = 'Events';

    private static $url_segment = 'event-admin';
    public $showImportForm = false;

    private static $url_priority = 40;
    static $menu_priority = 1.5;

    private static $allowed_actions = [
        'EditForm'
    ];
    private static $menu_icon = 'mysites/images/heydings_spaced_big.gif\') no-repeat; background-position: -89px -22px; background-size:175px 121px;  ';

    function subsiteCMSShowInMenu() {
        return true;
    }

    /**
     * Gets the list of data to show in the table. In this case we are overriding to limit to the current Subsite.
     * @return mixed
     */
    public function getList()
    {
        $list = parent::getList();
        return $list->sort(['StartTime'=>'DESC']);
    }

    public function getEditForm($id = null, $fields = null) {

        $form = parent::getEditForm($id, $fields);
        $fields = $form->fields();

        $gridFieldName = $this->sanitiseClassName($this->modelClass);
        $gridField = $form->Fields()->fieldByName($gridFieldName);

        if ($gridField) {
            $gridField->getConfig()
                ->removeComponentsByType('GridFieldPrintButton')
                ->removeComponentsByType('GridFieldExportButton');
    //            ->removeComponentsByType('GridFieldFilterHeader')
    //            ->removeComponentsByType('GridFieldSortableHeader')

            $gridField->getConfig()->getComponentByType('GridfieldPaginator')->setItemsPerPage(25);

            $gridField->addDataFields([
                    "Intro" => function($row) {
                        $cleanContent = strip_tags($row->Content);
                        $beginning = substr($cleanContent, 0, 40);
                        if (strlen($beginning ) < strlen($cleanContent)) {
                            return $beginning . "...";
                        }
                        return $cleanContent;
                    },
                ]
            );

            $gridField->getConfig()->getComponentByType('GridFieldDataColumns')->setDisplayFields(
                [
                    'Title' => 'Name',
                    'StartTime' => 'Start Time',
                    'EndTime' => 'End Time',
                    'Intro' => 'Intro'
                ]
            );
        }

        return $form;
    }
}

