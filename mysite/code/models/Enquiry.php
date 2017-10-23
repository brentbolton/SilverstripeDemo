 <?php
 
class EnquiryMessage extends DataObject {

	private static $db = array(
                'When' => 'SS_DateTime',	
		'FirstName' => 'Varchar(30)',
		'Surname' => 'Varchar(30)',
		'Email' => 'Varchar(128)',
		'Phone' => 'Varchar(30)',
		'Message' => 'Text',
	);

	private static $summary_fields = array(	
		'Created.Nice' => 'Date'
	);

	public static $default_sort = 'Created DESC';

	public function canCreate($member = null) {
		return false;
	}

	public function canView($member = null) {	
		return true;
	}
	
	public function canEdit($member = null) {	
		return false;
	}

	public function canDelete($member = null) {
		return false;
	}

	public function getCMSFields() {

		$fields = parent::getCMSFields();
		return $fields;
	}
}

