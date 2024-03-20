<?php

require_once '/app/mysql/connexion.php';

function findAllUsers(): array
{
    global $db;

    $sqlStatement = $db->prepare("SELECT * FROM users");
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}

function findOneUserByEmail(string $email): bool|array
{
    global $db;

    $sqlStatement = $db->prepare("SELECT * FROM users WHERE email = :email");
    $sqlStatement->execute([
        'email' => $email
    ]);

    return $sqlStatement->fetch();
}

function createUser(string $firstName, string $lastName, string $email, string $password): bool
{
    global $db;

    try {
        $sqlStatement = $db->prepare("INSERT INTO users(firstName, lastName, email, password) VALUES (:firstName, :lastName, :email, :password)");
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
