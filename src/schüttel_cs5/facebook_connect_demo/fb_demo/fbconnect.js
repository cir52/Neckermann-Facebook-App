var userID;
var userInfo;
var friendInfo;

//STAGING OR PROD FB
if (document.location.href.indexOf("dev.") == -1){
	var api_key = "0d4bc648f390d35ff7f6e96abfdee32b"; //LIVE
}else{
	var api_key = "0d4bc648f390d35ff7f6e96abfdee32b"; //DEV TEDPEREZ DEMO
}

function loginConnect(){
	statusMsg("Login FB Connect...");
	FB.Connect.requireSession();
	checkConnect();
}
function logoutConnect(){
	FB.Connect.logout(sendLogoutStatus);
}

function checkConnect(){
	//FACEBOOK WILL WAIT UNTIL THERE IS A CONNECTION BEFORE RUNNING FUNCTION
	statusMsg("Check FB Connect...");
	
	FB_RequireFeatures(["XFBML"], function()
	{
	  FB.Facebook.init(api_key, "xd_receiver.htm");	  
	  FB.Facebook.get_sessionState().waitUntilReady(function()	  {
		userID = FB.Facebook.apiClient.get_session().uid;		
		if (!userID) {
			statusMsg("USER NOT VALID!");
		}else{
			getProfile();
		}
	  });
	});
}
function getProfile(){
	//Get the user's info	
	statusMsg("Loading profile..." + userID);
		
	FB.Facebook.apiClient.users_getInfo(userID,'first_name,last_name,name,pic_square,is_app_user',function(result, ex) {
		userInfo = result.slice();
		sendProfile();
		getFriends();
	});     	
}
function getFriends(){
	statusMsg("Loading friends...");
	
	//Get the friend's and their info        
	FB.Facebook.apiClient.friends_get(null, function(result, ex) {
		
		var ids = result.slice();
		
		FB.Facebook.apiClient.users_getInfo(ids,'name,pic_square,is_app_user',function(result, ex) {
			friendInfo = result.slice();
			sendFriends();
		});
	});    	
}
//SEND BACK TO FLASH
function sendProfile(){   
	//writeProfile();
	var flash = (navigator.appName.indexOf ("Microsoft") !=-1)?window["container"]:document["container"];
	flash.returnProfile(userInfo);		
	statusMsg("Finished loading profile!");
}
function sendFriends(){
	//writeFriends();
	var flash = (navigator.appName.indexOf ("Microsoft") !=-1)?window["container"]:document["container"];
	flash.returnFriends(friendInfo,friendInfo.length); 	
	statusMsg("Finished loading friends!");
}
function sendLogoutStatus(){
	var flash = (navigator.appName.indexOf ("Microsoft") !=-1)?window["container"]:document["container"];
	flash.returnLogoutStatus(true); 	
	statusMsg("Finished logout");	
}


function statusMsg(msgIn){
	var fb_status = document.getElementById('fb_status');  	
	if (fb_status){
		fb_status.innerHTML += "<br />" + msgIn;
	}
}
function cbFeedPostFinished(){
	statusMsg("Post closed.");
}
function feedPostOpenInvite(user_prepop_msg,subject_text,body_text,event_url){
	statusMsg("Prompt feed post...");

	var feedPostID = 138572240139;
	var template_data = {
						"images":[
								{"src":"http://www.mysite.com/events/media/images/facebook/fb_130x100.jpg", "href":event_url}
						],
						"message":subject_text
	};
	var friends_ar = null;
	var user_message_prompt = "Invite your Facebook friends to your event."; 
	var user_message = {value: user_prepop_msg}; 

	//Must have setTimeout for IE Browser bug
	setTimeout(function(){
		FB.Connect.showFeedDialog(
			feedPostID, 
			template_data, 
			friends_ar, 
			body_text, 
			null, 
			FB.RequireConnect.promptConnect, 
			cbFeedPostFinished, 
			user_message_prompt, 
			user_message
		);
	}, 1000);
}


function sendNotification(uids,msg){
	//If uids is blank it will send to current user
	
	//alert(uids);
	
	//FB.Facebook.apiClient.notifications_send(uids,msg,'user_to_user');
}


/*

{
"video":{ "video_src":"http://www.youtube.com/v/NP3lltOrGM0", "preview_img":"http://s3.ytimg.com/vi/NP3lltOrGM0/default.jpg" }
}
*/