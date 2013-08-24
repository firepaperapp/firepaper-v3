/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	 config.uiColor = '#D7E7E9';

	config.toolbar = 'MyToolbar';
	config.resize_enabled = false;
  	config.removePlugins = 'elementspath'; 
	config.toolbar_MyToolbar =
	[
		['Bold','Italic'],
        ['NumberedList','BulletedList'],
        ['Link','Unlink']
	];
	config.LinkShowTargets = false ;
	
};
CKEDITOR.on( 'dialogDefinition', function( ev )
{
  // Take the dialog name and its definition from the event data.
  var dialogName = ev.data.name;
  var dialogDefinition = ev.data.definition;

  // Check if the definition is from the dialog we're
  // interested in (the 'link' dialog).
  if ( dialogName == 'link' )
  {
     // Remove the 'Target' and 'Advanced' tabs from the 'Link' dialog.
     dialogDefinition.removeContents( 'target' );
     dialogDefinition.removeContents( 'advanced' );

     // Get a reference to the 'Link Info' tab.
     var infoTab = dialogDefinition.getContents( 'info' );

     // Remove unnecessary widgets from the 'Link Info' tab.         
     infoTab.remove( 'linkType');
     infoTab.remove( 'protocol');
  }
});