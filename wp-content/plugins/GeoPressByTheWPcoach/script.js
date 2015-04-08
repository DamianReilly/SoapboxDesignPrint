
jQuery(document).ready(function(){ 
	jQuery(".djgeositemap-field").each(function(){
		var tmp = jQuery(this).attr("alt");
		var value = jQuery(this).attr("value");
		if(tmp == value)
		{
			jQuery(this).attr("style","color:grey;font-style:italic");
		}
	});

	jQuery(".djgeositemap-field").focus(function(){
		var tmp = jQuery(this).attr("alt");
		var value = jQuery(this).attr("value");
		if(tmp == value)
		{
			jQuery(this).attr("value","");
			jQuery(this).attr("style","");
		}

	});

   jQuery(".djgeositemap-field").blur(function(){
      var tmp = jQuery(this).attr("alt");
      var value = jQuery(this).attr("value");
      if(value == "")
      {
         jQuery(this).attr("value",tmp );
         jQuery(this).attr("style","color:grey;font-style:italic");
      }

   });

   jQuery("#djgeositemap-short li").click(function(){
      var message = jQuery("#djgeositemap_description").val();
      message += jQuery(this).html();
      jQuery("#djgeositemap_description").val(message);
   });
});

function lookup()
{
	var geocoder;
	geocoder = new google.maps.Geocoder();
	var st = jQuery("#djgeositemap_address").val();
	var city = jQuery("#djgeositemap_city").val();
	var state = jQuery("#djgeositemap_state").val();
	var zipcode = jQuery("#djgeositemap_zipcode").val();
	var country = jQuery("#djgeositemap_country").val();

	var list = st+","+city+","+state+","+zipcode+","+country;

	geocoder.geocode({ 'address': list }, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			jQuery("#djgeositemap_ll").val(results[0].geometry.location);
             			
		}
	});

	return false;
}

function formSubmit()
{
	var valid = true; 

	jQuery(".djgeositemap-require").each(function(){
		var tmp = jQuery(this).attr("alt");
		var value = jQuery(this).attr("value");
		var name = jQuery(this).attr("name");
      
		jQuery("label[for='"+name +"']").css("color","black");
		if(tmp == value || value == "")
		{
			jQuery("label[for='"+name +"']").css("color","red");
			valid  = false;
		}
	});

	if(!valid)
	{
		alert("Please fill all required fields");
	
		return valid;
	}else
	{
		jQuery(".djgeositemap-field").each(function(){

			var tmp = jQuery(this).attr("alt");
			var value = jQuery(this).attr("value");
			if(tmp == value)
			{
				jQuery(this).val("");
			}

		});
	}
	
	return valid;	



}

 