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
                        $filtered = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_STRING);
                        $result = db_fetch_filtered($filtered);
                        $tags = db_fetch_tags();
                        //rendering the filtered the data, order them based on date

                        function date_sort($a, $b){
                            return  strtotime($b['date']) - strtotime($a['date']);
                        }
                        uasort($result, "date_sort");
                        
                        foreach($tags as $tag){
                           echo  "<ul>"
                                ."<li><a href='filtered.php?filter=$tag[tag_name]'>#$tag[tag_name]</a></li>"
                            ."</ul>";
                        }
                        foreach($result as $key => $result){
                            echo "<article>";
                            echo "<h2><a href='detail.php?id=$result[id]'>$result[title]</a></h2>";
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