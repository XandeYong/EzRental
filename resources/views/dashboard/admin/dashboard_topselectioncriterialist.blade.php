@if (isset($user))
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>EzRental | Top Selection Criteria List</title>

        @include('../base/dashboard/dashboard_head')
        <link rel="stylesheet" href="{{ asset('/css/dashboard/dashboard_index.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/dashboard/dashboard_topselectioncriterialist.css') }}">
    </head>

    <body>


        @include('../base/dashboard/dashboard_sidebar')

        <div id="wrapper">
            <div class="container-fluid">
                @include('../base/dashboard/dashboard_header')

                <div id="content" class="row">

                    {{-- Code here --}}
                    <div class="col justify-content-center">

                        <div class="container">

                            <table>
                                <tr>
                                    <th>
                                        <h3>Criteria</h3>
                                    </th>
                                    <th>
                                        <h3 class="text-align-second-column">Number of Tenants Selected</h3>
                                    </th>
                                </tr>
                                {{-- For loop 3 records --}}
                                <tr>
                                    <td><label>Master room</label></td>
                                    <td class="text-align-second-column"><label>590</label></td>
                                </tr>
                                <tr>
                                    <td><label>Single room</label></td>
                                    <td class="text-align-second-column"><label>100</label></td>
                                </tr>
                                <tr>
                                    <td><label>Sleep room</label></td>
                                    <td class="text-align-second-column"><label>300</label></td>
                                </tr>
                            </table>

                        </div>

                    </div>


                </div>

            </div>
        </div>

        @include('../base/dashboard/dashboard_script')

    </body>

    </html>
@else
    <script>
        window.location = "/";
    </script>
@endif
