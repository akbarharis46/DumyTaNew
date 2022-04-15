<?php 

$data_produksi = array(

    [
        'bulan' => "Januari",
        'qty'   => "267"
    ],
    [
        'bulan' => "Februari",
        'qty'   => "110"
    ],
    [
        'bulan' => "Maret",
        'qty'   => "150"
    ],
    [
        'bulan' => "April",
        'qty'   => "235"
    ],
    [
        'bulan' => "Mei",
        'qty'   => "355"
    ],
    [
        'bulan' => "Juni",
        'qty'   => "222"
    ],
    [
        'bulan' => "July",
        'qty'   => "160"
    ],
    [
        'bulan' => "Agustus",
        'qty'   => "200"
    ],
    [
        'bulan' => "September",
        'qty'   => "301"
    ],
    [
        'bulan' => "Oktober",
        'qty'   => "244"
    ],
    [
        'bulan' => "November",
        'qty'   => "150"
    ],
    [
        'bulan' => "Desember",
        'qty'   => "171"
    ],
);



// menyiapkan variabel 

// alpha
$a = 0.1;
$hasil = array(); // menampung hasil

$urutan = 0;
foreach ( $data_produksi AS $dp ) {

    echo '<h3>Perhitungan '. $dp['bulan'].'</h3>';
    
    if ( $urutan == 0 ) {

        $peramalan = array(

            'bulan' => $dp['bulan'],
            'actual'=> $dp['qty'],
            'pemulusan_1'=> $dp['qty'],
            'pemulusan_2'=> $dp['qty'],
            'pemulusan_3'=> $dp['qty'],
            'at'   => 0,
            'bt'   => 0,
            'ct'   => 0,
            'Ft'   => 0
        );

        
        // push array $hasil
        array_push( $hasil, $peramalan );

    } else {

        // data peramalan sebelumnya
        $t = $urutan - 1;
        $St_1 = $hasil[$t];

        // @TODO 1 : Pemulusan Tunggal - Triple
        $S1 = ($a * $dp['qty']) + (1 - $a) * $St_1['pemulusan_1'];
        $S2 = ($a * $S1) + (1 - $a) * $St_1['pemulusan_2'];
        $S3 = ($a * $S2) + (1 - $a) * $St_1['pemulusan_3'];


        // @TODO 2 : Nilai at
        $at = (3 * $S1) - (3 * $S2) + $S3;

        // @TODO 3 : Nilai bt
        $bt = ( pow($a, 2) / (2 * (pow((1 - $a), 2))) ) * 
            ( 
                ( (6 - (5 * $a)) * $S1 ) - 
                ( (10 - (8 * $a)) * $S2 ) +
                ( (4 - (3 * $a)) * $S3 )
            );

        // @TODO 4 : Nilai ct
        $ct = ( pow($a, 2) / (pow((1 - $a), 2)) ) * 
            ( $S1 - (2 * $S2) + $S3 );


        // @TODO 5 : Forecasting
        $Ft = $at + $bt + (0.5 * $ct);
        
        echo "S't : " . $S1.'<br>';
        echo "S''t : " . $S2.'<br>';
        echo "S'''t : " . $S3.'<br>';
        echo "at : " . $at.'<br>';
        echo "bt : " . number_format($bt, 2).'<br>';
        echo "ct : " . number_format($ct, 2).'<br>';
        echo "Ft : " . number_format($Ft, 2).'<br>';


        $peramalan = array(

            'bulan' => $dp['bulan'],
            'actual'=> $dp['qty'],
            'pemulusan_1'=> $S1,
            'pemulusan_2'=> $S2,
            'pemulusan_3'=> $S3,
            'at'   => $at,
            'bt'   => $bt,
            'ct'   => $ct,
            'Ft'   => $Ft
        );

        
        // push array $hasil
        array_push( $hasil, $peramalan );

    }

    echo '<hr>';

    // increment 
    $urutan++;
}


// ------------------------------------------------


