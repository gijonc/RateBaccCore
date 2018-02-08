/*
  controller functions for Signup page
*/
var _ROLE = ['Instructor', 'Student'];


var app = angular.module('ratemycourse');

app.controller('signupCtrl', function($scope,$http, dataService){

  $scope.role = {
    model: null,
    options: _ROLE
  };


  $scope.signup = function() {

  	var rawDATA = {
      role: $scope.role.model,
      email: $scope.email, 
      password: $scope.password, // password -> password1
      re_password: $scope.re_password,
		};

    if(checkValid(rawDATA)){
      postDATA(rawDATA);
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
        case "email":
          break;

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

  // check exist values in sql
	function postDATA(data){
    var _URL = 'php/signup.php';

    dataService.async(_URL,data).then(function(d){
      if(d == 0){
        alert("This Email has been registered!");
        $scope.email = null;
      }else{
        $scope.signedup = 1;
      }
    });
  };


});






