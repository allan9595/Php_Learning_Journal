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
                <div class="new-entry">
                    <h2>New Entry</h2>
                    <form method="post" action="inc/db_add.php">
                        <label for="title"> Title</label>
                        <input id="title" type="text" name="title"><br>
                        <label for="date">Date</label>
                        <input id="date" type="date" name="date"><br>
                        <label for="time-spent"> Time Spent</label>
                        <input id="time-spent" type="text" name="timeSpent" placeholder="20 hours"><br>
                        <label for="tags">Tags</label>
                        <input id="tags" type="text" name="tags" placeholder="programming,php,victory"><br>
                        <label for="tags">Learned</label>
                        <textarea id="what-i-learned" rows="5" name="whatILearned" placeholder="React.js"></textarea>
                        <label for="resources-to-remember">Resources to Remember</label>
                        <textarea id="resources-to-remember" rows="5" name="ResourcesToRemember" placeholder="reactjs.org"></textarea>
                        <input type="submit" value="Publish Entry" class="button">
                        <a href="index.php" class="button button-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </section>
        <?php
            include("footer.php");
        ?>
    </body>
</html>