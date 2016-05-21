var updateData = false;
var $J = jQuery.noConflict();
//Ajax加载
function mainLoad(url){
	
	var hurl = $J('#main-content').data('currentUrl') || URL+'/';	
	
	$J('#main-content').loadPage(url,'mainBox').data('currentUrl',url).data('prevUrl',hurl);	
	//console.log('from:'+hurl)
	//console.log('Now:'+url)
	}
//请求完成后执行
function complete(data,status){

	if (status==1)
	{
		//$J(document).unbind('close.facebox');
		window.setTimeout(function (){
			$J.facebox.close();
		},500);
	window.setTimeout(function (){
		var url = $J('#main-content').data('currentUrl');
		if(url) mainLoad(url)
		},1000);
	}
}
//请求完成后执行，非facebox
function completeN(data,status){

	if (status==1)
	{
		//$J(document).unbind('close.facebox');
		window.setTimeout(function (){
		var url = $J('#main-content').data('currentUrl');
		if(url) mainLoad(url) 
		},1000);
	}
}

//请求完成后执行,回上一加载页
function completePrev(data,status,stime){

	if (status==1)
	{
		window.setTimeout(function (){						
            var url = $J('#main-content').data('prevUrl');
            if(url) mainLoad(url) 
		},stime || 1000);
	}
}

//请求完成后执行，非facebox
function completeMsg(){
if(updateData){
		//$J(document).unbind('close.facebox');
		window.setTimeout(function (){
		var url = $J('#main-content').data('currentUrl');
		if(url) mainLoad(url) 
		},1000);
		updateData = false;
		}
}

$J(document).ready(function(){
		
		
	$J(document).bind('close.facebox', function() {
	completeMsg();
	})
	//Sidebar Accordion Menu:
		
		$J("#main-nav li ul").hide(); // Hide all sub menus
		$J("#main-nav li a.current").parent().find("ul").slideToggle("slow"); // Slide down the current menu item's sub menu
		
		$J("#main-nav li a.nav-top-item").click( // When a top menu item is clicked...
			function () {
				$J(this).parent().siblings().find("ul").slideUp("normal"); // Slide up all sub menus except the one clicked
				$J(this).next().slideToggle("normal"); // Slide down the clicked sub menu
				return false;
			}
		);
		
		$J("#main-nav li a.no-submenu").click( // When a menu item with no sub menu is clicked...
			function () {
				window.location.href=(this.href); // Just open the link instead of a sub menu
				return false;
			}
		); 

    // Sidebar Accordion Menu Hover Effect:
		
		$J("#main-nav li .nav-top-item").hover(
			function () {
				$J(this).stop().animate({ paddingRight: "25px" }, 200);
			}, 
			function () {
				$J(this).stop().animate({ paddingRight: "15px" });
			}
		);

    //Minimize Content Box
		
		$J(".content-box-header h3").css({ "cursor":"s-resize" }); // Give the h3 in Content Box Header a different cursor
		$J(".closed-box .content-box-content").hide(); // Hide the content of the header if it has the class "closed"
		$J(".closed-box .content-box-tabs").hide(); // Hide the tabs in the header if it has the class "closed"
		
		$J(".content-box-header h3").click( // When the h3 is clicked...
			function () {
			  $J(this).parent().next().toggle(); // Toggle the Content Box
			  $J(this).parent().parent().toggleClass("closed-box"); // Toggle the class "closed-box" on the content box
			  $J(this).parent().find(".content-box-tabs").toggle(); // Toggle the tabs
			}
		);

    // Content box tabs:
		
		$J('.content-box .content-box-content div.tab-content').hide(); // Hide the content divs
		$J('ul.content-box-tabs li a.default-tab').addClass('current'); // Add the class "current" to the default tab
		$J('.content-box-content div.default-tab').show(); // Show the div with class "default-tab"
		
		$J('.content-box ul.content-box-tabs li a').click( // When a tab is clicked...
			function() { 
				$J(this).parent().siblings().find("a").removeClass('current'); // Remove "current" class from all tabs
				$J(this).addClass('current'); // Add class "current" to clicked tab
				var currentTab = $J(this).attr('href'); // Set variable "currentTab" to the value of href of clicked tab
				$J(currentTab).siblings().hide(); // Hide all content divs
				$J(currentTab).show(); // Show the content div with the id equal to the id of clicked tab
				return false; 
			}
		);

    //Close button:
		
		$J(".close").click(
			function () {
				$J(this).parent().fadeTo(400, 0, function () { // Links with the class "close" will close parent
					$J(this).slideUp(400);
				});
				return false;
			}
		);

    // Alternating table rows:
		
		$J('tbody tr:even').addClass("alt-row"); // Add class "alt-row" to even table rows

    // Check all checkboxes when the one in a table head is checked:
		
		$J('.check-all').click(
			function(){
				$J(this).parent().parent().parent().parent().find("input[type='checkbox']").attr('checked', $J(this).is(':checked'));   
			}
		);

    // Initialise Facebox Modal window:
		
		$J('a[rel*=modal]').facebox(); // Applies modal window to any link with attribute rel="modal"

    // Initialise $J WYSIWYG:
		
		//$J(".wysiwyg").wysiwyg(); // Applies WYSIWYG editor to any textarea with the class "wysiwyg"
		
		$J('#searchInput').focus(function(){
										  
			
  				//this.blur();
			});
		//绑定按钮	
		$J(window).keydown(function(event){
		  switch(event.keyCode) {
				case 116://F5
				var url = $J('#main-content').data('currentUrl');
					if(url){
						mainLoad(url);
					}else{
						location.reload();
						}
						return false;
				break;	
				
/*				case 13:
					alert('回车');
				//	$("form").bind("submit", function() { return false; })
					//e.preventDefault();
					return false;
				break;*/
				default:
				//event.preventDefault();
				break;
			
			// 不同的按键可以做不同的事情
			// 不同的浏览器的keycode不同
			// 更多详细信息:     http://unixpapa.com/js/key.html
			// ...
		  }
		});
		
/*	var checkBind=function(e){
		e=e||window.event;
		
		switch((e.which||e.keyCode)){
			case 116://F5
				if(e.preventDefault){//FF中处理
					var url = $J('#main-content').data('currentUrl');
					if(url){
						mainLoad(url);
					}else{
						location.reload();
						}
					e.preventDefault();
				}
				else{//IE中处理
					var url = $J('#main-content').data('currentUrl');
					if(url){
						mainLoad(url);
					}else{
						location.reload();
						
						}
					window.event.keyCode=0;     
					window.event.onkeydown=false;
					//event.keyCode = 0;
					e.returnValue=false;
				}	
			break;
			
			case 13:
				if(e.preventDefault){//FF中处理
					alert('回车');
					//e.preventDefault();
					return false;
				}
				else{//IE中处理
					alert('回车');
					window.event.keyCode=0;     
					window.event.onkeydown=false;
					//event.keyCode = 0;
					e.returnValue=false;
					return false;
				}	
			break;
			default:
			break;
			
			}

	}
		if(document.addEventListener){
			document.addEventListener("keydown",checkBind,false);
		}
		else{
			document.attachEvent("onkeydown",checkBind);
		}*/
		

});
  