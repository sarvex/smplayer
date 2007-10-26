var server = 'chatbox.php';
var posting = false;

// Function to Disable/Enable input fields
function input_disable(type) {
	disableThis = document.getElementsByTagName("input");
	for (i=0; i< disableThis.length; i++) {
			disableThis[i].disabled = type;
	}
}

// Request function for get possible new messages
function get_messages() {
        var args = 'ajax=1&last_msg='+LastMsg;
        var do_ajax = new Ajax.Request(server, {method: 'get', parameters: args, onComplete: handle_response});
	Element.show('loading');
}

// Request function for send new message
function send_message() {
        var req_message = $F('req_message');
        var form_user = escape($F('form_user'));
        var req_username = escape($F('req_username'));
        var req_email = escape($F('req_email'));
        var email = escape($F('email'));
	
        // Send message
        var args = 'ajax=1&last_msg=' + LastMsg + '&form_user=' + encodeURIComponent(form_user) + '&req_username=' + encodeURIComponent(req_username) + '&req_email=' + encodeURIComponent(req_email) + '&email=' + encodeURIComponent(email) + '&req_message=' + encodeURIComponent(req_message);
	var do_ajax = new Ajax.Request(server, {method: 'post', parameters: args, onComplete: handle_response});
	
	// Disable input fields while posting
	input_disable(true);
	// Display loading image
	Element.show('loading');
	// Let the script know that we're trying to post
	posting = true;
}

// Get the response server
function handle_response(request) {
        var LastMsgInfo = '';
	
	// Hide loading image
	Element.hide('loading');
	
        // We're getting a valid response, first get the latest timestamp
        var response = request.responseText;
	LastMsgInfo = response.substring(0, 10);
	
	// If error, we display error message
	if (LastMsgInfo == 'error:chat') {
		 error = response.substring(10, response.length);
		 var chatbox = $('chatbox');
		 chatbox.innerHTML = chatbox.innerHTML + error + '\n';
	}
	// If it's a posted response we get message(s)
	else if (LastMsgInfo == 'PostedInDB') {
		get_messages();
	}
	// If Response TimeStamp != Send TimeStamp we display display new message
	else if (LastMsgInfo != LastMsg) {
		LastMsg = LastMsgInfo;
		messages = response.substring(10, response.length);
		// Add all new message(s)
		var chatbox = $('chatbox');
		chatbox.innerHTML = chatbox.innerHTML + messages + '\n';
	}
	// If we was posting !
	if (posting == true) {
		
		// Re-enable input fields after posting but we need min 500ms beetween each post for good timestamp order
		setTimeout('input_disable(false)', 500);
		// If no error, we delete "req_message" value
		if (LastMsgInfo != 'error:chat')
			$('req_message').value = '';
		// Put focus in the input message box
		document.formulaire.req_message.focus();
		// Let the script know that we're not trying to post.
		posting = false; 
	}
	
	// Auto Scroll chatbox if is checked
	if ($('autoscroll').checked == true)
		$('chatbox').scrollTop = $('chatbox').scrollHeight;
}
