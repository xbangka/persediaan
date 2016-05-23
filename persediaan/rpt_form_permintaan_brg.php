<?php
include("config.php");
include("../ga/class-general.php");
include("../ga/class-attribute.php");
# ---------------------------------
define("FPDF_FONTPATH", "librariesPDF/font/");
require("libraries/PDF/FPDF.php");
# ---------------------------------


# /\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\

#                    BY DEDI RUDIYANTO

# /\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\

$kodepm = '';
if(!empty($_GET['kodepm'])) { $kodepm = $_GET['kodepm'] ; }

if($kodepm==''){ echo 'Tidak ada data yang akan ditampilkan' ; exit();}

function tambah_nol($angka,$jumlah)
{
   $jumlah_nol = strlen($angka);
   $angka_nol = $jumlah - $jumlah_nol;
   $nol = "";
   for($i=1;$i<=$angka_nol;$i++)
   {
      $nol .= '0';
   }
   return $nol.$angka;
}
# ---------------------------------
$pdf=new FPDF("P", "mm", "A4");

class PDF_FlowingBlock extends FPDF
{

    var $flowingBlockAttr;

    function saveFont()
    {

        $saved = array();

        $saved[ 'family' ] = $this->FontFamily;
        $saved[ 'style' ] = $this->FontStyle;
        $saved[ 'sizePt' ] = $this->FontSizePt;
        $saved[ 'size' ] = $this->FontSize;
        $saved[ 'curr' ] =& $this->CurrentFont;

        return $saved;

    }

    function restoreFont( $saved )
    {

        $this->FontFamily = $saved[ 'family' ];
        $this->FontStyle = $saved[ 'style' ];
        $this->FontSizePt = $saved[ 'sizePt' ];
        $this->FontSize = $saved[ 'size' ];
        $this->CurrentFont =& $saved[ 'curr' ];

        if( $this->page > 0)
            $this->_out( sprintf( 'BT /F%d %.2F Tf ET', $this->CurrentFont[ 'i' ], $this->FontSizePt ) );
    }

    function newFlowingBlock( $w, $h, $b = 0, $a = 'J', $f = 0 )
    {

        // cell width in points
        $this->flowingBlockAttr[ 'width' ] = $w * $this->k;

        // line height in user units
        $this->flowingBlockAttr[ 'height' ] = $h;

        $this->flowingBlockAttr[ 'lineCount' ] = 0;

        $this->flowingBlockAttr[ 'border' ] = $b;
        $this->flowingBlockAttr[ 'align' ] = $a;
        $this->flowingBlockAttr[ 'fill' ] = $f;

        $this->flowingBlockAttr[ 'font' ] = array();
        $this->flowingBlockAttr[ 'content' ] = array();
        $this->flowingBlockAttr[ 'contentWidth' ] = 0;

    }

    function finishFlowingBlock()
    {

        $maxWidth =& $this->flowingBlockAttr[ 'width' ];

        $lineHeight =& $this->flowingBlockAttr[ 'height' ];

        $border =& $this->flowingBlockAttr[ 'border' ];
        $align =& $this->flowingBlockAttr[ 'align' ];
        $fill =& $this->flowingBlockAttr[ 'fill' ];

        $content =& $this->flowingBlockAttr[ 'content' ];
        $font =& $this->flowingBlockAttr[ 'font' ];

        // set normal spacing
        $this->_out( sprintf( '%.3F Tw', 0 ) );

        // print out each chunk

        // the amount of space taken up so far in user units
        $usedWidth = 0;

        foreach ( $content as $k => $chunk )
        {

            $b = '';

            if ( is_int( strpos( $border, 'B' ) ) )
                $b .= 'B';

            if ( $k == 0 && is_int( strpos( $border, 'L' ) ) )
                $b .= 'L';

            if ( $k == count( $content ) - 1 && is_int( strpos( $border, 'R' ) ) )
                $b .= 'R';

            $this->restoreFont( $font[ $k ] );

            // if it's the last chunk of this line, move to the next line after
            if ( $k == count( $content ) - 1 )
                $this->Cell( ( $maxWidth / $this->k ) - $usedWidth + 2 * $this->cMargin, $lineHeight, $chunk, $b, 1, $align, $fill );
            else
                $this->Cell( $this->GetStringWidth( $chunk ), $lineHeight, $chunk, $b, 0, $align, $fill );

            $usedWidth += $this->GetStringWidth( $chunk );

        }

    }

