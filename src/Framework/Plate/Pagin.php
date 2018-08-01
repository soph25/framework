<?php
namespace App\Plate;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class Pagin implements ExtensionInterface{

public function register(Engine $engine)
    {
        $engine->registerFunction('pagin', [$this, 'pagin']);
        
    }

public function pagin($url, $link, $total, $current, $adj=3) {
	// Initialisation des variables
	$prev = $current - 1; // numéro de la page précédente
	$next = $current + 1; // numéro de la page suivante
	$penultimate = $total - 1; // numéro de l'avant-dernière page
	$pagination = ''; // variable retour de la fonction : vide tant qu'il n'y a pas au moins 2 pages
        $courante = '';
	if ($total > 1) {
		// Remplissage de la chaîne de caractères à retourner
		$pagination .= "<ul class=\"pagination pagination-lg\">\n<li class=\"page-item \">\n";
                //$pagination .= "<span class=\"page-link\">\n<ul class=\"pagination pagination-lg\"><li class=\"page-item \">\n";
		/* =================================
		 *  Affichage du bouton [précédent]        pagination pagination-md   class=\"pagination pagination-md\"
		 * ================================= */
		if ($current == 2) {
			// la page courante est la 2, le bouton renvoie donc sur la page 1, remarquez qu'il est inutile de mettre $url{$link}1
			$pagination .= " <a href=\"{$url}\">◄</a>";
		} elseif ($current > 2) {
			// la page courante est supérieure à 2, le bouton renvoie sur la page dont le numéro est immédiatement inférieur
                        //$current .= "<li class=\"page-item active\">$current</li>";    
			$pagination .= " <a href=\"{$url}{$link}{$prev}\">◄</a>";
		} else {
			// dans tous les autres, cas la page est 1 : désactivation du bouton [précédent]
			$pagination .= '<span class="page-link">◄</span>';
		}
		/**       <span class="sr-only">(current)</span>
		 * Début affichage des pages, l'exemple reprend le cas de 3 numéros de pages adjacents (par défaut) de chaque côté du numéro courant
		 * - CAS 1 : il y a au plus 12 pages, insuffisant pour faire une troncature
		 * - CAS 2 : il y a au moins 13 pages, on effectue la troncature pour afficher 11 numéros de pages au total
		 */
		/* ===============================================
		 *  CAS 1 : au plus 12 pages -> pas de troncature
		 * =============================================== */
		if ($total < 7 + ($adj * 2)) {
			// Ajout de la page 1 : on la traite en dehors de la boucle pour n'avoir que index.php au lieu de index.php?p=1 et ainsi éviter le duplicate content
			$pagination .= ($current == 1) ? '<a class="active">1</a>' : "<a href=\"{$url}\">1</a>"; // Opérateur ternaire : (condition) ? 'valeur si vrai' : 'valeur si fausse'
			// Pour les pages restantes on utilise itère
			for ($i=2; $i<=$total; $i++) {
				if ($i == $current) {
					// Le numéro de la page courante est mis en évidence (cf. CSS)
					$pagination .= "<span class=\"page-link\">{$i}</span>";
				} else {
					// Les autres sont affichées normalement
					$pagination .= "<a href=\"{$url}{$link}{$i}\">{$i}</a>";
				}
			}
		}
		/* =========================================
		 *  CAS 2 : au moins 13 pages -> troncature
		 * ========================================= */
		else {
			/**
			 * Troncature 1 : on se situe dans la partie proche des premières pages, on tronque donc la fin de la pagination.
			 * l'affichage sera de neuf numéros de pages à gauche ... deux à droite
			 * 1 2 3 4 5 6 7 8 9 … 16 17
			 */
			if ($current < 2 + ($adj * 2)) {
				// Affichage du numéro de page 1
				$pagination .= ($current == 1) ? "<a class=\"active\">1</a>" : "<a href=\"{$url}\">1</a>";
				// puis des huit autres suivants
				for ($i = 2; $i < 4 + ($adj * 2); $i++) {
					if ($i == $current) {
						$pagination .= "<a class=\"active\">{$i}</a>";
					} else {
						$pagination .= "<a href=\"{$url}{$link}{$i}\">{$i}</a>";
					}
				}
				// ... pour marquer la troncature
				$pagination .= '<a>...</a>';
				// et enfin les deux derniers numéros
				$pagination .= "<a href=\"{$url}{$link}{$penultimate}\">{$penultimate}</a>";
				$pagination .= "<a href=\"{$url}{$link}{$total}\">{$total}</a>";
			}
			/**
			 * Troncature 2 : on se situe dans la partie centrale de notre pagination, on tronque donc le début et la fin de la pagination.
			 * l'affichage sera deux numéros de pages à gauche ... sept au centre ... deux à droite
			 * 1 2 … 5 6 7 8 9 10 11 … 16 17
			 */
			elseif ( (($adj * 2) + 1 < $current) && ($current < $total - ($adj * 2)) ) {
				// Affichage des numéros 1 et 2
				$pagination .= "<a href=\"{$url}\">1</a>";
				$pagination .= "<a href=\"{$url}{$link}2\">2</a>";
				$pagination .= '<a>...</a>';
				// les pages du milieu : les trois précédant la page courante, la page courante, puis les trois lui succédant
				for ($i = $current - $adj; $i <= $current + $adj; $i++) {
					if ($i == $current) {
						$pagination .= "<a class=\"active\">{$i}</a>";
					} else {
						$pagination .= "<a href=\"{$url}{$link}{$i}\">{$i}</a>";
					}
				}
				$pagination .= '<a>...</a>';
				// et les deux derniers numéros
				$pagination .= "<a href=\"{$url}{$link}{$penultimate}\">{$penultimate}</a>";
				$pagination .= "<a href=\"{$url}{$link}{$total}\">{$total}</a>";
			}
			/**
			 * Troncature 3 : on se situe dans la partie de droite, on tronque donc le début de la pagination.
			 * l'affichage sera deux numéros de pages à gauche ... neuf à droite
			 * 1 2 … 9 10 11 12 13 14 15 16 17
			 */
			else {
				// Affichage des numéros 1 et 2
				$pagination .= "<a href=\"{$url}\">1</a>";
				$pagination .= "<a href=\"{$url}{$link}2\">2</a>";
				$pagination .= '<a>...</a>';
				// puis des neuf derniers numéros
				for ($i = $total - (2 + ($adj * 2)); $i <= $total; $i++) {
					if ($i == $current) {
						$pagination .= "<a class=\"active\">{$i}</a>";
					} else {
						$pagination .= "<a href=\"{$url}{$link}{$i}\">{$i}</a>";
					}
				}
			}
		}
		/* ===============================
		 *  Affichage du bouton [suivant]
		 * =============================== */
		if ($current == $total)
			$pagination .= "<a class=\"inactive\">►</a>\n";
		else
			$pagination .= "<a href=\"{$url}{$link}{$next}\">►</a>\n";
		// Fermeture de la <div> d'affichage
		$pagination .= "</span></li></ul>\n";
	}
	return ($pagination);
}

}
?>
