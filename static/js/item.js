/**
 * by Anson
 * E-mail:75526201@qq.com
 * for hotelItem
 */
function addPt(){
    //酒店配套
 var d= document,
     J_pt = d.getElementById('J_pt');
    if(!J_pt) return false;

    var pTag = J_pt.getElementsByTagName('P'),
     inTag = J_pt.getElementsByTagName('INPUT');
        for(var i = 0,j = inTag.length;i<j;i++){

        for(var k = 0,l = pTag.length;k<l;k++){

           if(inTag[i].value===pTag[k].innerHTML){
              pTag[k].className = 'show';
              pTag[k].parentNode.parentNode.className = 'show';
              }
        }


    }

    var rooms_J = d.getElementById('rooms_J');
    if(!rooms_J) return false;
    var divTag = rooms_J.getElementsByTagName('DIV');

    for(var i = 0,j = divTag.length;i<j;i++){

        if(divTag[i].className!=='con') continue;

       if(divTag[i].clientHeight > 90){
        divTag[i].previousSibling.className = 'moreArr show';
       }



    }

    rooms_J.onclick = function(e){

        if(e.target.tagName!=='A') return false;
        var eobj = e.target;
        var p = e.target.parentNode;
        p.className = (p.className === 'include show' ? 'include' : 'include show');
        eobj.className = (eobj.className === 'moreArr show deg' ? 'moreArr show' : 'moreArr show deg');


    }

}

addPt();


!function(){

var contain = document.getElementById('picsList');
var imgs = contain.getElementsByTagName('img');
if(!imgs.length) return false;
var imgitem = [];
for(var i = 0; i < imgs.length;i++){

	imgs[i].setAttribute('index',i);

	(function(x){

		var img = new Image();
		var item = {
			src: x.src,
			title:x.title
		};
		var maxTime = 0;
		var getWH = function(){
			maxTime++;
			if(maxTime > 1500){clearInterval(set);}
			if(img.width>0 || img.height>0){
				item.w = img.width;
				item.h = img.height;
				clearInterval(set);
			}
		};
		var set = setInterval(getWH,40);

		img.onerror=function(){
			item.w = 0;
			item.h = 0;
		};

		img.src =  x.src;
		imgitem.push(item);

	}(imgs[i]));
}



function openImg(index){

	var pswpElement = document.getElementById('photoBox');
	var items = imgitem;
	var options = {
		history: false,
		focus: false,
		index: parseInt(index, 10),
		fullscreenEl:false,
		shareButtons: [
			{id:'download', label:'下载', url:'{{raw_image_url}}', download:true}
		],
		errorMsg:'<div class="pswp__error-msg">下载<a href="%url%" target="_blank" download> %title% </a></div>',
		showAnimationDuration: 0,
		hideAnimationDuration: 0

	};

	var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
	gallery.init();
}
contain.onclick = function(e){

	if(e.target.tagName!=='IMG') return true;
	var id = e.target.getAttribute('index');
	openImg(id);
}
}()
