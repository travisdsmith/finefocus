var width = 960,
        height = 480;

var projection = d3.geo.equirectangular()
        .scale(153)
        .translate([width / 2, height / 2])
        .precision(.1);

var path = d3.geo.path()
        .projection(projection);

var svg = d3.selectAll('#experts')
        .append('svg')
        .attr('width', width)
        .attr('height', height);

var g = svg.append("g");

d3.json("js/countries.json", function (world) {
    g.selectAll('path')
            .data(topojson.feature(world, world.objects.countries).features)
            .enter()
            .append('path')
            .attr("d", path);

    d3.csv("js/experts.csv", function (data) {
        g.selectAll("circle")
                .data(data)
                .enter()
                .append("circle")
                .attr("cx", function (d) {
                    return projection([d.lon, d.lat])[0];
                })
                .attr("cy", function (d) {
                    return projection([d.lon, d.lat])[1];
                })
                .attr("r", 1)
                .style("fill", "rgb(0,115,189)")
                .append("title")
                .text(function (d) {
                    return d.name + "\r\n" + d.institution;
                });

    });
});

var zoom = d3.behavior.zoom()
        .scaleExtent([1, 10])
        .on("zoom", function () {
            g.attr("transform", "translate(" +
                    d3.event.translate.join(",") + ")scale(" + d3.event.scale + ")");
            g.selectAll("path")
                    .attr("d", path.projection(projection));
        });

svg.call(zoom);