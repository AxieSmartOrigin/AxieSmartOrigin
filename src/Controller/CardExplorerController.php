<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\CardType;
use App\Repository\CardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/card/explorer")
 */
class CardExplorerController extends AbstractController
{
    /**
     * @Route("/", name="app_card_explorer_browse", methods={"GET"})
     */
    public function browse(CardRepository $cardRepository, Request $request): Response
    {
       
        //Sur cette page, je veux afficher les cartes du jeu et pouvoir trier les cartes à afficher.
        
        //Dans un premier temps je regarde si des filtres sont présents dans l'URL:
        //  - Si oui, je traite et decoupe les filtres individuellements pour les mettres dans un tableau;
        //  - Si non, je vais charger toutes les cartes depuis le Repository
        
        if (isset( $_SERVER['QUERY_STRING'])) {

            $queries = $_SERVER['QUERY_STRING'];
            $queriesStrings = explode('&', $queries);

            $queriesFilters = [];
            $i=-1;
            foreach ($queriesStrings as $key => $value) {
                $i++;
                $new = explode('=', $value);
                $queriesFilters[$i] = array($new[0] => $new[1]);
            }
            
            // $queriesFilters est un tableau contenant tout les filtres reçus.

            // Je créé le tableau $criteria qui contient les filtres pertinents pour le tri des cartes,
            // cela va me permettre d'ignorer tout les filtres qui n'ont rien à voir avec les cartes
            $criteria = array('class', 'part', 'cost', 'tag');
   
            foreach ($queriesFilters as $key => $tabl) {
                foreach ($tabl as $query => $value) {

                    if (array_search($query,$criteria) === false) {
                        unset($queriesFilters[$key]);
                    }
                }
            }
            $queriesFilters = array_values($queriesFilters);
            dump($queriesFilters);
            // $queriesFilters ne contient maintenant que les filtres intéressants avec la valeur associé
            /*
            Exemple: pour "/?class=Aquatic&oui=non&part=Horn&cost=1"

            array(3) {  [0]=> array(1) { ["class"]=> string(7) "Aquatic" } 
                        [1]=> array(1) { ["part"]=> string(4) "Horn" }
                        [2]=> array(1) { ["cost"]=> string(1) "1" } 
                    }
            */

            // Maintenant je récupère toutes les cartes depuis la base de donnée,
            // je crée également un tableau $cards[] dans lequel je mettrais les cartes validées par les filtres
            $cardsFetched = $cardRepository->findAllOrder();
            $cards = [];

            // Je commence le traitement de chaque carte:
            foreach ($cardsFetched as $card) {

                // $compareArray va me permettre de conserver la valeur true aux filtres qui match avec la carte
                $compareArray = 
                ['class' => null,
                 'part' => null,
                 'cost' => null,
                 'tag' => null];

                // Dans cette boucle, on vérifie que les filtres matchs avec la carte,
                // On oublie pas qu'un filtre peut avoir plusieurs valeurs ex:"/?class=Aquatic&class=Beast&part=Horn"
                // Je veux donc que le filtre 'class' soit sur true si au moins un des deux filtres matchs la class de la carte.
                foreach ($queriesFilters as $key => $tabl) {
                    foreach ($tabl as $property => $value) {                       
                        $var = ucfirst(array_search($value,$tabl));
                        $var = "get" . $var;
                        //dump($card->$var());
                        $cardProperty = $card->$var();
                        if ($property == 'tag') {
                            //dump("dans le if");
                            foreach ($cardProperty as $key => $tag) {
                                
                                if ($tag == $value) {
                                    if ($compareArray[array_search($value,$tabl)] != true) {
        
                                        $compareArray[array_search($value,$tabl)] = true;
                                        //dump($tag . ' set on true');
                                    }elseif ($compareArray[array_search($value,$tabl)] == true) {/*dump($property . ' already on true');*/}   
                                }elseif ($compareArray[array_search($value,$tabl)] !== true) {
        
                                    $compareArray[array_search($value,$tabl)] = false;
                                    //dump(array_search($value,$tabl) . ' not the same but already true');
                                }  
                            }
                        }elseif ($cardProperty == $value) {
                            if ($compareArray[array_search($value,$tabl)] != true) {

                                $compareArray[array_search($value,$tabl)] = true;
                                //dump($compareArray . ' set on true');
                            }elseif ($compareArray[array_search($value,$tabl)] == true) {/*dump($property . ' already on true');*/}   
                        }elseif ($compareArray[array_search($value,$tabl)] !== true) {

                            $compareArray[array_search($value,$tabl)] = false;
                            //dump(array_search($value,$tabl) . ' not the same but already true');
                        }                  
                    }
                }
                // Désormais la que l'on vient de traiter possède un tableau $compareArray avec les valeurs true, false ou null

                // Nous traitons une dernière fois les filtres de la cartes:
                //  - Si le tableau contient une valeur à false, la carte est exclue du triage;
                //  - Si le tableau ne contient que les valeurs true (match du filtre) ou null (filtre non demandé), alors la carte est gardée.
                $n=0;
                foreach ($compareArray as $key => $value) {
                    if ($value === null || $value === true) {
                        $n++;
                    }elseif ($value === false) {
                        $n=0;                        
                        break;
                    }
                    if ($n === count($compareArray)) {
                        // On ajoute notre carte à notre tableau pour affichage
                        $cards[] = $card;
                        $n=0;
                    }
                }
                // On a finis le traitement de cette carte, fin de la boucle, on traite maintenant la carte suivante !
                //exit;
            }

        }else {
            // Ici on a pas reçu de filtre donc on récupère toutes nos cartes
            $cards = $cardRepository->findAllOrder();
            $queriesFilters = [];
        }
        return $this->render('card_explorer/browseV2.html.twig', [
            'cards' => $cards,
            'queriesFilters' => $queriesFilters,
        ]);
    }

    /**
     * @Route("/{id}", name="app_card_explorer_read", methods={"GET"})
     */
    public function read(Card $card): Response
    {
        return $this->render('card_explorer/read.html.twig', [
            'card' => $card,
        ]);
    }

}
