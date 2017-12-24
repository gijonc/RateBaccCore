/*
	controller functions for login page
*/

var app = angular.module('ratemycourse');


app.controller('loginCtrl', function($scope, $http, authService, $rootScope){

	$scope.input_error = false;

	$scope.$on('$viewContentLoaded', function() {
    	var data = sessionStorage.getItem('islogin');
    	if (data !== null){
    		window.location = '#home';
    	}
	});


	$scope.credentials = {
		username: '',
		password: ''
	};

	$scope.login = function(credentials) {
		if (credentials){
			if (credentials['username'] === '' || credentials['password'] === ''){
				$scope.input_error = true;
			} else {

				authService.login(credentials).then(function (user) {
					if (user){
						sessionStorage.setItem('email',user.uEmail);
						sessionStorage.setItem('userId',user.uID);
						sessionStorage.setItem('islogin',1);
						sessionStorage.setItem('userType',user.uType);
						sessionStorage.setItem('signup_t',user.signup_t);

						window.location = '#home'; 

					} else {
						$scope.input_error = true;
					}
		    	}, function () {});
			}
			
		}
		
  	};

});

