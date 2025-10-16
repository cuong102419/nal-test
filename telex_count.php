<?php
function countTelex($text)
{
    $count = 0;
    $i = 0;
    $n = strlen($text);
    $foundWord = [];

    while ($i < $n) {
        if ($i + 1 < $n) {
            $pair = $text[$i] . $text[$i + 1];
            if (in_array($pair, ['aw', 'aa', 'dd', 'ee', 'oo', 'ow'])) {
                $count++;
                $foundWord[] = $pair;
                $i += 2;
                continue;
            }
        }

        if ($text[$i] == 'w') {
            $count++;
            $foundWord[] = 'w';
        }

        $i++;
    }

    return [$count, $foundWord];
}

$input = "";
$result = 0;
$word = [];
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['text_input'])) {
    $input = trim($_POST['text_input']);

    if (empty($input)) {
        $error = "Vui lòng nhập chuỗi ký tự.";
    } elseif (!preg_match('/^[a-zA-Z]+$/', $input)) {
        $error = "Dữ liệu không hợp lệ, chuỗi nhập vào chỉ được chứa chữ cái.";
    } else {
        $input = strtolower($input);
        list($result, $word) = countTelex($input);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>Nhập chuỗi đếm ký tự tiếng Việt</h2>
    <form action="" method="post">
        <label for="telex">Nhập chuỗi chữ cái</label>
        <br>
        <input type="text" id="telex" name="text_input" value="<?php echo $input ?>">
        <br>
        <button type="submit">Gửi</button>
    </form>

    <?php if (!empty($error)): ?>
        <div class="error">
            <span style="color: red;">Lỗi: <?php echo $error; ?></span>
        </div>
    <?php endif; ?>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($error) && !empty($input)): ?>
        <div class="result">
            <h3>Kết quả</h3>
            <span>Input: <?php echo $input ?></span>
            <br>
            <span>Chữ cái tiếng Việt: <?php echo $result ?></span>
            <br>
            <span>Các chữ tìm được: <?php echo implode(', ', $word); ?></span>
        </div>
    <?php endif ?>
</body>

</html>