
<?php
class EventPage extends Page {

    private static $db = array(
        'StartTime' => 'SS_DateTime',
        'EndTime' => 'SS_DateTime'
    );

    static $searchable_fields = array(
      'Title',
      'Content'
   );

   private static $can_be_root = false;

   public function getCMSFields() {
        $fields = parent::getCMSFields();

        $startTimeField = new DatetimeField('StartTime', 'Start Time');
        $startTimeField->setConfig('datavalueformat', 'yyyy-MM-dd HH:mm'); // global setting
        $startTimeField->getDateField()->setConfig('showcalendar', true); // field-specific setting

        $endTimeField = new DatetimeField('EndTime', 'End Time');
        $endTimeField->setConfig('datavalueformat', 'yyyy-MM-dd HH:mm'); // global setting
        $endTimeField->getDateField()->setConfig('showcalendar', true); // field-specific setting

        $fields->addFieldToTab('Root.Main', $startTimeField, 'Content');
        $fields->addFieldToTab('Root.Main', $endTimeField, 'Content');

        return $fields;
    }

    public function DayMatches($match) {
        $startDay = strftime('%d', strtotime($this->StartTime));
        $endDay = strftime('%d', strtotime($this->EndTime));

        if ((int)$startDay === (int)$match || (int)$endDay === (int)$match) {
            return true;
        }

        return false;
    }

    public function MonthMatches($match) {
        $startMonth = strftime('%m', strtotime($this->StartTime));
        $endMonth = strftime('%m', strtotime($this->EndTime));

        if ((int)$startMonth === (int)$match || (int)$endMonth === (int)$match) {
            return true;
        }

        return false;
    }

    public function YearMatches($match) {
        $startYear = strftime('%Y', strtotime($this->StartTime));
        $endYear = strftime('%Y', strtotime($this->EndTime));

        if ((int)$startYear === (int)$match || (int)$endYear === (int)$match) {
            return true;
        }

        return false;
    }

}

class Event_Controller extends Page_Controller {

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
