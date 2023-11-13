
<?php
//Fichier CRUD pour la base de donnees 
// CREATE
// READ
// UPDATE
// DELETE


        
        
function create_report_post($conn, $id_user, $id_post, $report){

/* fonction pour ajouter / creer un(e) new 'report_post'
     *              entree: element de connexion
     *                      toutes les variables: valeurs des colonnes
     *              sortie: sql request
*/

$sql = "INSERT INTO `reports_posts`(`id_user`, `id_post`, `report`) VALUES('$id_user', '$id_post', '$report') ";
return mysqli_query($conn, $sql);
}
    
        
        
function update_report_post($conn, $id_user, $id_post, $report, $id){

/* fonction pour update / modifier un(e) 'report_post' en fonction de l'id
 *              entree: element de connexion
 *                      toutes les variables: valeurs des colonnes
 *              sortie: sql request
 */

$sql = "UPDATE `reports_posts` set `id_user`='$id_user', `id_post`='$id_post', `report`='$report' WHERE`id_report_post`=$id";
return mysqli_query($conn, $sql);
}
    


function update_report_post_with_parameter($conn, $parameter_name, $parameter_value, $id){

/* fonction pour update / modifier un(e) 'report_post' en fonction d'un parametre
 *              entree: element de connexion
 *                      $parameter_name: nom du parametre a modifier
                        $parameter_value: valeur du parametre a modifier
 *              sortie: sql request
 */

$sql = "UPDATE `reports_posts` set `$parameter_name`='$parameter_value' WHERE `id_report_post`=$id";
return mysqli_query($conn, $sql);
}
    


function select_report_post($conn, $id){

/* fonction pour selectionner un(e) 'report_post' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'report_post' a recuperer
     *              sortie: element
*/

$sql = "SELECT * FROM `reports_posts` WHERE `id_report_post`=$id";
if($ret=mysqli_query($conn, $sql)){
    $ret=mysqli_fetch_assoc($ret);
}
return $ret;
}
    

function select_all_report_post($conn){

/* fonction pour selectionner tous les 'report_post' dans la table
     *              entree: element de connexion
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `reports_posts`";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    

function select_all_report_post_with_parameter($conn, $parameter_name, $parameter_value){

/* fonction pour selectionner tous les 'report_post' dans la table en fonction d'un parametre
     *              entree: element de connexion
                            $parameter_name: nom de la colonne a utiliser pour la selection
                            $parameter_value: valeur que dans la colonne pour que la ligne soit selectionnee
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `reports_posts` WHERE `$parameter_name`=$parameter_value";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    


function delete_report_post($conn, $id){

/* fonction pour supprimer un(e) 'report_post' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'report_post' a supprimer
     *              sortie: sql request
*/

$sql = "DELETE FROM `reports_posts` WHERE `id_report_post`=$id";
return mysqli_query($conn, $sql);
}
?>