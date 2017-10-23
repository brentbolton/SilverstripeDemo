<?php

class ContainsWordTextareaField extends TextareaField {

    private $word;
    private $count;
    private $caseSensitive;

    public function setWord($word, $count = 1, $caseSensitive = false) { 
        $this->word = $word;
        $this->count = $count;
        $this->caseSensitive = $caseSensitive;
        return $this;
    }

    public function validate($validator) {
        if (!isset($this->count) || !is_numeric($this->count) || $this->count < 0) {
            $this->count = 1;
        }

        $word = $this->caseSesitive ? $this->word : strtolower($this->word);
        $value = $this->caseSensitive ? $this->value : strtolower($this->value);

        $counts = array_count_values(str_word_count($value, 1)); 
        if (!isset($counts[$this->word]) || $counts[$this->word] != $this->count) {
            $validator->validationError(
                $this->name, "Server Validation: Must contain the word '" . $this->word . "' " . $this->count . " times.", "validation", false
            ); 
            return false;
        }

        return true;
    }
}
