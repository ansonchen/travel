
function addPt(){
    //酒店配套
 var d= document,
     J_pt = d.getElementById('J_pt'),
     pTag = J_pt.getElementsByTagName('P'),
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
        divTag = rooms_J.getElementsByTagName('DIV');
    
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