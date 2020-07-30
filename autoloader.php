<?php
// Using an anonymous function
spl_autoload_register(function($class){
    include_once('lib/' . $class . '.php');
});

// selected
function selected($value,$select){
    if($value == $select){
      return 'selected="selected"';
    }
}

// checked
function checked($value,$input){
    if($value == $input){
      return 'checked="checked"';
    }
}