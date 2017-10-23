<?php

class EnquiryAdmin extends ModelAdmin
{
    private static $managed_models = [
        'EnquiryMessage'
    ];

    private static $menu_title = 'Enquires';

    private static $url_segment = 'enquiry-admin';
    public $showImportForm = false;

    private static $allowed_actions = [
        'EditForm'
    ];
    private static $menu_icon = 'mysites/images/heydings_spaced_big.gif\') no-repeat; background-position: -89px -22px; background-size:175px 121px;  ';

    /**
     * Gets the list of data to show in the table. In this case we are overriding to limit to the current Subsite.
     * @return mixed
     */
    public function getList()
    {
        $list = parent::getList();
        return $list->sort(['When'=>'DESC']);
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

            $gridField->getConfig()->getComponentByType('GridfieldPaginator')->setItemsPerPage(25);

            $gridField->getConfig()->getComponentByType('GridFieldDataColumns')->setDisplayFields(
                [
                    'When' => 'When',
                    'FirstName' => 'First Name',
                    'Surname' => 'Surname',
                    'Email' => 'Email',
                    'Phone' => 'Phone',
                    'Message' => 'Message'
                ]
            );
        }

        return $form;
    }
}

