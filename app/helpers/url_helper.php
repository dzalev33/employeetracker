<?php
//page reddirect
function redirect($page){
    header('location: ' . URLROOT . '/' . $page );
}