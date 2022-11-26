<script src="{{ asset("/vendor/jquery/jquery-3.6.0.min.js") }}"></script>
<script src="{{ asset("/vendor/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
<script src="{{ asset("/js/dashboard/dashboard_master.js") }}"></script>
<script src="{{ asset('/vendor/xande/scripting.js') }}"></script>
<script src="{{ asset("/vendor/xande/form.js") }}"></script>



@if (isset($page))
    <script>
        let page_str = "{{ $page }}"
        page_str = page_str.replace(/ /gi, "_");
        page_str = page_str.toLowerCase();

        $page = $("#" + page_str);
        $page.addClass("active");

        $page.find(".ico-sidebar").addClass('ico-golden');
    </script>
@endif