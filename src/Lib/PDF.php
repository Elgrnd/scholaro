<?php

namespace App\Sae\Lib;


require_once __DIR__ . '/fpdf/fpdf.php';

// Classe personnalisée pour le PDF
class PDF extends \FPDF
{
    // En-tête de page
    function Header()
    {
        $this->Image('../ressources/images/dep_info.png', 3, 5, 44);
        $this->Image('../ressources/images/um_noir.png', 152, 1, 18);
        $this->Image('../ressources/images/Logo_IUT_RVB.jpg', 175, 4, 25);
        $this->Ln(11);
    }

    // Pied de page
    function Footer()
    {
        $this->SetY(-15);
    }
}

// Créer le PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'b', 10);

$pdf->Cell(0,4.5, mb_convert_encoding("Fiche Avis Poursuite d'Études - Promotion 2023-2024", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
$pdf->Cell(0,4.5, mb_convert_encoding("Département Informatique", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
$pdf->Cell(0,4.5, 'IUT Montpellier-Sete', 0, 1, 'C');
$pdf->Cell(0, 10, 'FICHE D\'INFORMATION ETUDIANT(E)', 0, 1, 'L');
$x = $pdf->GetX(); // Position X actuelle
$y = $pdf->GetY(); // Position Y actuelle
$pdf->Line($x - 1, $y - 2, $x + 191, $y - 2); // Ligne sous le texte
$pdf->Ln(3);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(70, 10, 'NOM', 1, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(105, 10, mb_convert_encoding("«Nom»", 'ISO-8859-1', 'UTF-8'), 1, 1);

$pdf->Cell(70, 10, 'Prenom', 1, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(105, 10, mb_convert_encoding("«Prenom»", 'ISO-8859-1', 'UTF-8'), 1, 1);

$pdf->Cell(70, 10, 'Apprentissage en BUT 3 : (oui/non)', 1, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(105, 10, mb_convert_encoding("«Alternance»", 'ISO-8859-1', 'UTF-8'), 1, 1);

$pdf->Cell(70, 10, 'Parcours BUT', 1, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(105, 10, mb_convert_encoding("«Parcours»", 'ISO-8859-1', 'UTF-8'), 1, 1);

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, mb_convert_encoding('Avis de l\'équipe pédagogique pour la poursuite d\'études après le BUT 3', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
$x = $pdf->GetX(); // Position X actuelle
$y = $pdf->GetY(); // Position Y actuelle
$pdf->Line($x - 1, $y - 2, $x + 191, $y - 2); // Ligne sous le texte
$pdf->Ln(3);

$pdf->SetFont('Arial', '', 10);

$y = $pdf->GetY();
$pdf->MultiCell(34, 24, mb_convert_encoding('Pour l\'étudiant', 'ISO-8859-1', 'UTF-8'), 1, 'C');
$pdf->SetXY($pdf->GetX() + 34, $y);

$pdf->MultiCell(50, 7, mb_convert_encoding('En école d\'ingénieur et  master en informatique', 'ISO-8859-1', 'UTF-8'), 1, 'L');
$y2 = $pdf->GetY();
$pdf->SetXY($pdf->GetX() + 84, $y);
$pdf->SetFont('Arial', 'b', 10);
$pdf->MultiCell(60, ($y2 - $y)/2, mb_convert_encoding('«Avis_Ecole_dingénieur_et_master_en_info»', 'ISO-8859-1', 'UTF-8'), 1, 'C');

$pdf->SetFont('Arial', '', 10);
$y = $pdf->GetY();
$pdf->SetXY($pdf->GetX() + 34, $y);
$pdf->MultiCell(50, 10, 'En master en management', 1);
$y2 = $pdf->GetY();
$pdf->SetXY($pdf->GetX() + 84, $y);
$pdf->SetFont('Arial', 'b', 10);
$pdf->MultiCell(60, ($y2 - $y), mb_convert_encoding('«Avis_Master_en_management»', 'ISO-8859-1', 'UTF-8'), 1, 'C');

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 10);
$y = $pdf->GetY();
$pdf->MultiCell(34, 5, 'Nombre d\'avis pour la promotion', 1);
$pdf->SetXY($pdf->GetX() + 34, $y);
$pdf->MultiCell(39, 10, '', 1, 0);
$pdf->SetXY($pdf->GetX() + 73, $y);
$pdf->MultiCell(39, 10, mb_convert_encoding('Très Favorable', 'ISO-8859-1', 'UTF-8'), 1, 'C');
$pdf->SetXY($pdf->GetX() + 112, $y);
$pdf->MultiCell(39, 10, 'Favorable', 1, 'C');
$pdf->SetXY($pdf->GetX() + 151, $y);
$pdf->MultiCell(39, 10, mb_convert_encoding('Réservé', 'ISO-8859-1', 'UTF-8'), 1, 'C');

$y = $pdf->GetY();
$pdf->MultiCell(34, 12, '', 1);
$pdf->SetXY($pdf->GetX() + 34, $y);
$pdf->MultiCell(39, 6, mb_convert_encoding('En école d\'ingénieur et master en informatique', 'ISO-8859-1', 'UTF-8'), 1, 'L');
$pdf->SetXY($pdf->GetX() + 73, $y);
$pdf->MultiCell(39, 12, 37, 1, 'C');
$pdf->SetXY($pdf->GetX() + 112, $y);
$pdf->MultiCell(39, 12, 20, 1, 'C');
$pdf->SetXY($pdf->GetX() + 151, $y);
$pdf->MultiCell(39, 12, 33, 1, 'C');

$y = $pdf->GetY();
$pdf->MultiCell(34, 12, '', 1);
$pdf->SetXY($pdf->GetX() + 34, $y);
$pdf->MultiCell(39, 6, mb_convert_encoding('Master en management ', 'ISO-8859-1', 'UTF-8'), 1, 'L');
$pdf->SetXY($pdf->GetX() + 73, $y);
$pdf->MultiCell(39, 12, 44, 1, 'C');
$pdf->SetXY($pdf->GetX() + 112, $y);
$pdf->MultiCell(39, 12, 40, 1, 'C');
$pdf->SetXY($pdf->GetX() + 151, $y);
$pdf->MultiCell(39, 12, 6, 1, 'C');

$pdf->Ln(10);
$pdf->SetXY($pdf->GetX() + 105, $pdf->GetY());
$pdf->MultiCell(85, 7, mb_convert_encoding('Signature du Responsable des Poursuites d\'études par délégation du chef de département', 'ISO-8859-1', 'UTF-8'), 0, 1);

// Sortie du PDF
$pdf->Output('avis_pe_2024.pdf', 'I');
