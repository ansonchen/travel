 	ThinkAjax.sInfoWarp = ['<div class="notification success png_bg" ><div>','</div></div>'];
 	ThinkAjax.eInfoWarp = ['<div class="notification error png_bg" ><div>','</div></div>'];
	ThinkAjax.iInfoWarp = ['<div class="notification information png_bg" ><div>','</div></div>'];
        //后台管理主页
	function searchFn(data,status){
		if (status==1)
	{
	//	alert(data.key)
		mainLoad(URL+'/search/DB/'+data.dataBase+'/key/'+data.key);
	}
		}
$J(document).ready(function(){
						   
						   
						   $J('a.nav-top-item,a.showMsg').click(function(){
									//if($(this).hasClass('selected')) return false;
									$J('#main-nav a').removeClass('current');
									$J(this).addClass('current');
									mainLoad(this.href);
									return false;
									});
						   $J('a.shortLink').click(function(){
									$J('#main-content').load(this.href,function(date){
																				$J('#shortAction').click();
																				});
									return false;
									});
							
							$J('#SearchBtn').click(function(){
							//	mainLoad(URL+'/search/');
								ThinkAjax.sendForm('searchForm',URL+'/searchGo/',searchFn,'result');
							
							})
						   
						   })


