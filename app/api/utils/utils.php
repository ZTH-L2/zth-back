<?php
function update_post_var(){
    /*
    This function update the $_POST variable
    and return false if it's NULL, true otherwise
    */
    // check if post is empty
    if($_POST == NULL)
    {
        // if empty, check if data was in json
        // if in json it's update $_POST
            
        $_POST = json_decode(file_get_contents('php://input'), true);
    }
    return !is_null($_POST);
}

// Private
function is_logged_in(){
    return isset($_SESSION["id_user"]);
}
// Private
function is_admin(){
    // should be called only if is_logged_in has returned true
    // but can handle the case where is_logged_in has returned false
    return isset($_SESSION["permission"]) && $_SESSION["permission"] == 1;
}


function message_json($statusCode, $key, $message){
    http_response_code($statusCode);
    return json_encode([
        $key=> $message
    ]);
}

function success_message_json($statusCode, $message){   
    // 200 kind of status code
    return message_json($statusCode, "message", $message);
}

function error_message_json($statusCode, $message){
    // 400, 500 kind of status code
    return message_json($statusCode, "error", $message);
}


// CHATGPT :
// 200 OK:
// Explanation: Indicates that the request was successful.
// Example: Returning the requested resource successfully.

// 201 Created:
// Explanation: Indicates that the request has been fulfilled and resulted in a new resource being created.
// Example: After successfully creating a new user account.

// 204 No Content:
// Explanation: Indicates that the server successfully processed the request but there is no content to send.
// Example: Used in response to a successful DELETE request.

// 400 Bad Request:
// Explanation: Indicates that the request could not be understood by the server due to malformed syntax, missing parameters, or invalid input.
// Example: Sending a request with missing required parameters.
function no_data_error_message(){
    return error_message_json(400 ,"400 Bad Request: the body or the data of the request doesn't have any information or we couldn't access it.");
}

function invalid_format_data_error_message(){
    return error_message_json(400, "400 Bad Request: The request could not be understood or processed due to invalid data format.");
}

function invalid_data_error_message(){
    return error_message_json(400, "400 Bad Request: The request could not be understood or processed due to invalid data.");
}

function unsafe_data_error_message(){
    return error_message_json(400, "400 Bad Request: The submitted data contains invalid or malicious content.");
}

function file_message_error_messages( $string ){
	/**
	$string le message d'erreur associé
	*/
	return error_message_json(400, $string );
}

// 401 Unauthorized:
// Explanation: Indicates that the request has not been applied because it lacks valid authentication credentials.
// Example: Accessing a protected resource without providing valid authentication.
function authentification_required_error_message(){
    return error_message_json(401, "401 Unauthorized: Authentication required.");
}
// 403 Forbidden:
function permission_denied_error_message(){
    return error_message_json(403, "403 Forbidden: Permission denied.");
}
// Explanation: Indicates that the server understood the request, but it refuses to authorize it.
// Example: Trying to access a resource for which the user doesn't have the necessary permissions.

// 404 Not Found:
// Explanation: Indicates that the server cannot find the requested resource.
// Example: Accessing a URL that does not correspond to any existing resource.

// 405 Method Not Allowed:
// Explanation: Indicates that the method specified in the request is not allowed for the specified resource.
// Example: Sending a PUT request to an endpoint that only allows GET requests.

// 422 Unprocessable Entity
// Explanation: The request was well-formed but semantically incorrect.
function enforce_data_policy_error_message(){
    return error_message_json(422, "422 Unprocessable Entity: The data provided does not match our validation policy.");
};

function cant_be_used_data_error_message(){
    return error_message_json(422,"422 Unprocessable Entity: The data provided can't be chosen.");
}
// 500 Internal Server Error:
// Explanation: Indicates that the server encountered an unexpected condition that prevented it from fulfilling the request.
// Example: A script on the server encounters an error during execution.

// 503 Service Unavailable:
// Explanation: Indicates that the server is not ready to handle the request. Commonly used during maintenance or when the server is overloaded.
// Example: Temporarily shutting down a service for maintenance.



