
function booknow(){
 var d= document,
     bookNav = d.getElementById('bookNav');
    bookNav.onclick = function(e){


        if(e.target.tagName!=='A') return false;

        var id = e.target.rel;

        if(d.getElementById(id).className==='formBox'){
            d.getElementById(id).className='formBox show';
        }
        console.log(id);
        return true;

    }

    var formEven = {
        sending:0,

        send:function(url){
            var localTest = /^(?:file):/,
				xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function () {
				if (xmlhttp.readyState == 4 &&  xmlhttp.status == 200) {
                    console.log(xmlhttp.responseText);
                    var redata = eval('('+xmlhttp.responseText+')');
                    if(redata.status===1){
                        //alert(redata.msg);
                        location.href="/Getorder?order="+redata.orderno;
                        d.getElementById("addForm").reset();
                        setTimeout(function(){
					       formEven.sending = 0;
                        },1000)
                    }else{
                        alert(redata.msg);
                        formEven.sending = 0;
                    }

				}
			}
			xmlhttp.open("POST", url, true);
			 var formData = new FormData(d.getElementById("addForm"));
			xmlhttp.send(formData);
        },
        init:function(){

            var url = d.getElementById('url').value;
            d.getElementById('sendBtn').onclick = function(){

                if(!formEven.sending){
                    formEven.sending  = 1;
                    formEven.send(url);

                    }
            }


        }
 }
    formEven.init();
}


booknow();
