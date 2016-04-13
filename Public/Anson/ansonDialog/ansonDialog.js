 /*
 * name     :  ansonDialog
 * desc     :  弹出层/提示层 调用参数说明参阅 ansonDialog.setting
 * author	:  Anson  E-mail:chents@gpcsoft.com
 * version  :  1.2(2010.01.11)
 * depends  : jquery.dragAndResize.js
               jquery.bgiframe.js
               loadPage.js
 
 */

(function($) {
		  
$.ansonDialog = function(settings){
	
	var options = jQuery.extend({
									title:null, //标题,为空时将不出现标题栏
									content:'加载中...',//ansonDialog内容,使用url或isLocalhost为false时,无效
									url:null, //ansonDialog中显示的内容
									parm:'',
									width: 640,//默认宽度
									height: 400,//默认高度
									top:false,//绝对定位上边距
									left:false,//绝对定位左边距
									hasBg:true,//遮挡层
									isLocalhost:true, //是否本地地址,默认是
									isTips:false, //是否右下角提示,默认否
									newWin:false,
									maxWin:false,//最大化窗口
									dragAndResize:true,//拖动和改变大小
									timeOut:0, //自动关闭时间,默认0不关闭
									onOpen: function(){}, //打开ansonDialog时调
									afterLoad: function(){}, //加载完url后调用
									onClose: function(){} //关闭后调用
								}, settings),
		self = this,
		o = options,
		ansonDialogTextHeight = parseInt(o.height),
		ansonDialogTextWidth = parseInt(o.width),
		dragAndResizeOK = true;
		
	var ansonDialog = {
		
		center:function(){//居中
			var elWidth = E.width();
			var elHeight = E.height(); 
			var winWidth = $(window).width();
			var winHeight = $(window).height();	
			E.css({
				 "top" : E.data('top') || (winHeight / 2) - (elHeight / 2),
				 "left": E.data('left') || (winWidth / 2) - (elWidth / 2)
				 });
			if($.fn.bgIframe) E.bgiframe();
			},
		maxMinWin:function(){//最大化-最小化
			var oh = $('.ansonDialogContent').height()-$('.ansonDialogText').height();
			  if ($('#ansonDialogMax').hasClass("min")){
					  //最小化
						$('#ansonDialogMax').removeClass("min").attr('title','最大化'); 
						$('.ansonDialogText').height( ansonDialogTextHeight );
						E.css({
								width: ansonDialogTextWidth,
								height: ansonDialogTextHeight + oh
						});
						ansonDialog.center();
						dragAndResizeOK = true;
						if(o.dragAndResize) $('.ansonDialogResize').show();
				  }else{
				 	 //最大化
						$('#ansonDialogMax').addClass("min").attr('title','最小化');
						E.css({
								  marginTop:'0px',
								  marginLeft:'0px',
								  left:'0px',
								  top:'0px',
								  width:$(window).width(),
								  height:$(window).height()
							  });
						if($.fn.bgIframe) E.bgiframe();
						$('.ansonDialogText').height(E.height()-oh);
						dragAndResizeOK = false;
						if(o.dragAndResize) $('.ansonDialogResize').hide();
					
				 }
			},
		position:function(){
						if(eval(o.top)&&eval(o.left)){
		E.css({
			top: parseInt(o.top) +'px',
			left:parseInt(o.left) +'px'
			}).bgiframe();
		}else{
			if(eval(o.isTips)){
				//右下角提示
				E.css({
					right:'0px',
					bottom:'0px'
					}).bgiframe();
				
				}else{
				//居中显示
					 ansonDialog.center();
		
					}
		}
						if(!o.newWin){$('#ansonDialogNewWin').hide();};
						if(!o.maxWin){$('#ansonDialogMax').hide();$('#ansonDialogNewWin').css('right','24px')};
						if(o.title){}else{$('.ansonDialogIcon').addClass('ansonDialogIconBg')};
						if(!o.hasBg){$('.ansonDialogBg').remove()};
						o.onOpen();
						},
		dnr:function(){//拖动和改变大小
				if(o.dragAndResize && $.fn.dragAndResize){
		E.find('.ansonDialogResize').show();
		var oh = E.height()- $('.ansonDialogText').height();
		 E.dragAndResize({
			 handle:{'.ansonDialogContent>h3':'m',	
					 '.ansonDialogResizeSW':'sw',
					 '.ansonDialogResizeSE':'se',
					 '.ansonDialogResizeNW':'nw',
					 '.ansonDialogResizeW':'w',
					 '.ansonDialogResizeE':'e',
					 '.ansonDialogResizeS':'s',
					 '.ansonDialogResizeN':'n'
					 },
			minHeight: 180,
			minWidth: 260,
			ghost:true,
			stopCallback:function(w,h){
				if(!dragAndResizeOK){ 
					E.css({left:'0px',top:'0px'});
					$('body').css('cursor', 'auto');
					return false;
				}
				$('.ansonDialogText').height(h-oh);
				}
		 })
		}
				},
		buildId:function(){//生成id
					var now= new Date(); 
					var number = now.getSeconds(); 
					var minute = now.getMinutes();
					return number+'_'+minute;},
		close:function(){//关闭
				$('div[tag=ansonDialog]').remove();
				$(document).unbind("keydown");
				o.onClose();
				},
		autoClose:function(){//自动关闭
					if(o.timeOut>0){self.timeOver = setTimeout(function(){ansonDialog.close()},parseInt(o.timeOut)*1000);}
					},
		escClose:function(){//按Esc关闭
					$(document).unbind("keydown").bind("keydown", function(event){
												//点Esc键关闭
												if (event.keyCode == 27) {
													ansonDialog.close();
													return false;}
													});
					},
		addDialog:function(){//添加dialog
					//如果已用弹出层先移除
					$('div[eps=ansonDialog]').remove();
					$('<div class="ansonDialog" tag="ansonDialog">'+
					'<div class="ansonDialogContent">'+
						'<div class="ansonDialogIcon">'+
							'<a href="'+o.url+'" target="_blank" id="ansonDialogNewWin" title="新窗口打开" >新窗口打开</a>'+
							'<a href="#" id="ansonDialogMax" title="最大化" >最大化</a>'+
							'<a href="#" id="ansonDialogClose" title="Esc/点击 关闭">关闭</a>'+
						'</div>'+
						'<h3>'+o.title +'</h3>'+
						'<div class="ansonDialogText" url="'+o.url+'">'+o.content+'</div>'+
						'<div class="ansonDialogResize ansonDialogResizeSE"></div>'+
						'<div class="ansonDialogResize ansonDialogResizeSW"></div>'+
						'<div class="ansonDialogResize ansonDialogResizeNW"></div>'+
						'<div class="ansonDialogResize ansonDialogResizeE"></div>'+
						'<div class="ansonDialogResize ansonDialogResizeW"></div>'+
						'<div class="ansonDialogResize ansonDialogResizeS"></div>'+
						'<div class="ansonDialogResize ansonDialogResizeN"></div>'+
					'</div>'+
			  '</div>'+
			  '<div class="ansonDialogBg"  tag="ansonDialog"></div>')
					.find('#ansonDialogClose').click(function(){ansonDialog.close();return false;}).end()
					.find('#ansonDialogMax').click(function(){ansonDialog.maxMinWin(); return false;}).end()
					.find('.ansonDialogContent>h3').bind('dblclick',function(){
																		   if(o.dragAndResize) E.find('#ansonDialogMax').trigger('click')
																		   }).end()
					.find('.ansonDialogText').each(function(){
														$(this).height(ansonDialogTextHeight);
														if(eval(o.isLocalhost)){
															//本地通过div加载
															//if(o.url){$(this).loadPage(o.url,o.afterLoad())};
															if(o.url){
																//$(this).loadPage_call(o.url,function(){o.afterLoad()});
																if(o.url){$(this).loadPage(o.url,o.parm,o.afterLoad())};
				
																};
														}
														else{
															//异地通过iframe加载
															$(this).loadPage_frame(o.url,'ansonDialog',function(){o.afterLoad()});
															}
														 }).end()
					.appendTo('body');
					E = $('.ansonDialog');
					E.css("width",ansonDialogTextWidth+"px");
				
					//定位
					ansonDialog.position();
						
					//自动关闭
					ansonDialog.autoClose();
						
					//拖动和改变大小
					ansonDialog.dnr();
						
					//Esc键关闭
					ansonDialog.escClose();
			}
		
		}
	
	if(self.timeOver){ clearTimeout(self.timeOver);}

	o.onOpen = o.onOpen || function() {};
	o.afterLoad = o.afterLoad || function() {};
	o.onClose = o.onClose || function() {};
	
	if(o.isTips){
		o.dragAndResize = false;
		o.maxWin = false;
		o.hasBg = false;
		}
	
	ansonDialog.addDialog();

	return this;
	};
	
})(jQuery);