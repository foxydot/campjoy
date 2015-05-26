jQuery('.my_meta_control .wpa_loop').sortable({
	items: '.wpa_group',
	cursor: 'move',
	axis: 'y',
	containment: '.my_meta_control .wpa_loop',
	delay: 300,
	distance: 50,
	start: function(event, ui) {
		ui.item.css( 'background-color', '#ffffff' );
		ui.item.css( 'outline', '1px dashed #dfdfdf' );
	},
	stop: function(event, ui) {		
		ui.item.removeAttr('style');
	},
	update: function(event, ui) {	
		ui.item.css('cursor','default');
		ui.item.disableSelection();
	},
	tolerance: 'pointer'
});
jQuery('.my_meta.control .wpa_loop').disableSelection();