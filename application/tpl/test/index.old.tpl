<h1>test</h1>
<ul class="menu">
 <li>
  <h4 class="trigger">Uno</h4>
  <ul>
   <li><h4 class="trigger">uno uno</h4>
      <ul>
        <li>uno uno uno</li>
        <li>uno uno dos</li>
        <li>uno uno tres</li>
       </ul>
    </li>
    <li>uno dos</li>
    <li>uno dos</li>
    <li>uno dos</li>
   </ul>
  <li>dos</li>
  <li>tres</li>
 </ul>
 </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
    {literal}
    <script>
    /**
 * @author marcg
 * Accordion plugin based in jquery javascript library
 * Necessary structure to make this accordion work
 *   <ul>
 *    <li>
 *     <h4>Menu item</h4>
 *     <ul>
 *      <li>Submenu item</li>
 *     </ul>
 *    </li>
 *    <li>
 *     <h4>Menu item</h4>
 *     <ul>
 *      <li>Submenu item</li>
 *     </ul>
 *    </li>
 *   </ul>
 */

(function($) {
  $.fn.Accordion = function(settings){
	
 	contBox = this;
	settings = $.extend({}, arguments.callee.defaults, settings);
		/* send settings to each function */
	$(this).each(function(){
	 tSettings = settings;
	});

	$(this).find("li h4.trigger")
         .css("cursor","pointer")
         .bind(settings.event,function(){
         	var chUl = $(this).parent().find('ul:first');
         	if( $(this).parent().find('ul').attr("class") != "expanded"){
		     	$(contBox).find("ul.expanded")
		               .addClass("collapsed")
		               .removeClass("expanded")
		               .find("ul")
		               .slideToggle(settings.speed);
			       
		        chUl.addClass('expanded')
		            .removeClass('collapsed')
		            .slideToggle(settings.speed);
		    }else{
		     chUl.addClass("collapsed")
		         .removeClass("expanded")
		         .slideToggle(settings.speed);		
		    };
         }).parent()
         .find('ul')
         .addClass("collapsed")
         .hide();
	  
	return this;
  };
  
 $.fn.Accordion.defaults = {
  delay: 250,
  event: "click",
  speed: 500
 };
})(jQuery);
    
    
    $(document).ready(function(){
	    $('ul.menu').Accordion();
    })
    </script>
    {/literal}