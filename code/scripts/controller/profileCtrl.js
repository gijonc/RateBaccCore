/*
	controller functions for profile page
*/

var app = angular.module('ratemycourse');

app.controller('profileCtrl', function($scope,$http,dataService){
	self.userID = sessionStorage.getItem('userId');
	$scope.userEmail = sessionStorage.getItem('email');
	$scope.userType = sessionStorage.getItem('userType');
	$scope.userSignT = sessionStorage.getItem('signup_t');
	$scope.update_check = false;
	$scope.dup_pswd = false;

	$scope.save = function() {
	  	var rawDATA = {
	  		userID: self.userID,
	      	password: $scope.password, // password -> password1
	      	re_password: $scope.re_password,
		};

	    if(checkValid(rawDATA)){
	      	update(rawDATA);
	    }  
  	};

  	function checkValid(data){
    	for (var i in data){
			var input = data[i];
			if (!input){
				alert(i + " is not defined");  // check empty input
				return false;
			}

      		switch(i){
        		case "password":
					if(input.length < 6){
			            alert("Minimum length of password is 6");
			            return false;
	          		}
          			break;

        		case "re_password":
					if(input !== data["password"]){
						alert("passwords not matched");
						return false;
					}
          			break;
      		}
    	}
    	return true;
  	};


  	function update(data){
	    var _URL = 'php/updateProfile';
		var r = '';
		dataService.async(_URL,data).then(function(d){
			if (d == 1)
				$scope.update_check = true;
			else if(d == 'duplicated')
				$scope.dup_pswd = true;
				$scope.password = null;
				$scope.re_password = null;
		});
  	};


});


