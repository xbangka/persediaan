<?php

include("config.php");
include("libraries/class-general.php");
# ---------------------------------
define("FPDF_FONTPATH", "libraries/PDF/font/");
require("libraries/PDF/FPDF.php");
# ---------------------------------



# /\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\

#                    BY DEDI RUDIYANTO

# /\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\

if(!isset($_SESSION['id'])){
	echo '<script>window.location= "index.php";</script>';
	exit;
}

if($_POST['tgl1']=='' || $_POST['tgl2'] == ''){ echo 'Tidak ada data yang akan ditampilkan' ; exit();}

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











$pdf->AddPage();


#    =================== Logo  ===================
$pdf->Ln(0);
$pdf->Image('assets/img/logo.png',3,4,50,15);
$pdf->SetFont('Arial','B',14);
#    =================== Logo dan nomor register ===================





#    ============================ Title ============================

$tgl1 = $_POST['tgl1'];
$tgl2 = $_POST['tgl2'];

$k 			= explode('/',substr($tgl1,0,10));
$tanggal1	= $k[0] . ' ' . $namabulan[floattostr($k[1])] . ' ' . $k[2]  ;

$k 			= explode('/',substr($tgl2,0,10));
$tanggal2	= $k[0] . ' ' . $namabulan[floattostr($k[1])] . ' ' . $k[2]  ;

$pdf->Ln(10);
$pdf->SetX(5);
$pdf->SetFont('Times','B',12);
$pdf->Cell(200,5,'LAPORAN MUTASI SEMUA BARANG',0,0,'L');

$pdf->Ln(5);
$pdf->SetFont('Times','',12);
$pdf->SetX(5);
$pdf->Cell(200, 5,'Periode  : '.$tanggal1.'  s.d  '.$tanggal2 , 0, 0, "L");
#    ============================ Title ============================





#    =========================== Header Table ===========================
$pdf->Ln(6);
$pdf->SetX(6);
$pdf->setFillColor(210,210,210); 
$pdf->SetFont('Times','B',10);
$pdf->Cell(10,8,'No.',1,0,'C',1);
$pdf->Cell(24,8,'No. Mutasi',1,0,'C',1);
$pdf->Cell(18,8,'Tanggal',1,0,'C',1);
$pdf->Cell(123,8,'Uraian',1,0,'C',1);
$pdf->Cell(12,8,'Masuk',1,0,'C',1);
$pdf->Cell(12,8,'Keluar',1,0,'C',1);
$y = 0 ;
#    =========================== Header Table ===========================







#    =========================== Isi Table ===========================

$pdf->Ln(3);


$n 			= 0 ;
$Masuk 		= 0 ;
$Keluar 	= 0 ;

$k 		= explode('/',substr($tgl1,0,10));
$tgl1 	= $k[2] . '-' . $k[1] . '-' . $k[0] . ' 00:00:00'  ;

$k 		= explode('/',substr($tgl2,0,10));
$tgl2 	= $k[2] . '-' . $k[1] . '-' . $k[0] . ' ' . date('H:i:s')  ;

