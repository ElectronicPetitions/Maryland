<?PHP
include_once('/var/www/secure.php'); 
function mysqli_field_name($result, $field_offset)
{
    $properties = mysqli_fetch_field_direct($result, $field_offset);
    return is_object($properties) ? $properties->name : null;
}
if ($_COOKIE['level'] == 'admin'){
  $q = "SELECT date_time_signed, signed_name_as, VTRID, shared_email, petition_id, VoterList_table FROM signatures where signature_status = 'verified' ORDER BY id";
}else{
  $q = "SELECT date_time_signed, signed_name_as, VTRID, shared_email, VoterList_table FROM signatures where petition_id = '$_COOKIE[petition_id]' and signature_status = 'verified' ORDER BY id";
}

$r = $petition->query($q);

$fields = mysqli_num_fields ( $r );

for ( $i = 0; $i < $fields; $i++ )
{
    $header .= mysqli_field_name( $r , $i ) . "\t";
}
// https://www.php.net/manual/en/mysqli-result.fetch-row.php
while( $row = $r->fetch_row() )
{
    $line = '';
    foreach( $row as $value )
    {                                            
        if ( ( !isset( $value ) ) || ( $value == "" ) )
        {
            $value = "\t";
        }
        else
        {
            $value = str_replace( '"' , '""' , $value );
            $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;
    }
    $data .= trim( $line ) . "\n";
}
$data = str_replace( "\r" , "" , $data );

if ( $data == "" )
{
    $data = "\n(0) Records Found!\n";                        
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=petition_signatures_".time().".xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";
