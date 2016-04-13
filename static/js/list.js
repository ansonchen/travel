
function addname(){
 var d= document,
     addname = d.getElementById('addname'),
     zid = d.getElementById('zid').value,
    sid = d.getElementById('sid').value;
    
    if(zid!=''){
        var obj = d.getElementById('zone_'+zid);
        obj.className = 'cur';
        addname.innerHTML = obj.innerHTML;
            
    }
    if(sid!=''){
    
        d.getElementById('star_'+sid).className = 'cur';
    }
    

}

addname();