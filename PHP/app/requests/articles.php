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

    $sqlStatement = $db->prepare("SELECT a.id, a.title, a.description, a.createdAt, a.enable, a.imageName, u.firstName, u.lastName FROM articles a JOIN users u ON u.id = a.userId ORDER BY a.createdAt DESC");
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}


/**
 * Find one article filter by id
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


/**
 * find one user filter by email
 *
 * @param string $email
 * @return array|boolean
 */
function findOneArticleBytitle(string $title): array|bool
{
    global $db;

    $sqlStatement = $db->prepare("SELECT * FROM articles WHERE title = :title");
    $sqlStatement->execute([
        'title' => $title,
    ]);

    return $sqlStatement->fetch();
}


/**
 * Create article en db
 *
 * @param string $title
 * @param string $description
 * @param integer $enable
 * @param int $userId
 * @param ?string $imageName = null
 * @return boolean
 */
function createArticle(string $title, string $description, int $enable, int $userId, ?string $imageName = null): bool
{
    global $db;

    try {
        $query = "INSERT INTO articles(title, description, enable, userId, imageName) VALUES (:title, :description, :enable, :userId, :imageName)";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'title' => $title,
            'description' => $description,
            'enable' => $enable,
            'userId' => $userId,
            'imageName' => $imageName,
        ]);
    } catch (PDOException $error) {
        // die($error->getMessage());
        return false;
    }

    return true;
}

/**
 * mise a jour d'un article en db
 *
 * @param integer $id
 * @param string $title
 * @param string $description
 * @param integer $enable
 * @param string $updatedAt
 * @param ?string $imageName =null
 * @return boolean
 */
function updateArticle(int $id, string $title, string $description, int $enable, string $updatedAt, int $userId, ?string $imageName =null): bool
{
    global $db;

    try {
        $query = "UPDATE articles SET title = :title, description = :description, enable = :enable, updatedAt = :updatedAt, userId = :userId";
        $params = [
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'enable' => $enable,
            'updatedAt' => $updatedAt,
            'userId' => $userId,
        ];

        if ($imageName) {
            $query .= ", imageName = :imageName";
            $params['imageName'] = $imageName;
        }

        $query .= " WHERE id = :id";

        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute($params);

        // $query = "UPDATE articles SET title = :title, description = :description, enable = :enable, updatedAt = :updatedAt WHERE id = :id";

        // $sqlStatement = $db->prepare($query);
        // $sqlStatement->execute([
        //     'title' => $title,
        //     'description' => $description,
        //     'enable' => $enable,
        //     'id' => $id,
        //     'updatedAt' => $updatedAt,
        // ]);
    } catch (Exception $error) {
        // Log or handle the error appropriately
        error_log('Error updating article: ' . $error->getMessage());
        return false;
    }

    return true;
}


/**
 * DELETE a article from DB
 *
 * @param integer $id
 * @return boolean
 */
function deleteArticle(int $id): bool
{
    global $db;

    try {
        $query = "DELETE FROM articles WHERE id = :id";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'id' => $id,
        ]);
    } catch (PDOException $error) {
        return false;
    }

    return true;
}


