// jQuery Initialization
jQuery(document).ready(function($){
"use strict"; 
    
    var contact_div = $('.contact_form_div').height();
    jQuery('.google_maps_div, .google_maps_div *').stop(true,true).animate({
                                    'height' : contact_div
                                },{queue:false, duration:450, easing: 'easeOutCubic'}); 

    $("#submit_btn").click(function() { 
          
        
        //get input field values
        var user_name       = $('input[name=name]').val(); 
        var user_email      = $('input[name=email]').val();
        var user_phone      = $('input[name=phone]').val();
        var user_message    = $('textarea[name=message]').val();
        
        //simple validation at client's end
        //we simply change border color to red if empty field using .css()
        var proceed = true;
        if(user_name==""){ 
            $('input[name=name]').css('border-color','red'); 
            proceed = false;
        }
        if(user_email==""){ 
            $('input[name=email]').css('border-color','red'); 
            proceed = false;
        }
        if(user_phone=="") {    
            $('input[name=phone]').css('border-color','red'); 
            proceed = false;
        }
        if(user_message=="") {  
            $('textarea[name=message]').css('border-color','red'); 
            proceed = false;
        }

        //everything looks good! proceed...
        if(proceed) 
        {
            //data to be sent to server
            var post_data;
            var output;
            post_data = {'userName':user_name, 'userEmail':user_email, 'userPhone':user_phone, 'userMessage':user_message};
            //Ajax post data to server
            $.post('contact_me.html', post_data, function(response){  

                //load json data from server and output message     
                if(response.type == 'error')
                {
                    output = '<div class="error">'+response.text+'</div>';
                }else{
                    output = '<div class="success">'+response.text+'</div>';
                    
                    //reset values in all input fields
                    $('#contact_form input').val(''); 
                    $('#contact_form textarea').val(''); 
                }
                
                $("#result").hide().html(output).slideDown();
            }, 'json');
            
        }

        var contact_div = $('.contact_form_div').height();
        jQuery('.google_maps_div, .google_maps_div *').stop(true,true).animate({
                                    'height' : contact_div
                                },{queue:false, duration:450, easing: 'easeOutCubic'}); 
    });
    
    //reset previously set border colors and hide all message on .keyup()
    $("#contact_form input, #contact_form textarea").keyup(function() { 
        $("#contact_form input, #contact_form textarea").css('border-color',''); 
        $("#result").slideUp();
        var contact_div = $('.contact_form_div').height();
        jQuery('.google_maps_div, .google_maps_div *').stop(true,true).animate({
                                    'height' : contact_div
                                },{queue:false, duration:450, easing: 'easeOutCubic'}); 
    });
});