<?php
require_once "modules/module.php";
require_once "controlleur.php";


$dict = [
    "OPTION" => [
        "function" => 'option_user'
    ],
    "GET" => [ // TO DO
        "routes" => [
            // admin
            [   // /byuser/id_user/page/nb_by_page
                "params" => ["/byuser/","/[0-9]{1,}/","/[0-9]{1}/","/[0-9]{1,2}/"],
                "function" => 'get_by_user_page_amount_sorted_by_report'
            ],
            // public
            [   // /bypost/id_post/total
                "params" => ["/bypost/","/[0-9]{1,}/","/total/"],
                "function" => 'get_nb_total'
            ],
            [   // /bypost/id_post/total/parent
                "params" => ["/bypost/","/[0-9]{1,}/","/total/","/parent/"],
                "function" => 'get_nb_total_parent'
            ],
            [   // /bypost/id_post/total/enfantof/id_parent
                "params" => ["/bypost/","/[0-9]{1,}/","/total/","/enfantof/","/[0-9]{1,2}/"],
                "function" => 'get_nb_total_enfantof_parent'
            ],
            [   // /bypost/id_post/parent/page/nb_by_page
                "params" => ["/bypost/","/[0-9]{1,}/","/parent/","/[0-9]{1}/","/[0-9]{1,2}/"],
                "function" => 'get_parent_page_amount'
            ],
            [   // /bypost/id_post/enfantof/id_parent/page/nb_by_page
                "params" => ["/bypost/","/[0-9]{1,}/","/enfantof/", "/[0-9]{1,}/","/[0-9]{1,}/","/[0-9]{1,2}/"],
                "function" => 'get_enfant_of_parent_page_amount'
            ],
            // public authentification required
            [   // /me/total
                "params" => ["/me/","/total/"],
                "function" => 'get_nb_my'
            ],
            [   // /me/page/nb_by_page
                "params" => ["/me/","/[0-9]{1,}/","/[0-9]{1,2}/"],
                "function" => 'get_my_page_amount'
            ] 
        ]
    ],
    "POST" => [
        "routes" => [
            [
                "params" => [],
                "function" => 'make_comment'
            ],
            [   // /reply/id_comment_to_reply
                "params" => ["/reply/","/[0-9]{1,}/"]
            ]
        ]
        
    ],
    "PUT" => [
        // /id_comment
        "params" => ["/[0-9]{1,}/"],
        "function" => 'modify_my_comment'
    ],
    "DELETE" => [
        "routes" => [
            // admin or authentified
            [   // /id_comment
                "params" => ["/[0-9]{1,}/"],
                "function" => 'delete'
            ]
        ]
        
    ]
];

$user_module = new Module($dict);