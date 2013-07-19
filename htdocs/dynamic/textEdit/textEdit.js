var textEditObj = {
	name: 'Text Editer Object',
	
	// Text Editer Functions
	display: function(that) {
		var obj = $(that);
		//if (!obj.hasClass('truncated')) 
		if (obj.height() >= 150) {
			obj.parent().append('<span class="continued ui-icon ui-icon-arrowthick-1-s" title="Content truncated" onClick="textEditObj.toggleTrunc(this);"></span>');
			obj.addClass('truncated');
		}
		if (obj.parent().find('.controls').length < 1) { // don't start it twice
			obj.parent().prepend('<span class="controls">'+
				'<span class="edit ui-icon ui-icon-pencil" style="float:left;" title="Edit content" onClick="textEditObj.init(this);"></span>'+
				'<span class="move ui-icon ui-icon-transferthick-e-w" style="float:left;" title="Move content"></span>'+
				'<span class="delete ui-icon ui-icon-closethick" style="float:left;" title="Delete coontent" onClick="Editer.killMe(this);" ></span>'+
			'</span>');
		}
	},
	toggleTrunc: function(that) {
		$(that).toggleClass('ui-icon-arrowthick-1-s ui-icon-arrowthick-1-n').parent().find('.content').toggleClass('truncated');
	},
	check: function(id) { // what does this do?
		for (var attr in this) if(this[attr].id == id) return true;
		return false;
	},
	init: function(that) {
		var id = $(that).parent().parent().attr('id');
		
		if ( this.check(id) ) return; // ensure instance is not already running
		
		var sid = '#' + id;
		
		if ($('.continued', sid).length > 0) $('.continued', sid).remove(); // remove content truncated icon
		
		$('.controls', sid).hide();
		
		var width = $(sid).width();
		
		$('.content', sid).tinymce({
			script_url : '/js/tiny_mce/tiny_mce.js', // Location of TinyMCE script
			
			// Woods Callbacks
			save_oncancelcallback: 'textEditObj.checkSave',
			save_onsavecallback: 'textEditObj.save',
			init_instance_callback: function(inst) { 
				textEditObj[inst.editorId] = {
					content: inst.getContent(), // content after editer did magic
					id: id,
					sid: sid
				}; 
			},
			
			// General options
			theme : 'advanced',
			plugins : 'save',
			height : '200px', // handle width with css : location specific
			width : width + 'px',

			// Theme options
			//*
			theme_advanced_buttons1 : 'save,cancel,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,|,code',
			theme_advanced_buttons2 : '',
			theme_advanced_buttons3 : '',//*/
			/*
			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",//*/
			theme_advanced_toolbar_location : 'top',
			theme_advanced_toolbar_align : 'center',
			theme_advanced_statusbar_location : 'bottom',
			theme_advanced_resizing : true
		});
	},
	destruct: function(editor) {
		var eid = editor.editorId;
		editor.remove();
		Cookies.erase('TinyMCE_' + eid + '_size'); // erase resize data
		var obj = $('.content', this[eid].sid).html(this[eid].content);
		this.display(obj); // run display function
		
		$('.controls', this[eid].sid).show();
		delete this[eid];
	},
	save: function(editor) {
		var eid = editor.editorId;
		editor.setProgressState(1); // Show progress
		this[eid].content = editor.getContent();
		
		Editer.updateContent(this[eid].id, this[eid].content, function() {editor.setProgressState(0);});
	},
	checkSave: function(editor) {
		var eid = editor.editorId;
		
		if (this[eid].content == editor.getContent()) return this.destruct(editor); // already saved
		
		var dialog = $(document.createElement('div'));
		dialog.html('<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span>This content contains unsaved changes. Would you like to save before close?')
			.attr('title','Close without saving?')
			.dialog({ resizable: false, draggable: false, modal: true, closeOnEscape: false,
				buttons: {
					'Save this item': function() {
						textEditObj[eid].content = editor.getContent();
						
						$(".ui-dialog-titlebar-close").hide();
						dialog.dialog('option', 'buttons', { } ).html('<div id="progress"></div>');
						var progress = $('#progress').progressbar();
						var timer = setInterval(function() {
							value = progress.progressbar('value')+1;
							progress.progressbar('value', value % 101);
						}, 10);
						
						Editer.updateContent(textEditObj[eid].id, textEditObj[eid].content, function() {
							textEditObj.destruct(editor);
							clearInterval(timer);
							progress.progressbar( 'destroy' );
							dialog.dialog('close');
						});
					},
					'Close editer': function() {
						textEditObj.destruct(editor);
						dialog.dialog('close');
					}
				},
				close: function() { dialog.dialog( 'destroy' ); dialog.remove(); }
			});
	}
};

var Cookies = { // http://www.quirksmode.org/js/cookies.html
	/*mceDestroy: function() {
		var allCookies = document.cookie.split('; ');
		for (var i=0;i<allCookies.length;i++) {
			var cookiePair = allCookies[i].split('=');
			if (cookiePair[0].indexOf('TinyMCE') != -1) this.erase(cookiePair[0]);
		}
	},//*/
	create: function (name,value,days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = '; expires='+date.toGMTString();
		}
		else var expires = '';
		document.cookie = name+'='+value+expires+'; path=/';
	},
	erase: function (name) {
		this.create(name,'',-1);
	}
};

$(document).ready(function () {
	$('.content', '.block-edit.text').each(function() {
		textEditObj.display(this);
	});
});