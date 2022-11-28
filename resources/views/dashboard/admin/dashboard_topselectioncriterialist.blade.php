
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
                        {{-- Check is the topResult empty --}}
                        @if ($topResults->isEmpty())
                        <label>
                            <h3>There was no selection criteria.</h3>
                        </label>
                        @else

                            <div class="table-design">
                                <table>
                                    <tr>
                                        <th>
                                            <h3>Criteria</h3>
                                        </th>
                                        <th>
                                            <h3>Type</h3>
                                        </th>
                                        <th>
                                            <h3 class="text-align-second-column">Number of Tenants Selected</h3>
                                        </th>
                                    </tr>
                                    {{-- For loop records --}}
                                    @foreach ($topResults as $topResult)
                                    <tr>
                                        <td><label>{{ $topResult->name }}</label></td>
                                        <td><label>{{ $topResult->type }}</label></td>
                                        <td class="text-align-second-column"><label>{{ $topResult->selected_count }}</label></td>
                                    </tr>
                                    @endforeach

                                </table>
                            </div>
                            
                        @endif

                        </div>

                    </div>


                </div>

            </div>
        </div>

        @include('../base/dashboard/dashboard_script')

    </body>

    </html>

