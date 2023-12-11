<?php
require_once "modules/module.php";
require_once "controlleur.php";

$dict = [
    "OPTIONS" => [
        "function" => 'option_comment'
    ],
    "GET" => [ // TO DO
        "routes" => [
            // admin
            [   // /byuser/id_user/page/nb_by_page
                "params" => ["/^byuser$/","/^[0-9]{1,}$/","/^[0-9]{1}$/","/^[0-9]{1,2}$/"],
                "function" => 'get_by_user_page_amount_sorted_by_report'
            ],
            // public - by post 
            [   // /id_post/total
                "params" => ["/^[0-9]{1,}$/","/^total$/"],
                "function" => 'get_nb_total'
            ],
            [   // /id_post/total/parent
                "params" => ["/^[0-9]{1,}$/","/^total$/","/^parent$/"],
                "function" => 'get_nb_total_parent'
            ],
            [   // /id_post/total/enfantof/id_parent
                "params" => ["/^[0-9]{1,}$/","/^total$/","/^enfantof$/","/^[0-9]{1,2}$/"],
                "function" => 'get_nb_total_enfantof_parent'
            ],
            [   // /id_post/parent/page/nb_by_page
                "params" => ["/^[0-9]{1,}$/","/^parent$/","/^[0-9]{1}$/","/^[0-9]{1,2}$/"],
                "function" => 'get_parent_page_amount'
            ],
            [   // /id_post/enfantof/id_parent/page/nb_by_page
                "params" => ["/^[0-9]{1,}$/","/^enfantof$/", "/^[0-9]{1,}$/","/^[0-9]{1,}$/","/^[0-9]{1,2}$/"],
                "function" => 'get_enfant_of_parent_page_amount'
            ],
            // public authentification required
            [   // /me/total
                "params" => ["/^me$/","/^total$/"],
                "function" => 'get_nb_my'
            ],
            [  // Authentification required
                // /my//page/nb_by_page
                "params" => ["/^me$/","/^[0-9]{1}$/","/^[0-9]{1,2}$/"],
                "function" => 'get_my_comments_page_amount_sorted_by_likes' 
            ]
        ]
    ],
    "POST" => [
        "params" => [],
        "function" => 'make_comment'
    ],
    "PUT" => [
        "params" => [],
        "function" => 'modify_my_comment'
    ],
    "DELETE" => [
        "routes" => [
            // admin or authentified
            [   // /id_comment
                "params" => ["/^[0-9]{1,}$/"],
                "function" => 'delete'
            ]
        ]
        
    ]
];

$comment_module = new Module($dict);