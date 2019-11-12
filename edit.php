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
                        $result = db_fetch_detail();
                        echo "
                            <form action='inc/db_edit.php?id=$result[id]' method='post'>
                                <label for='title'> Title</label>
                                <input id='title' type='text' name='title' value='$result[title]'><br>
                                <label for='date'>Date</label>
                                <input id='date' type='date' name='date' value='$result[date]'><br>
                                <label for='time-spent'> Time Spent</label>
                                <input id='time-spent' type='text' name='timeSpent' value='$result[time_spent]'><br>
                                <label for='what-i-learned'>What I Learned</label>
                                <textarea id='what-i-learned' rows='5' name='whatILearned'>$result[learned]</textarea>
                                <label for='resources-to-remember'>Resources to Remember</label>
                                <textarea id='resources-to-remember' rows='5' name='ResourcesToRemember'>$result[resources]</textarea>
                                <input type='submit' value='Publish Edit' class='button'>
                                <a href='#' class='button button-secondary'>Cancel</a>
                            </form>
                        ";
                    ?>
                </div>
            </div>
        </section>
        <?php
            include("footer.php");
        ?>
    </body>
</html>