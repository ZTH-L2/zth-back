<?php
function create_user($conn, $mail, $username, $password, $permission, $restricted, $first_connexion, $data_size){

/* fonction pour ajouter / creer un(e) new 'user'
     *              entree: element de connexion
     *                      toutes les variables: valeurs des colonnes
     *              sortie: sql request
*/
$sql = "INSERT INTO `users`(`mail`, `username`, `password`, `permission`, `restricted`, `first_connexion`, `data_size`) VALUES('$mail', '$username', '$password', '$permission', '$restricted', '$first_connexion', '$data_size') ";
return mysqli_query($conn, $sql);
}
    
        
        
function update_user($conn, $mail, $username, $password, $permission, $restricted, $first_connexion, $data_size, $id){

/* fonction pour update / modifier un(e) 'user' en fonction de l'id
 *              entree: element de connexion
 *                      toutes les variables: valeurs des colonnes
 *              sortie: sql request
 */

$sql = "UPDATE `users` set `mail`='$mail', `username`='$username', `password`='$password', `permission`='$permission', `restricted`='$restricted', `first_connexion`='$first_connexion', `data_size`='$data_size' WHERE`id_user`=$id";
return mysqli_query($conn, $sql);
}
    
function update_data_user($conn, $data_size, $id){
     $sql = "UPDATE `users` SET `data_size`= `data_size` + '$data_size' WHERE`id_user`=$id";
     return mysqli_query($conn, $sql);
}

function update_user_with_parameter($conn, $parameter_name, $parameter_value, $id){

/* fonction pour update / modifier un(e) 'user' en fonction d'un parametre
 *              entree: element de connexion
 *                      $parameter_name: nom du parametre a modifier
                        $parameter_value: valeur du parametre a modifier
 *              sortie: sql request
 */

$sql = "UPDATE `users` set `$parameter_name`='$parameter_value' WHERE `id_user`=$id";
return mysqli_query($conn, $sql);
}
    


function select_user($conn, $id){

/* fonction pour selectionner un(e) 'user' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'user' a recuperer
     *              sortie: element
*/

$sql = "SELECT * FROM `users` WHERE `id_user`=$id";
if($ret=mysqli_query($conn, $sql)){
    $ret=mysqli_fetch_assoc($ret);
}
return $ret;
}

function select_all_user($conn, $amount_per_page, $page){
     $offset = ($page-1)*$amount_per_page;
     $sql = "SELECT `id_user`, `mail`, `username`, `permission`, `restricted`, `first_connexion`, `data_size` FROM `users` ORDER BY `id_user` DESC LIMIT $amount_per_page OFFSET $offset";
     if ($res = mysqli_query($conn, $sql))
     {
          $res = mysqli_fetch_all($res, MYSQLI_ASSOC);
     }
     return $res;
}

function select_user_name($conn, $id){

     /* fonction pour selectionner un(e) 'user' en fonction de l'id
          *              entree: element de connexion
          *                      id: id de 'user' a recuperer
          *              sortie: element
     */
     
     $sql = "SELECT `username` FROM `users` WHERE `id_user`=$id";
     if($ret=mysqli_query($conn, $sql)){
         $ret=mysqli_fetch_assoc($ret);
     }
     return $ret;
     }

function select_user_by_username($conn, $username){

     /* fonction pour selectionner un(e) 'user' en fonction de username
          *              entree: element de connexion
          *                      username: username de 'user' a recuperer
          *              sortie: element
     */
     
     $sql = "SELECT * FROM `users` WHERE `username`='$username'";
     if($ret=mysqli_query($conn, $sql)){
         $ret=mysqli_fetch_assoc($ret);
     }
     return $ret;
}
// This is not really secure / usefull to get all user

// function select_all_user($conn){

// /* fonction pour selectionner tous les 'user' dans la table
//      *              entree: element de connexion
//      *              sortie: tableau d'elements
// */

// $sql = "SELECT * FROM `users`";
// $ret=mysqli_fetch_all(mysqli_query($conn, $sql));
// return $ret ;
// }
    

function select_all_user_with_parameter($conn, $parameter_name, $parameter_value){

/* fonction pour selectionner tous les 'user' dans la table en fonction d'un parametre
     *              entree: element de connexion
                            $parameter_name: nom de la colonne a utiliser pour la selection
                            $parameter_value: valeur que dans la colonne pour que la ligne soit selectionnee
     *              sortie: tableau d'elements
*/
$parameter_value_string = strval($parameter_value);
$sql = "SELECT * FROM `users` WHERE `$parameter_name`='$parameter_value' ";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    


function delete_user($conn, $id){

/* fonction pour supprimer un(e) 'user' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'user' a supprimer
     *              sortie: sql request
*/

$sql = "DELETE FROM `users` WHERE `id_user`=$id";
return mysqli_query($conn, $sql);
}
?>