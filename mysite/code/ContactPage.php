<?php

class ContactPage extends Page
{
    private static $db = array (
        'RobotCheck' => 'Boolean'
    );

    private static $has_one = array();

    private static $description = 'Demo Contact Page';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab('Root.Main', CheckboxField::create('RobotCheck'), 'Content');

        return $fields;
    }
}

class ContactPage_Controller extends Page_Controller
{
    public static $allowed_actions = array(
        'ContactForm',
        'Submit'
    );

    public function init()
    {
        parent::init();

        Requirements::customScript(<<<js
            $(document).ready(function(){
                jQuery('#Form_ContactForm').submit(function() {
                    jQuery('.message.validation').remove();
                    if (jQuery('#Form_ContactForm_FirstName').val().length < 3) {
                        jQuery('#Form_ContactForm_FirstName_Holder').append('<span class="message validation">Client: Must have a minimum of 3 characters.</span>');
                        return false;
                    }
                    if (jQuery('#Form_ContactForm_Surname').val().length > 5) {
                        jQuery('#Form_ContactForm_Surname_Holder').append('<span class="message validation">Client: Must have a maximum of 5 characters.</span>');
                        return false;
                    }
                    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    if (!regex.test(jQuery('#Form_ContactForm_Email').val())) {
                        jQuery('#Form_ContactForm_Email_Holder').append('<span class="message validation">Client: Must be a valid email address.</span>');
                        return false;
                    }
                    var message = jQuery('#Form_ContactForm_Message').val().toLowerCase();
                    var counts = message.replace(/[^\w\s]/g, "").split(/\s+/).reduce(function(map, word) {
                        map[word] = (map[word]||0)+1;
                        return map;
                    }, []);
                    if (counts['the'] != 3) {
                        jQuery('#Form_ContactForm_Message_Holder').append('<span class="message validation">Client: Must contain the word "the" 3 times.' + counts['the'] + '</span>');
                        return false;
                    }

                    return true;
                });
            });
js
);
    }

    public function ContactForm()
    {
        $fields = new FieldList(
            LengthCheckTextField::create('FirstName')
                ->setAttribute('Placeholder', 'Enter First Name')
                ->addExtraClass('col-sm-6')
                ->setMinChars(3),
            LengthCheckTextField::create('Surname')
                ->setAttribute('Placeholder', 'Enter Surname')
                ->addExtraClass('col-sm-6')
                ->setMaxChars(5),
            EmailField::create('Email')
                ->setAttribute('Placeholder', 'Enter Email')
                ->addExtraClass('col-sm-6'),
            TextField::create('Phone')
                ->setAttribute('Placeholder', 'Enter Phone')
                ->addExtraClass('col-sm-6'),
            ContainsWordTextareaField::create('Message')
                ->setAttribute('Placeholder', 'Write your message')
                ->addExtraClass('col-sm-12')
                ->setWord('the', 3, false)
        );

        if ($this->RobotCheck) {
           $fields->push(RecaptchaField::create('')
                ->addExtraClass('col-sm-12')
           ); 
        }

        foreach ($fields as $field) {
            $field->addExtraClass('form-control');
        }

        $actions = new FieldList(
            CompositeField::create(
                FormAction::create('Submit', 'Send Enquiry')->addExtraClass('btn btn-primary')
            )->addExtraClass('col-sm-12')
        );

        $required = new RequiredFields(array('FirstName', 'Surname', 'Email', 'Message'));

        $form = new Form($this, 'ContactForm', $fields, $actions, $required);

        $previousData = Session::get("ContactFormData" . $this->ID);
        if ($previousData) {
            $form->loadDataFrom($previousData);
        }

        return $form;

    }

    public function Submit($data, $form)
    {
        Session::set("ContactFormData" . $this->ID, $data);

        $firstName = isset($data['FirstName']) ? strip_tags($data['FirstName']) : '';
        $surname = isset($data['surname']) ? strip_tags($data['surname']) : '';
        $email = isset($data['Email']) ? strip_tags($data['Email']) : '';
        $phone = isset($data['Phone']) ? strip_tags($data['Phone']) : '';
        $message = isset($data['Message']) ? strip_tags($data['Message']) : '';

        // Lets' go nuts and double check everything for demo!!!!!
        if (strlen($firstName) < 3) {
          $form->addErrorMessage("FirstName", "First Name must have at least 3 characters!", "bad");
          $this->redirectBack(); 
        }
        if (strlen($surname) > 5) {
          $form->addErrorMessage("Surname", "Surname must have at most 5 characters!", "bad");
          $this->redirectBack(); 
        }

        $pcrePattern = '^[a-z0-9!#$%&\'*+/=?^_`{|}~-]+(?:\\.[a-z0-9!#$%&\'*+/=?^_`{|}~-]+)*'
             . '@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$';
        // PHP uses forward slash (/) to delimit start/end of pattern, so it must be escaped
        $pregSafePattern = str_replace('/', '\\/', $pcrePattern);
        if(!preg_match('/' . $pregSafePattern . '/i', $email)){
          $form->addErrorMessage("Email", "Invalid email address!", "bad");
          $this->redirectBack();
        }

        $lowerMessage = strtolower($message);
        $counts = array_count_values(str_word_count($lowerMessage, 1));
        if (!isset($counts['the']) || $counts['the'] != 3) {
          $form->addErrorMessage("Message", "Must contain the word 'the' 3 times!", "bad");
          $this->redirectBack();
        }

        $enquiry = EnquiryMessage::create();
        $form->saveInto($enquiry);
        $enquiry->When = SS_DateTime::now();
        $enquiry->write();

        Session::clear("ContactFormData" . $this->ID);
        $form->sessionMessage('Thanks for the message, we will be in touch shortly!', 'good');
        return $this->redirectBack();
     }
}
