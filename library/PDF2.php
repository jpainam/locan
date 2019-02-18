<?php

class PDF2 extends TCPDF {

    private $logo;

    /**
     * Est ce que la page est en portrait, permet la modification apres le constructeur
     * @var type 
     */
    public $isLandscape = false;

    /**
     * Faut t-il certifier l'impression par le login de l'utilisateur?
     * Pour desactiver, se situer dans vue qui imprimer et saisir $pdf->bCertify = false;
     * @var type 
     */
    public $bCertify = true;

    public function __construct($orientation = 'P', $unit = 'mm', $format = 'A4') {
        parent::__construct($orientation, $unit, $format, true, 'UTF-8', false);
        $this->fontpath = SITE_ROOT . "library/tcpdf/fonts";
        $this->logo = SITE_ROOT . "public/img/logo2.png";

        # set default monospaced font
        $this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        #est margins
        $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->SetFooterMargin(PDF_MARGIN_FOOTER);
        #$this->AddFont("xephyr", "", K_PATH_FONTS."Xephyr Shadow.ttf");
    }

    //Page header
    public function Header() {

        $header_gauche = <<<EOD
                <p style = "text-align:center;line-height: 10px">
                    REPUBLIQUE DU CAMEROUN<br/>
                <i>Paix - Travail - Patrie</i><br/>
                                *************<br/>
                    D&eacute;l&eacute;gation R&eacute;gionale du Centre<br/>
                                *************<br/>
                    D&eacute;l&eacute;gation D&eacute;partementale de <br/>la Haute Sanaga<br/>
                        *************<br/>
                    <b>LYCEE DE NANGA - EBOKO</b><br/>
                    BP 90<br/>
                    T&eacute;l : 22-26-50-05/22-13-04-06<br/>
                </p>
                        
EOD;
        $this->SetFontSize(9);

        $this->writeHTMLCell(70, 50, LEFT_UP_CORNER, 5, $header_gauche);

        //$this->writeHTML($header_gauche);
        if ($this->isLandscape) {
            $this->Image($this->logo, 130, 5, 35, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        } else {
            $this->Image($this->logo, 85, 5, 35, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }

        // Set font
        //$this->WriteHTML

        $header_droit = <<<EOD
                <p style = "text-align:center;line-height: 10px">
                    REPUBLIC OF CAMEROON<br/>
                <i>Peace - Work - Fatherland</i><br/>
                                *************<br/>
                    Center Regional Delegation<br/>
                                *************<br/>
                    Upper Sanaga Divisional <br/>Delegation<br/>
                        *************<br/>
                    <b>GOVERNMENT HIGH SCHOOL NANGA-EBOKO</b><br/>
                    P.O. BOX 90<br/>
                    T&eacute;l : 22-26-50-05/22-13-04-06<br/>
                </p>
                        
EOD;

        if ($this->isLandscape) {
            $this->writeHTMLCell(0, 5, 200, 5, $header_droit);
        } else {
            $this->writeHTMLCell(80, 5, 130, 5, $header_droit);
        }
        $this->SetFont('helvetica', 'B', 20);
        // set document information
        $this->SetCreator("BAACK Group");
        $this->SetAuthor('BAACK Group');
        # set auto page breaks
        //$this->CEll
        $this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        # $this->writeHTMLCell(50, 50, 20, 20, $this->GetY(), 1);
    }

    /**
     *  Page footer
     */
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-20);
        // Set font
        if ($this->bCertify) {
            $this->SetFont('helvetica', 'B', 7);
            $d = new DateFR();
            $signature = '<p style="text-align:right">Imprim&eacute; par : ' . $_SESSION['user'] . " / " . $d->getJour(3) . " " . $d->getDate()
                    . " " . $d->getMois(3) . " " . $d->getYear() . '</p>';
            $this->writeHTML($signature);
        }
        // Page number
        $this->SetFont('helvetica', 'B', 8);
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    public function LandScapeFooter() {
        
    }

}
