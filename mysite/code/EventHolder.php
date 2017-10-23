<?php
class EventHolder extends Page {
    private static $allowed_children = array('EventPage');

    private static $db = array (
    );

    private static $description = 'List of events pages';
 
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName('Content');

        return $fields;
    }
}

class EventHolder_Controller extends Page_Controller {

     private static $allowed_actions = array(
         'SearchForm'
     );

    public function index(SS_HTTPRequest $request) {
       $events = EventPage::get()->filter(array('ParentID' => $this->ID))
                         ->sort('StartTime DESC');

       if ($day = $request->getVar('day')) {
            $events = $events->filterByCallback(function($record) use ($day) {
                return $record->DayMatches($day);
            });
       }
       if ($month = $request->getVar('month')) {
            $events = $events->filterByCallback(function($record) use ($month) {
                return $record->MonthMatches($month);
            });
       }
       if ($year = $request->getVar('year')) {
            $events = $events->filterByCallback(function($record) use ($year) {
                return $record->YearMatches($year);
            });
       }

       return array(
           'Results' => $events
      );
    }
    public function SearchForm() {
        $fields = new FieldList(
            NumericField::create('day')
                ->setAttribute('Placeholder', 'Enter Day')
                ->addExtraClass('col-sm-3'),
           DropdownField::create(
                'month',
                'Month',
                array(
    '0' => '--Enter Month--',
    '1' => 'January',
    '2' => 'February',
    '3' => 'March',
    '4' => 'April',
    '5' => 'May',
    '6' => 'June',
    '7' => 'July',
    '8' => 'August',
    '9' => 'September',
    '10' => 'October',
    '11' => 'November',
    '12' => 'December'
               ))
                ->addExtraClass('col-sm-3'),
            NumericField::create('year')
                ->setAttribute('Placeholder', 'Enter Year')
                ->addExtraClass('col-sm-3')
        );

        foreach ($fields as $field) {
            $field->addExtraClass('form-control');
        }

        $actions = new FieldList(
            CompositeField::create(
                FormAction::create('Search', 'Search')->addExtraClass('btn btn-primary')
            )->addExtraClass('col-sm-12')
        );

        $form = new Form($this, 'SearchForm', $fields, $actions);
        $form->setFormMethod('GET')
             ->setFormAction($this->Link())
             ->disableSecurityToken();

        return $form;
    }
}
