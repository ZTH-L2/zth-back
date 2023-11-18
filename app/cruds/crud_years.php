<?php
//Fichier CRUD pour la base de donnees 
// CREATE
// READ
// UPDATE
// DELETE


        
        
function create_year($conn, $name){

/* fonction pour ajouter / creer un(e) new 'year'
     *              entree: element de connexion
     *                      toutes les variables: valeurs des colonnes
     *              sortie: sql request
*/

$sql = "INSERT INTO `years`(`name`) VALUES('$name') ";
return mysqli_query($conn, $sql);
}
    
        
        
function update_year($conn, $name, $id){

/* fonction pour update / modifier un(e) 'year' en fonction de l'id
 *              entree: element de connexion
 *                      toutes les variables: valeurs des colonnes
 *              sortie: sql request
 */

$sql = "UPDATE `years` set `name`='$name' WHERE`id_year`=$id";
return mysqli_query($conn, $sql);
}
    


function update_year_with_parameter($conn, $parameter_name, $parameter_value, $id){

/* fonction pour update / modifier un(e) 'year' en fonction d'un parametre
 *              entree: element de connexion
 *                      $parameter_name: nom du parametre a modifier
                        $parameter_value: valeur du parametre a modifier
 *              sortie: sql request
 */

$sql = "UPDATE `years` set `$parameter_name`='$parameter_value' WHERE `id_year`=$id";
return mysqli_query($conn, $sql);
}
    


function select_year($conn, $id){

/* fonction pour selectionner un(e) 'year' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'year' a recuperer
     *              sortie: element
*/

$sql = "SELECT * FROM `years` WHERE `id_year`=$id";
if($ret=mysqli_query($conn, $sql)){
    $ret=mysqli_fetch_assoc($ret);
}
return $ret;
}
    

function select_all_year($conn){

/* fonction pour selectionner tous les 'year' dans la table
     *              entree: element de connexion
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `years`";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    

function select_all_year_with_parameter($conn, $parameter_name, $parameter_value){

/* fonction pour selectionner tous les 'year' dans la table en fonction d'un parametre
     *              entree: element de connexion
                            $parameter_name: nom de la colonne a utiliser pour la selection
                            $parameter_value: valeur que dans la colonne pour que la ligne soit selectionnee
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `years` WHERE `$parameter_name`=$parameter_value";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    


function delete_year($conn, $id){

/* fonction pour supprimer un(e) 'year' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'year' a supprimer
     *              sortie: sql request
*/

$sql = "DELETE FROM `years` WHERE `id_year`=$id";
return mysqli_query($conn, $sql);
}
?>