<?php

class Page extends SiteTree
{
    private static $db = array(
    );

    private static $has_one = array(
    );

    public function getTitleFirstLetter() {
        return $this->Title[0];
    }
}