    function WriteFlowingBlock( $s )
    {

        // width of all the content so far in points
        $contentWidth =& $this->flowingBlockAttr[ 'contentWidth' ];

        // cell width in points
        $maxWidth =& $this->flowingBlockAttr[ 'width' ];

        $lineCount =& $this->flowingBlockAttr[ 'lineCount' ];

        // line height in user units
        $lineHeight =& $this->flowingBlockAttr[ 'height' ];

        $border =& $this->flowingBlockAttr[ 'border' ];
        $align =& $this->flowingBlockAttr[ 'align' ];
        $fill =& $this->flowingBlockAttr[ 'fill' ];

        $content =& $this->flowingBlockAttr[ 'content' ];
        $font =& $this->flowingBlockAttr[ 'font' ];

        $font[] = $this->saveFont();
        $content[] = '';

        $currContent =& $content[ count( $content ) - 1 ];

        // where the line should be cutoff if it is to be justified
        $cutoffWidth = $contentWidth;

        // for every character in the string
        for ( $i = 0; $i < strlen( $s ); $i++ )
        {

            // extract the current character
            $c = $s[ $i ];

            // get the width of the character in points
            $cw = $this->CurrentFont[ 'cw' ][ $c ] * ( $this->FontSizePt / 1000 );

            if ( $c == ' ' )
            {

                $currContent .= ' ';
                $cutoffWidth = $contentWidth;

                $contentWidth += $cw;

                continue;

            }

            // try adding another char
            if ( $contentWidth + $cw > $maxWidth )
            {

                // won't fit, output what we have
                $lineCount++;

                // contains any content that didn't make it into this print
                $savedContent = '';
                $savedFont = array();

                // first, cut off and save any partial words at the end of the string
                $words = explode( ' ', $currContent );

                // if it looks like we didn't finish any words for this chunk
                if ( count( $words ) == 1 )
                {

                    // save and crop off the content currently on the stack
                    $savedContent = array_pop( $content );
                    $savedFont = array_pop( $font );

                    // trim any trailing spaces off the last bit of content
                    $currContent =& $content[ count( $content ) - 1 ];

                    $currContent = rtrim( $currContent );

                }

                // otherwise, we need to find which bit to cut off
                else
                {

                    $lastContent = '';

                    for ( $w = 0; $w < count( $words ) - 1; $w++)
                        $lastContent .= "{$words[ $w ]} ";

                    $savedContent = $words[ count( $words ) - 1 ];
                    $savedFont = $this->saveFont();

                    // replace the current content with the cropped version
                    $currContent = rtrim( $lastContent );

                }

                // update $contentWidth and $cutoffWidth since they changed with cropping
                $contentWidth = 0;

                foreach ( $content as $k => $chunk )
                {

                    $this->restoreFont( $font[ $k ] );

                    $contentWidth += $this->GetStringWidth( $chunk ) * $this->k;

                }

                $cutoffWidth = $contentWidth;

                // if it's justified, we need to find the char spacing
                if( $align == 'J' )
                {

                    // count how many spaces there are in the entire content string
                    $numSpaces = 0;

                    foreach ( $content as $chunk )
                        $numSpaces += substr_count( $chunk, ' ' );

                    // if there's more than one space, find word spacing in points
                    if ( $numSpaces > 0 )
                        $this->ws = ( $maxWidth - $cutoffWidth ) / $numSpaces;
                    else
                        $this->ws = 0;

                    $this->_out( sprintf( '%.3F Tw', $this->ws ) );

                }

                // otherwise, we want normal spacing
                else
                    $this->_out( sprintf( '%.3F Tw', 0 ) );

                // print out each chunk
                $usedWidth = 0;

                foreach ( $content as $k => $chunk )
                {

                    $this->restoreFont( $font[ $k ] );

                    $stringWidth = $this->GetStringWidth( $chunk ) + ( $this->ws * substr_count( $chunk, ' ' ) / $this->k );

                    // determine which borders should be used
                    $b = '';

                    if ( $lineCount == 1 && is_int( strpos( $border, 'T' ) ) )
                        $b .= 'T';

                    if ( $k == 0 && is_int( strpos( $border, 'L' ) ) )
                        $b .= 'L';

                    if ( $k == count( $content ) - 1 && is_int( strpos( $border, 'R' ) ) )
                        $b .= 'R';

                    // if it's the last chunk of this line, move to the next line after
                    if ( $k == count( $content ) - 1 )
                        $this->Cell( ( $maxWidth / $this->k ) - $usedWidth + 2 * $this->cMargin, $lineHeight, $chunk, $b, 1, $align, $fill );
                    else
                    {

                        $this->Cell( $stringWidth + 2 * $this->cMargin, $lineHeight, $chunk, $b, 0, $align, $fill );
                        $this->x -= 2 * $this->cMargin;

                    }

                    $usedWidth += $stringWidth;

                }

                // move on to the next line, reset variables, tack on saved content and current char
                $this->restoreFont( $savedFont );

                $font = array( $savedFont );
                $content = array( $savedContent . $s[ $i ] );

                $currContent =& $content[ 0 ];

                $contentWidth = $this->GetStringWidth( $currContent ) * $this->k;
                $cutoffWidth = $contentWidth;

            }

            // another character will fit, so add it on
            else
            {

                $contentWidth += $cw;
                $currContent .= $s[ $i ];

            }

        }

    }

}