// visualisasi data
$isi_table = "";
$urutan = 0;

$actual_forecast = array();

foreach ( $hasil AS $hsl ) {

    // forecasting
    $Ft = 0;

    if ( $urutan <= 1 ) {

        $Ft = 0;

    } else {

        $t = $urutan - 1;
        $Ft = number_format($hasil[$t]['Ft'], 2);
    }


    $isi_table .= '
    
        <tr>
            <td>'.$urutan.'</td>
            <td>'.$hsl['bulan'].'</td>
            <td>'.$hsl['actual'].'</td>
            <td>'.number_format($hsl['pemulusan_1'], 2).'</td>
            <td>'.number_format($hsl['pemulusan_2'], 2).'</td>
            <td>'.number_format($hsl['pemulusan_3'], 2).'</td>
            <td>'.number_format($hsl['at'], 2).'</td>
            <td>'.number_format($hsl['bt'], 2).'</td>
            <td>'.number_format($hsl['ct'], 2).'</td>
            <td>'.$Ft.'</td>
        </tr>
    ';



    $peramalan = array(

        'bulan' => $hsl['bulan'],
        'actual'=> $hsl['actual'],
        'pemulusan_1'=> $hsl['pemulusan_1'],
        'pemulusan_2'=> $hsl['pemulusan_2'],
        'pemulusan_3'=> $hsl['pemulusan_3'],
        'at'   => $hsl['at'],
        'bt'   => $hsl['bt'],
        'ct'   => $hsl['ct'],
        'Ft'   => $Ft
    );

    
    // push array $hasil
    array_push( $actual_forecast, $peramalan );




    $urutan++;
}


echo "<table border='1' width='100%'>
    <tr>
        <th>No</th>
        <th>BLN</th>
        <th>Actual</th>
        <th>S't</th>
        <th>S''t</th>
        <th>S'''t</th>
        <th>at</th>
        <th>bt</th>
        <th>ct</th>
        <th>Ft</th>
    </tr>

    ". $isi_table ."
</table>";




// ------------------------------------------------

# MAPE (Mean Absolut Percentage Error)
$hasil_mape = array();
$total_ape = 0;
$total_pe = 0;

foreach ( $actual_forecast AS $af ) {


    $PE = "-";
    $APE = "-";

    if ( $af['Ft'] != 0 ) {

        $PE = (( $af['actual'] - $af['Ft'] ) / $af['actual']) * 100;
        $APE = abs($PE);


        $total_ape += $APE;
        $total_pe += $PE;
    }

    $hitung_mape = array(

        'bulan' => $af['bulan'],
        'actual'=> $af['actual'],
        'Ft'    => $af['Ft'],
        'PE'    => $PE,
        'APE'   => $APE
    );

    array_push( $hasil_mape, $hitung_mape );
}





// visualisasi MAPE 




$isi_table = "";

foreach ( $hasil_mape AS $hm ) {

    $isi_table .= '
    
        <tr>
            <td>'.$hm['bulan'].'</td>
            <td>'.$hm['actual'].'</td>
            <td>'.$hm['Ft'].'</td>
            <td>'.$hm['PE'].'</td>
            <td>'.$hm['APE'].'</td>
        </tr>
    ';
}


echo '<h2>Mean Absolut Percentage Error</h2>';
echo '<table border="1">
    <tr>
        <th>Bulan</th>
        <th>Actual</th>
        <th>Forecast</th>
        <th>PE</th>
        <th>APE</th>
    </tr>

    '.$isi_table.'

    <tr>
        <td colspan="3"></td>
        <td colspan=""><b>'.$total_pe.'</b></td>
        <td colspan=""><b>'.$total_ape.'</b></td>
    <tr>
</table>';


$MAPE = $total_ape / 10;
$MPE = $total_pe / 10;

echo '<h2>Mean Percentage Error '.number_format($MPE, 2).'</h2>';
echo '<h2>Mean Absolut Percentage Error '.number_format($MAPE, 2).'</h2>';






?>