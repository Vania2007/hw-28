<?php
const STORAGE_DIR = 'storage';

function deleteImage($fileUrl)
{
    if (file_exists($fileUrl)) {
        unlink($fileUrl);
        return true;
    }
}

function uploadImage($file)
{
    if (!isset($file['tmp_name']) || !$file['tmp_name']) {
        echo '<div class="alert alert-warning">Файл не завантажено. Виберіть файл, будь ласка.</div>';
        return;
    }

    $fileInfo = getimagesize($file['tmp_name']);
    if (!$fileInfo || !preg_match('{image/(.*)}', $fileInfo['mime'], $match)) {
        echo '<div class="alert alert-warning">Цей формат не підтримується</div>';
        return;
    }

    if (!file_exists(STORAGE_DIR)) {
        mkdir(STORAGE_DIR, 0777, true);
    }

    $fileName = STORAGE_DIR . '/' . time() . '.' . $match[1];

    if (move_uploaded_file($file['tmp_name'], $fileName)) {
        echo '<div class="alert alert-success">Файл успішно додано!</div>';
    }
}

function getImages()
{
    $images = [];
    foreach (glob(STORAGE_DIR . '/*') as $fileUrl) {
        if ($size = getimagesize($fileUrl)) {
            $images[filemtime($fileUrl)] = [
                'url' => $fileUrl,
                'name' => basename($fileUrl),
                'dimensions' => $size[3],
                'time' => date('d.m.Y H:i:s', filemtime($fileUrl))
            ];
        }
    }
    krsort($images);
    return $images;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete']) && $fileToDelete = filter_input(INPUT_POST, 'url')) {
        deleteImage($fileToDelete);
    }

    if (isset($_POST['import']) && isset($_FILES['file'])) {
        uploadImage($_FILES['file']);
    }
}

$images = getImages();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Images</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Images</h1>

        <form method="POST" enctype="multipart/form-data" class="mb-4">
            <div class="input-group">
                <input type="file" name="file" class="form-control" required>
                <button type="submit" name="import" class="btn btn-primary">Завантажити зобраення</button>
            </div>
        </form>

        <div class="row">
            <?php if (empty($images)): ?>
                <div class="col-12">
                    <p class="text-muted">Зображення поки не було завантажено.</p>
                </div>
            <?php else: ?>
                <?php foreach ($images as $image): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?php echo htmlspecialchars($image['url']); ?>" class="card-img-top" alt="Изображение">
                            <div class="card-body">
                                <p class="card-text">Назва: <?php echo $image['time']; ?></p>
                                <form method="POST">
                                    <input type="hidden" name="url" value="<?php echo htmlspecialchars($image['url']); ?>">
                                    <button type="submit" name="delete" class="btn btn-outline-danger btn-sm">Видалити</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
