(function($) {

	$.ajax({
		type : "post",
		dataType : "json",
		url : post.ajaxurl,
		data : {
			action: "generate_daerah",
		},
		success: function(response) {
			autoComplete(response);
		}
	});

	function autoComplete(data) {
		var daerah = [];

		$.each( data, function( key, value ) {
			daerah.push({
					label : value,
			    slug : key
			});
		});

		$( "#category_label" ).autocomplete({
      minLength: 2,
      source: daerah,
      focus: function( event, ui ) {
        $( "#category_label" ).val( ui.item.label );
        return false;
      },
      select: function( event, ui ) {
        $( "#category_label" ).val( ui.item.label );
        $( "#category_name" ).val( ui.item.slug );

        return false;
      }
    });
	}
})(jQuery); // End of use strict
