<?php

ob_start();

session_start();
$id = $_POST['btn_map_xml'];

require('../PHP/conn.php');
//	require('../PHP/funciones.php');
	$db = conectar();
	if ($db)
	{
		$sql = 'SELECT * FROM coberturas where record_id='.$id.';';
		$result = pg_query($db, $sql); 
		if( $fila = pg_fetch_array($result) )
        {  $cobertura = $fila['cobertura']; }
        $cobertura = strtolower($cobertura);
		$cita = $fila['cita']; 	
		$fecha_inicial = $fila['fecha_inicial']; 	
		$nombre = $fila['nombre']; 	
		$resumen = $fila['resumen']; 	
        $geoform = $fila['geoform'];
        $resumen = $fila['resumen'];
        $objetivo = $fila['objetivo'];
        $datos_comp = $fila['datos_comp'];
        $software_hardware = $fila['software_hardware'];
        $sistema_operativo = $fila['sistema_operativo'];
        $metodologia = $fila['metodologia'];
        $descrip_proceso = $fila['descrip_proceso'];
        $descrip_metodologia = $fila['descrip_metodologia'];
        $tabla = $fila['tabla'];
        $datum = $fila['datum'];
        $elipsoide = $fila['elipsoide'];
        if (NULL == $fila['tiempo'])
        {  $tiempo = "000000";} // Hay que preguntar que hacer si el dato esta vacio. En este caso estoy rellenando con 00 pero tal vez podria no llevar algo
        $tiempo2 = $fila['tiempo2'];

//-----------------
        $links ='SELECT liga_www FROM ligas_www where dataset_id='.$id.';';     
        $links_k = pg_query($db, $links);
        $num_link = pg_num_rows($links_k); 

        for ($l = 0; $l < $num_link; $l++){
            $links_p = pg_fetch_result($links_k, $l, 0);
            //$ligas_www = $ligas_www.'<onlink>'.$links_p.'</onlink>';
            $ligas_www .= '<onlink>'.$links_p.'</onlink>';
        };

//-----------------

        $avance = $fila['avance'];
        $mantenimiento = $fila['mantenimiento'];
        $area_geo = $fila['area_geo'];
        $oeste = $fila['oeste'];
        $este = $fila['este'];
        $norte = $fila['norte'];
        $sur = $fila['sur'];
//-----------------
        $palabras='SELECT palabra_clave FROM temas_clave where dataset_id='.$id.';';     
        $palabras_k = pg_query($db, $palabras);
        $num_clave = pg_num_rows($palabras_k); 

        for ($i = 0; $i < $num_clave; $i++){
            $clave_p = pg_fetch_result($palabras_k, $i, 0);
            $palabra_clave .= '<themekt>'.$clave_p.'</themekt>';
        };

//-----------------

        $sitios='SELECT sitios_clave FROM sitios_clave where dataset_id='.$id.';';     
        $sitio_k = pg_query($db, $sitios);
        $num_sitios = pg_num_rows($sitio_k); 

        for ($j = 0; $j < $num_sitios; $j++){
            $clave_k = pg_fetch_result($sitio_k, $j, 0);
            $sitios_clave .= '<placekt>'.$clave_k.'</placekt>';
        };

//-----------------
        $taxonomia = 'SELECT * FROM taxonomia where dataset_id='.$id.';';
		$tax = pg_query($db, $taxonomia); 
		if( $fila_tax = pg_fetch_array($tax) )
            $reino = $fila_tax['reino']; 
            $division = $fila_tax['division']; 
            $clase = $fila_tax['clase']; 
            $orden = $fila_tax['orden']; 
            $familia = $fila_tax['familia']; 
            $genero = $fila_tax['genero']; 
            $especie = $fila_tax['especie']; 
            $nombre_comun = $fila_tax['nombre_comun']; 
	
        $taxon_conabio = '<taxonkt>Taxon_CONABIO</taxonkt><taxonkey>'.$clase.'</taxonkey><taxonkey>'.$orden.'</taxonkey><taxonkey>'.$familia.'</taxonkey><taxonkey>'.$genero.'</taxonkey><taxonkey>'.$especie.'</taxonkey><taxonkey>'.$nombre_comun.'</taxonkey>';


//-----------------

        $tax_cita = 'select * from taxon_cita where id_taxon=(select id_taxon from taxonomia where dataset_id='.$id.');';
        $taxon_cita = pg_query($db, $tax_cita);
        $num_tax_cita = pg_num_rows($taxon_cita); 

        $citeinfo = ''; 
        for ($m = 0; $m < $num_tax_cita; $m++){
            
		if( $fila_taxon_c = pg_fetch_array($taxon_cita) )
            $origin_t = $fila_taxon_c['cita']; 
            $pubdate_t = $fila_taxon_c['pubdate']; 
            $title_c = $fila_taxon_c['title']; 
            $geoform_t = 'No conocido';
    
            $citeinfo .= '<origin>'.$origin_t.'</origin><pubdate>'.$pubdate_t.'</pubdate><title>'.$title_t.'</title><geoform>'.$geoform_t.'</geoform>';
        };
//-----------------
        $d_orig = 'select * from datos_origen where dataset_id='.$id.';';
        $d_origin = pg_query($db, $d_orig);
        $num_d_origin = pg_num_rows($d_origin); 

        $dato_origen = ''; 
        for ($d = 0; $d < $num_d_origin; $d++){
            if( $fila_dato_o = pg_fetch_array($d_origin) )
                if (NULL == $fila_dato_o['origen_dato']){
                    $origen_dato = "No conocido";}
                else {
                    $origen_dato = $fila_dato_o['origen_dato'];} 
                if (NULL == $fila_dato_o['escala_original']){
                    $escala_original = "No conocido";}
                else {
                    $escala_original = $fila_dato_o['escala_original'];} 
                if (NULL == $fila_dato_o['formato_original']){
                    $formato_original = "No conocido";}
                else {
                    $formato_original = $fila_dato_o['formato_original'];} 
                if (NULL == $fila_dato_o['nombre']){
                    $nombre_d = "No conocido";}
                else {
                    $nombre_d = $fila_dato_o['nombre'];} 
                if (NULL == $fila_dato_o['publish']){
                    $publish_d = "No conocido";}
                else {
                    $publish_d = $fila_dato_o['publish'];} 
                if (NULL == $fila_dato_o['publish_siglas']){
                    $publish_siglas_d = "No conocido";}
                else {
                    $publish_siglas_d = $fila_dato_o['publish_siglas'];} 
                if (NULL == $fila_dato_o['pubplace']){
                    $pubplace_d = "No conocido";}
                else {
                    $pubplace_d = $fila_dato_o['pubplace'];} 
                if (NULL == $fila_dato_o['edition']){
                    $edition_d = "No conocido";}
                else {
                    $edition_d = $fila_dato_o['edition'];} 
                if (NULL == $fila_dato_o['geoform']){
                    $geoform_d = "No conocido";}
                else {
                    $geoform_d = $fila_dato_o['geoform'];} 
                if (NULL == $fila_dato_o['pubdate']){
                    $pubdate_d = "No conocido";}
                else {
                    $pubdate_d = $fila_dato_o['pubdate'];} 
                if (NULL == $fila_dato_o['srccontr']){
                    $srccontr = "No conocido";}
                else {
                    $srccontr = $fila_dato_o['srccontr'];} 
                if (NULL == $fila_dato_o['issue']){
                    $issue = "No conocido";}
                else {
                    $issue = $fila_dato_o['issue'];} 
                if (NULL == $fila_dato_o['onlink']){
                    $onlink = "No conocido";}
                else {
                    $onlink = $fila_dato_o['onlink'];} 
            $srccitea = 'No conocido'; //revisar
            $srccurr = 'No conocido';  //revisar 
    
            $dato_origen .= '<srcinfo><srccite><citeinfo><origin>'.$origen_dato.'</origin><pubdate>'.$publish_d.'</pubdate><title>'.$nombre_d.'</title><geoform>'.$geoform_d.'</geoform></citeinfo></srccite><srcscale>'.$escala_original.'</srcscale><typesrc>'.$formato_original.'</typesrc><srctime><timeinfo><sngdate><caldate>'.$pubdate_d.'</caldate></sngdate></timeinfo><srccurr>'.$srccurr.'</srccurr></srctime><srccitea>'.$srccitea.'</srccitea><srccontr>'.$srccontr.'</srccontr></citeinfo></srccite></srcinfo>';
        }
//-----------------//-----------------
        $d_attr = 'select * from atributos where dataset_id='.$id.';';
        $d_atributo = pg_query($db, $d_attr);
        $num_d_atributo = pg_num_rows($d_atributo); 

        $atributo = ''; 
        for ($a = 0; $a < $num_d_atributo; $a++){
            if( $fila_attr = pg_fetch_array($d_atributo) )
                    $nombre_atributo = $fila_attr['nombre']; 
                    $tipo_atributo = $fila_attr['tipo'];
                    $descripcion_atributo = $fila_attr['descripcion_atributo']; 
                    $fuente = $fila_attr['fuente']; 
        $atributo .= '<attr><attrlabl>'.$nombre_atributo.'</attrlabl><attrdef>'.$tipo_atributo.'</attrdef><attrdefs>'.$fuente.'</attrdefs><attrdomv><udom>'.$descripcion_atributo.'</udom></attrdomv></attr>';
        }

        $analista_query = 'select * from analistas where "idAnalista" = (select id_analista from coberturas where record_id ='.$id.');';
		$result_ana = pg_query($db, $analista_query); 
		if( $fila_ana = pg_fetch_array($result_ana) )
            $persona = $fila_ana['Persona']; 
		    $mail = $fila_ana['mail']; 	
		    $puesto = $fila_ana['Puesto']; 	
	






	} //Cerrrar conexion a la BD

