


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
            <h4>Sort</h4>
        </div>

        <div class="item-body container">
            <div class="row px-3 py-2">

                <div class="col mt-2">
                    <button class="w-100 btn btn-sm btn-outline-dark">
                        <i>Time</i>
                    </button>
                </div>
                
                <div class="col mt-2">
                    <button class="w-100 btn btn-sm btn-outline-dark">
                        <i>Price</i>
                    </button>
                </div>

                <div class="col mt-2">
                    <button class="w-100 btn btn-sm btn-outline-dark">
                        <i>Newest</i>
                    </button>
                </div>

                <div class="col mt-2">
                    <button class="w-100 btn btn-sm btn-outline-dark">
                        <i>Oldest</i>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div class="sidenav-item mb-3">
        <form action="">

            <div class="item-header p-1 ps-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="">
                        <h4>Filter</h4>
                    </div>
                    
                    <div class="">
                        <input class="btn btn-sm btn-outline-success" type="submit" value="Filter">
                        <input class="btn btn-sm btn-outline-danger" type="reset" value="reset">
                    </div>
                </div>
            </div>
            
            <div class="item-body container">
                <div class="row px-3 py-2">

                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <input type="checkbox" name="filter" value="Big" />
                                <span class="ms-1">Master Room</span>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <input type="checkbox" name="filter" value="Big" />
                                <span class="ms-1">Big Medium Room</span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <input type="checkbox" name="filter" value="Big" />
                                <span class="ms-1">Small Room</span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <input type="checkbox" name="filter" value="Big" />
                                <span class="ms-1">Kitchen</span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <input type="checkbox" name="filter" value="Big" />
                                <span class="ms-1">Aircond</span>
                            </div>
                        </div>

                    
                </div>
            </div>

        </form>
    </div>

</div>