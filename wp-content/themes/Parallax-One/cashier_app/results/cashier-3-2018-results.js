$(function() {
							Highcharts.setOptions( {
									lang: {
										decimalPoint: ",", thousandsSep: " "
									}
								}
							);
							Highcharts.getData=function(table, options) {
								var sliceNames=[];
								$("th", table).each(function(i) {
										if(i>0) {
											sliceNames.push(this.innerHTML)
										}
									}
								);
								options.series=[];
								$("tr", table).each(function(i) {
										var tr=this;
										$("th, td", tr).each(function(j) {
												if(j>0) {
													if(i==0) {
														options.series[j-1]= {
															name: this.innerHTML, data: []
														}
													}
													else {
														if(i==1) {
															options.series[j-1].data.push( {
																	sliced: true, selected: true, name: sliceNames[i-1], y: parseFloat(this.innerHTML)
																}
															)
														}
														else {
															options.series[j-1].data.push( {
																	name: sliceNames[i-1], y: parseFloat(this.innerHTML)
																}
															)
														}
													}
												}
											}
										)
									}
								)
							}
						}

					);
					$(function() {
							Highcharts.setOptions( {
									colors: ["#3bb479", "#4a99e3"]
								}
							);
							var table=document.getElementById("datatable_for_chart1");
							$("#chart1").highcharts( {
									data: {
										table: table
									}
									, chart: {
										type: "column"
									}
									, title: {
										text: table.caption.innerHTML
									}
									, xAxis: {}
									, yAxis: {
										title: {
											text: "CZK"
										}
										, stackLabels: {
											enabled:true, style: {
												fontWeight: "bold", color: (Highcharts.theme&&Highcharts.theme.textColor)||"gray"
											}
											, formatter:function() {
												return Highcharts.numberFormat(this.total, "0")+" CZK"
											}
										}
										, labels: {
											formatter:function() {
												return this.value
											}
										}
									}
									, tooltip: {
										formatter:function() {
											if(this.series.name=="Students") {
												return"Students: "+Highcharts.numberFormat(this.y, "2f")+" CZK<br/>"+"<b>All: "+Highcharts.numberFormat(this.point.stackTotal, "2f")+" CZK</b>"
											}
											else {
												return"Non-Students: "+Highcharts.numberFormat(this.y, "2f")+" CZK<br/>"+"<b>All: "+Highcharts.numberFormat(this.point.stackTotal, "2f")+" CZK</b>"
											}
										}
									}
									, plotOptions: {
										column: {
											stacking:"normal", dataLabels: {
												enabled:true, color:(Highcharts.theme&&Highcharts.theme.dataLabelsColor)||"white", style: {
													textShadow: "0 0 3px black, 0 0 3px black"
												}
												, formatter:function() {
													return Highcharts.numberFormat(this.point.y, "0")+" CZK"
												}
											}
										}
									}
									, series:[ {
										pointWidth: 50
									}
										, {
											pointWidth: 50
										}
									]
								}
							)

						Highcharts.setOptions( {
								colors: ["#4a99e3", "#3bb479", "#434348", "#f9913d", "#7b62b5", "#db4646", "#abb479"]
							}
						);
						var table=document.getElementById("datatable_for_chart2");
						$("#chart2").highcharts( {
								data: {
									table: table
								}
								, chart: {
									type: "column"
								}
								, title: {
									text: table.caption.innerHTML
								}
								, xAxis: {}
								, yAxis: {
									title: {
										text: "Attended"
									}
									, stackLabels: {
										enabled:true, style: {
											fontWeight: "bold", color: (Highcharts.theme&&Highcharts.theme.textColor)||"gray"
										}
										, formatter:function() {
											return Highcharts.numberFormat(this.total, "0")
										}
									}
									, labels: {
										formatter:function() {
											return this.value
										}
									}
								}
								, tooltip: {
									formatter:function() {
										return "<b>Week "+(this.x + 1)+"</b><br/>"+"<b>"+this.series.name+": "+Highcharts.numberFormat(this.y, "2f")+"</b>"
									}
								}
								, plotOptions: {
									column: {
										stacking:"normal", dataLabels: {
											enabled:true, color:(Highcharts.theme&&Highcharts.theme.dataLabelsColor)||"white", style: {
												textShadow: "0 0 3px black, 0 0 3px black"
											}
											, formatter:function() {
												return ''//Highcharts.numberFormat(this.point.y, "0")
											}
										}
									}
								}
								, series:[ {
										pointWidth: 30
									}
									, {
										pointWidth: 30
									}, {
									pointWidth: 30
								}, {
									pointWidth: 30
								}, {
									pointWidth: 30
								}, {
									pointWidth: 30
								}, {
									pointWidth: 30
								}
								]
							}
						)
						}

					);
					$(function() {
							Highcharts.setOptions( {
									colors: ["#4a99e3", "#3bb479", "#434348", "#f9913d", "#7b62b5", "#db4646"]
								}
							);
						}

					);
