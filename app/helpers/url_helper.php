<?php
//page reddirect
function redirect($page){
    header('location: ' . URLROOT . '/' . $page );
}

function redirectUserById($page,$id){
    header('location: ' . URLROOT . '/' . $page . '/' . $id );
}