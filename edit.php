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
                <div class="edit-entry">
                    <h2>Edit Entry</h2>
                    <?php   
                        //fetch the data to fill the form then edit it to update the db
                        include('inc/db_fetch_detail.php');
                        $result = db_fetch_detail_no_tags();
                        $result_with_tags = db_fetch_detail_with_tags();
                        $result_get_tags =  db_fetch_detail_get_tags();

                        if(!empty($result_with_tags)){
    
                            foreach($result_get_tags as $value){
                                $tags[] =  $value['tag_name'];
                            }
                            $tags_string = implode(",", $tags);
                            
                            echo "
                            <form action='inc/db_edit.php?id=$result_with_tags[entry_id]' method='post'>
                                <label for='title'> Title</label>
                                <input id='title' type='text' name='title' value='$result_with_tags[title]'><br>
                                <label for='date'>Date</label>
                                <input id='date' type='date' name='date' value='$result_with_tags[date]'><br>
                                <label for='time-spent'> Time Spent</label>
                                <input id='time-spent' type='text' name='timeSpent' value='$result_with_tags[time_spent]'><br>
                                <label for='tags'>Tags</label> 
                                <input id='tags' type='text' name='tags' value='$tags_string'><br>
                                <label for='what-i-learned'>What I Learned</label>
                                <textarea id='what-i-learned' rows='5' name='whatILearned'>$result_with_tags[learned]</textarea>
                                <label for='resources-to-remember'>Resources to Remember</label>
                                <textarea id='resources-to-remember' rows='5' name='ResourcesToRemember'>$result_with_tags[resources]</textarea>
                                <input type='submit' value='Publish Edit' class='button'>
                                <a href='index.php' class='button button-secondary'>Cancel</a>
                            </form>
                        ";
                        
                        }else{
                            echo "
                            <form action='inc/db_edit.php?id=$result[id]' method='post'>
                                <label for='title'> Title</label>
                                <input id='title' type='text' name='title' value='$result[title]'><br>
                                <label for='date'>Date</label>
                                <input id='date' type='date' name='date' value='$result[date]'><br>
                                <label for='time-spent'> Time Spent</label>
                                <input id='time-spent' type='text' name='timeSpent' value='$result[time_spent]'><br>
                                <label for='tags'>Tags</label>
                                <input id='tags' type='text' name='tags'><br>
                                <label for='what-i-learned'>What I Learned</label>
                                <textarea id='what-i-learned' rows='5' name='whatILearned'>$result[learned]</textarea>
                                <label for='resources-to-remember'>Resources to Remember</label>
                                <textarea id='resources-to-remember' rows='5' name='ResourcesToRemember'>$result[resources]</textarea>
                                <input type='submit' value='Publish Edit' class='button'>
                                <a href='index.php' class='button button-secondary'>Cancel</a>
                            </form>
                        ";
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