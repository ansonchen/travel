/*
 *
 ********
 * $.fn.loadPage
 * 加载页面所有ajax页面都要经过此方法(url,参数,回调)
 * 
 * by:Anson,E-mail:75526201@qq.com
 *
 * 2010-4-8
 ********本js还包含方法 ********
 *
 * 		$.fn.loadPage_call
 * 		通过load加载并运行页面call标签包含函数(url,回调)
 *
 * 		$.fn.loadPage_frame(url,iframe的id,回调)
 * 		用iframe加载页面
 *
 * 		loadPage_includeJs
 * 		非jquery方法，加载完js并回调(url,回调)
 *
 * 		loadPage_getParaValue
 * 		非jquery方法，取url参数
 *
 * 		loadPage_history
 * 		非jquery方法,用历史记录加载页面调
 *
 * 		loadPage_saveRecord
 * 		非jquery方法,保存记录
 *
 * 		clearJsBug
 * 		非jquery方法,清除由js引起的bug
 *
 * 		loadFramePage
 * 		非jquery方法,用iframe读页面(url,id)
 *
 ******** ******** ********
 *
 * by:Anson,E-mail:chents@gpcsoft.com
 *
 * Depends:
 * 
 *  
 * 	
 * 
 */
 


(function($) {

//loadPage 所有ajax页面都要经过此方法
jQuery.fn.extend({

	_loadPage: jQuery.fn.loadPage,

	loadPage: function( url, params, callback ) {
		if ( typeof url !== "string" )
			return this._loadPage( url );

		var off = url.indexOf(" ");
		if ( off >= 0 ) {
			var selector = url.slice(off, url.length);
			url = url.slice(0, off);
		}

		var type = "GET";

		if ( params )

			if ( jQuery.isFunction( params ) ) {
				callback = params;
				params = null;

			} else if( typeof params === "object" ) {
				params = jQuery.param( params );
				type = "POST";
			}

		var self = this;

		//载入页面时显示动画
		//self.html('<div class="loader">正在努力加载中...</div>');
		
		//清除由js引起的bug
		//clearJsBug();
		
		jQuery.ajax({
			url: url,
			type: type,
			dataType: "html",
			data: params,
			complete: function(res, status){
				
				if ( status == "success" || status == "notmodified" )
						//res.responseText.replace(/<script(.|\s)*?\/script>/g, "")
					self.html( selector ? jQuery("<div/>").append(res.responseText.replace(/<script(.|\s)*?\/script>/g, "")) .find(selector) : res.responseText );

				if( callback )
					self.each( callback, [res.responseText, status, res] );
			
			}
		});
		return this;
	}
});

//retarder
jQuery.fn.retarder = function(delay, method){
	var node = this
	if (node.length){
		if (node[0]._timer_) clearTimeout(node[0]._timer_);
		node[0]._timer_ = setTimeout(function(){ method(node); }, delay);
	}
	return this;
};

//通过load加载并运行页面call参数 仅用于测试原型
jQuery.fn.loadPage_call = function(url,callback){

	var self = this;
	callback = callback || function() {};
	return 	self.loadPage(url,function(e){
										   if(self.find('call').length>0){
											  var pm = self.find('call').attr('fn').split(',');
											  for(var i=0; i<pm.length;i++){
												var pmi = pm[i];
											  	pageRun(pmi);  
												  }
											  
										   }
										   callback();
									   });
	}
	
//用iframe打开(连接,iframe的id,回调)
jQuery.fn.loadPage_frame = function(url,id,callback){
	var self = this;
	callback = callback || function() {};
	var ifameId ='iframe_'+id;
	var iframe = document.createElement("iframe");
	iframe.src = url;
	iframe.id = ifameId;
	iframe.width="100%";
	iframe.height="100%";
	iframe.setAttribute('scrolling','auto');
	iframe.setAttribute('marginheight',0);
	iframe.setAttribute('marginwidth',0);
	iframe.setAttribute('frameborder',0);
	if (iframe.attachEvent){
		iframe.attachEvent("onload", function(){
			//alert("Local iframe is now loaded.");
			callback();
		});
	} else {
		iframe.onload = function(){
			//alert("Local iframe is now loaded.");
			callback();
		};
	}
	//var frame = $('<iframe id="'+ ifameId + '" src="'+ url +'" width="100%"  height="100%" scrolling="auto"  marginheight="0" marginwidth="0" frameborder="0" ></iframe>');
	self.empty().append(iframe);
	return this;
}
	
	
})(jQuery);



