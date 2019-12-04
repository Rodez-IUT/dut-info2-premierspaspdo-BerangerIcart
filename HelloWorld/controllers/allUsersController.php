<?php

namespace controllers;

use yasmf\HttpHelper;
use yasmf\View;

class allUsersController
{

    public function all_users($pdo) {
        $view = new View("HelloWorld/views/all_users");
        return $view;
    }

    public function setRecherche($pdo) {
        $lettre = HttpHelper::getParam('start_letter') ?: '' ;
		$status_id = HttpHelper::getParam('status_id') ?: '' ;
        $view = new View("HelloWorld/views/all_users");
		
		// Empêcher demande d'un autre statut
		if ($status_id != 1 AND $status_id != 2) {
			throw new \Exception("Illegal Access Exception");
		}
		
		$userLike = $lettre ."%";

		$get = $pdo->prepare("	SELECT u.id user_id, u.username, u.email, u.status_id, s.name status
								FROM users u 
								INNER JOIN status s ON s.id = u.status_id 
								WHERE u.status_id = :status_id AND u.username LIKE :userLike
								ORDER BY u.username ASC");

		$get->execute(["status_id" => $status_id, "userLike" => $userLike]);
			
		$view->setVar('searchStmt',$get);
		
        return $view;
    }
	
	/**
	 * @param $pdo the pdo object
	 */
	public function editUser($pdo) {
		$user_id = HttpHelper::getParam('user_id') ?: '' ;
		$user = $this->findUserById($pdo, $user_id);
		$view = new View("HelloWorld/views/user");
		
		$view->setVar('user',$user);
		return $view;
	}
	
	/**
	 * @param $pdo
	 * @param $user_id the user_id of the search user
	 */
	private function findUserById($pdo, $userId) {
		$sql = "select users.id as user_id, username, email, s.name as status, s.id as status_id 
				from users join status s on users.status_id = s.id 
				where users.id = ?";
		$searchStmt = $pdo->prepare($sql);
		$searchStmt->execute([$userId]);
		return $searchStmt->fetch();
	}
	
	/**
	 * @param $pdo the pdo object
	 */
	public function saveUser($pdo) {
		$user_id = HttpHelper::getParam('user_id') ?: '' ;
		$username = HttpHelper::getParam('username') ?: '' ;
		// update user list
		$this->saveUsername($pdo, $user_id, $username);
		$view = new View("HelloWorld/views/all_users");
		
		return $view;
	}
	
	/**
	 * @param $pdo the pdo object
	 * @param $userId the user_id
	 * @param $username the new username
	 */
	function saveUsername($pdo, $userId, $username) {
		$sql = "update users set username = ? where users.id = ?";
		$searchStmt = $pdo->prepare($sql);
		$searchStmt->execute([$username, $userId]);
	}
	
	public function deleteUser($pdo) {
		// Empêcher suppression
		throw new Exception("Illegal Access Exception");
		
        $action = HttpHelper::getParam('action2') ?: '' ;
		$user_id = HttpHelper::getParam('user_id') ?: '' ;
		$status_id = HttpHelper::getParam('status_id') ?: '' ;
        $view = new View("HelloWorld/views/all_users");
		
		if ($action AND $user_id AND $status_id) {
			$action = htmlspecialchars($action);
			$user_id = htmlspecialchars($user_id);
			$status_id = htmlspecialchars($status_id);
			
			try {
		
				// Commencer la transaction
				$pdo->beginTransaction();
				
				// Enregistrer l'action dans les logs
				$insert = $pdo->prepare("INSERT INTO action_log (action_date, action_name, user_id) VALUES (?, ?, ?)");
				$insert->execute([date("Y-m-d H:i:s"), $action, $user_id]);
				
				// Enoncé erronné
				//$probleme = $pdo->query("SELECT uneValeur FROM uneTable");
				
				// Update le statut de l'user
				$update = $pdo->prepare("UPDATE users SET status_id = ? WHERE id = ?");
				$update->execute([$status_id, $user_id]);
				
				// Commit la transaction
				$pdo->commit();
			} catch (Exception $e) {
				$pdo->rollBack();
				throw new Exception($e->getMessage());
			}
		}
			
        return $view;
    }

}