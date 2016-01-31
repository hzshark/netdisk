<?php
namespace Admin\Service;

class Authenticator {

    function authenticate($username, $password) {
        $condition['UserName'] = $username;
        $myDao = D("Index");
        $user = $myDao->where($condition)->find();
        if ($user == null || count($user) == 0) {
            return false;
        }
        if (date("Y-m-d", strtotime($user['lastlogin'])) > date("Y-m-d")) {
            return false;
        }
        if (MD5($password) == $user["password"]) {
            session('username', $username);
            session('userid', $user['Id']);
            session('lastLogin', $user['LastLogin']);
            $data['LastLogin'] = date("Y-m-d h:i:s");
            $myDao->where($condition)->save($data);
            return true;
        }
        return false;
    }

}