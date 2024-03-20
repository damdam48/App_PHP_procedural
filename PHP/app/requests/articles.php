<?php

require_once '/app/config/mysql.php';

/**
 * find all ARTICLES in database
 * 
 * @return array
 */
function findAllArticle(): array
{
    global $db;

    $sqlStatement = $db->prepare("SELECT * FROM articles");
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}



/**
 * Find one ARTICLES filter by id
 *
 * @param integer $id
 * @return array|boolean
 */
function findOneArticleById(int $id): array|bool
{
    global $db;

    $sqlStatement = $db->prepare("SELECT * FROM articles WHERE id = :id");
    $sqlStatement->execute([
        'id' => $id,
    ]);

    return $sqlStatement->fetch();
}