//加载完js并回调
function loadPage_includeJs(file,callback) {

	callback = callback || function() {};
    var _doc = document.getElementsByTagName('head')[0];
    var js = document.createElement('script');
    js.setAttribute('type', 'text/javascript');
    js.setAttribute('src', file);
    _doc.appendChild(js);

    if (!/*@cc_on!@*/0) { //if not IE
        //Firefox2、Firefox3、Safari3.1+、Opera9.6+ support js.onload
        js.onload = function () {
           // alert('Firefox2、Firefox3、Safari3.1+、Opera9.6+ support js.onload');
		   callback();
        }
    } else {
        //IE6、IE7 support js.onreadystatechange
        js.onreadystatechange = function () {
            if (js.readyState == 'loaded' || js.readyState == 'complete') {
              // alert('IE6、IE7 support js.onreadystatechange');
			  callback();
			 //$('.mainTip').hide().html('');
            }//else{alert('loading...')}
        }
    }
	var fileName = file.replace(/.+\/([^\/]+)/,'$1');
		if($('script[src$='+fileName+']').length>1){ $('script[src$='+fileName+']:first').remove(); }
    return false;
}


//刷新
function loadPage_refreshBage(obj){
	
		var self = obj;	
		if(self.data('href')){
			self.addClass('selected');
			$('#conTitle').html('<div class="loader">刷新...</div>');
			var target = self.data('target');
			var href = self.data('href');
			var title = self.data('title');
			var id = self.data('id');
			var hash = self.data('hash');
			$('#'+target)
			.retarder(300,function(i){	
				i.load(href,function(){
					  $('#conTitle').text(title);
					  self.removeClass('selected');
					  loadPage_saveRecord(href,title,target,id,hash);
					  loadPage_finsh(id,href,title,target,hash);
					  
											  });
			})
		}else{
			loadDefaultHtml();
			}
	
}

	
//用iframe读页面(链接,Div的id)
function loadFramePage(url,id){
	//清除id内容
	$(id).empty();
	//添加ifrmae
	var ifameId = "Frame_"+id.replace("#","");
	var addFrame = $('<iframe id="'+ ifameId + '" src="'+ url +'" width="100%"  height="100%" scrolling="NO"  marginheight="0" marginwidth="0" frameborder="0" ></iframe>');
	$(id).append(addFrame);
	
	//调整高度
	$('#'+ifameId).load(function(){
	var innerDoc = ($(this).get(0).contentDocument) ? $(this).get(0).contentDocument : $(this).get(0).contentWindow.document;
	$(this).height(innerDoc.body.scrollHeight + 35);
	$(id).height(innerDoc.body.scrollHeight + 35);
	//reinitIframeAgent($(this).get(0),innerDoc);
	})
	
}

//tipsPage
function tipsPage(url,parms,callback){
	callback = callback || function() {};
	$("#ajaxPage")
	.retarder(300,function(i){
			i.load(url, parms,function(){
			var self = $(this);
			 self.fadeIn('fast',function(){
				callback();
				 setTimeout(function(){self.fadeOut('slow')},3000);
				
			 });
			});
	})
	
	}
//tips
function tips(text,callback){
	callback = callback || function() {};
	$("#ajaxPage")
	.retarder(300,function(i){
						   i.html(text)
							.fadeIn('fast',function(){
								callback();
								setTimeout(function(){$("#ajaxPage").fadeOut('slow')},3000);
								
							 });
						   })
	
	
	}