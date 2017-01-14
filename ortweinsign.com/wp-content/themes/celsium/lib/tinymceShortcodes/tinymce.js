function init() {
	tinyMCEPopup.resizeToInnerSize();
}


function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

function aflshortcodesubmit() {
	var tagtext;
	var afl_shortcode = document.getElementById('afl_shortcode_panel');
	// who is active ?
	if (afl_shortcode.className.indexOf('current') != -1) {
		var afl_shortcodeid = document.getElementById('afl_shortcode_tag').value;
		switch(afl_shortcodeid)
		{
			case 0:
				tinyMCEPopup.close();
			break;
			case 'map':
				tagtext=" ["+afl_shortcodeid + " width=\"\" height=\"\" src=\"\"] "+ tinyMCEPopup.editor.selection.getContent() +" [/" + afl_shortcodeid + "] ";
			break;
			case 'button':
				tagtext=" ["+afl_shortcodeid + " link=\"\" color=\"\"] "+ tinyMCEPopup.editor.selection.getContent() +" [/" + afl_shortcodeid + "] ";
			break;
			case 'quote':
				tagtext=" ["+afl_shortcodeid + " title=\"\"] "+ tinyMCEPopup.editor.selection.getContent() +" [/" + afl_shortcodeid + "] ";
			break;
			case 'warning_box':
				tagtext=" [box title=\"\"] "+ tinyMCEPopup.editor.selection.getContent() +" [/box] ";
			break;
			case 'success_box':
				tagtext=" [box type=\"success\" title=\"\"] "+ tinyMCEPopup.editor.selection.getContent() +" [/box] ";
			break;
			case 'info_box':
				tagtext=" [box type=\"info\" title=\"\"] "+ tinyMCEPopup.editor.selection.getContent() +" [/box] ";
			break;
			case 'error_box':
				tagtext=" [box type=\"error\" title=\"\"] "+ tinyMCEPopup.editor.selection.getContent() +" [/box] ";
			break;
			case 'vimeo':
				tagtext=" [video type=\"vimeo\" width=\"\" height=\"\" id=\"\"] "+ tinyMCEPopup.editor.selection.getContent() +" [/video] ";
			break;
			case 'youtube':
				tagtext=" [video width=\"\" height=\"\" id=\"\"] "+ tinyMCEPopup.editor.selection.getContent() +" [/video] ";
			break;
			case 'tooltip':
				tagtext=" ["+afl_shortcodeid + " text=\"\"] "+ tinyMCEPopup.editor.selection.getContent() +" [/" + afl_shortcodeid + "] ";
			break;
			case 'recents':
			tagtext=" ["+afl_shortcodeid + "] [/" + afl_shortcodeid + "] ";
			break;
			case 'user_posts_strip':
			tagtext=" ["+afl_shortcodeid + " type=\"post\" offset=\"0\" per_page=\"2\"] [/" + afl_shortcodeid + "] ";
			break;
            case 'testimonials':
            tagtext=" ["+afl_shortcodeid + "] [/" + afl_shortcodeid + "] ";
            break;
            case 'accordion':
                tagtext=" ["+afl_shortcodeid + "][accordion_unit title='Some Title' link_text='Read More ...' url='#'] "+ tinyMCEPopup.editor.selection.getContent() +" [/accordion_unit][/" + afl_shortcodeid + "] ";
                break;
			default:
				tagtext=" ["+afl_shortcodeid + "] "+ tinyMCEPopup.editor.selection.getContent() +" [/" + afl_shortcodeid + "] ";
			break;
		}
	}
	if(tinyMCEPopup.editor) {
		window.tinyMCE.execInstanceCommand(tinyMCEPopup.editor.id, 'mceInsertContent', false, tagtext);
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
	}
	return;
}