<?xml version="1.0" encoding="UTF-8" ?>

<rss version='2.0'>
    <channel>
        <title>Global Wild Swimming and Camping</title>
    </channel>

    <description>This page will display all pages available in GWSC website.</description>

    <?php
        include('./dbConnect.php');
        header('Content-Type: text/xml');

        $sql = 'SELECT * From RSSFeed Order By RSSFeedID DESC';
        $query = mysqli_query($connect, $sql);
        $count = mysqli_num_rows($query);

        for($i=0; $i < $count; $i++){
            $data = mysqli_fetch_array($query);

            echo "<item>";
                echo "<title>".$data['Title']."</title>";
                echo "<description>".$data['Description']."</description>";
                echo "<url>".$data['Url']."</url>";
            echo "</item>";

        }
    ?>
</rss>