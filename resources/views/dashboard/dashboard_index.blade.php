

<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Dashboard</title>
    
    @include('../base/dashboard/dashboard_head')
    <link rel="stylesheet" href="{{ asset("/css/dashboard/dashboard_index.css")}}">
</head>
<body>
     
    
    @include('../base/dashboard/dashboard_sidebar')

    <div id="wrapper">
        <div class="container-fluid">
            @include('../base/dashboard/dashboard_header')

            @if (1 != 1)
            <div id="content" class="row">

                <div class="col col-lg-4 item">
                    <div class="item-content">
                        <div class="row">
                            <span class="title text-nowrap">CATEGORIES LISTED</span>
                        </div>
                        <div class="d-flex justify-content-between state">
                            <h4><?php echo executeQuery("category", 1); ?></h4>
                            <i class="ico ico-color-dashboard ico-unipress"></i>
                        </div>
                    </div>
                </div>

                <div class="col col-lg-4 item">
                    <div class="item-content">
                        <div class="row">
                            <span class="title text-nowrap">SUBCATEGORIES LISTED</span>
                        </div>
                        <div class="d-flex justify-content-between state">
                            <h4><?php echo executeQuery("subcategory", 1); ?></h4>
                            <i class="ico ico-color-dashboard ico-unipress"></i>
                        </div>
                    </div>
                </div>
                <div class="col col-lg-4 item">
                    <div class="item-content">
                        <div class="row">
                            <span class="title text-nowrap">LIVE NEWS</span>
                        </div>
                        <div class="d-flex justify-content-between state">
                            <h4><?php echo executeQuery("news", 1); ?></h4>
                            <i class="ico ico-color-dashboard ico-unipress"></i>
                        </div>
                    </div>
                </div>
                <div class="col col-lg-4 item">
                    <div class="item-content">
                        <div class="row">
                            <span class="title text-nowrap">TRASHED NEWS</span>
                        </div>
                        <div class="d-flex justify-content-between state">
                            <h4><?php echo executeQuery("news", 2); ?></h4>
                            <i class="ico ico-color-dashboard ico-unipress"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
        </div>
    </div>

    @include('../base/dashboard/dashboard_script')

</body>
</html>
