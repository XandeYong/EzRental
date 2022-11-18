

<!DOCTYPE html>
<html lang="en">
<head>
    <title>EzRental | Report</title>
    
    @include('../base/dashboard/dashboard_head')
    <link rel="stylesheet" href="{{ asset("/css/dashboard/dashboard_index.css")}}">
    <link rel="stylesheet" href="{{ asset("/css/dashboard/dashboard_report.css")}}">
</head>
<body>
     
    
    @include('../base/dashboard/dashboard_sidebar')

    <div id="wrapper">
        <div class="container-fluid">
            @include('../base/dashboard/dashboard_header')

            <div id="content" class="row">
                
                <div class="col-12 col-lg-10 justify-content-center">

                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('dashboard.admin.topselectioncriterialist') }}">
                                    <button type="button" class="report-button">Top Selection Criteria List</button>
                                </a>
                                
                            </div>
                        </div>
                    </div>

                </div>

                
            </div>
            
        </div>
    </div>

    @include('../base/dashboard/dashboard_script')

</body>
</html>
