<?php
$admin_page = 4;
require_once("../includes/initialize.php");
require_once("../includes/check_login.php");
if (filter_input(INPUT_POST, 'submit')) {
    if (Page::find_by_id(filter_input(INPUT_GET, "id"))) {
        $page = Page::find_by_id(filter_input(INPUT_GET, "id"));
    } else {
        $page = new Page();
    }
    
    validate_presences(array('title', 'slug'));
    
    if (!empty($errors)) {
        $message = "danger|There were errors. " . join(" ", $errors);
    } else {
        $page->title = filter_input(INPUT_POST, 'title');
        $page->slug = filter_input(INPUT_POST, 'slug');
        $page->content_indented = filter_input(INPUT_POST, 'content_indented');
        $page->content_unindented = filter_input(INPUT_POST, 'content_unindented');

        if ($page->save()) {
            $session->message("success|The page was updated.");
            redirect_to('page_all.php');
        } else {
            $message = "danger|The page could not be updated. Have you checked to make sure your slug is unique?";
        }
    }
}
?>
<?php
require_once(LAYOUT_PATH . DS . "admin_header.php");
if (filter_input(INPUT_GET, "id")) {
    if ($page = Page::find_by_id(filter_input(INPUT_GET, "id"))) {
        ?>
        <h1 class="page-header"><i class="fa fa-files-o fa-fw"></i>&nbsp;Edit Page</h1>
        <?= output_message($message) ?>
        <form class="form-horizontal" role="form" action="page_edit.php?id=<?= $page->id ?>" method="POST">
            <div class="form-group">
                <label for="title" class="control-label">Title</label>
                <input type="text" class="form-control input-lg" id="title" name="title" placeholder="Title" maxlength="255" value="<?= filter_input(INPUT_POST, 'title') ? filter_input(INPUT_POST, 'title') : $page->title ?>" required>
            </div>
            <div class="form-group">
                <label for="slug" class="control-label">Slug</label>
                <input type="text" class="form-control input-sm" id="slug" name="slug" placeholder="Slug" maxlength="45" value="<?= filter_input(INPUT_POST, 'slug') ? filter_input(INPUT_POST, 'slug') : $page->slug ?>" required>
                <p class="help-block">A slug identifies a page using human-readable keywords. The slug may only consist of alphanumeric characters or dashes and should be based off of the page title. No two pages may have the same slug.</p>
            </div>
            <div class="form-group">
                <label for="content_indented" class="control-label">Indented Content</label>
                <a class="btn btn-default btn-sm" role="button" data-toggle="collapse" href="#content_indented_div" aria-expanded="false" aria-controls="content_indented_div">Toggle</a>
                <div class="collapse" id="content_indented_div">
                    <textarea id="content_indented" name="content_indented" class="wysiwyg_page"><?= filter_input(INPUT_POST, 'content_indented') ? filter_input(INPUT_POST, 'content_indented') : $page->content_indented ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="content_unindented" class="control-label">Unindented Content</label>
                <a class="btn btn-default btn-sm" role="button" data-toggle="collapse" href="#content_unindented_div" aria-expanded="false" aria-controls="content_unindented_div">Toggle</a>
                <div class="collapse" id="content_unindented_div">
                    <textarea id="content_unindented" name="content_unindented" class="wysiwyg_page"><?= filter_input(INPUT_POST, 'content_unindented') ? filter_input(INPUT_POST, 'content_unindented') : $page->content_unindented ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <input class="btn btn-lg btn-primary" type="submit" name="submit" id="submit" value="Update" />
            </div>
        </form>
    <?php } else { ?>
        <h1 class="page-header"><i class="fa fa-files-o fa-fw"></i>&nbsp;Edit Page</h1>
        <p class="text-muted">Page not found.</p>
        <?php
    }
} else {
    ?>
    <h1 class="page-header"><i class="fa fa-files-o fa-fw"></i>&nbsp;Add Page</h1>
    <?= output_message($message) ?>
    <form class="form-horizontal" role="form" action="page_edit.php" method="POST">
        <div class="form-group">
            <label for="title" class="control-label">Title</label>
            <input type="text" class="form-control input-lg" id="title" name="title" placeholder="Title" maxlength="255" value="<?= filter_input(INPUT_POST, 'title') ?>" required>
        </div>
        <div class="form-group">
            <label for="slug" class="control-label">Slug</label>
            <input type="text" class="form-control input-sm" id="slug" name="slug" placeholder="Slug" maxlength="45" value="<?= filter_input(INPUT_POST, 'slug') ?>" required>
            <p class="help-block">A slug identifies a page using human-readable keywords. The slug may only consist of alphanumeric characters or dashes and should be based off of the page title. No two pages may have the same slug.</p>
        </div>
        <div class="form-group">
            <label for="content_indented" class="control-label">Indented Content</label>
            <a class="btn btn-default btn-sm" role="button" data-toggle="collapse" href="#content_indented_div" aria-expanded="false" aria-controls="content_indented_div">Toggle</a>
            <div class="collapse" id="content_indented_div">
                <textarea id="content_indented" name="content_indented" class="wysiwyg_page"><?= filter_input(INPUT_POST, 'content_indented') ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="content_unindented" class="control-label">Unindented Content</label>
            <a class="btn btn-default btn-sm" role="button" data-toggle="collapse" href="#content_unindented_div" aria-expanded="false" aria-controls="content_unindented_div">Toggle</a>
            <div class="collapse" id="content_unindented_div">
                <textarea id="content_unindented" name="content_unindented" class="wysiwyg_page"><?= filter_input(INPUT_POST, 'content_unindented') ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <input class="btn btn-lg btn-primary" type="submit" name="submit" id="submit" value="Add" />
        </div>
    </form>
    <?php
}
require_once(LAYOUT_PATH . DS . "admin_footer.php");
?>