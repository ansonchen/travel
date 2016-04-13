
$J(document).ready(function(){
							
		
	

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
		
	//	$J('a[rel*=modal]').facebox(); // Applies modal window to any link with attribute rel="modal"

    // Initialise $J WYSIWYG:
		
		$J(".wysiwyg").wysiwyg(); // Applies WYSIWYG editor to any textarea with the class "wysiwyg"

});
  
  
  