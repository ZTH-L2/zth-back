<?php 
require_once "api/majors/major_module.php";
require_once "api/example/example_module.php";
require_once "api/users/user_module.php";
require_once "api/comments/comment_module.php";
require_once "api/likes/like_module.php";
require_once "api/reports_comments/report_comment_module.php";
require_once "api/courses/course_module.php";
require_once "api/majors_courses_link/majors_courses_link_module.php";
require_once "api/subscriptions/subscription_module.php";
require_once "api/authors/author_module.php";
require_once "api/grades/grade_module.php";
require_once "api/posts/post_module.php";
require_once "api/data/data_module.php";


$modules = [
    "example" => $example_module,
    "user" => $user_module,
    "comment" => $comment_module,
    "likes" => $like_module,
    "report_comment" => $report_comment_module,
    "major" => $major_module,
    "course" => $course_module,
    "majors_courses_link" => $majors_courses_link_module,
    "subscription" => $subscription_module,
    "author" => $author_module,
    "grade" => $grade_module,
    "post" => $post_module,
    "data" => $data_module
];