/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    config.extraPlugins = 'sourcedialog';
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.toolbarGroups = [
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
        { name: 'editing',     groups: [ 'find', 'selection' ] },
        { name: 'links' },
        { name: 'insert' },
        //{ name: 'forms' },
        //{ name: 'tools' , items : [ 'Sourcedialog' ]},
        { name: 'document',	   groups: [ 'mode' ]},
        //{ name: 'others' },
        '/',

        { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
        { name: 'styles' },
        { name: 'colors' },
        //{ name: 'about' }
    ];
    // Remove some buttons provided by the standard plugins, which are
    // not needed in the Standard(s) toolbar.
    config.removeButtons = 'Underline,Subscript,Superscript,Div';

    // Set the most common block elements.
    config.format_tags = 'p;h1;h2;h3;pre';
};
