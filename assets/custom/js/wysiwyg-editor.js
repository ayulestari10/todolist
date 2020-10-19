var ComponentsEditors = function() {
    var t = function() {
            jQuery().wysihtml5 && $(".wysihtml5").size() > 0 && $(".wysihtml5").wysihtml5({
                "font-styles": false, // Font styling, e.g. h1, h2, etc.
                "emphasis": true, // Italics, bold, etc.
                "lists": true, // (Un)ordered lists, e.g. Bullets, Numbers.
                "html": false, // Button which allows you to edit the generated HTML.
                "link": false, // Button to insert a link.
                "image": false, // Button to insert an image.
                "color": false, // Button to change color of font
                "blockquote": false, // Blockquote
            });
        },
        s = function() {
            $(".summernote_1").summernote({});
        },
        x = function() {
            $(".summernote_2").summernote({
                // toolbar: [
                //     ['style', ['bold', 'italic', 'underline', 'clear']]
                // ],
                height: 300,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: true                  // set focus to editable area after initializing summernote
            });
        };
    return {
        init: function() {
            t();
            s(); 
            x();
        }
    }
}();
jQuery(document).ready(function() {
    ComponentsEditors.init()
});