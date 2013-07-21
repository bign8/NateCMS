$(document).ready(function () {
	$('.block-edit.text').each(function() {
		textEditObj.display(this);
	});
});

var textEditObj = {
	name: 'Text Editer Object',
	version: '1.0',
	
	// Text Editer Functions
	display: function(that) {
		var obj = $(that);
		console.log('display');
		console.log(that);
		console.log(typeof(that));
		//if (!obj.hasClass('truncated')) 
		if (obj.find('.content').height() >= 50) {
			obj.append('<span class="continued ui-icon ui-icon-arrowthick-1-s" title="Content truncated" onClick="textEditObj.toggleTrunc(this);"></span>');
			obj.find('.content').addClass('truncated');
		}

		obj.on('startEdit', function(evt){
			textEditObj.init(evt.target);
		});
		obj.on('startMove', function(evt){
			console.log('move Started');
			// obj.css({
			// 	'maxHeight': '50px',
			// 	overflow: 'hidden'
			// });
		});
		obj.on('endMove', function(evt){
			console.log('move Ended');
			// obj.css({
			// 	'maxHeight':'none',
			// 	overflow:'visible'
			// });
		});
	},
	toggleTrunc: function(that) {
		$(that).toggleClass('ui-icon-arrowthick-1-s ui-icon-arrowthick-1-n').parent().find('.content').toggleClass('truncated');
	},
	check: function(id) {
		for (var attr in this) if(this[attr].id == id) return true;
		return false;
	},
	init: function(that) {
		var id = $(that).attr('id');
		
		if ( this.check(id) ) return; // ensure instance is not already running
		
		var sid = '#' + id;
		
		if ($('.continued', sid).length > 0) $('.continued', sid).remove(); // remove content truncated icon
		
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
			theme_advanced_buttons1 : 'save,cancel,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,|,code',
			theme_advanced_buttons2 : '',
			theme_advanced_buttons3 : '',
			theme_advanced_toolbar_location : 'top',
			theme_advanced_toolbar_align : 'center',
			theme_advanced_statusbar_location : 'bottom',
			theme_advanced_resizing : true
		});
	},
	destruct: function(editor) {
		var eid = editor.editorId;
		editor.remove();
		textEditObj.Cookies.erase('TinyMCE_' + eid + '_size'); // erase resize data
		var obj = $('.content', this[eid].sid).html(this[eid].content);
		textEditObj.display(obj.parent());
		
		$(this[eid].sid).trigger('closeEdit');
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
		
		var dialog = $('<div/>', {
			title:'Close without saving?',
			html:'<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span>This content contains unsaved changes. Would you like to save before close?'
		}).dialog({ resizable: false, draggable: false, modal: true, closeOnEscape: false,
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
	},
	Cookies: { // http://www.quirksmode.org/js/cookies.html
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
	}
};
