
function addzone(){
 var d= document,
     addname = d.getElementById('addname'),
     zid = d.getElementById('zid').value;
    
    if(zid!=''){
        var obj = d.getElementById('zone_'+zid);
        obj.className = 'cur';
        addname.innerHTML = obj.innerHTML;
            
    }    

}

addzone();

function addname(id,aname){
 var d= document,
     objid = d.getElementById(id);    
    
    if(objid && objid.value!=''){
        

       d.getElementById( aname + objid.value).className = 'cur';
        
    }
    

}

addname('sid','star_');
addname('themeid','theme_');

addname('roomnumid','roomnum_');
addname('acttypeid','acttype_');
addname('actgroupid','actgroup_');

