<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Friend request system</title>
    <link rel="stylesheet" href="friends.css">
</head>
<body>
<?php
require 'php/Relation.php';

$relation = new Relation();
$uid = 1;

    if (isset($_POST['req'])) {
        $pass = true;

        switch ($_POST['req']) {
            default:
                $pass = $relation->error = "Invalid request";
                break;

            case 'add':
                $pass = $relation->request($uid, $_POST['to']);
                break;

            case 'cancel':
                $pass = $relation->cancel($uid, $_POST['to']);
                break;

            case 'accept':
                $pass = $relation->accept($uid, $_POST['to']);
                break;

            case 'unfriend':
                $pass = $relation->unfriend($uid, $_POST['to']);
                break;

            case 'block':
                $pass = $relation->block($uid, $_POST['to']);
                break;

            case 'unblock':
                $pass = $relation->block($uid, $_POST['to'], false);
                break;
        }

        echo $pass ? "<div class='success'>$relation->error</div>" : "<div class='error'>$relation->erro}</div>";
    }

    $users = $relation->getUsers($uid); ?>

    <div id="userNow" class="flex">
        <div><img src="" alt=""></div>
    </div>

    <div>
        <small>you are: </small>
        <strong><?= $users[$uid] ?></strong>
    </div>

    <div id="userList">
        <?php
            $id = $_SESSION['id'];
            $requests = $relation->getRequest($id);
            $friends = $relation->getFriends($id);

            foreach ($users as $id => $name) {
                if ($id != $uid) {
                    echo "<div class='uRow flex'>";
                    echo "<div class='uName'>{$name}</div>";
                }

                if ($friends['b'[$id]]) {
                    echo "<button onclick='{$relation->unblock()}'>Unblock</button>";
                } else {
                    echo "<button onclick='{$relation->block()}'>Block</button>";
                }

                // TODO: flix this bug first thing tomorrow
                // a: how can i fix this bug?

                if (isset($friends['f'][$id])) {
                    echo "<button onclick='{$relation->unfriend()}'>unfriend</button>";
                } else if ($requests["out"][$id]) {
                    echo "<button onclick='{$relation->accept()}'>accept</button>";
                } else {
                    echo "<button onclick='{$relation->request()}'>add</button>";
                }

                echo "</div>";
            }
        ?>

    </div>
    <form target="_self" id="ninform" method="post">
        <input type="hidden" name="req" id="ninreq">
        <input type="hidden" name="id" id="ninid">
    </form>
</body>
</html>
