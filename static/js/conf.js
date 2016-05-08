function addlinks(){


    var links = {
    
        head:['/','/Hotellist','/Villalist','/Activelist','特别','关于'],
        cons:['#1','#2','#3','#4','#5'],
        foot:['#1','#2','#3','#4',
              '#5','#2','#3','#4',
              '#5','#2','#3','#4'
             ]
    }
    var d = document;
    var headmenu_J = d.getElementById('headmenu_J'),
        footermenu_J = d.getElementById('footermenu_J'),
        special_J = d.getElementById('special_J');
    
    if(headmenu_J){
        var atag = headmenu_J.getElementsByTagName('A');
        for(var i= 0,j=atag.length;i<j;i++){
            atag[i].href = links.head[i];        
        }
    
    }
    if(footermenu_J){
        var atag = footermenu_J.getElementsByTagName('A');
        for(var i= 0,j=atag.length;i<j;i++){
            atag[i].href = links.foot[i];        
        }
    
    }
    
    if(special_J){
        var atag = special_J.getElementsByTagName('A');
        for(var i= 0,j=atag.length;i<j;i++){
            atag[i].href = links.cons[i];        
        }
    
    }
    
        

}

addlinks();