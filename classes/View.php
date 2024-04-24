<?php

include_once "Template.php";

abstract class View extends Template {
    private array $marker;
    public abstract function set_marker($marker);
    public abstract function get_marker();
    public abstract function insert_content($content);
    public abstract function get_view();
    public abstract function show();
}
