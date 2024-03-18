<?php

require_once '/app/config/mysql.php';

/**
 * find all user in database
 * 
 * @return array
 */
function findAllUser(): array
{
    global $db;

    $sqlStatement = $db->prepare("SELECT * FROM users");
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}


/**
 * find one user filter by email
 *
 * @param string $email
 * @return array|boolean
 */
function findOneUserByEmail(string $email): array|bool
{
    global $db;

    $sqlStatement = $db->prepare("SELECT * FROM users WHERE email = :email");
    $sqlStatement->execute([
        'email' => $email,
    ]);

    return $sqlStatement->fetch();
}

