<script src="{{ asset("/vendor/jquery/jquery-3.6.0.min.js") }}"></script>
<script src="{{ asset("/vendor/bootstrap/js/bootstrap.js") }}"></script>
<script src="{{ asset("/js/dashboard/dashboard_master.js") }}"></script>



@if (isset($page))
    <script>
        let page_str = "{{ $page }}"
        console.log(page_str);
        page_str = page_str.replace(/ /gi, "_");
        page_str = page_str.toLowerCase();
        
        console.log(page_str);

        $page = $("#" + page_str);
        $page.addClass("active");
    </script>
@endif