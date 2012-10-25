<?php

      //SPECIAL NOTES:
      // This is just a DEMO to illustrate usage of the MobileESP PHP code library.
      // It is not necessarily a Best Practice to use an intermediary landing and detection page like this example
      //    when using PHP as a detection method. 
      //Load the Mobile Detection library
      include("mdetect.php");
      $uagent_obj = new uagent_info();
      

      //This is a common mobile detection scenario...
      // First, detect iPhone tier devices, like iPod Touches, Android, WebOS, etc. 
      //    Send them to the nice touch-optimized page. 
      //    These often have rich CSS and advanced but mobile-friendly JavaScript functionality and no Flash.
      // Second, detect any other mobile device. Send them to the basic mobile pages, with light CSS and no JavaScript.
      //    Some (often older) touch devices might be included in this bunch, which otherwise includes feature phones.
      //    It's a Best Practice to include an alternate web page for less-capable mobile devices. 
      // Finally, assume anything else not caught by these filters is a desktop PC-class device. 
      //    Send them to your regular home page which may include large pictures, lots of JS, Flash, etc.. 
      //
      // NOTE: If you wanted an iPad-class tablet-optimized web site, too, then you should FIRST do a 
      //    device detection using the DetectTierTablet() method. Then detect for iPhone tier, and so on. 
      
	 
      //In this simple example, we simply re-route depending on which type of device it is.
      //Before we can call the function, we have to define it. 
      function AutoRedirectToProperHomePage()
      {
	      global $uagent_obj;
        
        //We have variables for certain high-usage device variables, like the iPhone Tier.
        //   You might use the device variables to show/hide certain functionality or platform-specific features and ads, etc.
        //   Alternately, you can use the method: DetectTierIphone().
        //   Sometimes, you may wish to include the Tablet Tier devices here, as well. 
	      if ($uagent_obj->isTierIphone == $uagent_obj->true) 
          header ("Location: login_smartphone.php");
          
        //We can generally use the Quick Mobile detection method to save a couple of cycles.
	      else if ($uagent_obj->DetectMobileQuick() == $uagent_obj->true) 
          header ("Location: login_phone.php");

        //We'll assume that anything else not caught in the above filters is a desktop-class device. 
        //   (Which can include tablets.)
	      else 
          header("Location: login.php");
          
      }
  
      //Now, we can call the redirect function.
      AutoRedirectToProperHomePage();
    
  ?>
