<?php

namespace App\Meddra;

// use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\Form\Extension\Core\Type\DateType;
// use Symfony\Component\Form\Extension\Core\Type\TextType;
// use Symfony\Component\Form\Extension\Core\Type\SubmitType;
// use Symfony\Component\Form\Extension\Core\Type\TextareaType;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class RequetesMeddra
{
    private $em;
    private $doctrine;
    public function __construct(ManagerRegistry $doctrine)
    {
        // $this->dateCreation = $dateCreation;
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getManager('meddra');
    }

    public function donneIndicEng_UnCode(int $codeindic): string
    {

        $sql = "SELECT llt_name_en "
            . "FROM 1_low_level_term "
            . "WHERE llt_code = " . $codeindic;

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt_2 = $stmt->execute()->fetchAll();

        if (is_null($stmt_2[0]['llt_name_en'])) {
            return "";
        } else {
            foreach ($stmt_2[0] as $ter) {
                if (isset($lst)) {
                    $lst .= "," . $ter;
                } else {
                    $lst = $ter;
                }
            }
            return $lst;
        }
    }

    /**
     * Retourne une chaine de caractères contenant la liste des indications en anglais, concaténées, à partir d'un array de code indication
     * Cette méthode est utilisée pour stocker dans la table Susar la liste des indications en anglais
     * 
     * @param array $tabCodeIndic tableau de code indication
     * @return string liste des indications en anglais concaténées, séparée par une virgule.
     */
    public function donneIndicEng(array $tabCodeIndic): string
    {
        if (!empty($tabCodeIndic)) {

            $stmt = $this->em->getConnection();

            foreach ($tabCodeIndic as $codeIndic) {
                $sql = "SELECT llt_name_en "
                    . "FROM 1_low_level_term "
                    . "WHERE llt_code = " . $codeIndic;

                $stmt_2 = $stmt->prepare($sql)->execute()->fetchAll();
                // dd($stmt_2);

                if (!empty($stmt_2)) {
                    if (is_null($stmt_2[0]['llt_name_en'])) {
                        // return "";
                    } else {
                        foreach ($stmt_2[0] as $ter) {
                            if (isset($lst)) {
                                $lst .= "," . $ter;
                            } else {
                                $lst = $ter;
                            }
                        }
                    }

                    return $lst;

                }
                return "";
            }
        } else {
            return "";
        }
    }
    
    /**
     * Permet de retourner l'indication en anglais à partir du code indiction
     * Cette méthode est utilisée pour stocker la valeur de retour dans la table Indication
     * 
     * @param integer $codeIndic : code indication
     * @return string indication en anglais
     */
    public function donneIndicEng_not_array(int $codeIndic): string
    {
        if (!empty($codeIndic)) {

            $stmt = $this->em->getConnection();


                $sql = "SELECT llt_name_en "
                    . "FROM 1_low_level_term "
                    . "WHERE llt_code = " . $codeIndic;

                $stmt_2 = $stmt->prepare($sql)->execute()->fetchAll();
                // dd($stmt_2);

                if (!empty($stmt_2)) {
                    if (is_null($stmt_2[0]['llt_name_en'])) {
                        // return "";
                    } else {
                        foreach ($stmt_2[0] as $ter) {
                            if (isset($lst)) {
                                $lst .= "," . $ter;
                            } else {
                                $lst = $ter;
                            }
                        }
                    }

                    return $lst;

                }
                return "";
        } else {
            return "";
        }
    }
}
