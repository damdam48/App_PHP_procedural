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
 * Find one user filter by id
 *
 * @param integer $id
 * @return array|boolean
 */
function findOneUserById(int $id): array|bool
{
    global $db;

    $sqlStatement = $db->prepare("SELECT * FROM users WHERE id = :id");
    $sqlStatement->execute([
        'id' => $id,
    ]);

    return $sqlStatement->fetch();
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




/**
 * function to crate User in database
 *
 * @param string $firstName
 * @param string $lastName
 * @param string $email
 * @param string $password
 * @return boolean
 */
function createUser(string $firstName, string $lastName, string $email, string $password): bool
{
    global $db;
    try {
        $query = "INSERT INTO users(firstName, lastName, email, password) VALUE (:firstName, :lastName, :email, :password)";

        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'password' => $password,
        ]);
    } catch (PDOException $error) {
        die($error->getMessage());
        return false;
    }

    return true;
}




/**
 * Update a user in DB
 *
 * @param integer $id
 * @param string $firstName
 * @param string $lastName
 * @param string $email
 * @param array|null $roles
 * @return boolean
 */
function updateUser(int $id, string $firstName, string $lastName, string $email, ?array $roles = null): bool
{
    global $db;

    try {
        $query = "UPDATE users SET firstName = :firstName, lastName = :lastName, email = :email, roles = :roles WHERE id =:id";

        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'roles' => json_encode($roles ?: ['ROLE_USER']),
            'id' => $id,
        ]);
    } catch (PDOException $error) {
        return false;
    }

    return true;
}



/**
 * DELETE a user from DB
 *
 * @param integer $id
 * @return boolean
 */
function deleteUser(int $id): bool
{
    global $db;

    try {
        $query = "DELETE FROM users WHERE id = :id";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'id' => $id,
        ]);
    } catch (PDOException $error) {
        return false;
    }

    return true;
}
