<?php

class LengthCheckTextField extends TextField {

    private $minChars;
    private $maxChars;

    public function setMinChars($minChars) { 
        $this->minChars = $minChars;
        return $this;
    }

    public function setMaxChars($maxChars) { 
        $this->maxChars = $maxChars;
        return $this;
    }

    public function validate($validator) {
        if (isset($this->minChars) && is_numeric($this->minChars) && $this->minChars >= 0) {
            if (strlen($this->value) < $this->minChars) {
                $validator->validationError(
                    $this->name, "Server Validation: Must have a minimum of " . $this->minChars . " characters.", "validation", false
                ); 
                return false;
            }
        }

        if (isset($this->maxChars) && is_numeric($this->maxChars) && $this->maxChars >= 0) {
            if (strlen($this->value) > $this->maxChars) {
                $validator->validationError(
                    $this->name, "Server Validation: Must have a maximum of " . $this->maxChars . " characters.", "validation", false
                );
                return false;
            }
        }

        return true;
    }
}
