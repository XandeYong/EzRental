


<?php
//Establishing Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "unipress";

//Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

//Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Query
$sql_category = "SELECT category_id, category FROM category 
                WHERE status='show' 
                ORDER BY datetime ASC";

$sql_news = "SELECT N.news_id, N.title FROM news N, category CA, subcategory S
            WHERE N.status = 'show' 
            AND CA.status = 'show' 
            AND S.status = 'show' 
            AND N.subcategory_id = S.subcategory_id 
            AND N.category_id = CA.category_id 
            ORDER BY N.datetime DESC LIMIT 3";



//Executing Query
$result_category = $conn->query($sql_category);
$result_news = $conn->query($sql_news);

?>

<div class="sidenav-section col-12 col-lg-3">
    <div class="sidenav-item mb-3">
        <div class="item-header p-1 ps-3">
            <h4>Search</h4>
        </div>
        <div class="item-body">
            <form action="./index.php" method="GET">
                <div class="search d-flex p-3">
                    <input class="form-control shadow-none" type="text" name="search" placeholder="Search" >
                    <button class="btn btn-secondary shadow-none" type="submit">Go</button>
                </div>
            </form>
        </div>
    </div>

    <div class="sidenav-item mb-3">
        <div class="item-header p-1 ps-3">
            <h4>Categories</h4>
        </div>
        <div class="item-body">
            <div class="p-3">
                <ul class="category list-unstyled m-0">
                    <?php 
                        if ($result_category->num_rows > 0) {
                            while ($row = $result_category->fetch_assoc()) {
                    ?>
                    <li><a href="./index.php?category=<?php echo $row['category_id']; ?>"><?php echo $row['category']; ?></a></li>
                    <?php }} else {
                        echo "<li>No category found</li>";
                    } ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="sidenav-item mb-3">
        <div class="item-header p-1 ps-3">
            <h4>Recent News</h4>
        </div>
        <div class="item-body">
            <div class="p-3">
                <ul class="recent-news m-0">
                    <?php 
                        if ($result_news->num_rows > 0) {
                            while ($row = $result_news->fetch_assoc()) {
                    ?>
                    <li><a href="./news.php?news=<?php echo $row['news_id']; ?>"><?php echo $row['title']; ?></a></li>
                    <?php }} else {
                        echo "<li>No news found</li>";
                    } ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="sidenav-item mb-3">
        <div class="item-header p-1 ps-3">
            <h4>Feedback</h4>
        </div>
        <div class="item-body">
            <div class="p-3">
                <ul class="feedback m-0">
                    <li><a href="./feedback.php">Google Feedback Form</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>