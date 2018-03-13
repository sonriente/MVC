<?php

class User
{
    public function getByLogin($login)
    {
        $db = DB::getInstance()->getPDO();
        $sql = "SELECT * FROM users WHERE login = :login LIMIT 1";
        $sth = $db->prepare($sql);
        $params = array(
            'login' => $login,
        );
        $sth->execute($params);
        $user = $sth->fetch(PDO::FETCH_ASSOC);
        if (isset($user)) {
            return $user;
        }
        return false;
    }
}
?>
