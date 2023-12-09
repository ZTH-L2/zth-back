<?php
//Fichier CRUD pour la base de donnees 
// CREATE
// READ
// UPDATE
// DELETE


        
        
function create_author($conn, $id_user, $id_post){

/* fonction pour ajouter / creer un(e) new 'auteur'
     *              entree: element de connexion
     *                      toutes les variables: valeurs des colonnes
     *              sortie: sql request
*/

$sql = "INSERT INTO `authors`(`id_user`, `id_post`) VALUES('$id_user', '$id_post') ";
return mysqli_query($conn, $sql);
}
    
        
        
function update_author($conn, $id_user, $id_post, $id){

/* fonction pour update / modifier un(e) 'auteur' en fonction de l'id
 *              entree: element de connexion
 *                      toutes les variables: valeurs des colonnes
 *              sortie: sql request
 */

$sql = "UPDATE `authors` set `id_user`='$id_user', `id_post`='$id_post' WHERE`id_author`=$id";
return mysqli_query($conn, $sql);
}
    


function update_author_with_parameter($conn, $parameter_name, $parameter_value, $id){

/* fonction pour update / modifier un(e) 'auteur' en fonction d'un parametre
 *              entree: element de connexion
 *                      $parameter_name: nom du parametre a modifier
                        $parameter_value: valeur du parametre a modifier
 *              sortie: sql request
 */

$sql = "UPDATE `authors` set `$parameter_name`='$parameter_value' WHERE `id_author`=$id";
return mysqli_query($conn, $sql);
}
    


function select_author($conn, $id){

/* fonction pour selectionner un(e) 'auteur' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'auteur' a recuperer
     *              sortie: element
*/

$sql = "SELECT * FROM `authors` WHERE `id_author`=$id";
if($ret=mysqli_query($conn, $sql)){
    $ret=mysqli_fetch_assoc($ret);
}
return $ret;
}

function select_author_by_user($conn, $id){

     /* fonction pour selectionner un(e) 'auteur' en fonction de l'id
          *              entree: element de connexion
          *                      id: id de 'auteur' a recuperer
          *              sortie: element
     */
     
     $sql = "SELECT * FROM `authors` WHERE `id_user`=$id";
     $ret = mysqli_query($conn, $sql);
     return rs_to_tab($ret);
}

function select_author_by_post($conn, $id){

     /* fonction pour selectionner un(e) 'auteur' en fonction de l'id
          *              entree: element de connexion
          *                      id: id de 'auteur' a recuperer
          *              sortie: element
     */
     
     $sql = "SELECT * FROM `authors` WHERE `id_post`=$id";
     $ret = mysqli_query($conn, $sql);
     return rs_to_tab($ret);
}

function select_all_author($conn){

/* fonction pour selectionner tous les 'auteur' dans la table
     *              entree: element de connexion
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `authors`";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    

function select_all_author_with_parameter($conn, $parameter_name, $parameter_value){

/* fonction pour selectionner tous les 'auteur' dans la table en fonction d'un parametre
     *              entree: element de connexion
                            $parameter_name: nom de la colonne a utiliser pour la selection
                            $parameter_value: valeur que dans la colonne pour que la ligne soit selectionnee
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `authors` WHERE `$parameter_name`=$parameter_value";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    


function delete_author($conn, $id){

/* fonction pour supprimer un(e) 'auteur' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'auteur' a supprimer
     *              sortie: sql request
*/

$sql = "DELETE FROM `authors` WHERE `id_author`=$id";
return mysqli_query($conn, $sql);
}

function rs_to_tab($rs){
     // met le paramètre $rs sous forme de tableau 
      $tab=[]; 
      while($row=mysqli_fetch_assoc($rs)){
           $tab[]=$row;	
     }
      return $tab;
}

?>