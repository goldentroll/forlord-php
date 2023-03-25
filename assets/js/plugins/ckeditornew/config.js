/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.enterMode = CKEDITOR.ENTER_P;
	config.allowedContent = true;
	config.filebrowserBrowseUrl = 'https://www.forlord.com/assets/js/plugins/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = 'https://www.forlord.com/assets/js/plugins/ckfinder/ckfinder.html?type=Images';
	config.filebrowserFlashBrowseUrl = 'https://www.forlord.com/assets/js/plugins/ckfinder/ckfinder.html?type=Flash';
	config.filebrowserUploadUrl = 'https://www.forlord.com/assets/js/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = 'https://www.forlord.com/assets/js/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl = 'https://www.forlord.com/assets/js/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';


};
