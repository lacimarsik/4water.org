(function() {
    var a = window.dialogArguments || opener || parent || top;
    if (intergeo_options.send_to_editor && a.send_to_editor) {
        a.send_to_editor(intergeo_options.send_to_editor)
    }
})();
(function(a, b) {
    if (typeof define == "function") {
        define(b)
    } else {
        if (typeof module != "undefined") {
            module.exports = b()
        } else {
            this[a] = b()
        }
    }
})("klass", function() {
    var c = this,
        d = c.klass,
        h = "function",
        k = /xyz/.test(function() {
            xyz
        }) ? /\bsupr\b/ : /.*/,
        e = "prototype";

    function i(f) {
        return j.call(g(f) ? f : function() {}, f, 1)
    }

    function g(f) {
        return typeof f === h
    }

    function b(l, m, f) {
        return function() {
            var o = this.supr;
            this.supr = f[e][l];
            var p = {}.fabricatedUndefined;
            var n = p;
            try {
                n = m.apply(this, arguments)
            } finally {
                this.supr = o
            }
            return n
        }
    }

    function a(m, n, f) {
        for (var l in n) {
            if (n.hasOwnProperty(l)) {
                m[l] = g(n[l]) && g(f[e][l]) && k.test(n[l]) ? b(l, n[l], f) : n[l]
            }
        }
    }

    function j(m, p) {
        function t() {}
        t[e] = this[e];
        var q = this,
            s = new t(),
            n = g(m),
            f = n ? m : this,
            l = n ? {} : m;

        function r() {
            if (this.initialize) {
                this.initialize.apply(this, arguments)
            } else {
                p || n && q.apply(this, arguments);
                f.apply(this, arguments)
            }
        }
        r.methods = function(u) {
            a(s, u, q);
            r[e] = s;
            return this
        };
        r.methods.call(r, l).prototype.constructor = r;
        r.extend = arguments.callee;
        r[e].implement = r.statics = function(v, u) {
            v = typeof v == "string" ? (function() {
                var o = {};
                o[v] = u;
                return o
            }()) : v;
            a(this, v, q);
            return this
        };
        return r
    }
    i.noConflict = function() {
        c.klass = d;
        return this
    };
    c.klass = i;
    return i
});
if (!window.intergeo) {
    window.intergeo = {
        maps: {}
    }
}
if (!window.intergeo.maps) {
    window.intergeo.maps = {}
}(function(c, b, a) {
    a.Overlay = klass({
        initialize: function(h, f, g, d, i) {
            var e = this;
            e.map = h;
            e.overlay = f;
            e.html = g;
            e.position = d;
            e.array = i;
            e.timeout = null;
            e.bindRemoveEvent(i)
        },
        bindRemoveEvent: function(e) {
            var d = this;
            d.html.find(".intergeo_tlbr_actn_delete").click(function() {
                if (showNotice.warn()) {
                    d.overlay.setMap(null);
                    d.map[e][d.position] = null;
                    d.html.remove()
                }
            })
        }
    });
    a.Marker = a.Overlay.extend({
        initialize: function(i, f, g, d) {
            var e = this,
                h = new b.InfoWindow();
            e.supr(i, f, g, d, "markers");
            g.hover(function() {
                if (i.markers[d]) {
                    f.setAnimation(b.Animation.BOUNCE)
                }
            }, function() {
                if (i.markers[d]) {
                    f.setAnimation(null)
                }
            });
            e.html.find(".intergeo_tlbr_actn_edit").click(function() {
                var j = c("#intergeo_marker_ppp");
                j.find(".intergeo_ppp_frm").attr("data-position", d);
                j.find(".intergeo_tlbr_marker_title").val(g.find(".intergeo_tlbr_marker_title").val());
                j.find(".intergeo_tlbr_marker_icon").val(g.find(".intergeo_tlbr_marker_icon").val());
                j.find(".intergeo_tlbr_marker_info").val(g.find(".intergeo_tlbr_marker_info").val());
                j.fadeIn(150)
            });
            b.event.addListener(f, "dragend", function(j) {
                g.find(".intergeo_tlbr_marker_location").val(j.latLng.toUrlValue())
            });
            b.event.addListener(f, "click", function() {
                var j = c.trim(g.find(".intergeo_tlbr_marker_info").val());
                if (j.length) {
                    if (i.infowindow) {
                        i.infowindow.close()
                    }
                    h.setContent(j);
                    h.open(i.map, f);
                    i.infowindow = h
                }
            })
        },
        update: function(g) {
            var d = this,
                e = {},
                i = c.trim(g.find(".intergeo_tlbr_marker_title").val()),
                f = c.trim(g.find(".intergeo_tlbr_marker_icon").val()),
                h = c.trim(g.find(".intergeo_tlbr_marker_info").val()),
                j = d.html.find(".intergeo_tlbr_marker_title_td");
            e.title = i;
            if (/^([a-z]([a-z]|\d|\+|-|\.)*):(\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?((\[(|(v[\da-f]{1,}\.(([a-z]|\d|-|\.|_|~)|[!\$&'\(\)\*\+,;=]|:)+))\])|((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=])*)(:\d*)?)(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*|(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)|((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)|((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)){0})(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(f)) {
                e.icon = f
            } else {
                e.icon = null
            }
            d.html.find(".intergeo_tlbr_marker_title").val(i);
            d.html.find(".intergeo_tlbr_marker_icon").val(f);
            d.html.find(".intergeo_tlbr_marker_info").val(h);
            d.overlay.setOptions(e);
            if (i != "") {
                j.text(i)
            } else {
                j.text("#" + (d.position + 1) + " " + intergeo_options.l10n.marker)
            }
        }
    });
    a.PolyOverlay = a.Overlay.extend({
        initialize: function(h, f, g, d, i) {
            var e = this;
            e.supr(h, f, g, d, i);
            e.html.find(".intergeo_tlbr_actn_edit").click(function() {
                e.edit();
                return false
            })
        },
        pathToString: function() {
            var d = [];
            this.overlay.getPath().forEach(function(e) {
                d.push(e.toUrlValue())
            });
            return d.join(";")
        },
        bindChangeEvent: function(e) {
            var d = this;
            b.event.addListener(d.overlay, e, function() {
                d.html.find(".intergeo_tlbr_" + d.array + "_path").val(d.pathToString())
            })
        },
        edit: function() {
            var d = this,
                e = c("#intergeo_polyoverlay_ppp"),
                g = c.trim(d.html.find(".intergeo_tlbr_" + d.array + "_fill_color").val()),
                f = c.trim(d.html.find(".intergeo_tlbr_" + d.array + "_stroke_color").val());
            e.find(".intergeo_ppp_frm").attr("data-position", d.position).attr("data-target", d.array);
            if (!g) {
                g = "#000000"
            }
            e.find(".intergeo_tlbr_polyoverlay_fill_color").val(g).wpColorPicker("color", g);
            e.find(".intergeo_tlbr_polyoverlay_fill_opacity").val(d.html.find(".intergeo_tlbr_" + d.array + "_fill_opacity").val());
            if (!f) {
                f = "#000000"
            }
            e.find(".intergeo_tlbr_polyoverlay_stroke_color").val(f).wpColorPicker("color", f);
            e.find(".intergeo_tlbr_polyoverlay_weight").val(d.html.find(".intergeo_tlbr_" + d.array + "_weight").val());
            e.find(".intergeo_tlbr_polyoverlay_stroke_opacity").val(d.html.find(".intergeo_tlbr_" + d.array + "_stroke_opacity").val());
            e.find(".intergeo_tlbr_polyoverlay_position").val(d.html.find(".intergeo_tlbr_" + d.array + "_position").val());
            e.fadeIn(150)
        },
        update: function(e) {
            var n = this,
                o = {},
                k = e.find(".intergeo_tlbr_polyoverlay_position").val(),
                j = parseInt(e.find(".intergeo_tlbr_polyoverlay_weight").val()),
                i = !isNaN(j) && 0 <= j,
                f = parseFloat(e.find(".intergeo_tlbr_polyoverlay_stroke_opacity").val()),
                d = !isNaN(f) && 0 <= f && f <= 1,
                h = c.trim(e.find(".intergeo_tlbr_polyoverlay_stroke_color").val()),
                g = parseFloat(e.find(".intergeo_tlbr_polyoverlay_fill_opacity").val()),
                l = !isNaN(g) && 0 <= g && g <= 1,
                m = c.trim(e.find(".intergeo_tlbr_polyoverlay_fill_color").val());
            o.strokePosition = b.StrokePosition[k] || b.StrokePosition.CENTER;
            o.strokeWeight = i ? j : 3;
            o.strokeOpacity = d ? f : 1;
            o.strokeColor = h;
            o.fillOpacity = l ? g : 0.3;
            o.fillColor = m;
            n.html.find(".intergeo_tlbr_" + n.array + "_position").val(k);
            n.html.find(".intergeo_tlbr_" + n.array + "_weight").val(i ? j : "");
            n.html.find(".intergeo_tlbr_" + n.array + "_stroke_opacity").val(d ? f : "");
            n.html.find(".intergeo_tlbr_" + n.array + "_stroke_color").val(h);
            n.html.find(".intergeo_tlbr_" + n.array + "_fill_opacity").val(l ? g : "");
            n.html.find(".intergeo_tlbr_" + n.array + "_fill_color").val(m);
            n.html.find(".intergeo_tlbr_clr_prvw:last").css("background-color", h).fadeTo(0, d ? f : 1);
            n.html.find(".intergeo_tlbr_clr_prvw:first").css("background-color", m).fadeTo(0, l ? g : 0.3);
            n.overlay.setOptions(o)
        }
    });
    a.PolyOverlay.stringToPath = function(e, d) {
        var f = [];
        c.each(e.find(d).val().split(";"), function(h, i) {
            var g = i.split(",");
            if (g.length == 2) {
                f.push(new b.LatLng(g[0], g[1]))
            }
        });
        return f
    };
    a.PolyOverlay.stringToBounds = function(e, d) {
        var f = a.PolyOverlay.stringToPath(e, d);
        return new b.LatLngBounds(f[0], f[1])
    };
    a.Polyline = a.PolyOverlay.extend({
        initialize: function(g, e, f, d) {
            this.supr(g, e, f, d, "polyline");
            this.bindChangeEvent("mouseup")
        },
        edit: function() {
            var e = this,
                f = c("#intergeo_polyline_ppp"),
                d = c.trim(e.html.find(".intergeo_tlbr_polyline_color").val());
            f.find(".intergeo_ppp_frm").attr("data-position", e.position).attr("data-target", "polyline");
            f.find(".intergeo_tlbr_polyline_weight").val(e.html.find(".intergeo_tlbr_polyline_weight").val());
            f.find(".intergeo_tlbr_polyline_opacity").val(e.html.find(".intergeo_tlbr_polyline_opacity").val());
            if (!d) {
                d = "#000000"
            }
            f.find(".intergeo_tlbr_polyline_color").val(d).wpColorPicker("color", d);
            f.fadeIn(150)
        },
        update: function(i) {
            var e = this,
                g = {},
                j = parseInt(i.find(".intergeo_tlbr_polyline_weight").val()),
                k = !isNaN(j) && 0 <= j,
                f = parseFloat(i.find(".intergeo_tlbr_polyline_opacity").val()),
                h = !isNaN(f) && 0 <= f && f <= 1,
                d = c.trim(i.find(".intergeo_tlbr_polyline_color").val());
            g.strokeOpacity = h ? f : 1;
            g.strokeWeight = k ? j : 3;
            g.strokeColor = d;
            e.html.find(".intergeo_tlbr_polyline_weight").val(k ? j : "");
            e.html.find(".intergeo_tlbr_polyline_opacity").val(h ? f : "");
            e.html.find(".intergeo_tlbr_polyline_color").val(d);
            e.html.find(".intergeo_tlbr_clr_prvw").css("background-color", d).fadeTo(0, h ? f : 1);
            e.overlay.setOptions(g)
        }
    });
    a.Polygon = a.PolyOverlay.extend({
        initialize: function(g, e, f, d) {
            this.supr(g, e, f, d, "polygon");
            this.bindChangeEvent("mouseup")
        }
    });
    a.Rectangle = a.PolyOverlay.extend({
        initialize: function(g, e, f, d) {
            this.supr(g, e, f, d, "rectangle");
            this.bindChangeEvent("bounds_changed")
        },
        pathToString: function() {
            var d = this.overlay.getBounds();
            return [d.getSouthWest().toUrlValue(), d.getNorthEast().toUrlValue()].join(";")
        }
    });
    a.Circle = a.PolyOverlay.extend({
        initialize: function(g, e, f, d) {
            this.supr(g, e, f, d, "circle");
            this.bindChangeEvent("center_changed");
            this.bindChangeEvent("radius_changed")
        },
        pathToString: function() {
            var d = this.overlay;
            return d.getCenter().toUrlValue() + ";" + d.getRadius() + ",0"
        }
    });
    a.Direction = a.PolyOverlay.extend({
        initialize: function(g, e, f, d) {
            this.supr(g, e, f, d, "direction")
        },
        edit: function() {
            var d = this,
                e = c("#intergeo_drctn_ppp");
            e.find(".intergeo_ppp_frm").attr("data-position", d.position).attr("data-target", d.array);
            e.find("#intergeo_ppp_drctn_from").val(d.html.find(".intergeo_tlbr_drctn_from").val());
            e.find("#intergeo_ppp_drctn_to").val(d.html.find(".intergeo_tlbr_drctn_to").val());
            e.find("#intergeo_ppp_drctn_mode").val(d.html.find(".intergeo_tlbr_drctn_mode").val());
            e.fadeIn(150)
        },
        update: function(f) {
            var d = this,
                i = f.find("#intergeo_ppp_drctn_from").val(),
                h = f.find("#intergeo_ppp_drctn_to").val(),
                g = f.find("#intergeo_ppp_drctn_mode").val(),
                e = {
                    origin: i,
                    destination: h,
                    travelMode: b.TravelMode[g] || b.TravelMode.DRIVING
                };
            d.map.directions.route(e, function(k, j) {
                if (j == b.DirectionsStatus.OK) {
                    d.overlay.setDirections(k);
                    d.html.find(".intergeo_tlbr_direction_title_td").text(c("#intergeo_tlbr_drctn_ttl_tmpl").text().replaceByHash({
                        "%num%": d.position + 1,
                        "%from%": i,
                        "%to%": h,
                        "%mode%": f.find("#intergeo_ppp_drctn_mode > :selected").text()
                    }))
                } else {
                    alert(intergeo_options.l10n.error.directions)
                }
            });
            d.html.find(".intergeo_tlbr_drctn_from").val(i);
            d.html.find(".intergeo_tlbr_drctn_to").val(h);
            d.html.find(".intergeo_tlbr_drctn_mode").val(g)
        }
    })
})(jQuery, google.maps, intergeo.maps);
(function(d, c, b) {
    var a;
    String.prototype.replaceByHash = function(e) {
        var f = this;
        d.each(e, function(g, h) {
            f = f.split(g).join(h)
        });
        return f
    };
    a = function(e, g) {
        var f = this;
        f.map = new c.Map(document.getElementById(e), g);
        f.drawing = new c.drawing.DrawingManager({
            drawingControl: false,
            map: f.map,
            circleOptions: {
                editable: true
            },
            markerOptions: {
                draggable: true
            },
            polygonOptions: {
                editable: true
            },
            polylineOptions: {
                editable: true
            },
            rectangleOptions: {
                editable: true
            }
        });
        f.directions = new c.DirectionsService();
        f.geocoder = null;
        f.traffic = null;
        f.bicycling = null;
        f.weather = null;
        f.cloud = null;
        f.panoramio = null;
        f.adunit = null;
        f.markers = [];
        f.polyline = [];
        f.polygon = [];
        f.rectangle = [];
        f.circle = [];
        f.direction = [];
        f.infowindow = null;
        c.event.addListener(f.map, "center_changed", function() {
            var h = f.map.getCenter();
            d("#intergeo_map_lat").val(h.lat());
            d("#intergeo_map_lng").val(h.lng())
        });
        c.event.addListener(f.map, "zoom_changed", function() {
            d("#intergeo_map_zoom").val(f.map.getZoom())
        });
        c.event.addListener(f.drawing, "overlaycomplete", function(h) {
            switch (h.type) {
                case c.drawing.OverlayType.MARKER:
                    f._markerComplete(h);
                    break;
                case c.drawing.OverlayType.CIRCLE:
                    f._polyComplete(h, "circle", b.Circle);
                    break;
                case c.drawing.OverlayType.POLYGON:
                    f._polyComplete(h, "polygon", b.Polygon);
                    break;
                case c.drawing.OverlayType.POLYLINE:
                    f._polyComplete(h, "polyline", b.Polyline);
                    break;
                case c.drawing.OverlayType.RECTANGLE:
                    f._polyComplete(h, "rectangle", b.Rectangle);
                    break
            }
        });
        f._initOverlays()
    };
    a.Styles = {
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
    a.prototype = {
        _initOverlays: function() {
            var e = this;
            d(".intergeo_tlbr_marker").each(function(f, i) {
                var h = d(i),
                    g = h.find(".intergeo_tlbr_marker_location").val().split(",");
                e.markers.push(new b.Marker(e, new c.Marker({
                    position: new c.LatLng(parseFloat(g[0]), parseFloat(g[1])),
                    map: e.map,
                    title: h.find(".intergeo_tlbr_marker_title").val(),
                    icon: h.find(".intergeo_tlbr_marker_icon").val(),
                    draggable: true
                }), h, f))
            });
            d(".intergeo_tlbr_polyline").each(function(f, j) {
                var i = d(j),
                    g = d.trim(i.find(".intergeo_tlbr_polyline_color").val()),
                    h = parseFloat(i.find(".intergeo_tlbr_polyline_opacity").val()),
                    k = parseInt(i.find(".intergeo_tlbr_polyline_weight").val());
                e.polyline.push(new b.Polyline(e, new c.Polyline({
                    map: e.map,
                    path: b.PolyOverlay.stringToPath(i, ".intergeo_tlbr_polyline_path"),
                    editable: true,
                    strokeColor: g.length == 0 ? "#000000" : g,
                    strokeOpacity: isNaN(h) ? 1 : h,
                    strokeWeight: isNaN(k) ? 3 : k
                }), i, f))
            });
            d(".intergeo_tlbr_polygon").each(function(f, i) {
                var h = d(i),
                    l = d.trim(h.find(".intergeo_tlbr_polygon_fill_color").val()),
                    g = parseFloat(h.find(".intergeo_tlbr_polygon_fill_opacity").val()),
                    k = d.trim(h.find(".intergeo_tlbr_polygon_stroke_color").val()),
                    m = parseFloat(h.find(".intergeo_tlbr_polygon_stroke_opacity").val()),
                    f = d.trim(h.find(".intergeo_tlbr_plygon_position").val()),
                    j = parseInt(h.find(".intergeo_tlbr_polygon_weight").val());
                e.polygon.push(new b.Polygon(e, new c.Polygon({
                    map: e.map,
                    path: b.PolyOverlay.stringToPath(h, ".intergeo_tlbr_polygon_path"),
                    editable: true,
                    fillColor: l.length == 0 ? "#000000" : l,
                    fillOpacity: isNaN(g) ? 0.3 : g,
                    strokeColor: k.length == 0 ? "#000000" : k,
                    strokeOpacity: isNaN(m) ? 1 : m,
                    strokePosition: c.StrokePosition[f] || c.StrokePosition.CENTER,
                    strokeWeight: isNaN(j) ? 3 : j
                }), h, f))
            });
            d(".intergeo_tlbr_rectangle").each(function(f, i) {
                var h = d(i),
                    l = d.trim(h.find(".intergeo_tlbr_rectangle_fill_color").val()),
                    g = parseFloat(h.find(".intergeo_tlbr_rectangle_fill_opacity").val()),
                    k = d.trim(h.find(".intergeo_tlbr_rectangle_stroke_color").val()),
                    m = parseFloat(h.find(".intergeo_tlbr_rectangle_stroke_opacity").val()),
                    f = d.trim(h.find(".intergeo_tlbr_rectangle_position").val()),
                    j = parseInt(h.find(".intergeo_tlbr_rectangle_weight").val());
                e.rectangle.push(new b.Rectangle(e, new c.Rectangle({
                    map: e.map,
                    bounds: b.PolyOverlay.stringToBounds(h, ".intergeo_tlbr_rectangle_path"),
                    editable: true,
                    fillColor: l.length == 0 ? "#000000" : l,
                    fillOpacity: isNaN(g) ? 0.3 : g,
                    strokeColor: k.length == 0 ? "#000000" : k,
                    strokeOpacity: isNaN(m) ? 1 : m,
                    strokePosition: c.StrokePosition[f] || c.StrokePosition.CENTER,
                    strokeWeight: isNaN(j) ? 3 : j
                }), h, f))
            });
            d(".intergeo_tlbr_circle").each(function(m, j) {
                var l = d(j),
                    p = d.trim(l.find(".intergeo_tlbr_circle_fill_color").val()),
                    i = parseFloat(l.find(".intergeo_tlbr_circle_fill_opacity").val()),
                    h = d.trim(l.find(".intergeo_tlbr_circle_stroke_color").val()),
                    g = parseFloat(l.find(".intergeo_tlbr_circle_stroke_opacity").val()),
                    o = d.trim(l.find(".intergeo_tlbr_circle_position").val()),
                    k = parseInt(l.find(".intergeo_tlbr_circle_weight").val()),
                    q = d.trim(l.find(".intergeo_tlbr_circle_path").val()).split(";"),
                    f = q[0].split(","),
                    n = q[1].split(",");
                e.circle.push(new b.Circle(e, new c.Circle({
                    map: e.map,
                    center: new c.LatLng(f[0], f[1]),
                    radius: parseFloat(n[0]),
                    editable: true,
                    fillColor: p.length == 0 ? "#000000" : p,
                    fillOpacity: isNaN(i) ? 0.3 : i,
                    strokeColor: h.length == 0 ? "#000000" : h,
                    strokeOpacity: isNaN(g) ? 1 : g,
                    strokePosition: c.StrokePosition[o] || c.StrokePosition.CENTER,
                    strokeWeight: isNaN(k) ? 3 : k
                }), l, m))
            });
            d(".intergeo_tlbr_drctn").each(function(f, h) {
                var g = d(h),
                    l = d.trim(g.find(".intergeo_tlbr_drctn_from").val()),
                    k = d.trim(g.find(".intergeo_tlbr_drctn_to").val()),
                    j = d.trim(g.find(".intergeo_tlbr_drctn_mode").val()),
                    i = {
                        origin: l,
                        destination: k,
                        travelMode: c.TravelMode[j] || c.TravelMode.DRIVING
                    };
                e.directions.route(i, function(n, m) {
                    if (m == c.DirectionsStatus.OK) {
                        var o = new b.Direction(e, new c.DirectionsRenderer({
                            map: e.map,
                            directions: n
                        }), g, f);
                        e.direction.push(o)
                    } else {
                        g.remove();
                        e.direction.push(null)
                    }
                })
            })
        },
        _markerComplete: function(i) {
            var g = this,
                e = g.markers.length,
                h = d(d("#intergeo_tlbr_marker_tmpl").html().replaceByHash({
                    "%pos%": e,
                    "%num%": e + 1
                })),
                f = new b.Marker(g, i.overlay, h, e);
            h.find(".intergeo_tlbr_marker_location").val(i.overlay.getPosition().toUrlValue());
            d("#intergeo_tlbr_markers").append(h);
            g.markers.push(f);
            i.overlay.setDraggable(true)
        },
        _polyComplete: function(j, i, h) {
            var f = this,
                e = f[i].length,
                g = d(d("#intergeo_tlbr_" + i + "_tmpl").html().replaceByHash({
                    "%pos%": e,
                    "%num%": e + 1
                })),
                k = new h(f, j.overlay, g, e);
            f[i].push(k);
            g.find(".intergeo_tlbr_" + i + "_path").val(k.pathToString());
            d("#intergeo_tlbr_" + i + "s").append(g)
        },
        _normalize: function(h) {
            var g = function(j) {
                    return j === "1"
                },
                f = function(j, k, l) {
                    return k[j] || l
                },
                e = function(j) {
                    return f(j, c.ControlPosition, 0)
                },
                i = {
                    minZoom: parseInt,
                    maxZoom: parseInt,
                    scrollwheel: g,
                    draggable: g,
                    mapTypeId: function(j) {
                        return c.MapTypeId[j] || c.MapTypeId.ROADMAP
                    },
                    mapTypeControl: g,
                    mapTypeControlOptions: {
                        position: e,
                        mapTypeIds: function(j) {
                            var k = [];
                            d.each(j, function(l, m) {
                                if (c.MapTypeId[m] !== undefined) {
                                    k.push(c.MapTypeId[m])
                                }
                            });
                            return k
                        },
                        style: function(j) {
                            return f(j, c.MapTypeControlStyle, c.MapTypeControlStyle.DEFAULT)
                        }
                    },
                    overviewMapControl: g,
                    overviewMapControlOptions: {
                        opened: g
                    },
                    panControl: g,
                    panControlOptions: {
                        position: e
                    },
                    rotateControl: g,
                    rotateControlOptions: {
                        position: e
                    },
                    scaleControl: g,
                    scaleControlOptions: {
                        position: e
                    },
                    streetViewControl: g,
                    streetViewControlOptions: {
                        position: e
                    },
                    zoomControl: g,
                    zoomControlOptions: {
                        position: e,
                        style: function(j) {
                            return f(j, c.ZoomControlStyle, c.ZoomControlStyle.DEFAULT)
                        }
                    }
                };
            return d.each(h, function(j, k) {
                if (i[j] === undefined) {
                    delete h[j]
                } else {
                    if (typeof k === "string") {
                        h[j] = i[j](k)
                    } else {
                        d.each(k, function(m, l) {
                            if (i[j][m] === undefined) {
                                delete h[j][m]
                            } else {
                                h[j][m] = i[j][m](l)
                            }
                        })
                    }
                }
            })
        },
        _traffic: function(f) {
            var e = this;
            if (f.layer.traffic == 1) {
                if (!e.traffic) {
                    e.traffic = new c.TrafficLayer()
                }
                e.traffic.setMap(e.map)
            } else {
                if (e.traffic) {
                    e.traffic.setMap(null)
                }
            }
        },
        _bicycling: function(f) {
            var e = this;
            if (f.layer.bicycling == 1) {
                if (!e.bicycling) {
                    e.bicycling = new c.BicyclingLayer()
                }
                e.bicycling.setMap(e.map)
            } else {
                if (e.bicycling) {
                    e.bicycling.setMap(null)
                }
            }
        },
        _weather: function(f) {
            var e = this;
            if (f.layer.weather == 1) {
                if (!e.weather) {
                    e.weather = new c.weather.WeatherLayer({})
                }
                e.weather.setMap(e.map);
                e.weather.setOptions({
                    temperatureUnits: c.weather.TemperatureUnit[f.weather.temperatureUnits] || c.weather.TemperatureUnit.CELSIUS,
                    windSpeedUnits: c.weather.WindSpeedUnit[f.weather.windSpeedUnits] || c.weather.WindSpeedUnit.METERS_PER_SECOND
                })
            } else {
                if (e.weather) {
                    e.weather.setMap(null)
                }
            }
        },
        _cloud: function(f) {
            var e = this;
            if (f.layer.cloud == 1) {
                if (!e.cloud) {
                    e.cloud = new c.weather.CloudLayer()
                }
                e.cloud.setMap(e.map)
            } else {
                if (e.cloud) {
                    e.cloud.setMap(null)
                }
            }
        },
        _panoramio: function(f) {
            var e = this;
            if (f.layer.panoramio == 1) {
                if (!e.panoramio) {
                    e.panoramio = new c.panoramio.PanoramioLayer({})
                }
                e.panoramio.setMap(e.map);
                e.panoramio.setTag(f.panoramio.tag);
                e.panoramio.setUserId(f.panoramio.userId)
            } else {
                if (e.panoramio) {
                    e.panoramio.setMap(null)
                }
            }
        },
        _adsense: function(f) {
            var e = this;
            if (f.layer.adsense == 1 && intergeo_options.adsense.publisher_id && d.trim(intergeo_options.adsense.publisher_id) != "") {
                if (!e.adunit) {
                    e.adunit = new c.adsense.AdUnit(document.createElement("div"), {
                        visible: true,
                        publisherId: intergeo_options.adsense.publisher_id
                    })
                }
                e.adunit.setMap(this.map);
                e.adunit.setBackgroundColor(f.adsense.backgroundColor);
                e.adunit.setBorderColor(f.adsense.borderColor);
                e.adunit.setUrlColor(f.adsense.urlColor);
                e.adunit.setTitleColor(f.adsense.titleColor);
                e.adunit.setTextColor(f.adsense.textColor);
                if (c.ControlPosition[f.adsense.position] !== undefined) {
                    e.adunit.setPosition(c.ControlPosition[f.adsense.position])
                }
                if (c.adsense.AdFormat[f.adsense.format]) {
                    e.adunit.setFormat(c.adsense.AdFormat[f.adsense.format])
                }
            } else {
                if (e.adunit) {
                    e.adunit.setMap(null)
                }
            }
        },
        _pro: function(f){
            var e = this;
            if(window._proFeatures){
                _proFeatures(f, e);
            }
        },
        createDirection: function() {
            var f = this,
                e = d("#intergeo_drctn_ppp"),
                g = e.find(".intergeo_ppp_frm");
            g.bind("submit.firsttime", function() {
                var h, i, j, l, k;
                if (g.attr("data-position") != "") {
                    return false
                }
                h = f.direction.length;
                l = d.trim(g.find("#intergeo_ppp_drctn_from").val());
                k = d.trim(g.find("#intergeo_ppp_drctn_to").val());
                if (l == "" || k == "") {
                    return false
                }
                j = d(d("#intergeo_tlbr_drctn_tmpl").html().replaceByHash({
                    "%pos%": h,
                    "%num%": h + 1,
                    "%from%": l,
                    "%to%": k,
                    "%mode%": d.trim(g.find("#intergeo_ppp_drctn_mode option:selected").text())
                }));
                i = new b.Direction(f, new c.DirectionsRenderer({
                    map: f.map
                }), j, h);
                d("#intergeo_tlbr_drctns").append(j);
                f.direction.push(i);
                i.update(g);
                g.unbind("submit.firsttime");
                return false
            });
            g.find('select,input[type!="submit"]').val("");
            g.attr("data-position", "");
            e.fadeIn(150)
        },
        updateOverlays: function() {
            var e = this;
            d.each(e.polyline, function(g, f) {
                if (f) {
                    d('.intergeo_tlbr_polyline_path[data-position="' + g + '"]').val(f.pathToString())
                }
            });
            d.each(e.polygon, function(g, f) {
                if (f) {
                    d('.intergeo_tlbr_polygon_path[data-position="' + g + '"]').val(f.pathToString())
                }
            })
        },
        preview: function() {
            var f = this,
                g = {};
            d.each(d("#intergeo_frm").serializeArray(), function() {
                var l = /\[\]$/,
                    m = g,
                    j = this.name.replace(l, "").split("_"),
                    e = j.pop(),
                    k = this.value || "",
                    i = l.test(this.name);
                d.each(j, function(n, o) {
                    if (m[o] === undefined) {
                        m[o] = {}
                    }
                    m = m[o]
                });
                if (m[e] !== undefined) {
                    if (i) {
                        m[e].push(k)
                    } else {
                        m[e] = k
                    }
                } else {
                    m[e] = i ? [k] : k
                }
            });
            f._normalize(g.map);
            if (d("#intergeo_map_lock_preview").is(":checked")) {
                g.map.draggable = false;
                g.map.scrollwheel = false
            }
            f.map.setOptions(g.map);
            if (g.styles && g.styles.type) {
                if (g.styles.type == -1) {
                    try {
                        f.map.setOptions({
                            styles: d.parseJSON(g.styles.custom || "[]")
                        })
                    } catch (h) {
                        alert(intergeo_options.l10n.error.style)
                    }
                } else {
                    if (a.Styles[g.styles.type] !== undefined) {
                        f.map.setOptions({
                            styles: a.Styles[g.styles.type]
                        })
                    }
                }
            }
            f._traffic(g);
            f._bicycling(g);
            f._weather(g);
            f._cloud(g);
            f._panoramio(g);
            f._adsense(g);
            f._pro(g);
        }
    };
    d(document).ready(function() {
        var g, f, e;
        f = new a("intergeo_canvas", {
            center: new c.LatLng(parseFloat(d("#intergeo_map_lat").val()), parseFloat(d("#intergeo_map_lng").val())),
            zoom: parseInt(d("#intergeo_map_zoom").val()),
            minZoom: 0,
            maxZoom: 19,
            mapTypeId: c.MapTypeId.ROADMAP
        });
        var xxxx = window.dialogArguments || opener || parent || top;
        xxxx.intergeo_maps_current = f;
        e = d("#intergeo_frm");
        e.find("input[name], select[name], textarea[name]").not("input[type='file']").change(function() {
            f.preview()
        });
        e.find(".intergeo_tlbr_cntrl_onkeyup").keyup(function() {
            f.preview()
        });
        e.submit(function() {
            f.updateOverlays();
            return true
        });
        f.preview();
        d("#intergeo_map_lock_preview").change(function() {
            var h = d(this).is(":checked");
            f.map.setOptions({
                draggable: !h,
                scrollwheel: !h
            })
        });
        d(".intergeo_tlbr_ul_li_h3").click(function() {
            var h = d(this).parent();
            if (h.hasClass("open")) {
                h.removeClass("open")
            } else {
                d(".intergeo_tlbr_ul_li.open").removeClass("open");
                h.addClass("open")
            }
        });
        d(".intergeo_tlbr_cntrl_more_info").click(function() {
            d(this).parent().nextAll(".intergeo_tlbr_cntrl_dsc:first").toggle();
            return false
        });
        d(".intergeo_tlbr_cntrl_ttl").click(function() {
            d(this).toggleClass("open").parent().find(".intergeo_tlbr_cntrl_items").toggle();
            return false
        });
        d(".color-picker-hex").wpColorPicker({
            change: function() {
                clearTimeout(g);
                g = setTimeout(function() {
                    f.preview()
                }, 500)
            }
        });
        d(".intergeo_tlbr_clr").wpColorPicker();
        d("#intergeo_show_map_center").change(function() {
            d("#intergeo_canvas_center").toggle();
            d.post(intergeo_options.ajaxurl, {
                action: "intergeo_show_map_center",
                nonce: intergeo_options.nonce || "",
                status: d(this).is(":checked") ? 1 : 0
            })
        });
        d("#intergeo_tlbr_drawing_tools").change(function() {
            f.drawing.setDrawingMode(null);
            f.drawing.setOptions({
                drawingControl: d(this).is(":checked")
            })
        });
        d(".intergeo_ppp_cls").click(function() {
            d(this).parents(".intergeo_ppp").fadeOut(150);
            return false
        });
        d("#intergeo_go_to_address").click(function() {
            d("#intergeo_address_ppp").fadeIn(150);
            return false
        });
        d("#intergeo_address_ppp .intergeo_ppp_frm").submit(function() {
            var h = d(this),
                j = h.find(".intergeo_ppp_txt"),
                i = d.trim(j.val());
            if (i != "") {
                if (!f.geocoder) {
                    f.geocoder = new c.Geocoder()
                }
                f.geocoder.geocode({
                    address: i
                }, function(l, k) {
                    if (k == c.GeocoderStatus.OK) {
                        f.map.setCenter(l[0].geometry.location)
                    }
                })
            }
            j.val("");
            h.parents(".intergeo_ppp").fadeOut(150);
            return false
        });
        d(".intregeo_ppp_frm_overlay").submit(function() {
            var j = d(this),
                h = parseInt(j.attr("data-position")),
                i = j.attr("data-target");
            j.parents(".intergeo_ppp").fadeOut(150);
            if (f[i] && f[i][h]) {
                f[i][h].update(j)
            }
            return false
        });
        d("#intergeo_tlbr_new_drctn").click(function() {
            f.createDirection();
            return false
        })
    })
})(jQuery, google.maps, intergeo.maps);