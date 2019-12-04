<?php
namespace controllers;

require_once $_SERVER['DOCUMENT_ROOT'].'/HelloWorld/controllers/UsersDAF.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/HelloWorld/yasmf/Input.php';

class UsersController {

/**
 * @param $pdo the pdo object
 */
function defaultAction($pdo) {
    global $searchStmt;
    $status_id = (int)get('status_id') ?: 2 ;
    if (!in_array($status_id,array(1,2))) {
        throw new Exception("Access denied");
    }
    $start_letter = htmlspecialchars(get('start_letter').'%') ?: '%';
    $searchStmt = findUsersByUsernameAndStatus($pdo, $start_letter, $status_id) ;
}

/**
 * @param $pdo the pdo object
 */
function editUser($pdo) {
    global $user;
    $user_id = (int)get('user_id');
    $user = findUserById($pdo, $user_id);
}

/**
 * @param $pdo the pdo object
 */
function saveUser($pdo) {
    $user_id = (int)get('user_id');
    $username = get('username');
    saveUsername($pdo, $user_id, $username);
    // update user list
    defaultAction($pdo);
}

/**
 * @param $pdo the pdo object
 */
function askDeletion($pdo) {
    throw new Exception("Access denied");
    $user_id = (int)get("user_id");
    // ask deletion
    askUserDeletion($pdo, $user_id);
    // update user list
    defaultAction($pdo);
}

}