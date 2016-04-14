
function addPt(){
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
    

}

addPt();