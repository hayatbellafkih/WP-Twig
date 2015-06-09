(function($) {
	$(document).ready(function() {

		$('.lien').click(function(e) {
			var contentPanelId = jQuery(this).attr("id");
			e.preventDefault();
			$.post(PT_Ajax.ajaxurl, {
				// wp ajax action
				action : 'remove_dir',
				// vars
				removed_dir_index : contentPanelId
				}, function(response) {
				console.log(response);
			});
		})

		$('#auto_reload').click(function(e) {
			e.preventDefault();
			$.post(PT_Ajax.ajaxurl, {
				// wp ajax action
				action : 'auto_reload',
				// vars
				auto_reload : this.value
				}, function(response) {
				console.log(response);
			});
			e.preventDefault();

		})
		$('#routing').click(function(e) {
			var contentPanelId = jQuery(this).attr("id");
			e.preventDefault();
			$.post(PT_Ajax.ajaxurl, {
				// wp ajax action
				action : 'routing',
				// vars
				routing : this.value
				}, function(response) {
				console.log(response);
			});
			e.preventDefault();

		})
		$('#wt_is_cache').change(function(e) {
			var state;
			if ($(this).is(":checked")) {
				state = 1;
			} else {
				state = 0;
			}
			e.preventDefault();
			$.post(PT_Ajax.ajaxurl, {
				// wp ajax action
				action : 'is_cache',
				// vars
				is_cache : state
			}, function(response) {
				console.log(response);
			});
			e.preventDefault();
		})
		
		$("#debug").change(function(e) {
			$.post(PT_Ajax.ajaxurl, {
				// wp ajax action
				action : 'wt_debug',
				// vars
				debug : this.value,
			}, function(response) {
				console.log(response);
			});
			e.preventDefault();
		});
		
		$('#empty').click(function(e) {
			e.preventDefault();
			$.post(PT_Ajax.ajaxurl, {
				// wp ajax action
				action : 'empty_cache',

				// vars
				pathTxt : '',
			}, function(response) {
				console.log(response);
			});
		});
		
		
		$("#list_dirs").unbind('click');
		$('#list_dirs').click(function(e) {
		
			$.post(PT_Ajax.ajaxurl, {
				// wp ajax action
				action : 'list_dirs'
				
			}, function(response) {
				liste = document.getElementById("registred_dirs");
				$('#registred_dirs').empty();
				var res = response.split(";");
				
				liste.innerHTML += "<ul>";
				for(var i=0 ; i<res.length;i++){
					liste.innerHTML += "<li> "+ res[i]+"</li>";
				}
				liste.innerHTML += "</ul>";
				
			});
			e.preventDefault();
		});
		
		$('#dirs').click(function(e) {
			var x = $("#pathTxt").val();

			//liste.innerHTML += "<div>" + $("#pathTxt").val() + "</div>";
			$.post(PT_Ajax.ajaxurl, {
				// wp ajax action
				action : 'add_dir',
				// vars
				path : x,
			}, function(response) {
				console.log(response);
			});
			e.preventDefault();
		});
	});
	function a() {
	}
})(jQuery);