class paperpdf extends FPDF { 
    var $javascript; 
    var $n_js; 

    function IncludeJS($script) { 
        $this->javascript=$script; 
    } 

    function _putjavascript() { 
        $this->_newobj(); 
        $this->n_js=$this->n; 
        $this->_out('<<'); 
        $this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R]'); 
        $this->_out('>>'); 
        $this->_out('endobj'); 
        $this->_newobj(); 
        $this->_out('<<'); 
        $this->_out('/S /JavaScript'); 
        $this->_out('/JS '.$this->_textstring($this->javascript)); 
        $this->_out('>>'); 
        $this->_out('endobj'); 
    } 

    function _putresources() { 
        parent::_putresources(); 
        if (!empty($this->javascript)) { 
            $this->_putjavascript(); 
        } 
    } 

    function _putcatalog() { 
        parent::_putcatalog(); 
        if (!empty($this->javascript)) { 
            $this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>'); 
        } 
    } 
}










$pdf = new PDF_FlowingBlock();
$pdf->Open();
$pdf->AddPage();








#    ============================ Title ============================
$pdf->Ln(8);
$pdf->SetX($pdf->lMargin);
$pdf->SetX(20);
$pdf->SetFont('Times','B',12);
$pdf->Cell(170,10,'FORM PERMINTAAN BARANG',0,0,'C');

#    ============================ Title ============================





