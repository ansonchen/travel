var $J = jQuery.noConflict();
var updateData = false;
//ThinkAjax.sInfoWarp = ['<span class="input-notification success png_bg" >','</span>'];
//ThinkAjax.eInfoWarp = ['<span class="input-notification error png_bg" >','</span>'];
//ThinkAjax.iInfoWarp = ['<span class="input-notification information png_bg" >','</span>'];
ThinkAjax.sInfoWarp = ['<div class="notification success png_bg" ><div>','</div></div>'];
ThinkAjax.eInfoWarp = ['<div class="notification error png_bg" ><div>','</div></div>'];
ThinkAjax.iInfoWarp = ['<div class="notification information png_bg" ><div>','</div></div>'];


$J.fn.retarder = function(delay, method){
	var node = this;
	if (node.length){
		if (node[0]._timer_) clearTimeout(node[0]._timer_);
		node[0]._timer_ = setTimeout(function(){ method(node); }, delay);
	}
	return this;
};

function showSelfTip(text,type,id){
	var css = 'information';
	if(type){css=type;}
	var html = '<div id="showSelfTipDiv" class="notification '+css+' png_bg" ><div>'+text+'</div></div>';
	var ide="result";
	if(id){ide = id;}
	ide = '#'+ide;
	$J(ide)
	.html(html)
	.animate({opacity: 'show'},1000)
	.retarder(3000,function(){
	$J('#showSelfTipDiv').remove();
	//$J(ide).hide();
	})
	
//	$J(ide).html(html).fadeIn("slow");

}

function closeFBbox(){
if(updateData){
		//location.href = URL;
		updateData = false;
	//	location.reload();
		}
}
$J(document).ready(function(){
		
		
	$J(document).bind('close.facebox', function() {
	closeFBbox();
	})
							
});
