
 $("document").ready(function() {
 // alert("hasclass");
 
  
        if( localStorage.getItem('hasmenu'))
        {
            // alert("true");
            $("body").addClass("menu-pin");
            $("body").addClass("sidebar-visible");
         
            console.log("setmenu");

        }

        if($(this).hasClass("menu-pin")){
             alert("hasclass");
    $( ".rent_field" ).css({'width':'100%','margin':'0 auto'});
    }
    });


     $("body").on("click",function(){
        
         if($(this).hasClass("menu-pin"))
         {
            // alert("menu-pin");
           localStorage.setItem('hasmenu', 'true');

         }
		 else
		 {
			  localStorage.removeItem('hasmenu', 'true');
		 }
        

     });
	 
	 
	  
		  