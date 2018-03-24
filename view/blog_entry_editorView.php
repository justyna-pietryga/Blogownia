<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>
        tinymce.init(
            { //selector:'textarea',
                selector: 'textarea',
                height: 500,
                theme: 'modern',
                plugins: ['print preview fullpage powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern help',
                    "advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste imagetools wordcount"],
                toolbar1: 'insertfile undo redo | formatselect | bold italic underline strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist outdent indent  | removeformat | image media',
                image_advtab: true,
                templates: [
                    { title: 'Test template 1', content: 'Test 1' },
                    { title: 'Test template 2', content: 'Test 2' }
                ],
                content_css: [
                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                    '//www.tinymce.com/css/codepen.min.css'
                ]
            });
    </script>

    <link rel="stylesheet" href="../css/postEditor.css" type="text/css">
    <?php require_once 'head_injection.php' ?>

</head>
<body>
<header>
    <?php include 'menu_nav.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/model/BlogEntry.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/model/Category.php';
    ?>

</header>


<form method="post" <?php
        if(isset($_GET['postId']))
        {
            echo ' action="/post_editor_controller.php?action=edit&postId='.$_GET['postId'].'"';
        }
        else{
            echo ' action="/post_editor_controller.php?action=new_post"';
        }

?>>

<div class="container">
<div class="title"><input type="text" name="title" placeholder="Tytuł"
        <?php
        if($_GET['action']=='edit'){
            echo "value=\"". BlogEntry::getOnePost($_GET['postId'])->getTitle(). "\"";
        }
        ?> ></div>
<textarea class="textArea" name="content"><?php
    if($_GET['action']=='edit'){
        echo BlogEntry::getOnePost($_GET['postId'])->getContent();
    }
    ?></textarea>

<select name="category" style="margin-top: 10px" required>

    <?php
    $categories=Category::getAll();

    foreach ($categories as $category) {
        $id= Category::getId($category);
        echo '<option value='.$id.'>'.$category.'</option>';
    }
    ?>
</select>


<input type="submit" value="Zapisz">
</div>

</form>













</body>
</html>