$sql2 = mysqli_query($jazz,"SELECT 
						permintaan.*, 
						pemohon.nama
					FROM db_persediaan.permintaan 
					INNER JOIN db_persediaan.pemohon ON pemohon.user_id = permintaan.user_approve 
					WHERE permintaan.kodepm = '$kodepm' AND permintaan.approve = '1'");

$ada = mysqli_num_rows($sql2);

if($ada>=1){
	$rs = mysqli_fetch_array($sql2);
}else{
	echo '<br />&nbsp; &nbsp; Maaf, Form permintaan Anda belum di setujui.' ;
	exit();
}



	$k = explode('-',substr($rs['tgl'],0,10) ) ; 
	$l = substr($rs['tgl'],11,5) ;
	$tgl = $k[2] . '-' . $k[1] . '-' . $k[0] . ' ' . $l ;
	
	$k = explode('-',$rs['tgl_butuh'] ) ; 
	$tgl_butuh = $k[2] . '-' . $k[1] . '-' . $k[0] ;


#   //////////////////////////// ///////////////////////////
$pdf->SetFont( 'Times', '', 10 );
$pdf->Ln(0);
$pdf->SetLeftMargin(10);
$pdf->SetXY(10,35);

$pdf->Cell(20, 4, "KODE ", 0, 0, "L");
$pdf->SetLeftMargin(15);
$pdf->newFlowingBlock(104, 4, '', 'L' );
$pdf->WriteFlowingBlock(':  ');
$pdf->SetFont( 'Times', 'B', 10 );
$pdf->WriteFlowingBlock( strtoupper($kodepm) );
$pdf->finishFlowingBlock();

$pdf->Ln(1);
$pdf->SetX(10);
$pdf->SetFont( 'Times', '', 10 );
$pdf->Cell(20, 4, "TANGGAL ", 0, 0, "L");
$pdf->SetLeftMargin(15);
$pdf->newFlowingBlock(104, 4, '', 'L' );
$pdf->WriteFlowingBlock(':  ');
$pdf->SetFont( 'Times', 'B', 10 );
$pdf->WriteFlowingBlock( $tgl );
$pdf->finishFlowingBlock();

$pdf->Ln(1);
$pdf->SetX(10);
$pdf->SetFont( 'Times', '', 10 );
$pdf->Cell(35, 4, "PERMINTAAN DARI ", 0, 0, "L");
$pdf->SetLeftMargin(15);
$pdf->newFlowingBlock(134, 4, '', 'L' );
$pdf->SetFont( 'Times', 'BU', 10 );
$pdf->WriteFlowingBlock( $rs[5] );
$pdf->finishFlowingBlock();
#   //////////////////////////// ///////////////////////////





#   //////////////////////////// ///////////////////////////
$pdf->Ln(8);
$pdf->SetFont( 'Times', '', 10 );
$pdf->SetXY(110,35);
$pdf->Cell(30, 4, "DEPARTEMEN ", 0, 0, "L");
$pdf->SetLeftMargin(15);
$pdf->newFlowingBlock(164, 4, '', 'L' );
$pdf->WriteFlowingBlock(':  ');
$pdf->SetFont( 'Times', 'B', 10 );
$pdf->WriteFlowingBlock( $rs['departemen'] );
$pdf->finishFlowingBlock();


if($rs['klasifikasi']=='1'){
	$urgen = 'SEGERA' ;
}else{
	$urgen = 'BIASA' ;
}


$pdf->Ln(1);
$pdf->SetXY(110,40);
$pdf->SetFont( 'Times', '', 10 );
$pdf->Cell(30, 4, "KLARIFIKASI ", 0, 0, "L");
$pdf->SetLeftMargin(15);
$pdf->newFlowingBlock(164, 4, '', 'L' );
$pdf->WriteFlowingBlock(':  ');
$pdf->SetFont( 'Times', 'B', 10 );
$pdf->WriteFlowingBlock( $urgen );
$pdf->finishFlowingBlock();

$pdf->Ln(1);
$pdf->SetXY(110,45);
$pdf->SetFont( 'Times', '', 10 );
$pdf->Cell(45, 4, "TANGGAL DIBUTUHKAN", 0, 0, "L");
$pdf->SetLeftMargin(15);
$pdf->newFlowingBlock(164, 4, '', 'L' );
$pdf->SetFont( 'Times', 'B', 10 );
$pdf->WriteFlowingBlock( $tgl_butuh );
$pdf->finishFlowingBlock();

#   ///////////////////////////////////////////////////////






#    =========================== Barang ===========================

$pdf->Ln(10);


#    =========================== Header Table ===========================
$pdf->SetX(11);
$pdf->setFillColor(210,210,210); 
$pdf->SetFont('Times','B',10);
$pdf->Cell(10,8,'No.',1,0,'C',1);
$pdf->Cell(25,8,'Kodebrg',1,0,'C',1);
$pdf->Cell(85,8,'Nama Barang',1,0,'C',1);
$pdf->Cell(16,8,'Jumlah',1,0,'C',1);
$pdf->Cell(22,8,'Satuan',1,0,'C',1);
$pdf->Ln(3);
#    =========================== Header Table ===========================


$n = 0 ;
$sql = mysqli_query($jazz,"SELECT rinci_permintaan.* , barang.satuan FROM db_persediaan.rinci_permintaan INNER JOIN db_persediaan.barang ON rinci_permintaan.kodebrg = barang.kodebrg WHERE rinci_permintaan.idx='$rs[x]' ORDER BY rinci_permintaan.x ASC");
while($data = mysqli_fetch_array($sql)){
	$n += 1 ;	
	
	
	if($n % 2 == 1){

		$pdf->Ln(5);
		$pdf->SetX(11);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(10,5,$n,1,0,'R');
		$pdf->Cell(25,5,$data['kodebrg'],1,0,'C');
		$pdf->Cell(85,5,$data['namabrg'],1,0,'L');
		$pdf->Cell(16,5,$data['jml'],1,0,'C');
		$pdf->Cell(22,5,$data['satuan'],1,0,'L');
	}else{
		$pdf->Ln(5);
		$pdf->SetX(11);
		$pdf->SetFont('Times','',10);
		$pdf->setFillColor(230,230,230); 
		$pdf->Cell(10,5,$n,1,0,'R',1);
		$pdf->Cell(25,5,$data['kodebrg'],1,0,'C',1);
		$pdf->Cell(85,5,$data['namabrg'],1,0,'L',1);
		$pdf->Cell(16,5,$data['jml'],1,0,'C',1);
		$pdf->Cell(22,5,$data['satuan'],1,0,'L',1);
	}

}


$n = $n + 1 ;
for( $i= $n ; $i <= 5 ; $i++ ){
	if($i % 2 == 1){

		$pdf->Ln(5);
		$pdf->SetX(11);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(10,5,$i,1,0,'R');
		$pdf->Cell(25,5,'',1,0,'C');
		$pdf->Cell(85,5,'',1,0,'L');
		$pdf->Cell(16,5,'',1,0,'C');
		$pdf->Cell(22,5,'',1,0,'L');
	}else{
		$pdf->Ln(5);
		$pdf->SetX(11);
		$pdf->SetFont('Times','',10);
		$pdf->setFillColor(230,230,230); 
		$pdf->Cell(10,5,$i,1,0,'R',1);
		$pdf->Cell(25,5,'',1,0,'C',1);
		$pdf->Cell(85,5,'',1,0,'L',1);
		$pdf->Cell(16,5,'',1,0,'C',1);
		$pdf->Cell(22,5,'',1,0,'L',1);
	}
}
#    =========================== Barang =========================


$sql2 = mysqli_query($jazz,"SELECT keterangan FROM db_persediaan.pemohon WHERE user_id = '$rs[user_approve]'");
$data = mysqli_fetch_array($sql2);
$disetujui = $data[0];

#    =================== Logo dan nomor  ===================

$pdf->SetXY(155,100);
$pdf->MultiCell(120, 4, 'Disetujui oleh '.$disetujui ,0,'L','');

$pdf->SetXY(170,86);
$pdf->MultiCell(30, 4, strtoupper($kodepm) ,0,'C','');

include('../ga/phpqrcode/qrlib.php');
$filebarcode = '../ga/barcode/'.strtolower($kodepm).'.png';
if (!file_exists($filebarcode)) {
  QRcode::png(strtolower($kodepm), $filebarcode);
}
   
$pdf->Ln(1);
$pdf->Image('../public/images/logo.png',154,10,50,15);
$pdf->Image($filebarcode ,170,55,30,30);
$pdf->Image('../public/images/cecktrue.jpg',150,100,4,4);
$pdf->SetFont('Arial','B',14);
$pdf->SetXY(5,10);
$pdf->MultiCell(200, 100, '' ,1,'C','');
#    =================== Logo dan nomor  ===================
$pdf->Output();
?>
