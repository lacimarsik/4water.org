(function(c, b) {
    var a = function(d, f) {
        var e = this;
        e.map = null;
        e.container = document.getElementById(d);
        e.options = f;
        e.infowindow = null;
        e._normalizeOptions()
    };
    a.styles = {
        DEFAULT: [],
        RED: [{
            featureType: "all",
            stylers: [{
                hue: "#ff0000"
            }]
        }],
        NIGHT: [{
            featureType: "all",
            stylers: [{
                invert_lightness: "true"
            }]
        }],
        BLUE: [{
            featureType: "all",
            stylers: [{
                hue: "#0000b0"
            }, {
                invert_lightness: "true"
            }, {
                saturation: -30
            }]
        }],
        GREYSCALE: [{
            featureType: "all",
            stylers: [{
                saturation: -100
            }, {
                gamma: 0.5
            }]
        }],
        NO_ROADS: [{
            featureType: "road",
            stylers: [{
                visibility: "off"
            }]
        }],
        MIXED: [{
            featureType: "landscape",
            stylers: [{
                hue: "#00dd00"
            }]
        }, {
            featureType: "road",
            stylers: [{
                hue: "#dd0000"
            }]
        }, {
            featureType: "water",
            stylers: [{
                hue: "#000040"
            }]
        }, {
            featureType: "poi.park",
            stylers: [{
                visibility: "off"
            }]
        }, {
            featureType: "road.arterial",
            stylers: [{
                hue: "#ffff00"
            }]
        }, {
            featureType: "road.local",
            stylers: [{
                visibility: "off"
            }]
        }],
        CHILLED: [{
            featureType: "road",
            elementType: "geometry",
            stylers: [{
                visibility: "simplified"
            }]
        }, {
            featureType: "road.arterial",
            stylers: [{
                hue: 149
            }, {
                saturation: -78
            }, {
                lightness: 0
            }]
        }, {
            featureType: "road.highway",
            stylers: [{
                hue: -31
            }, {
                saturation: -40
            }, {
                lightness: 2.8
            }]
        }, {
            featureType: "poi",
            elementType: "label",
            stylers: [{
                visibility: "off"
            }]
        }, {
            featureType: "landscape",
            stylers: [{
                hue: 163
            }, {
                saturation: -26
            }, {
                lightness: -1.1
            }]
        }, {
            featureType: "transit",
            stylers: [{
                visibility: "off"
            }]
        }, {
            featureType: "water",
            stylers: [{
                hue: 3
            }, {
                saturation: -24.24
            }, {
                lightness: -38.57
            }]
        }]
    };
    a.prototype = {};
    a.prototype._normalizeOptions = function() {
        var g = this.options.map || {},
            f = function(i) {
                return i === "1"
            },
            e = function(i, j, k) {
                return j[i] || k
            },
            d = function(i) {
                return e(i, b.ControlPosition, 0)
            },
            h = {
                minZoom: parseInt,
                maxZoom: parseInt,
                scrollwheel: f,
                draggable: f,
                mapTypeId: function(i) {
                    return b.MapTypeId[i] || b.MapTypeId.ROADMAP
                },
                mapTypeControl: f,
                mapTypeControlOptions: {
                    position: d,
                    mapTypeIds: function(i) {
                        var j = [];
                        c.each(i, function(k, l) {
                            if (b.MapTypeId[l] !== undefined) {
                                j.push(b.MapTypeId[l])
                            }
                        });
                        return j
                    },
                    style: function(i) {
                        return e(i, b.MapTypeControlStyle, b.MapTypeControlStyle.DEFAULT)
                    }
                },
                overviewMapControl: f,
                overviewMapControlOptions: {
                    opened: f
                },
                panControl: f,
                panControlOptions: {
                    position: d
                },
                rotateControl: f,
                rotateControlOptions: {
                    position: d
                },
                scaleControl: f,
                scaleControlOptions: {
                    position: d
                },
                streetViewControl: f,
                streetViewControlOptions: {
                    position: d
                },
                zoomControl: f,
                zoomControlOptions: {
                    position: d,
                    style: function(i) {
                        return e(i, b.ZoomControlStyle, b.ZoomControlStyle.DEFAULT)
                    }
                }
            };
        return c.each(g, function(i, j) {
            if (h[i] === undefined) {
                delete g[i]
            } else {
                if (typeof j === "boolean") {
                    j = j ? "1" : "0";
                }
                if (typeof j === "string") {
                    g[i] = h[i](j)
                } else {
                    c.each(j, function(l, k) {
                        if (h[i][l] === undefined) {
                            delete g[i][l]
                        } else {
                            g[i][l] = h[i][l](k)
                        }
                    })
                }
            }
        })
    };
    a.prototype._getGeocoder = function() {
        if (!a._geocoder) {
            a._geocoder = new b.Geocoder()
        }
        return a._geocoder
    };
    a.prototype._renderOverlays = function() {
        var d = this;
        c.each(d.options.overlays.marker || [], function(h, g) {
            var f;
            try {
                f = new b.Marker({
                    position: new b.LatLng(g.position[0], g.position[1]),
                    map: d.map,
                    title: g.title || "",
                    icon: g.icon || null
                });
                b.event.addListener(f, "click", function() {
                    var i, e = c.trim(g.info || "");
                    if (e.length) {
                        if (d.infowindow) {
                            d.infowindow.close()
                        }
                        i = new b.InfoWindow();
                        i.setContent(e);
                        i.open(d.map, f);
                        d.infowindow = i
                    }
                })
            } catch (j) {}
        });
        c.each(d.options.overlays.polyline || [], function(g, f) {
            var j = [];
            c.each(f.path || [], function(i, e) {
                if (e.length == 2) {
                    j.push(new b.LatLng(e[0], e[1]))
                }
            });
            if (j.length >= 2) {
                try {
                    new b.Polyline({
                        map: d.map,
                        path: j,
                        strokeColor: f.color || "#000000",
                        strokeOpacity: f.opacity || 1,
                        strokeWeight: f.weight || 3
                    })
                } catch (h) {}
            }
        });
        c.each(d.options.overlays.polygon || [], function(g, f) {
            var j = [];
            c.each(f.path || [], function(i, e) {
                if (e.length == 2) {
                    j.push(new b.LatLng(e[0], e[1]))
                }
            });
            if (j.length >= 2) {
                try {
                    new b.Polygon({
                        map: d.map,
                        path: j,
                        strokeColor: f.stroke_color || "#000000",
                        strokeOpacity: f.stroke_opacity || 1,
                        strokeWeight: f.weight || 3,
                        strokePosition: b.StrokePosition[f.position] || b.StrokePosition.CENTER,
                        fillColor: f.fill_color || "#000000",
                        fillOpacity: f.fill_opacity || 0.3
                    })
                } catch (h) {}
            }
        });
        c.each(d.options.overlays.rectangle || [], function(g, f) {
            var j = [];
            c.each(f.path || [], function(i, e) {
                if (e.length == 2) {
                    j.push(new b.LatLng(e[0], e[1]))
                }
            });
            if (j.length == 2) {
                try {
                    new b.Rectangle({
                        map: d.map,
                        bounds: new b.LatLngBounds(j[0], j[1]),
                        strokeColor: f.stroke_color || "#000000",
                        strokeOpacity: f.stroke_opacity || 1,
                        strokeWeight: f.weight || 3,
                        strokePosition: b.StrokePosition[f.position] || b.StrokePosition.CENTER,
                        fillColor: f.fill_color || "#000000",
                        fillOpacity: f.fill_opacity || 0.3
                    })
                } catch (h) {}
            }
        });
        c.each(d.options.overlays.circle || [], function(g, f) {
            try {
                new b.Circle({
                    map: d.map,
                    center: new b.LatLng(f.path[0][0], f.path[0][1]),
                    radius: parseFloat(f.path[1][0]),
                    strokeColor: f.stroke_color || "#000000",
                    strokeOpacity: f.stroke_opacity || 1,
                    strokeWeight: f.weight || 3,
                    strokePosition: b.StrokePosition[f.position] || b.StrokePosition.CENTER,
                    fillColor: f.fill_color || "#000000",
                    fillOpacity: f.fill_opacity || 0.3
                })
            } catch (h) {}
        })
    };
    a.prototype._renderDirections = function() {
        var e = this,
            d = new b.DirectionsService();
        c.each(e.options.directions || [], function(g, f) {
            d.route({
                origin: f.from,
                destination: f.to,
                travelMode: b.TravelMode[f.mode] || b.TravelMode.DRIVING
            }, function(i, h) {
                if (h == b.DirectionsStatus.OK) {
                    new b.DirectionsRenderer({
                        map: e.map,
                        directions: i
                    })
                }
            })
        })
    };
    a.prototype.render = function() {
        var d = this,
            j = d.options.layer || {},
            i = d.options.weather || {},
            g = d.options.panoramio || {},
            k = null,
            f = d.options.adsense || {};
        if (!d.container) {
            return false
        }
        d.map = new b.Map(d.container, c.extend({
            center: new b.LatLng(d.options.lat || 48.1366069, d.options.lng || 11.577085099999977),
            zoom: d.options.zoom || 5,
            mapTypeId: b.MapTypeId.ROADMAP
        }, d.options.map || {}));
        if (d.options.styles && d.options.styles.type) {
            if (d.options.styles.type == -1) {
                try {
                    d.map.setOptions({
                        styles: d.options.styles.custom || []
                    })
                } catch (h) {}
            } else {
                if (a.styles[d.options.styles.type] !== undefined) {
                    d.map.setOptions({
                        styles: a.styles[d.options.styles.type]
                    })
                }
            }
        }
        if (d.options.address) {
            d._getGeocoder().geocode({
                address: d.options.address
            }, function(l, e) {
                if (e == b.GeocoderStatus.OK) {
                    d.map.setCenter(l[0].geometry.location)
                }
            })
        }
        if (d.options.overlays) {
            d._renderOverlays()
        }
        if (d.options.directions) {
            d._renderDirections()
        }
        if (j.traffic) {
            (new b.TrafficLayer()).setMap(d.map)
        }
        if (j.bicycling) {
            (new b.BicyclingLayer()).setMap(d.map)
        }
        if (j.weather) {
            new b.weather.WeatherLayer({
                map: d.map,
                temperatureUnits: b.weather.TemperatureUnit[i.temperatureUnits || "CELSIUS"],
                windSpeedUnits: b.weather.WindSpeedUnit[i.windSpeedUnits || "METERS_PER_SECOND"]
            })
        }
        if (j.cloud) {
            (new b.weather.CloudLayer()).setMap(d.map)
        }
        if (j.panoramio) {
            new b.panoramio.PanoramioLayer({
                map: d.map,
                tag: g.tag || "",
                userId: g.userId || ""
            })
        }
        if (j.adsense && intergeo_options.adsense.publisher_id && c.trim(intergeo_options.adsense.publisher_id) != "") {
            k = new b.adsense.AdUnit(document.createElement("div"), {
                map: d.map,
                visible: true,
                publisherId: intergeo_options.adsense.publisher_id,
                backgroundColor: f.backgroundColor || "",
                borderColor: f.borderColor || "",
                textColor: f.urlColor || "",
                titleColor: f.titleColor || "",
                urlColor: f.textColor || ""
            });
            if (f.position && b.ControlPosition[f.position]) {
                k.setPosition(b.ControlPosition[f.position])
            }
            if (f.format && b.adsense.AdFormat[f.format]) {
                k.setFormat(b.adsense.AdFormat[f.format])
            }
        }
        var containerID = c(this.container).attr("id");
        var __map = window.intergeo_maps_maps || [];
        __map[containerID] = d.map;
        return true
    };
    c(document).ready(function() {
        var d, e, f = window.intergeo_maps || [];
        for (d = 0; d < f.length; d++) {
            e = new a(f[d].container, f[d].options);
            e.render()
        }
    })

})(jQuery, google.maps);