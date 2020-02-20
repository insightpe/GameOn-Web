
<?php
// La secuencia básica con LDAP es conectar, amarrar, buscar, interpretar el resultado
// de la búsqueda, y cerrar la conexión.
var_dump($_SERVER['LOGON_USER']);
echo "<h3>Consulta de prueba LDAP</h3>";
echo "Conectando ...";
$ds=ldap_connect("red.cavipetrol.com");  // Debe ser un servidor LDAP válido!
echo "El resultado de la conexión es " . $ds . "<br />";

if ($ds) { 
    echo "Vinculando ..."; 
    //$ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
    $r=ldap_bind($ds, "AdmCigem", '$Cigem2019');     // Esta es una vinculación "anónima", tipicamente
                           // con acceso de sólo lectura.
    echo "El resultado de la vinculación es " . $r . "<br />";

    echo "Buscando (cn=*) ...";
    // Busca la entrada de apellidos
    $sr=ldap_search($ds, "DC=red,DC=cavipetrol,DC=com", "(cn=*)");  
    ldap_error($ds);
    echo "El resultado de la búsqueda es " . $sr . "<br />";

    echo "El número de entradas devueltas es " . ldap_count_entries($ds, $sr) . "<br />";

    echo "Obteniendo entradas ...<p>";
    $info = ldap_get_entries($ds, $sr);
    ldap_error($ds);
    echo "Los datos para " . $info["count"] . " objetos devueltos:<p>";

    for ($i=0; $i<$info["count"]; $i++) {
        echo "El dn es: " . $info[$i]["dn"] . "<br />";
        echo "La primera entrada cn es: " . $info[$i]["cn"][0] . "<br />";
        echo "La primera entrada de correo electrónico es: " . $info[$i]["mail"][0] . "<br /><hr />";
    }

    echo "Cerando la conexión";
    ldap_error($ds);
    ldap_close($ds);
    ldap_error($ds);
} else {
    echo "<h4>No se puede conectar al servidor LDAP</h4>";
}
?>