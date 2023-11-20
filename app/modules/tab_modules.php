<?php 
require_once "api/majors/major_module.php";
require_once "api/example/example_module.php";
require_once "api/users/user_module.php";
require_once "api/comments/comment_module.php";
require_once "api/years/year_module.php";
require_once "api/courses/course_module.php";
require_once "api/majors_courses_link/majors_courses_link_module.php";
require_once "api/subscriptions/subscription_module.php";
require_once "api/authors/author_module.php";




$modules = [
    "example" => $example_module,
    "user" => $user_module,
    "comment" => $comment_module,
    "major" => $major_module,
    "year" => $year_module,
    "course" => $course_module,
    "majors_courses_link" => $majors_courses_link_module,
    "subscription" => $subscription_module,
    "author" => $author_module
];