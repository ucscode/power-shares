"use strict";

$(function() {
	
	// Activate all popovers
	var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
	var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
		return new bootstrap.Popover(popoverTriggerEl)
	});
	
	// Form alert before submission
	$('form').each(function() {
		let form = this;
		let temp = document.createElement('div');
		temp.classList.add('text-center');
		$(this).on('submit', function(e) {
			let el = document.activeElement;
			if( el && ['BUTTON', 'INPUT'].includes(el.tagName) && el.hasAttribute('data-confirm') ) {
				temp.innerHTML = el.dataset.confirm;
				swal({
					icon: 'info',
					content: temp,
					buttons: true
				}).then(function(info) {
					if( info ) {
						let newForm = form.cloneNode(true);
						$("<input type='hidden' />")
						.attr("name", el.name)
						.attr("value", el.value)
						.appendTo(newForm);
						$('body').append(newForm);
						newForm.submit();
					}
				});
				return false;
			};
		});
	});
	
	// scrollTo
	$("[data-scroll-to]").each(function() {
		var to = this.dataset.scrollTo;
		if( to == 'bottom' ) this.scrollTop = this.scrollHeight;
	});
	
	// convert <select> To select2;
	$('select').each(function() {
		if( $(this).hasClass('.default') ||
			this.dataset.select == 'default' ||
				$(this).parents("[data-select='default']").length ||
					this.style.display == 'none' ||
						$(this).hasClass('d-none') ) return;
		$(this).select2();
	});
	
	// Trigger Copy on input or Textarea;
	$("[data-copy]").click(function() {
		let el = $(this.dataset.copy).get(0);
		if( !el ) return;
		el.select();
		let promise = navigator.clipboard.writeText(el.value);
		promise.then(function() {
			swal({ text: 'Text Copied To Clipboard', 'icon': 'success' });
		}, function() {
			swal({ text: 'Text Not Copied', 'icon': 'error' });
		});
	});
	
	// use dataTable library;
	$('table.table[data-layout]').each(function() {
		var option = { "responsive": false };
		var table = $(this).DataTable(option);    
	});
	
	
});