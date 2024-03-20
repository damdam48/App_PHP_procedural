<?php

require_once '/app/config/mysql.php';
/**
 * Find all article from db
 *
 * @return array
 */
function findAllArticles(): array
{
    global $db;

    $sqlStatement = $db->prepare("SELECT * FROM articles");
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}




/**
 * Create
 *
 * @param string $title
 * @param string $description
 * @param integer $enable
 * @param int $userId
 * @return boolean
 */
function createArticle(string $title, string $description, int $enable, int $userId): bool
{
    global $db;

    try {
        $query = "INSERT INTO articles(title, description, enable, userId) VALUES (:title, :description, :enable, :userId)";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'title' => $title,
            'description' => $description,
            'enable' => $enable,
            'userId' => $userId,
        ]);
    } catch (PDOException $error) {
        die($error->getMessage());
        return false;
    }

    return true;
}
