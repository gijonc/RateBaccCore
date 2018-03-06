<?php
class Course {
	private ID;
	private CreditNum;
	private Difficulty;
	private RecommondationLv
	private CourseCategory
	private CourseDescription;
	private CourseName;

    public function Course ( $data = array() ) {
        foreach ( $data as $key => $value ) {
            $this->$key = $value;
        }
	}
	
	public function getID() { return $this->ID; }
	public function getCreditNum() { return $this->CreditNum; }
	public function getDifficulty() { return $this->Difficulty; }
	public function getRecommondationLv() { return $this->RecommondationLv; }
	public function getCourseCategory() { return $this->CourseCategory; }
	public function getCourseDescription() { return $this->CourseDescription; }
	public function getCourseName() { return $this->CourseName; }

}


?>