$sql = mysqli_query($jazz,"SELECT 
							m.*,
							b.brg
						  FROM mutasi m 
						  INNER JOIN barang b 
						  ON b.kodebrg = m.kodebrg 
						  WHERE 
						    m.tgl >= '$tgl1' AND m.tgl <= '$tgl2' 
						  ORDER BY m.tgl, m.x ASC");
while($data = mysqli_fetch_array($sql)){
	$n += 1 ;
	$y += 1 ;
	
	
	$k 		 = explode('-',substr($data[2],0,10));
	$data[2] = $k[2] . '/' . $k[1] . '/' . $k[0]  ;
	$data[3] = $data[3] . ' ' . $data[8] . ' - ' . $data[5] ;
	
	if($data[4]=='1'){
		$strMasuk 	= number_format($data[6], 0, '', '.');
		$strKeluar 	= '-';
		
		$Masuk 		= $Masuk + $data[6] ;
		$Keluar 	= $Keluar ;
	}else{
		$strMasuk 	= '-';
		$strKeluar 	= number_format($data[6], 0, '', '.');
		
		$Masuk 		= $Masuk ;
		$Keluar 	= $Keluar + $data[6] ;
	}
	
	
	
	if($y == 48){
		$pdf->AddPage();
		
		#    =================== Logo  ===================
		$pdf->Ln(0);
		$pdf->Image('assets/img/logo.png',3,4,50,15);
		$pdf->SetFont('Arial','B',14);
		#    =================== Logo dan nomor register ===================
		
		
		
		
		
		#    ============================ Title ============================
		
		$tgl1 = $_POST['tgl1'];
		$tgl2 = $_POST['tgl2'];
		
		$k 			= explode('/',substr($tgl1,0,10));
		$tanggal1	= $k[0] . ' ' . $namabulan[floattostr($k[1])] . ' ' . $k[2]  ;
		
		$k 			= explode('/',substr($tgl2,0,10));
		$tanggal2	= $k[0] . ' ' . $namabulan[floattostr($k[1])] . ' ' . $k[2]  ;
		
		$pdf->Ln(10);
		$pdf->SetX(5);
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(200,5,'LAPORAN MUTASI SEMUA BARANG',0,0,'L');
		
		$pdf->Ln(5);
		$pdf->SetFont('Times','',12);
		$pdf->SetX(5);
		$pdf->Cell(200, 5,'Periode  : '.$tanggal1.'  s.d  '.$tanggal2 , 0, 0, "L");
		#    ============================ Title ============================
		
		
		
		
		
		#    =========================== Header Table ===========================
		$pdf->Ln(6);
		$pdf->SetX(6);
		$pdf->setFillColor(210,210,210); 
		$pdf->SetFont('Times','B',10);
		$pdf->Cell(10,8,'No.',1,0,'C',1);
		$pdf->Cell(24,8,'No. Mutasi',1,0,'C',1);
		$pdf->Cell(18,8,'Tanggal',1,0,'C',1);
		$pdf->Cell(123,8,'Uraian',1,0,'C',1);
		$pdf->Cell(12,8,'Masuk',1,0,'C',1);
		$pdf->Cell(12,8,'Keluar',1,0,'C',1);
		$y = 1 ;
		$pdf->Ln(3);
		#    =========================== Header Table ===========================
	}
	
	if($n % 2 == 1){

		$pdf->Ln(5);
		$pdf->SetX(6);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(10,5,$n,1,0,'R');
		$pdf->Cell(24,5,$data[1],1,0,'C');
		$pdf->Cell(18,5,$data[2],1,0,'C');
		$pdf->Cell(123,5,$data[3],1,0,'L');
		$pdf->Cell(12,5,$strMasuk,1,0,'R');
		$pdf->Cell(12,5,$strKeluar,1,0,'R');
	}else{
		$pdf->Ln(5);
		$pdf->SetX(6);
		$pdf->SetFont('Times','',10);
		$pdf->setFillColor(230,230,230); 
		$pdf->Cell(10,5,$n,1,0,'R',1);
		$pdf->Cell(24,5,$data[1],1,0,'C',1);
		$pdf->Cell(18,5,$data[2],1,0,'C',1);
		$pdf->Cell(123,5,$data[3],1,0,'L',1);
		$pdf->Cell(12,5,$strMasuk,1,0,'R',1);
		$pdf->Cell(12,5,$strKeluar,1,0,'R',1);
	}

}


#    =========================== Isi Table ===========================



#    =========================== Jumlah ===========================
$pdf->Ln(5);
$pdf->SetX(6);
$pdf->setFillColor(210,210,210); 
$pdf->SetFont('Times','B',10);

$pdf->Cell(175,7,'Jumlah',1,0,'C',1);

$pdf->Cell(12,7,number_format($Masuk, 0, '', '.'),1,0,'R',1);
$pdf->Cell(12,7,number_format($Keluar, 0, '', '.'),1,0,'R',1);




#$pdf->Output("Document_PDF/".$text_nomorregister."_".$namaDebitur.".pdf");
$pdf->Output();
 
?>
