
function addDom(dom,obj){
    
    var box = document.getElementById(dom);
    if(!dom) return false;
    var html = '';
    for(var i = 0,j=obj.length; i<j; i++){
        
    html+='<a href="'+obj[i]['link']+'" target="_blank"><img src="'+obj[i]['path'].replace('s_','')+'" ><div></div><p>'+obj[i]['name']+'<br/>'+obj[i]['enname']+'</p></a>';
    }
    box.innerHTML = html;
    html = null;


}
function addBg(dom,obj){
 var box = document.getElementById(dom);
    if(!dom) return false;
    var html = '';
    for(var i = 0,j=obj.length; i<j; i++){

    html+='<div class="img" style="background-image:url('+obj[i]['path'].replace('s_','')+')"><a href="'+obj[i]['link']+'"></a></div>';
    }
    box.innerHTML = html;
    html = null;
}

function init(){
    var indexbg = [];
    var book = [];
    var villa =  [];
    var action = [];

    for(var i = 0,j = indexdb.length;i<j;i++){    
        switch(indexdb[i]['g_id']){

                case '0':
                indexbg.push(indexdb[i]);
                break;
                 case '1':
                book.push(indexdb[i]);
                break;
                 case '2':
                villa.push(indexdb[i]);
                break;
                 case '3':
                action.push(indexdb[i]);
                break;


        }

    }
    addBg('imgBox',indexbg);
    addDom('bookBox',book);
    addDom('villaBox',villa);
    addDom('actionBox',action);
}


init();