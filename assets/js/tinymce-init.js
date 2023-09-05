
import tinymce from 'tinymce/tinymce';
import 'tinymce/themes/silver';
// Importez également tous les plugins que vous souhaitez utiliser, par exemple :
// import 'tinymce/plugins/link';
// import 'tinymce/plugins/table';
// ... etc.

document.addEventListener('DOMContentLoaded', function() {
    console.log('tinymce-init.js');
    console.log('tinymce', tinymce);
    console.log('.tinymce-textarea textarea', document.querySelector('.field-tinymce textarea'));
    tinymce.init({
        selector: '.field-tinymce textarea',
        base_url: '/bundles/tinymce/ext/tinymce',
        icons_url: '/bundles/tinymce/ext/tinymce/icons/default',
        // ... autres configurations de TinyMCE
    });
});