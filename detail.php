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
                <div class="entry-list single">
                    <?php
                        include('inc/db_fetch.php');
                        include('inc/db_fetch_detail.php');
                        $result = db_fetch_detail_no_tags();
                        $tags = db_fetch_tags();
                        echo 
                        "<article>"
                        .   "<h1>$result[title]</h1>"
                            ."<time datetime=$result[date]>" . date_format(new DateTime($result['date']), 'M d, Y') . "</time>";
                            echo "<p></p>";
                            $entry_tags = db_fetch_tags_under_same_entry($result['id']);
                                foreach($entry_tags as $key_tag => $tag){
                                    if(!empty($tag['tag_name'])){
                                        echo " ";
                                        echo "
                                                <span><a style='text-decoration:none;color:#678f89;' href='filtered.php?filter=$tag[tag_name]'>#$tag[tag_name]</a></span>
                                        ";
                                    }
                            }
                            echo "<p></p>";
                            echo "<div class='entry'>"
                                ."<h3>Time Spent: </h3>"
                                ."<p>$result[time_spent]</p>"
                            ."</div>"
                            ."<div class='entry'>"
                                ."<h3>What I Learned:</h3>"
                                ."<p>$result[learned]</p>"
                            ."</div>"
                            ."<div class='entry'>"
                                ."<h3>Resources to Remember:</h3>";
                                if(empty($result['resources'])){
                                    echo "<p>No resources to show!</p>";
                                }else{
                                    echo 
                                    "<ul>"
                                        ."<li><a href=''>$result[resources]</a></li>"
                                    ."</ul>";
                                }
                            echo "</div>"
                        ."</article>";

                        echo "<h3>All Tags:</h3>";
                        if(empty($tags)){
                            echo "<p>No Tags To Show..</p>";
                        }
                        foreach($tags as $tag){
                            if(!empty($tag['tag_name'])){
                                echo  "<ul>"
                                        ."<li><a href='filtered.php?filter=$tag[tag_name]'>#$tag[tag_name]</a></li>"
                                    ."</ul>";
                            }
                         }
                    ?>
                </div>
            </div>
            <div class="edit">
                <?php
                    echo "<p><a href='edit.php?id=$result[id]'>Edit Entry</a></p>";
                    echo "<p><a href='inc/db_delete.php?id=$result[id]'>Delete Entry</a></p>";
                ?>                
            </div>
        </section>
        <?php
            include("footer.php");
        ?>
    </body>
</html>