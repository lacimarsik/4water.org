(function($){
	var _p="mPS2id",
		_o=mPS2id_params,
		shortcodeClass=_o.shortcode_class, //shortcode without suffix 
		_hash=location.hash || null,
		_validateLocHash=function(val,forAll){
			try{ var $val=$(val); }catch(error){ return false; } //avoid js errors on invalid selectors
			return $(val).length && (forAll || $("a[href*='"+val+"']").filter(function(){return $(this).data(_p+"Element")==true}).length);
		},
		_offset=function(val){
			if(val.indexOf(",")!==-1){
				var arr=val.split(","),y=arr[0] || "0",x=arr[1] || "0";
				return {"y":y,"x":x};
			}else{
				return val;
			}
		},
		_screen=function(val){
			if(val.indexOf(",")!==-1){
				var arr=val.split(","),x=arr[0] || "0",y=arr[1] || "0";
				return [x,y];
			}else{
				return val;
			}
		};
	$(document).ready(function(){
		for(var k=0; k<_o.total_instances; k++){
			//scroll to location hash on page load
			if(_o.instances[_p+"_instance_"+k]["scrollToHash"]["value"]==="true" && _hash){
				$(_o.instances[_p+"_instance_"+k]["selector"]["value"]+",."+shortcodeClass).each(function(){
					$(this).data(_p+"Element",true);
				});
				if(_validateLocHash(_hash,_o.instances[_p+"_instance_"+k]["scrollToHashForAll"]["value"]==="true")){
					var href=window.location.href.replace(/#.*$/,"#"),
						layout=_o.instances[_p+"_instance_"+k]["layout"]["value"];
					if(layout!=="horizontal"){
						$(window).scrollTop(0); //stop jump to hash straight away
					}
					if(layout!=="vertical"){
						$(window).scrollLeft(0); //stop jump to hash straight away
					}
					if(window.history && window.history.pushState){
						window.history.pushState("","",href);
					}else{
						window.location.href=href;
					}
				}
			}
		}
	});
	$(window).load(function(){
		for(var i=0; i<_o.total_instances; i++){
			$(_o.instances[_p+"_instance_"+i]["selector"]["value"]+",."+shortcodeClass).mPageScroll2id({
				scrollSpeed:_o.instances[_p+"_instance_"+i]["scrollSpeed"]["value"],
				autoScrollSpeed:(_o.instances[_p+"_instance_"+i]["autoScrollSpeed"]["value"]==="true") ? true : false,
				scrollEasing:_o.instances[_p+"_instance_"+i]["scrollEasing"]["value"],
				scrollingEasing:_o.instances[_p+"_instance_"+i]["scrollingEasing"]["value"],
				pageEndSmoothScroll:(_o.instances[_p+"_instance_"+i]["pageEndSmoothScroll"]["value"]==="true") ? true : false,
				layout:_o.instances[_p+"_instance_"+i]["layout"]["value"],
				offset:_offset(_o.instances[_p+"_instance_"+i]["offset"]["value"].toString()),
				highlightSelector:_o.instances[_p+"_instance_"+i]["highlightSelector"]["value"],
				clickedClass:_o.instances[_p+"_instance_"+i]["clickedClass"]["value"],
				targetClass:_o.instances[_p+"_instance_"+i]["targetClass"]["value"],
				highlightClass:_o.instances[_p+"_instance_"+i]["highlightClass"]["value"],
				forceSingleHighlight:(_o.instances[_p+"_instance_"+i]["forceSingleHighlight"]["value"]==="true") ? true : false,
				keepHighlightUntilNext:(_o.instances[_p+"_instance_"+i]["keepHighlightUntilNext"]["value"]==="true") ? true : false,
				highlightByNextTarget:(_o.instances[_p+"_instance_"+i]["highlightByNextTarget"]["value"]==="true") ? true : false,
				disablePluginBelow:_screen(_o.instances[_p+"_instance_"+i]["disablePluginBelow"]["value"].toString())
			});
			//scroll to location hash on page load
			if(_o.instances[_p+"_instance_"+i]["scrollToHash"]["value"]==="true" && _hash){
				if(_validateLocHash(_hash,_o.instances[_p+"_instance_"+i]["scrollToHashForAll"]["value"]==="true")){
					setTimeout(function(){
						$.mPageScroll2id("scrollTo",_hash);
						if(window.history && window.history.pushState){
							window.history.pushState("","",_hash);
						}else{
							window.location.hash=_hash;
						}
					},_o.instances[_p+"_instance_"+i]["scrollToHashDelay"]["value"]);
				}
			}
		}
	});
	//extend jQuery's selectors
	$.extend($.expr[":"],{
		//position based - e.g. :fixed
		absolute:$.expr[":"].absolute || function(el){return $(el).css("position")==="absolute";},
		relative:$.expr[":"].relative || function(el){return $(el).css("position")==="relative";},
		static:$.expr[":"].static || function(el){return $(el).css("position")==="static";},
		fixed:$.expr[":"].fixed || function(el){return $(el).css("position")==="fixed";},
		//width based - e.g. :width(200), :width(>200), :width(>200):width(<300) etc.
		width:$.expr[":"].width || function(a,i,m){
			var val=m[3].replace("&lt;","<").replace("&gt;",">");
			if(!val){return false;}
			return val.substr(0,1)===">" ? $(a).width()>val.substr(1) : val.substr(0,1)==="<" ? $(a).width()<val.substr(1) : $(a).width()===parseInt(val);
		},
		//height based - e.g. :height(200), :height(>200), :height(>200):height(<300) etc.
		height:$.expr[":"].height || function(a,i,m){
			var val=m[3].replace("&lt;","<").replace("&gt;",">");
			if(!val){return false;}
			return val.substr(0,1)===">" ? $(a).height()>val.substr(1) : val.substr(0,1)==="<" ? $(a).height()<val.substr(1) : $(a).height()===parseInt(val);
		}
	});
})(jQuery);