$xml_text_1 = '<?xml version="1.0" encoding="UTF-8"?><metadata xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://www.conabio.gob.mx/informacion/gis/schemas/fgdc/fgdc-std-001.1-1999.xsd"><idinfo><citation><citeinfo><origin>'.$cita.'</origin><pubdate>'.$fecha_inicial.'</pubdate><title>'.$nombre.'</title><geoform>'.$geoform.'</geoform><othercit>1000000_XML</othercit><onlink>'.$ligas_www.'</onlink></citeinfo></citation><descript><abstract>'.$resumen.'</abstract><purpose>'.$objetivo.'</purpose><supplinf>'.$datos_comp.'</supplinf></descript><timeperd><timeinfo><sngdate><caldate>'.$tiempo.'</caldate></sngdate></timeinfo><current>'.$teimpo2.'</current></timeperd><status><progress>'.$avance.'</progress><update>'.$mantenimiento.'</update></status><spdom><descgeog>'.$area_geo.'</descgeog><bounding><westbc>'.$oeste.'</westbc><eastbc>'.$este.'</eastbc><northbc>'.$norte.'</northbc><southbc>'.$sur.'</southbc></bounding></spdom><keywords><theme>'.$palabra_clave.'</theme><place>'.$sitios_clave.'</place></keywords><taxonomy><keywtax>'.$taxon_conabio.'</keywtax><taxonsys><classsys><classcit><citeinfo>'.$citeinfo.'</citeinfo></classcit></classsys><taxonpro>No conocido</taxonpro></taxonsys><taxoncl><taxonrn>Reino</taxonrn><taxonrv>'.$reino.'</taxonrv><taxoncl><taxonrn>Division</taxonrn><taxonrv>'.$division.'</taxonrv><taxoncl><taxonrn>Clase</taxonrn><taxonrv>'.$clase.'</taxonrv>/taxonr><taxoncl><taxonrn>Orden</taxonrn><taxonrv>'.$orden.'</taxonrv><taxoncl><taxonrn>Familia</taxonrn><taxonrv>'.$familia.'</taxonrv><taxoncl><taxonrn>Genero</taxonrn><taxonrv>'.$genero.'</taxonrv><taxoncl><taxonrn>Especie</taxonrn><taxonrv>'.$especie.'</taxonrv><common>'.$nombre_comun.'</common><common>'.$nombre_comun.'</common></taxoncl></taxoncl></taxoncl></taxoncl></taxoncl></taxoncl></taxoncl></taxonomy><accconst>Sin restricciones</accconst><useconst>No se permite utilizar estos datos con fines lucrativos y se debe citar la fuente del mapa y a CONABIO Ver la licencia completa en http://creativecommons.org/licenses/by-nc/25/mx/</useconst><browse><browsen>http://wwwconabiogobmx/informacion/gis/layouts/'.$cobertura.'.png</browsen><browsed>Mapa ilustrativo de '.$nombre.'. La proyección citada, es exclusiva para el diseño de esta imagen.</browsed><browset>png</browset></browse><native>'.$software_hardware.'. '.$sistema_operativo.'</native>';

