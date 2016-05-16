function addlinks(){


    var links = {
    
        head:['/','/Hotellist','/Villalist','/Activelist',
              '/Other/index/id/36',//特别策划
              '/Other/index/id/37' //关于我们
             ],
        cons:['#1','#2','#3','#4','#5'],
        foot:['/Other/index/id/38', //特色项目
              '/Hotellist',
              '/Villalist',
              '/Booknow',
              
              '/Other/index/id/39', //公司信息
              '/Other/index/id/37',
              '/Other/index/id/40', //工作机会
              '/Other/index/id/36', //新闻 41
              
              '/Other/index/id/42', //帮助
              '/Other/index/id/43', //政策
              '/Other/index/id/44', //灾难响应
              '/Other/index/id/45' //条款与隐私
              
              
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