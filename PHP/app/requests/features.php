<?php

require_once '/app/config/mysql.php';

/**
 * All Features en array
 *
 * @return array
 */
function findAllFeatures(): array
{
    global $db;

    $sqlStatement = $db->prepare("SELECT * FROM features");
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();

}


/**
 * Find one Features filter by id
 *
 * @param integer $id
 * @return array|boolean
 */
function findOneFeatureById(int $id): array|bool
{
    global $db;

    $sqlStatement = $db->prepare("SELECT * FROM features WHERE id = :id");
    $sqlStatement->execute([
        'id' => $id,
    ]);

    return $sqlStatement->fetch();
}


/**
 * find one name filter
 *
 * @param string name
 * @return array|boolean
 */
function findOneFeatureByName(string $name): array|bool
{
    global $db;

    $sqlStatement = $db->prepare("SELECT * FROM features WHERE name = :name");
    $sqlStatement->execute([
        'name' => $name,
    ]);

    return $sqlStatement->fetch();
}


/**
 * creation de la Feature en db
 *
 * @param string $name
 * @param string $description
 * @param integer $enable
 * @param string|null $imageName
 * @return boolean
 */
function createFeature(string $name, string $description, int $enable, ?string $imageName = null): bool
{
    global $db;

    try {
        $query = "INSERT INTO features(name, description, enable, imageName) VALUES (:name, :description, :enable, :imageName)";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'name' => $name,
            'description' => $description,
            'enable' => $enable,
            'imageName' => $imageName,
        ]);
    } catch (PDOException $error) {
        // die($error->getMessage());
        return false;
    }

    return true;
}


function updateFeature(int $id, string $name, string $description, int $enable, string $updatedAt, ?string $imageName =null): bool
{
    global $db;

    try {
        $query = "UPDATE articles SET name = :name, description = :description, enable = :enable";
        $params = [
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'enable' => $enable,
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
 * DELETE a Feature from DB
 *
 * @param integer $id
 * @return boolean
 */
function deleteFeature(int $id): bool
{
    global $db;

    try {
        $query = "DELETE FROM features WHERE id = :id";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'id' => $id,
        ]);
    } catch (PDOException $error) {
        return false;
    }

    return true;
}
