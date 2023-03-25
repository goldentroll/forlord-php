;(function($){
	$.fn.zoom = function(options){
		// 默认配置
		var _option = {
			align: "left",				
			thumb_image_width: 350,		
			thumb_image_height: 350,	
			source_image_width: 900,  	
			source_image_height: 1200,	
			zoom_area_width: 600, 		
			zoom_area_height: "justify",
			zoom_area_distance: 10,     
			zoom_easing: true,          
			click_to_zoom: false,
			zoom_element: "auto",
			show_descriptions: true,
			description_location: "bottom",
			description_opacity: 0.7,
			small_thumbs: 3,			
			smallthumb_inactive_opacity: 0.4, 	
			smallthumb_hide_single: true,    	 
			smallthumb_select_on_hover: false,
			smallthumbs_position: "bottom",		
			show_icon: true,
			hide_cursor: false,			
			speed: 600,     			
			autoplay: true,				
			autoplay_interval: 6000, 	
			keyboard: true,
			right_to_left: false,
		}

		if(options){
			$.extend(_option, options);
		}

		var $ul = $(this);
		if($ul.is("ul") && $ul.children("li").length && $ul.find(".bzoom_big_image").length){

			$ul.addClass('bzoom clearfix').show();
			var $li = $ul.children("li").addClass("bzoom_thumb"),
				li_len = $li.length,
				autoplay = _option.autoplay;
			$li.first().addClass("bzoom_thumb_active").show();
			if(li_len<2){
				autoplay = false;
			}

			$ul.find(".bzoom_thumb_image").css({width:_option.thumb_image_width, height:_option.thumb_image_height}).show();

			var scalex = _option.thumb_image_width / _option.source_image_width,
				scaley = _option.thumb_image_height / _option.source_image_height,
				scxy = _option.thumb_image_width / _option.thumb_image_height;

			var $bzoom_magnifier, $bzoom_magnifier_img, $bzoom_zoom_area, $bzoom_zoom_img;

			
			if(!$(".bzoom_magnifier").length){
				$bzoom_magnifier = $('<li class="bzoom_magnifier"><div class=""><img src="" /></div></li>');
                $bzoom_magnifier_img = $bzoom_magnifier.find('img');

                $ul.append($bzoom_magnifier);

                $bzoom_magnifier.css({top:top, left:left});
                $bzoom_magnifier_img.attr('src', $ul.find('.bzoom_thumb_active .bzoom_thumb_image').attr('src')).css({width: _option.thumb_image_width, height: _option.thumb_image_height});
                $bzoom_magnifier.find('div').css({width:_option.thumb_image_width*scalex, height:_option.thumb_image_height*scaley});
			}
			
			
			if(!$('.bzoom_zoom_area').length){
                $bzoom_zoom_area = $('<li class="bzoom_zoom_area"><div><img class="bzoom_zoom_img" /></div></li>');
                $bzoom_zoom_img = $bzoom_zoom_area.find('.bzoom_zoom_img');
                var top = 0,
                    left = 0;

                $ul.append($bzoom_zoom_area);

                if(_option.align=="left"){
                	top = 0;
                	left = 0 + _option.thumb_image_width + _option.zoom_area_distance;
                }

                $bzoom_zoom_area.css({top:top, left:left});
                $bzoom_zoom_img.css({width: _option.source_image_width, height: _option.source_image_height});
			}

			var autoPlay = {
				autotime : null,
				isplay : autoplay,

				start : function(){
					if(this.isplay && !this.autotime){
						this.autotime = setInterval(function(){
							var index = $ul.find('.bzoom_thumb_active').index();
							changeLi((index+1)%_option.small_thumbs);
						}, _option.autoplay_interval);
					}
				},

				stop : function(){
					clearInterval(this.autotime);
					this.autotime = null;
				},

				restart : function(){
					this.stop();
					this.start();
				}
			}

		
			var $small = '';
			if(!$(".bzoom_small_thumbs").length){
				var top = _option.thumb_image_height+10,
					width = _option.thumb_image_width,



					smwidth = (_option.thumb_image_width / _option.small_thumbs) - 10,
					smheight = smwidth / scxy,
					ulwidth = 
					smurl = '',
					html = '';

				for(var i=0; i<_option.small_thumbs; i++){
					smurl = $li.eq(i).find('.bzoom_thumb_image').attr("src");

					if (smwidth > 300) {
						smwidth=150;
						smheight=150;
					}

					if(i==0){
						
						html += '<li id="small" class="bzoom_smallthumb_active"><img src="'+smurl+'" alt="small" style="width:'+smwidth+'px; height:'+smheight+'px;" /></li>';
					}else{
						html += '<li  style="opacity:0.4;"><img src="'+smurl+'" alt="small" style="width:'+smwidth+'px; height:'+smheight+'px;" /></li>';
					}
				}

				$small = $('<li class="bzoom_small_thumbs" style="top:'+top+'px; width:'+width+'px;"><ul class="clearfix" style="width: 485px;">'+html+'</ul></li>');
				$ul.append($small);

				$small.delegate("li", "click", function(event){
					changeLi($(this).index());
					autoPlay.restart();
				});

				autoPlay.start();
			}

			function changeLi(index){
				$ul.find('.bzoom_thumb_active').removeClass('bzoom_thumb_active').stop().animate({opacity: 0}, _option.speed, function() {
                    $(this).hide();
                });
                $small.find('.bzoom_smallthumb_active').removeClass('bzoom_smallthumb_active').stop().animate({opacity: _option.smallthumb_inactive_opacity}, _option.speed);

                $li.eq(index).addClass('bzoom_thumb_active').show().stop().css({opacity: 0}).animate({opacity: 1}, _option.speed);
                $small.find('li:eq('+index+')').addClass('bzoom_smallthumb_active').show().stop().css({opacity: _option.smallthumb_inactive_opacity}).animate({opacity: 1}, _option.speed);

                $bzoom_magnifier_img.attr("src", $li.eq(index).find('.bzoom_thumb_image').attr("src"));
			}

			
			

			_option.zoom_area_height = _option.zoom_area_width / scxy;
			$bzoom_zoom_area.find('div').css({width:_option.zoom_area_width, height:_option.zoom_area_height});

			$li.add($bzoom_magnifier).mousemove(function(event){
				var xpos = event.pageX - $ul.offset().left,
					ypos = event.pageY - $ul.offset().top,
					magwidth = _option.thumb_image_width*scalex,
					magheight = _option.thumb_image_height*scalex,
					magx = 0,
					magy = 0,
					bigposx = 0,
					bigposy = 0;

				if(xpos < _option.thumb_image_width/2){
					magx = xpos > magwidth/2 ? xpos-magwidth/2 : 0;
				}else{
					magx = xpos+magwidth/2 > _option.thumb_image_width ? _option.thumb_image_width-magwidth : xpos-magwidth/2;
				}
				if(ypos < _option.thumb_image_height/2){
					magy = ypos > magheight/2 ? ypos-magheight/2 : 0;
				}else{
					magy = ypos+magheight/2 > _option.thumb_image_height ? _option.thumb_image_height-magheight : ypos-magheight/2;
				}

				bigposx = magx / scalex;
				bigposy = magy / scaley;
				
				$bzoom_magnifier.css({'left':magx, 'top':magy});
				$bzoom_magnifier_img.css({'left':-magx, 'top': -magy});

				$bzoom_zoom_img.css({'left': -bigposx, 'top': -bigposy});
			}).mouseenter(function(event){
				autoPlay.stop();

				$bzoom_zoom_img.attr("src", $(this).find('.bzoom_big_image').attr('src'));
				$bzoom_zoom_area.css({"background-image":"none"}).stop().fadeIn(400);

				$ul.find('.bzoom_thumb_active').stop().animate({'opacity':0.5}, _option.speed*0.7);
				$bzoom_magnifier.stop().animate({'opacity':1}, _option.speed*0.7).show();
			}).mouseleave(function(event){
				$bzoom_zoom_area.stop().fadeOut(400);
				$ul.find('.bzoom_thumb_active').stop().animate({'opacity':1}, _option.speed*0.7);
				$bzoom_magnifier.stop().animate({'opacity':0}, _option.speed*0.7, function(){
					$(this).hide();
				});

				autoPlay.start();
			})
		}
	}
})(jQuery);