$xml_text_2 = '</idinfo><dataqual><logic>'.$metodologia.'</logic><complete>'.$descrip_metodologia.'</complete><lineage>'.$dato_origen.'<procstep><procdesc>'.$descrip_proceso.'</procdesc>';

$xml_text_3 = '<procdate>00000000</procdate></procstep></lineage></dataqual><spdoinfo><direct>Vector</direct><ptvctinf><sdtsterm ><sdtstype>G-polygon</sdtstype><ptvctcnt>19377</ptvctcnt></sdtsterm></ptvctinf></spdoinfo><spref><horizsys><geograph><latres>0.0174532925199433</latres><longres>0.0174532925199433</longres><geogunit>Decimal degrees</geogunit></geograph><geodetic><horizdn>'.$datum.'</horizdn><ellips>'.$elipsoide.'</ellips><semiaxis>6378137.000000</semiaxis><denflat>298.257224</denflat></geodetic></horizsys></spref><eainfo><detailed><enttyp><enttypl>'.$tabla.'</enttypl><enttypd>'.$descripcion_atributo.'</enttypd><enttypds>No conocido</enttypds></enttyp>'.$atributo.'</detailed></eainfo><distinfo><distrib><cntinfo><cntorgp><cntorg>CONABIO</cntorg>';
    
 $xml_text_4 = '<cntper>Jose Manuel Davila Rosas</cntper></cntorgp><cntpos>Subcoordinador de Sistemas de Información Geográfica</cntpos><cntaddr><addrtype>mailing and physical address</addrtype><address>Liga Perif&#x00E9;rico Insurgentes Sur Num. 4903 1er piso. Col. Parques del Pedregal. Delg. Tlalpan</address><city>Ciudad de M&#x00E9;xico</city><state>D.F.</state><postal>14010</postal><country>M&#x00E9;xico</country></cntaddr><cntvoice>50045012</cntvoice><cntfax>50044931</cntfax><cntemail>jdavila@conabio.gob.mx</cntemail><hours>Lunes a Viernes de 8 a 18 hrs.</hours></cntinfo></distrib><resdesc>'.$cobertura.'</resdesc><distliab>La Subdirecci&#x00F3;n de Sistemas de Informaci&#x00F3;n Geogr&#x00E1;fica de la CONABIO solo se hace responsable de la informaci&#x00F3;n presentada en el mapa y se deslinda del uso que se le de a la misma.</distliab><stdorder><digform><digtinfo><formname>ESRI Shapefile (SHP)</formname><formverd>199807</formverd><filedec>compactado en ZIP</filedec><transize>5.28</transize></digtinfo><digtopt><onlinopt><computer><networka><networkr> http://www.conabio.gob.mx/informacion/gis/maps/geo/'.$cobertura.'.zip</networkr></networka></computer><accinstr>Coordenadas geogr&#x00E1;ficas WGS84. (EPSG:4326). Formato vectorial de almacenamiento de elementos geogr&#x00E1;ficos y sus atributos asociados. </accinstr></onlinopt></digtopt></digform><digform><digtinfo><formname>Google Earth (KML)</formname><formvern>2.2</formvern><filedec>compactado como KMZ</filedec></digtinfo><digtopt><onlinopt><computer><networka><networkr> http://www.conabio.gob.mx/informacion/gis/maps/kmz/'.$cobertura.'.kmz</networkr></networka></computer><accinstr>Coordenadas geogr&#x00E1;ficas WGS84. (EPSG:4326). Los archivos KML representan datos geogr&#x00E1;ficos para Google Earth, a menudo suelen distribuirse comprimidos como KMZ.</accinstr></onlinopt></digtopt></digform><digform><digtinfo><formname>CNB.GEO.TMS</formname><formvern>1.0.0</formvern><formspec>PNG</formspec></digtinfo><digtopt><onlinopt><computer><networka><networkr>http://wms0.conabio.gob.mx/'.$cobertura.'.py/</networkr><networkr>';
    
 $xml_text_5 = 'http://wms1.conabio.gob.mx/'.$cobertura.'.py/</networkr><networkr>http://wms2.conabio.gob.mx/'.$cobertura.'.py/</networkr></networka></computer></onlinopt></digtopt></digform><digform><digtinfo><formname>Servicio de im&#x00E1;genes (WMS)</formname><formvern>1.1.1</formvern></digtinfo><digtopt><onlinopt><computer><networka><networkr>http://www.conabio.gob.mx/informacion/explorer/wms?Format=image/gif&amp;request=GetMap&amp;version=1.1.1&amp;width=800&amp;height=424&amp;srs=EPSG:4326&amp;bbox=-120.0,13.8,-85.1,33.5&amp;layers='.$cobertura.'</networkr></networka></computer><accinstr>Coordenadas geogr&#x00E1;ficas WGS84. (EPSG:4326). Servicio Web Map Service. Los mapas de datos referenciados espacialmente producidos se generan normalmente en un formato de imagen como PNG, GIF o JPEG, pueden se vistos en un SIG </accinstr></onlinopt></digtopt></digform><digform><digtinfo><formname>Mapa digital interactivo</formname><formvern>1.0</formvern></digtinfo><digtopt><onlinopt><computer><networka><networkr>http://www.conabio.gob.mx/informacion/gis/?vns=gis_root/biodiv/distpot/dpmamif/dpmcarni/'.$cobertura.'.</networkr></networka></computer><accinstr>Coordenadas geogr&#x00E1;ficas WGS84. (EPSG:4326)</accinstr></onlinopt></digtopt></digform><fees>Acceso libre sin ning&#x00FA;n cargo al p&#x00FA;blico en general.</fees></stdorder><techpreq>Tener Arc-Info, Arcview o sistemas compatibles, en caso que existan se pueden visualizar en Google Earth KML y/o conexi&#x00F3;n al servicio WMS.</techpreq></distinfo><metainfo><metd>20140130</metd><metc><cntinfo><cntorgp><cntorg>CONABIO</cntorg><cntper>'.$persona.'</cntper></cntorgp><cntpos>'.$puesto.'</cntpos><cntaddr><addrtype>mailing and physical address</addrtype><address>Liga Periférico Insurgentes Sur Num. 4903 1er piso. Col. Parques del Pedregal. Delg. Tlalpan</address><city>Ciudad de M&#x00E9;xico</city><state>D.F.</state><postal>14010</postal><country>M&#x00E9;xico</country></cntaddr><cntvoice>01 55 5004 4963</cntvoice><cntfax>50044931</cntfax><cntemail>'.$mail.'</cntemail><hours>Lunes a Viernes de 8 a 18 hrs.</hours></cntinfo></metc><metstdn>FGDC Biological Data Profile of the Content Standard for Digital Geospatial Metadata</metstdn><metstdv>FGDC-STD-001.1-1999</metstdv></metainfo></metadata>';

//Dudas: Se ponen todas las ligas? formato de la fecha. Ahora aparece asi: dd/mm/yy?

$xml_text = $xml_text_1.$xml_text_2.$xml_text_3.$xml_text_4.$xml_text_5; 

echo $xml_text;

//---nombre del archivo

$fichero = 'map_xml.xml';
$dir = $cobertura.".xml";

copy($fichero,$dir);
//-----Descarga del archivo

if (is_file($dir)) {
header("Content-Disposition: attachment; filename=\"$dir\"");
readfile($dir);
} else {
die("Error: no se encontró el archivo '$dir'");
}

?>
