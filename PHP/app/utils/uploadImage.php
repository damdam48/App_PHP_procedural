<?php
/**
 * upload image server
 *
 * @param array $image
 * @param string $folder
 * @return string|null
 */
function uploadImage(array $image, string $folder): ?string
{
    if ($image['error'] === 0 && $image['size'] < 16000000) {
        $fileInfo = pathinfo($image['name']);

        $extensionAllowed = ['png', 'jpg', 'jpeg', 'gif', 'svg'];

        if (in_array($fileInfo['extension'], $extensionAllowed)) {
            $imageName = $fileInfo['filename'] . (new DateTime())->format('Y_m_d_H_i_s') . '.' . $fileInfo['extension'];

            if (!is_dir("/app/assets/uploads/$folder")) {
                mkdir("/app/assets/uploads/$folder");
            }

            move_uploaded_file($image['tmp_name'], "/app/assets/uploads/$folder/$imageName");

            return $imageName;
        }
    }
    return null;
}
