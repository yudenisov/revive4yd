	// Swticher Cookie Base
	/**
	* Styleswitch stylesheet switcher built on jQuery
	* Under an Attribution, Share Alike License
	* By Kelvin Luck ( http://www.kelvinluck.com/ )
	* Thanks for permission! 
	**/
	(function($)
	{
		$(document).ready(function() {
			$('.styleswitch').click(function()
			{
				switchStylestyle(this.getAttribute("rel"));
				return false;
			});
			/* var c = readCookie('style'); */
			var c = 'light';
			if (c) switchStylestyle(c);
			
			
			//For Accent
			$('.accentswitch').click(function()
			{
				switchAccentStyle(this.getAttribute("rel"));
				return false;
			});
			var accent = 'blue';
			if (accent) switchAccentStyle(accent);
			
		});
	
		function switchStylestyle(styleName)
		{
			$('.skinlink').each(function(i) 
			{
				this.disabled = true;
				if (this.getAttribute('title') == styleName) this.disabled = false;
			});
			
			if (styleName == 'light') {
				jQuery('body').css('background-color','white');
			}
			else {
				jQuery('body').css('background-color','black');
			}
		}
		
		function switchAccentStyle(styleName)
		{
			$('.accentlink').each(function(i) 
			{
					this.disabled = true;
					if (this.getAttribute('title') == styleName) this.disabled = false;
			});
		}
		
		
		
	})(jQuery);
	
	function createCookie(name,value,days)
	{
		if (days)
		{
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	}
	function readCookie(name)
	{
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++)
		{
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}
	function eraseCookie(name)
	{
		createCookie(name,"",-1);
	}

	// DEMO Swticher Base
	jQuery('.demo_changer .demo-icon').click(function(){

		if(jQuery('.demo_changer').hasClass("active")){
			jQuery('.demo_changer').animate({"right":"-400px"},function(){
				jQuery('.demo_changer').toggleClass("active");
			});						
		}else{
			jQuery('.demo_changer').animate({"right":"0px"},function(){
				jQuery('.demo_changer').toggleClass("active");
			});			
		} 
	});
	
	// Selector (MODULE #4)
	jQuery(window).on('load', function () {
		jQuery('.selectpicker').selectpicker();
	});
	/*
jQuery(document).ready( function() {
		jQuery('#headers').change( function() {
			var hs = jQuery(this).val();
			
			switch (hs) {
				case 'LA':
					jQuery('#masthead #text-title-desc').css('text-align','left');
					jQuery('#masthead #text-title-desc').css('float','left');
					break;
				case 'CA':
					jQuery('#masthead #text-title-desc').css('text-align','center');
					jQuery('#masthead #text-title-desc').css('float','none');
					break;	
				case 'LABI'
					case 'LA':
					jQuery('#masthead #text-title-desc').css('text-align','left');
					jQuery('#masthead #text-title-desc').css('float','left');
					jQuery('#masthead').css('background-image'
					break;	
			}
			
			return false;
		});
	});
*/
	
	// Selector (MODULE #2)
	jQuery('.demo_changer .PatternChanger a').click(function(){
		var bgBgCol = jQuery(this).attr('href');
		jQuery('.demo_changer .PatternChanger a').removeClass('current');
		jQuery('body').css({backgroundColor:'#ffffff'});
		jQuery(this).addClass('current');
		jQuery('body').css({backgroundImage:'url(' + bgBgCol + ')'});
		if (jQuery(this).hasClass('bg_t')){
			jQuery('body').css({backgroundRepeat:'repeat', backgroundPosition:'50% 0', backgroundAttachment:'scroll'});
		} else {
			jQuery('body').css({backgroundRepeat:'repeat', backgroundPosition:'50% 0', backgroundAttachment:'scroll'});
		}
		return false;
	});
	
	jQuery('.removePattern').click(function() {
		jQuery('body').css({backgroundImage:'none'});
		var skin;
		jQuery('.skinlink').each(function(i) 
			{
				if ( this.disabled == false )
					skin = this.getAttribute('title');
			});
			
		if (skin == 'light') {
				jQuery('body').css('background-color','white');
			}
			else {
				jQuery('body').css('background-color','black');
			}
		
		return false;
	});

	// Selector (MODULE #5 and #6)
	/*
	   evol.colorpicker 2.2
	   (c) 2014 Olivier Giulieri
	*/
	jQuery(document).ready(function(){
		jQuery('#cp1').colorpicker({color:'#ffffff'})
		.on('change.color', function(evt, color){
			jQuery('body').attr('style','background-color:'+color);
		})
		jQuery('#cp2').colorpicker({color:'#656565'})
		.on('change.color', function(evt, color){
			jQuery('body').attr('style','color:'+color);
		})
	});