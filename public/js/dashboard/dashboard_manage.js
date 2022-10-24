$(document).ready(function () {
    
    $("#manage_category .edit").click(function (e) {
        $id = $(this).parent().parent().parent().attr("id");
        $category = $(this).parent().parent().siblings()[1].innerHTML;
        $desc = $(this).parent().parent().siblings()[2].innerHTML;

        $idInput = $("#update_category_modal").find("input[name=id]");
        $categoryInput = $("#update_category_modal").find("input[name=category]");
        $descInput = $("#update_category_modal").find("textarea[name=category-desc]");

        $idInput.val($id);
        $categoryInput.val($category);
        $descInput.val($desc);
    });

    $("#manage_subcategory .edit").click(function (e) {
        $id = $(this).parent().parent().parent().attr("id");
        $category = $(this).parent().parent().siblings()[1].innerHTML;
        $subcategory = $(this).parent().parent().siblings()[2].innerHTML;
        $desc = $(this).parent().parent().siblings()[3].innerHTML;

        $idInput = $("#update_subcategory_modal").find("input[name=id]");
        $categorySelect = $("#update_subcategory_modal").find("select[name=category]");
        $subcategoryInput = $("#update_subcategory_modal").find("input[name=subcategory]");
        $descInput = $("#update_subcategory_modal").find("textarea[name=subcategory-desc]");

        $selectionList = $categorySelect.children();

        $selectionList.each(i => {
            if($selectionList[i].innerHTML === $category) {
                $($selectionList[0]).removeAttr("selected");
                $($selectionList[i]).attr("selected", "selected");
            }
        });

        $idInput.val($id);
        $subcategoryInput.val($subcategory);
        $descInput.val($desc);
    });

    $("#manage_posts .edit, #trash_posts .edit").click(function (e) {
        $id = $(this).parent().parent().parent().attr("id");
        $title = $(this).parent().parent().siblings()[1].innerHTML;
        $category = $(this).parent().parent().siblings()[2].innerHTML;
        $subcategoryInnerHTML = $(this).parent().parent().siblings()[3].innerHTML;

        $idInput = $("#update_post_modal").find("input[name=id]");
        $titleInput = $("#update_post_modal").find("input[name=title]");
        $categorySelect = $("#update_post_modal").find("select[name=category]");
        $subcategorySelect = $("#update_post_modal").find("select[name=subcategory]");

        $selectionList = $categorySelect.children();

        $selectionList.each(i => {
            if($selectionList[i].innerHTML === $category) {
                $($selectionList[0]).removeAttr("selected");
                $($selectionList[i]).attr("selected", "selected");
            }
        });

        $category_id = $("select[name=category]").find(":selected").val();
        $.when(
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
            })
        ).then(function () {
            $selectionList = $subcategorySelect.children();

            $selectionList.each(i => {
                if($selectionList[i].innerHTML === $subcategoryInnerHTML) {
                    $($selectionList[0]).removeAttr("selected");
                    $($selectionList[i]).attr("selected", "selected");
                }
            });
        });

        $idInput.val($id);
        $titleInput.val($title);
    });

});