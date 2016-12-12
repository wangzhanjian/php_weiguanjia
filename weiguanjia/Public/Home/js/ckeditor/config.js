/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {

    config.toolbarGroups = [
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
        { name: 'forms', groups: [ 'forms' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        { name: 'tools', groups: [ 'tools' ] },
        { name: 'colors', groups: [ 'colors' ] },
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'insert', groups: [ 'insert' ] },
        { name: 'styles', groups: [ 'styles' ] },
        { name: 'colors', groups: [ 'colors' ] },
        { name: 'others', groups: [ 'others' ] }
    ];

    config.removeButtons = 'Source,Print,Form,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,NumberedList,BulletedList,CreateDiv,Link,Unlink,Anchor,Table,PageBreak,Iframe,Save,NewPage,Checkbox,About';

     //一下是后天验证非法数据
    config.protectedSource.push( /<\s*iframe[\s\S]*?>/gi ) ; // <iframe> tags.              
    config.protectedSource.push( /<\s*frameset[\s\S]*?>/gi ) ; // <frameset> tags.
    config.protectedSource.push( /<\s*frame[\s\S]*?>/gi ) ; // <frame> tags.
    config.protectedSource.push( /<\s*script[\s\S]*?\/script\s*>/gi ) ; // <SCRIPT> tags.
    config.protectedSource.push( /<%[\s\S]*?%>/g ) ; // ASP style server side code
    config.protectedSource.push( /<\?[\s\S]*?\?>/g ) ; // PHP style server side code
    config.protectedSource.push( /(<asp:[^\>]+>[\s|\S]*?<\/asp:[^\>]+>)|(<asp:[^\>]+\/>)/gi ) ;
    
};
