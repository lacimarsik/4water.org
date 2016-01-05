(function($){
	$(document).ready(function(){
		
		/*
		--------------------
		General js
		--------------------
		*/
		
		var adminID="#"+_adminParams.id,
			totalInstances=$("#"+_adminParams.db_prefix+"total_instances"),
			resetField=$("#"+_adminParams.db_prefix+"reset"),
			shortcodePrefix=_adminParams.sc_prefix,
			instanceTitle="Instance title";
		
		if(repeatables){
			$(".form-table").wrapAll("<div class='repeatable-group meta-box-sortables' />").each(function(index){
				$(this).wrap("<div class='repeatable postbox' />").wrap("<div class='inside' />").parent().parent().prepend("<div class='handlediv' title='"+toggle_instance_title+"'><br /></div><h3 class='handle'><span>"+instanceTitle+"</span></h3>").children(".inside").prepend("<p class='repeatable-info'></p>").append("<p class='repeatable-tools'><a class='button button-small repeatable-remove' href='#'>Remove</a></p>");
			});
			
			setRemovable();
			setTitle();
			
			if(shortcodes){
				$(".repeatable-info").append("<span class='shortcode-info' />");
				
				setShortcode();
			}
			
			$(".js .wrap form").css({"opacity":1});
			
			$(".repeatable-add").click(function(e){
				e.preventDefault();
				var repeatable=loc=$(adminID+" .repeatable:last"),cloned;
				if(repeatable.length>0){
					cloned=repeatable.clone(true);
					var clonedRadio=cloned.find("input:radio"),
						clonedRadioName=clonedRadio.attr("name");
					clonedRadio.attr("name",clonedRadioName+"-cloned");
					cloned.insertAfter(loc);
					totalInstances.val(parseInt(totalInstances.val())+1);
					setRepeatable();
				}else{
					cloned="WTF!? All is empty...";
					loc=$(".repeatable-group");
					loc.append(cloned);
				}
			});
			
			$(".repeatable-group").sortable({  
				opacity:0.6,
				revert:true,
				cursor:"move",
				handle:".handle",
				placeholder:"sortable-placeholder",
				forcePlaceholderSize:true,
				update: function(event,ui){
					setRepeatable();
				}
			});  
			
			$("body").delegate(".repeatable-group","click",function(){
				$(this).sortable("refresh");  
			}).delegate(".repeatable-remove","click",function(e){
				e.preventDefault();
				if(!$(this).hasClass("remove-disabled")){
					$(this).parent().parent().parent(".repeatable").remove();
					totalInstances.val(parseInt(totalInstances.val())-1);
					setRepeatable();
				}
			}).delegate(".handlediv","click",function(e){
				e.preventDefault();
				var $this=$(this);
				$this.parent().toggleClass("closed");
			});
		}else{
			if(shortcodes){
				$(".plugin-footer").prepend("<p><span class='shortcode-info' /></p>");
				
				setShortcode();
			}
		}
		
		$(".reset-to-default").click(function(e){
			e.preventDefault();
			resetField.val("true");
			$("#submit").attr({"id":"none","name":"none"});
			$(adminID).submit();
		});
		
		function setRepeatable(){
			$(".repeatable").each(function(){
				var $this=$(this),
					i=$this.index();
				$this.find("label,input,select,textarea").each(function(){
					var field=$(this);
					if(field[0].nodeName.toLowerCase()==="label"){
						if(!!field.attr("for")){
							var upd=changeAttr(field.attr("for"),i);
							field.attr({"for":upd});
						}
					}else{
						var upd=changeAttr(field.attr("name"),i).replace("-cloned","");
						field.attr({"name":upd});
						if(!!field.attr("id")){
							field.attr({"id":upd});
						}
					}
				});	
			});
			setRemovable();
			setTitle();
			setShortcode();
		}
		
		function changeAttr(attr,i){
			var n=attr.match(/\d+\.?\d*/g),
				o=attr.replace("_"+n[0]+"_","_"+i+"_");
			return o;
		}
		
		function setRemovable(){
			$(".repeatable").find(".repeatable-remove").removeClass("remove-disabled");
			if(totalInstances.val()<2){
				$(".repeatable").find(".repeatable-remove").addClass("remove-disabled");
			}
		}
		
		function setTitle(){
			$(".repeatable").each(function(){
				var $this=$(this),
					i=$this.index();
				$this.find("h3 span").each(function(){
					$(this).text(instanceTitle+" "+(i+1));
				});	
			});
		}
		
		function setShortcode(){
			if(repeatables){
				$(".repeatable").each(function(){
					var $this=$(this),
						i=$this.index();
					$this.find(".repeatable-info .shortcode-info").each(function(){
						$(this).html("Shortcode: <span class='code'><code>["+shortcodePrefix+(i+1)+"] your content here [/"+shortcodePrefix+(i+1)+"]</code></span>");
					});	
				});
			}else{
				$(".shortcode-info").html("Shortcode: <span class='code'><code>["+shortcodePrefix+"] your content here [/"+shortcodePrefix+"]</code></span>");
			}
		}
		
		/*
		--------------------
		Plugin specific js --edit--
		--------------------
		*/
		
		$(".mPS2id-open-help").click(function(e){
			e.preventDefault();
			openHelp();
		});
		
		$(".mPS2id-open-help-overview").click(function(e){
			e.preventDefault();
			openHelp("overview");
		});
		
		$(".mPS2id-open-help-get-started").click(function(e){
			e.preventDefault();
			openHelp("get-started");
		});
		
		$(".mPS2id-open-help-plugin-settings").click(function(e){
			e.preventDefault();
			openHelp("plugin-settings");
		});
		
		$(".mPS2id-open-help-shortcodes").click(function(e){
			e.preventDefault();
			openHelp("shortcodes");
		});
		
		function openHelp(tab){
			if(parseFloat(wpVersion)>=3.6){ //WP Contextual Help
				if(tab){
					$("a[href='#tab-panel-page-scroll-to-id"+tab+"']").trigger("click");
				}else{
					if(!$("#contextual-help-wrap").is(":visible")){
						setTimeout(function(){ $("#contextual-help-link").trigger("click"); },60);
					}
				}
			}else{
				if(tab){
					$(".oldwp-plugin-help-section-active:not(.oldwp-plugin-help-section-"+tab+")").removeClass("oldwp-plugin-help-section-active");
					$(".oldwp-plugin-help-section-"+tab).toggleClass("oldwp-plugin-help-section-active");
				}
			}
		}
		
	});
})(jQuery);