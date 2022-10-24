$(document).ready(function () {
    $("select[name=category]").change(function (e) {
        getSubcategory();
    });
});

function getSubcategory() {
    $category_id = $("select[name=category]").find(":selected").val();
    
    $.ajax({
        type: "POST",
        url: "../backend/dashboard/getSubcategory.php",
        data: {
            "category_id": $category_id
        },
        success: function (response) {
            $subcategory = $("select[name=subcategory]");
            $subcategory.children().not("option[hidden]").remove();
            $subcategory.children("option").removeAttr("selected");
            $subcategory.children("option").attr("selected", "selected");

            subcategories = JSON.parse(response);
            if (!$.isEmptyObject(subcategories)) {
                $.each(subcategories, function (i ,subcategory) { 
                    elem = '<option value="' + subcategory['subcategory_id'] + '">' + subcategory['subcategory'] + '</option>';
                    $subcategory.append(elem);
                });
                
            } else {
                elem = '<option value disabled>No Subcategory Found</option>';
                $subcategory.append(elem);
            }
        }
    });
}