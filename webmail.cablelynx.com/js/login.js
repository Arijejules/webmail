window.onload = function() {
    // generate our HTML canvas for authentication
    if (window.requestIdleCallback) {
        requestIdleCallback(generateFingerprint);
    } else {
        setTimeout(generateFingerprint, 500);
    }

    var theForm = document.forms["login-form"];

    // if portal mobility redirect is enabled....
    // and it found the visiting device to be a small screen...
    // NOTE: isMobile will only be defined if the setting is
    //       enabled...
    if (  typeof isMobile !== 'undefined'
       && isMobile === true) {
        // function is defined in js/redirect_portal.js
        loginMobilitySteps();
    } else {
        // automatically focus the email field
        theForm["login-email"].focus();
    }
    // if local storage item is set, then remove it
    if (localStorage.loaded) {
        localStorage.removeItem('loaded');
    }
}

// validate input parameters
function checkForm()
{
    var theForm = document.forms["login-form"];
    if (theForm["email"].value.indexOf('@') == -1) {
        alert("Please enter your full email address, for example, person@isp.com");
        theForm["email"].focus();
        return false;
    }

    if (theForm["password"].value.length==0) {
        alert("Please enter your password, being careful to use the proper case.");
        theForm["password"].focus();
        return false;
    }

    return true;
}

// toggle visible password input
function  showPass() {
	let thePass = document.getElementById('login-password');
	if(thePass !== null) {
		thePass.type === "password" ? 
		thePass.type = "text" : 
		thePass.type = "password";
	}
}
