(function() {
    tinymce.create('tinymce.plugins.quotes', {
        init : function(ed, url) {
            ed.addButton('columnID', {
                title : 'Add Columns',
                image : url+'/columnas.png',
                onclick : function() {
                     ed.selection.setContent('[columns]' + 'El contenido que introduzcas aquí, se dividira en columnas automaticamente.' + ed.selection.getContent() + '[/columns]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('pluginID', tinymce.plugins.quotes);
})();