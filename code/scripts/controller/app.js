var app = angular.module('ratemycourse',  ['ngRoute']);
var _DIR = 'directives/';



app.config(function($routeProvider,$locationProvider){

  	$routeProvider
    	.when('/signup', {
            title: 'signup',
        	templateUrl : _DIR + 'signup.html',
        	controller  : 'signupCtrl'
    	})

        .when('/home', {
            title: 'home',
            templateUrl : _DIR + 'home.html',
            controller  : 'homeCtrl'
        })

        .when('/profile', {
            title: 'profile',
            templateUrl : _DIR + 'profile.html',
            controller  : 'profileCtrl'
        })

        .when('/course/:id', {
            templateUrl : _DIR + 'course.html',
            controller  : 'courseCtrl'
        })

        .when('/', {
            title: 'Login',
            templateUrl : _DIR + 'login.html',
            controller  : 'loginCtrl'
        })

        .otherwise({redirectTo:'/'})
        
        ;
        $locationProvider.hashPrefix('');
});

// main controller
app.controller('mainCtrl', function($scope, $location){
    $scope.$on('$viewContentLoaded', function() {

        var data = sessionStorage.getItem('islogin');
        var url = $location.url();

        if (url != '/signup'){
            if(!data)
                window.location = '#/';
        }

        var bg = angular.element( document.querySelector( '#bg' ) );

        if (data){
            bg.addClass('container');
            $("body").css('background-image','none');
            $("body").css('background-color','#DCDCDC');
        } else{
            $("body").css('background-image',"url('./images/study_login.jpg')");
        }
    });
});


// header directive
app.directive('header', function () {
    return {
        restrict: 'A', //This menas that it will be used as an attribute and NOT as an element. I don't like creating custom HTML elements
        replace: true,
        // scope: {user: '='}, // This is one of the cool things :). Will be explained in post.
        templateUrl: "directives/header.html",
        controller: ['$scope', 'authService', function ($scope, authService,$rootScope){
            $scope.currentUser = null;
            
            $scope.checklogin = function(){
                if(sessionStorage.islogin){
                    $scope.currentUser = sessionStorage;

                    return true;
                }
            }

            $scope.logout = function(){
                sessionStorage.clear();
                $scope.currentUser = null;
                window.location = '#/';

            }
        }]
    }
});


// footer directive
app.directive('footer', function () {
    return {
        templateUrl: "directives/footer.html",
        controller: ['$scope', '$location', function ($scope, $location){

            $scope.getPage = function(){
                var cur_url = $location.url()
                var d = document.getElementById("pageInfo");

                if (cur_url.search("course")){
                    $scope.pageHeader = "Course";
                    $scope.pageInfo = "Users can rate a course by its difficulty and overall score," + 
                                    "users can post a comment to a specific course, Before giving a post," +
                                    "users must enter the term and year they took the class," +
                                    "Instructor and comment are optional for a post" +
                                    "Users can see the basic information of any course (including course credit, overall difficulty, overall score, class category, description and the link to the official website)," +
                                    "Users can only rate once to each course," +
                                    "Users can delete/edit his/her post," +
                                    "Users can ask as many as they want questions about a specific course," +
                                    "Users can answer for the questions," +
                                    "Users can delete their questions," +
                                    "Users cannot delete or edit their answers.";
                }

                switch (cur_url) {
                    case "/":
                        $scope.pageHeader = "Login";
                        $scope.pageInfo = "Users can only signup/login with a valid and unique email address";
                        break;

                    case "/signup":
                        $scope.pageHeader = "Sign-up";
                        $scope.pageInfo = "Users can only signup/login with a valid and unique email address";
                        break;
                    case "/profile":
                        $scope.pageHeader = "Profile";
                        $scope.pageInfo = "Users can change their passwords.";
                        break;
                    case "/home":
                        $scope.pageHeader = "Home";
                        $scope.pageInfo = "Users can search all available courses.";
                        break;
                }
            }

        }]
    }
});