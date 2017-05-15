<?php
 
 foreach (glob(dirname(__FILE__) . "/*/*.php") as $filename) {
     require_once $filename;
 }