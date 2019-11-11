<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>MyJournal</title>
        <link href="https://fonts.googleapis.com/css?family=Cousine:400" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Work+Sans:600" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/site.css">
    </head>
    <body>
        <?php
            include("header.php");
        ?>
        <section>
            <div class="container">
                <div class="entry-list">
                    <?php
                        include('inc/db_fetch.php');
                        foreach(db_fetch() as $key => $result){
                            echo $key + 1;
                            //$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
                            echo "<article>";
                            echo "<h2><a href='detail.php?id=" . ($key+1) . "'>$result[title]</a></h2>";
                            echo "<time datetime=$result[date]>" . date_format(new DateTime($result['date']), 'M d, Y') . "</time>";
                            echo "</article>";
                        }
                    ?>
                </div>
            </div>
        </section>
        <?php
            include("footer.php");
        ?>
    </body>
</html>