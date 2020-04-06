(function($) {
	$.ajax({
		type : "post",
		dataType : "json",
		url : postgraph.ajaxurl,
		data : {
			action: "generate_graph_data",
		},
		success: function(response) {
			console.log(response);
		}
	});

	am4core.ready(function() {

	// Themes begin
	am4core.useTheme(am4themes_animated);
	// Themes end



	var chart = am4core.create("force-directed", am4plugins_forceDirected.ForceDirectedTree);
	var networkSeries = chart.series.push(new am4plugins_forceDirected.ForceDirectedSeries())

	chart.data = [
	  {
			name: "Penyalur",
			children: [
				{ name: "Tenaga Medis",
						children: [
							{ name: "DI Yogyakarta", value: 75 },
							{ name: "Jakarta", value: 87 },
							{ name: "Bandung", value: 55 }
					]
				},
				{ name: "Masyarakat",
						children: [
							{ name: "Jakarta", value: 91 },
							{ name: "Jawa Tengah", value: 63 },
							{ name: "Surabaya", value: 12 }
					]
				}
			]
	  }
	];

	networkSeries.dataFields.value = "value";
	networkSeries.dataFields.name = "name";
	networkSeries.dataFields.children = "children";
	networkSeries.nodes.template.tooltipText = "{name}:{value}";
	networkSeries.nodes.template.fillOpacity = 1;

	networkSeries.nodes.template.label.text = "{name}"
	networkSeries.fontSize = 10;

	networkSeries.links.template.strokeWidth = 1;

	var hoverState = networkSeries.links.template.states.create("hover");
	hoverState.properties.strokeWidth = 3;
	hoverState.properties.strokeOpacity = 1;

	networkSeries.nodes.template.events.on("over", function(event) {
	  event.target.dataItem.childLinks.each(function(link) {
	    link.isHover = true;
	  })
	  if (event.target.dataItem.parentLink) {
	    event.target.dataItem.parentLink.isHover = true;
	  }

	})

	networkSeries.nodes.template.events.on("out", function(event) {
	  event.target.dataItem.childLinks.each(function(link) {
	    link.isHover = false;
	  })
	  if (event.target.dataItem.parentLink) {
	    event.target.dataItem.parentLink.isHover = false;
	  }
	})

	}); // end am4core.ready()
})(jQuery); // End of use strict
