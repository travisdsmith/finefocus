tinymce.init({
    selector: '.wysiwyg_slide',
    height: 200,
    plugins: [
        'autolink link charmap anchor',
        'searchreplace visualblocks code',
        'insertdatetime contextmenu paste code'
    ],
    removed_menuitems: 'newdocument',
    toolbar: 'undo redo | styleselect | bold italic underline | link'
});

tinymce.init({
    selector: '.wysiwyg_page',
    height: 400,
    theme: 'modern',
    plugins: [
        'advlist autolink lists link image charmap hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code',
        'insertdatetime media nonbreaking save table contextmenu directionality',
        'emoticons paste textcolor colorpicker textpattern imagetools'
    ],
    toolbar1: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
    toolbar2: 'link image media | forecolor backcolor',
    removed_menuitems: 'newdocument',
    image_advtab: true,
    content_css: [
        '../css/bootstrap.min.css',
        '../css/bootstrap-theme.min.css',
        '../css/custom.css'
    ]
});