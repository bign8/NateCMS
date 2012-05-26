var list;
$(document).ready(function () {
	// Drag and drop content for pages
	list = $( '.sortable' ).sortable({
		start: function (e, ui) { ui.placeholder.html('Content Destination'); }, // pretty up placeholder
		opacity: 0.6, cursor: 'move', placeholder: 'block-state-highlight', forcePlaceholderSize: true,
		connectWith: '.sortable', handle: 'span.move', items: 'div:not(.content)', 
		stop: Editer.updateOrder
	}).disableSelection();
});

var Editer = { 
	updateOrder: function() {
		list.sortable('disable');
		var orders = [], data = 'action=updateOrder';
		var rotatingClass = 'ui-icon-arrowrefresh-1-n', moveIcon = 'ui-icon-transferthick-e-w';

		$('.sortable span.move').toggleClass(moveIcon + " " + rotatingClass);
		var timer = setInterval(function() {
			var old = rotatingClass;
			switch(old){
				case 'ui-icon-arrowrefresh-1-n': rotatingClass = 'ui-icon-arrowrefresh-1-e'; break;
				case 'ui-icon-arrowrefresh-1-e': rotatingClass = 'ui-icon-arrowrefresh-1-s'; break;
				case 'ui-icon-arrowrefresh-1-s': rotatingClass = 'ui-icon-arrowrefresh-1-w'; break;
				case 'ui-icon-arrowrefresh-1-w': rotatingClass = 'ui-icon-arrowrefresh-1-n'; break;
			}
			$('.sortable span.move').toggleClass(old + ' ' + rotatingClass);
		}, 100);
		
		$('.sortable').children().each(function(i, item){
			if (item.id == '') return; // only elements with id's please
			
			parent = $(item).parent().attr('id');
			if (orders.hasOwnProperty(parent)) { orders[parent]++; } else { orders[parent] = 1; }
			
			data += '&data['+i+'][id]=' + item.id + '&data['+i+'][ord]=' + orders[parent] + '&data['+i+'][dest]=' + parent
		});
		
		$.ajax({
			url:'/edit.php',
			data:data,
			success:function(txt){
				list.sortable('enable');
				clearInterval(timer);
				$('.sortable span.move').toggleClass(moveIcon + ' ' + rotatingClass);
				if (txt != 'check') Editer.updateError();
			}
		});
	},

	// Remove content from pages
	killMe: function(that) {
		removeID = $(that).parent().parent().attr('id');
		
		var dialog = $(document.createElement('div'));
		dialog.html('<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span>This item will be permanently deleted and cannot be recovered. Are you absolutely sure?')
			.attr('title','Delete Content?')
			.dialog({ resizable: false, draggable: false, modal: true, closeOnEscape: false,
				buttons: {
					'Delete this item': function() {
						dialog.dialog('option', 'buttons', { } ).html('<div id="progress"></div>');
						var progress = $('#progress').progressbar();
						var timer = setInterval(function() {
							value = progress.progressbar('value')+1;
							progress.progressbar('value', value % 101);
						}, 10);
						$.ajax({
							url:'/edit.php',
							data:'action=removeContent&remID=' + removeID,
							success:function(txt){
								if (txt != 'check') Editer.updateError();
								clearInterval(timer);
								progress.progressbar( 'destroy' );
								dialog.dialog('close');
								$('div#' + removeID).delay(500).fadeOut('slow', function() {$(this).remove();});
							}
						});
					},
					Cancel: function() {
						dialog.dialog('close');
					}
				},
				open: function(event, ui) { $('.ui-dialog-titlebar-close').hide(); },
				close: function() { dialog.dialog( 'destroy' ); dialog.remove(); }
			});
	},

	// Add content scripts
	displayAddForm: function(that) {
		$('.add-new-text', that).hide();
		$('.add-new-form', that).show();
	},
	loadDesc: function(that) {
		var val = $('option:selected', that).attr('title');
		$(that).parent().find('.add-new-form-desc').html(val);
	},
	addContent: function(vfs, loc, that) {
		var val = that['type_id'].value;
		if (val == 'null') { Editer.revert(that); return false; }
		
		var data = 'action=addContent&vfsID=' + vfs + '&loc=' + loc + '&blockID=' + val;
		$.ajax({
			url:'/edit.php',
			data:data,
			dataType:'json',
			success:function(obj){ //to json
				//var obj = jQuery.parseJSON(json);
				if (obj.check != 'check') Editer.updateError();
				$('#' + loc).append(obj.html).fadeIn('slow');
				
				// script insertion parser
				var temp, srcObj;
				for (srcObj in obj.src){
					temp = obj.src[srcObj];
					if (temp.type == 'js') { // no css magic yet
						/*$.getScript(temp.script, function() {
							alert('Load Complete : ' + temp.script);
							//temp.obj.load();
						});*/
						//document.writeln('<script type="text/javascript" src="'+temp.script+'"></script>');
						var script = document.createElement('script');
						script.setAttribute("type","text/javascript");
						script.setAttribute("src", temp.script);
						if (typeof script!="undefined")
							document.getElementsByTagName("head")[0].appendChild(script);
					}
				}
				
				
				Editer.revert(that);
			}
		});
		
		$('input', that).toggle();
		$('.loader', that).toggle();
		return false;
	},
	revert: function(that) {
		var item = $(that).parent();
		$('.add-new-text, .add-new-form', item).toggle();
		$('.add-new-form-desc', item).html('Content type');
		$('[name="type_id"]', item).val('null');
		$('input', that).show();
		$('.loader', that).hide();
	},
	
	// Edit content blocks public functions
	updateContent: function(id, con, cb) {
		con = encodeURIComponent(con);
		var data = 'action=updateContent&cID=' + id + '&content=' + con;
		$.ajax({
			url:'/edit.php',
			data:data,
			success:function(txt){
				if (txt != 'check') Editer.updateError();
				if(typeof(cb) == 'function') cb();
			}
		});
	},
	updateError: function() {
		alert('error updating\nplease refresh page');
		// ajax log call here
	}
};