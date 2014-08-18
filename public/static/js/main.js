var search = (function(){
	var open = false,
		allow = true,
		search_block = $('.header-search'),
		nav_block = $('.main-nav');

	function search_open() {
		open = true;
		nav_block.addClass('closed');
		search_block.show();
		setTimeout(function(){
			search_block.addClass('active');
			setTimeout(function(){
				search_block.find('.menu-icon').addClass('active');
			}, 100);
		}, 15);
		setTimeout(function(){
			nav_block.hide();
			allow = true;
		}, 500);
	}

	function search_close() {
		open = false;
		nav_block.show();
		search_block.removeClass('active');
		setTimeout(function(){
			nav_block.removeClass('closed');
		}, 15);
		setTimeout(function(){
			search_block.hide();
			allow = true;
		}, 500);
	}

	$(document).on('click', '.search-icon', function(){
		if(!allow) return;
		allow = false;
		if(open) {
			allow = true;
			if(search_block.find('input').val() == '') {
				return false;
			}
		} else {
			search_open();
			return false;
		}
	});

	$(document).on('click', '.menu-icon', function(){
		if(!allow) return;
		allow = false;
		search_close();
	});
})();