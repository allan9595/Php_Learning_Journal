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
                        $result = db_fetch();
                        $tags = db_fetch_tags();
                        //order the item based on date

                        function date_sort($a, $b){
                            return  strtotime($b['date']) - strtotime($a['date']);
                        }
                        uasort($result, "date_sort");

                        foreach($tags as $tag){
                            if(!empty($tag['tag_name'])){
                                echo  "<ul>"
                                            ."<li><a href='filtered.php?filter=$tag[tag_name]'>#$tag[tag_name]</a></li>"
                                        ."</ul>";
                            }
                        }
                        foreach($result as $key => $result){
                            echo "<article>";
                            echo "<h2><a href='detail.php?id=$result[id]'>$result[title]</a></h2>";
                            echo "<time datetime=$result[date]>" . date_format(new DateTime($result['date']), 'M d, Y') . "</time><br>";
                            $entry_tags = db_fetch_tags_under_same_entry($result['id']);
                            foreach($entry_tags as $key_tag => $tag){
                                if(!empty($tag['tag_name'])){
                                    echo " ";
                                    echo "
                                        <span><a style='text-decoration:none;color:#678f89;' href='filtered.php?filter=$tag[tag_name]'>#$tag[tag_name]</span>
                                    ";
                                    
                                }else{
                                    echo "";
                                }
                            }
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