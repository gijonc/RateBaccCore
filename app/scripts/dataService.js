var app = angular.module('ratemycourse');

app.factory('authService', function ($http) {
	var authService = {};
	//var root = window.location.host + "/RateBaccCore/code/";

	authService.login = function (credentials) {
		var URL = 'php/login.php';

		return $http
			.post(URL, credentials)
			.then(function (respond) {
				var user = respond.data;
				if(typeof user === 'object'){
					return user;
				}
			});
	};

	return authService;
});



app.factory('dataService', function ($http) {
	var myService = {
		async: function(url, data) {
	  		// $http returns a promise, which has a then function, which also returns a promise
		  	var promise = $http
		  			.post(url, data)
		  			.then(function (response) {
				    	// The return value gets picked up by the then in the controller.
				    	return response.data;
		  			});
		  	// Return the promise to the controller
		  	return promise;
		}
	};
	return myService;
});
