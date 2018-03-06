/*
	controller functions for login page
*/

var app = angular.module('ratemycourse');

app.controller('homeCtrl',['$scope','$http', function($scope,$http){
	$scope.courses = '';
	$scope.result = '';

	const BASE_URL = 'http://localhost:8000/';
	const DATA_DIR = 'rateMyBaccCore/api/public/';


  	$scope.load = function(){
		var TABLE = "COURSE";
		var route = "courses/";
		const _URL = BASE_URL + DATA_DIR + route;

  		$scope.loading = true;
  		$http({
			method: 'GET',
			url: _URL,

		}).then(function (response) {
			$scope.courses = response.data[TABLE];
			
		}, function (response) {
			// on error
			console.log(response.data,response.status);
		});
  	}
  	$scope.search = function(n){
  		// Declare variables 
  		var input, filter, table, tr, td, i;
  		input = document.getElementById("myInput");
  		filter = input.value.toUpperCase();
  		table = document.getElementById("myTable");
  		tr = table.getElementsByTagName("tr");

  		// Loop through all table rows, and hide those who don't match the search query
  		for (i = 0; i < tr.length; i++) {
    		td0 = tr[i].getElementsByTagName("td")[0];
    		td1 = tr[i].getElementsByTagName("td")[1];
    		if (td0 || td1) {
      			if (td0.innerHTML.toUpperCase().indexOf(filter) > -1 || td1.innerHTML.toUpperCase().indexOf(filter) > -1) {
        			tr[i].style.display = "";
      			} else {
        			tr[i].style.display = "none";
      			}
    		}
  		}
  	}


  	$scope.gotoCourse = function(courseId){
  		window.location = '#/course/' + courseId;
  	}

}]);


