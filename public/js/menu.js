/* Ce Javascript cherche l'entrée du menu qui correspond à l'URL du navigateur
*  et change sa classe CSS pour le mettre en avant
*  Les entrées du menu sont définis dans _template/menu.php
*  et tilisent des balises <a> : on cherche le href qui correspond à l'URL du navigateur.
*/
const div=document.querySelector(".menu div");
let currentPage=location.href.substr(location.href.lastIndexOf('/')+1);
// currentPage contient toute la partie qui suit le dernier / de l'URL : index.php?c=XXXX&a=YYYY&....
const query=currentPage.split("?"); // split sépare une chaîne en un tableau de chaînes ; la séparation se fait sur le caractère ?
if (query.length>1) { // vrai s'il existe une partie ? dans l'URL : c=XXXX&a=YYYY&....
    const params=query[1].split("&"); 
    /* seuls c et a nous intéressent ; on va donc parcourir tous les paramètres de l'URL
    *  la raison est la suivante : cette page pourrait vouloir prendre un paramètre supplémentaire p.ex. id=1
    *  ce paramètre permet de décider quelle information afficher/manipuler
    *  ce paramètre est variable, mais le <a href="..."> de menu.php est fixé une bonne fois pour toute
    *  Pour gérer ce cas, le a< href="..."> ignorera le paramètre id supplémentaire.
    *  De plus on mettra cette entrée du menu en hidden : elle n'est pas visible par défaut puisque le lien est incomplet.
    *  Pour trouver le bon <a> de menu.php il faut donc enlever les parties inutiles de la requête.
    */ 
    for(let i=params.length-1; i>=0; i--) {
        const param=params[i].split("=")[0]; // et on regarde ce qui est à gauche de l'=
        if (param!="c" && param!="a") { // si ce n'est ni c, ni a
            params.splice(i,1); // splice supprime à partir de l'indice i, 1 élément du tableau
        }
    }
    currentPage=query[0]+"?"+params.join("&"); // reconstruit l'URL après avoir éliminé les paramètres superflus
}
const currentA=div.parentElement.querySelectorAll("[href=\""+currentPage+"\"]")[0]; // trouve le lien
/* Ajoute menuSelected à sa classe CSS
*  Une entrée du menu dont classe CSS devient "hidden menuSelected" est rendu maintenant visible par sa règle CSS
*/
currentA.parentElement.setAttribute("class",currentA.parentElement.getAttribute("class")+" menuSelected"); 

/* Les <a> appartenant à un <li class="hidden"> doivent être désactivés puisque leur href est incomplet.
*  On va utiliser une astuce pour le faire un bonne fois pour toute :
*     - l'événement click n'est pas placé sur les liens <a>, mais bien sur le <body>
*       la fonction est activée peu importe où on clique sur le body
*     - event.target référence l'élément sur lequel le click a réellement eu lieu :
*       on va pouvoir vérifier qu'il a eu lieu sur une balise <a> dont l'élément parent possède la classe "hidden"
*       et dans ce cas utiliser event.preventDefault() pour empêcher le navigateur de suivre le lien.
*/
document.body.addEventListener('click', function (event) {
    if (event.target.nodeName == 'A' && event.target.parentElement.getAttribute("class").split(" ").indexOf("hidden")!=-1) {
      event.preventDefault();
    }
  });