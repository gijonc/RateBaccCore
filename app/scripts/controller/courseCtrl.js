// global vars

var _DIFF = [
	{name: 'Very Easy', value: '2'},
	{name: 'Easy', value: '4'},
	{name: 'Normal', value: '6'},
	{name: 'Hard', value: '8'},
	{name: 'Very Hard', value: '10'}
];

var _TERM = ['fall', 'winter', 'spring', 'summer'];


// course page controller
var app = angular.module('ratemycourse');

app.controller('courseCtrl', function($scope, $http, $routeParams, dataService){

	// init params
	var self = this;
	self.courseID = $routeParams.id; 
	self.userID = sessionStorage.getItem('userId');
	self.commentID = -1;

	$scope.course = '';
	$scope.comment = '';
	$scope.not_post_before = true;	// check if user has posted before
	$('#success_alert').hide();
	$('#fail_alert').hide();

	$scope.load = function(){
		reloadpage();

	};

/*--------------------------------------------------
					POST COMMENT FUNCTIONS
--------------------------------------------------*/
	// init user post
	$scope.post_term = {
		model: null,
		options: _TERM
	};
	$scope.post_year = {
		model: null,
		options: getRange(2010, new Date().getFullYear())
	};
	$scope.post_diff = {
		model:null,
		options: _DIFF
	};
	$scope.post_score = {
		model:null,
		options: getRange(1,10)
	};
	$scope.post_text = {
		model:null
	};
	$scope.post_instr = {
		model:null
	};

	$scope.comment_post_btn = function(){
		var rawDATA = {
			term:	$scope.post_term.model,
			year:	$scope.post_year.model,
			instructor:	$scope.post_instr.model,
			reclv: 	$scope.post_score.model,
			diff:	$scope.post_diff.model,
			text: 	$scope.post_text.model,
			courseId: 	self.courseID,
			userId: 	self.userID
		};

		if(checkValidPost(rawDATA)){
			var request = $http({
				method: 'POST',
				url: 'php/postComment.php',
				data: rawDATA,
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			});

		    request.success(function (response) {// on success

		    	document.getElementById("success_alert_text").innerHTML = "Your post has been posted!";
		        $('#success_alert').fadeIn('slow');
				setTimeout(function(){
			        $('#success_alert').fadeOut('slow');
			    },1500);
				reloadpage();

		    }, function (response) {

		    });
		}
	}

	function checkValidPost(data){
		var input = '';
		for (var i in data){
			if (i === 'term' || 
				i === 'year' || 
				i === 'reclv' || 
				i === 'diff')
			{
				input = data[i];
				if(!input){
					alert(i,input);
					return false;
				}
			}
		}
		return true;
	}

/*--------------------------------------------------
				COURSE INFO FUNCTIONS
--------------------------------------------------*/
	// more detail to osu page
	$scope.getDetail = function(code, num){
		window.location = 'http://catalog.oregonstate.edu/CourseDetail.aspx?SubjectCode=' + code + '&CourseNumber=' + num;
	};

	$scope.getDiff =function(d){
		if(d<2){return '(Very Easy)';}
		else if(d<4){return '(Easy)';}
		else if(d<6){return '(Normal)';}
		else if(d<8){return '(Hard)';}
		else if(d<10){return '(Very Hard)';}
		else return '';
	}

	var loadCourseInfo = function(cid){
		var _URL = 'php/listCourse.php';
		var _DATA = {id: cid};
		var r = '';
		dataService.async(_URL,_DATA).then(function(d){
			$scope.course = d[0];
			$scope.course.name = capitalizeFirstLetter($scope.course.name,true);
		});
	};;


/*--------------------------------------------------
				COMMENT LIST FUNCTIONS
--------------------------------------------------*/
	var loadComment = function(cid){
		var _URL = 'php/getComment.php';
		var _DATA = {id: cid};
		dataService.async(_URL,_DATA).then(function(d){
			$scope.commentList = d;
			for (c in $scope.commentList){
				if (self.userID === $scope.commentList[c].uID){
					self.commentID = $scope.commentList[c].cmID;

					this_comment = $scope.commentList[c];
					$scope.post_term.model = this_comment.cmTermTook;
					$scope.post_year.model = this_comment.cmYearTook;
					$scope.post_year.post_instr = this_comment.cmInst;
					$scope.post_score.model = this_comment.cmRecLv;
					$scope.post_diff.model = this_comment.cmDiff;
					$scope.post_text.model = this_comment.cmText;
					$scope.post_instr.model = this_comment.cmInst;
					$scope.not_post_before = false;

					break;
				}
			}
		});
	};

	$scope.userPostHandle = function(uid){
		if (self.userID === uid)
			return true;
		else
			return false;
	}

	$scope.update_post = function(cmId){
		var _URL = 'php/updateComment.php';

		var _DATA = {
			action: 'edit',
			comment_id: self.commentID,

			term:	$scope.post_term.model,
			year:	$scope.post_year.model,
			instructor:	$scope.post_instr.model,
			reclv: 	$scope.post_score.model,
			diff:	$scope.post_diff.model,
			text: 	$scope.post_text.model
		};

		dataService.async(_URL,_DATA).then(function(d){
   			$('#commentModal').modal('toggle');
			reloadpage();
		    
	        document.getElementById("success_alert_text").innerHTML = "Your post has been updated!";
	        $('#success_alert').fadeIn('slow');
			setTimeout(function(){
		        $('#success_alert').fadeOut('slow');
		    },1500);
			reloadpage();
		});
	}

	$scope.del_btn = function(){
		var _URL = 'php/updateComment.php';
		var _DATA = {comment_id: self.commentID, action:'delete'};
		dataService.async(_URL,_DATA).then(function(d){
			if (d === '1'){
				$scope.not_post_before = true;

		        document.getElementById("success_alert_text").innerHTML = "Your post has been deleted!";
		        $('#success_alert').fadeIn('slow');
				setTimeout(function(){
			        $('#success_alert').fadeOut('slow');
			    },1500);
				reloadpage();

			} else{
				alert(d);
			}
			
		});
	}




/*--------------------------------------------------
				QUESTION LIST FUNCTIONS
--------------------------------------------------*/
	var loadQuestion = function(cid){
		var _URL = 'php/getQuestion.php';
		var _DATA = {cId: cid, action: 'question'};

		dataService.async(_URL,_DATA).then(function(q){
			$scope.questionList = q;

			for (var i = 0; i < $scope.questionList.length; i++){
				// load answers to corresponding questions
				var json_answer = JSON.parse($scope.questionList[i].answer);
				$scope.questionList[i].answer = json_answer;
				$scope.questionList[i].replyNum = $scope.questionList[i].answer.length;
			}

		});
	};

	$scope.question_text = '';
	$scope.question_post_btn = function(){
		var _URL = 'php/postQuestion.php';

		var rawDATA = {
			action: 'post',
			qText: 		$scope.question_text,
			courseId: 	self.courseID,
			userId: 	self.userID
		};
		if($scope.question_text){

			dataService.async(_URL,rawDATA).then(function(d){
	   			if (d == 1){
	   				// success
	   				$scope.question_text = '';

	   				document.getElementById("success_alert_text").innerHTML = "Your question has been posted!";
			        $('#success_alert').fadeIn('slow');
					setTimeout(function(){
				        $('#success_alert').fadeOut('slow');
				    },1500);
					reloadpage();
		   		}
			});

		}else{
			alert("text cannot be empty");
		}
	}

	$scope.ques_del_btn = function(qId){
		var _URL = 'php/postQuestion.php';
		var _DATA = {question_id: qId, action:'delete'};

		dataService.async(_URL,_DATA).then(function(d){
			if (d == 1){
				
				document.getElementById("success_alert_text").innerHTML = "Your question has been deleted!";
		        $('#success_alert').fadeIn('slow');
				setTimeout(function(){
			        $('#success_alert').fadeOut('slow');
			    },1500);
				reloadpage();

				
			} else{
				alert(d);
			}
		});
	}

	$scope.answer_post_btn = function(qid,a){
		var _URL = 'php/postAnswer.php';

		var rawDATA = {
			action: 		"post",
			aText: 			a,
			questionId: 	qid,
			userId: 		self.userID
		};

		if(a){

			dataService.async(_URL,rawDATA).then(function(d){
	   			if (d == 1){
	   				// success
	   				a = '';
	   				
	   				document.getElementById("success_alert_text").innerHTML = "Your reply has been posted!";
			        $('#success_alert').fadeIn('slow');
					setTimeout(function(){
				        $('#success_alert').fadeOut('slow');
				    },1500);
					reloadpage();
	   			}
			});

		}else{
			alert("text cannot be empty");
		}
	}

/*--------------------------------------------------
				OTHER HELPER FUNCTIONS
--------------------------------------------------*/
	function getRange(start, end) {
	    var foo = [];
	    for (var i = start; i <= end; i++) {
	        foo.push(i);
	    }
	    return foo;
	}

	function capitalizeFirstLetter(string,all) {
		if(all)
	    	return string.toUpperCase();
	    else
	    	return string.charAt(0).toUpperCase() + string.slice(1);
	}

	function reloadpage() {
		loadCourseInfo(self.courseID);
		loadComment(self.courseID);
		loadQuestion(self.courseID);
	}

});

