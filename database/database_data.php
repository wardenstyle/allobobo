<?php

function ab_get_data() {

    //mettez les insertions de données ici
    global $ab_db;

    $insert_table = ["
    
    INSERT INTO $ab_db->utilisateur (`code`, `nom_user`, `email_user`,`type_compte`, `mdp`, `id_rdv`) VALUES
    (1, 'Dr Queen', 'queen@allobobo.fr','MDC', 'ab4f63f9ac65152575886860dde480a1', null),
    (2, 'Dr Who', 'who@allobobo.fr','MDC', 'ab4f63f9ac65152575886860dde480a1', null),
    (3, 'Dr House', 'franck@allobobo.fr','MDC', 'ab4f63f9ac65152575886860dde480a1', null),
    (4, 'admin', 'admin@allobobo.fr','ADM', '21232f297a57a5a743894a0e4a801fc3', null)
    ;

    INSERT INTO $ab_db->medecin (`id_medecin`, `nom_medecin`, `email_medecin`, `disponibilite`,`specialite`,`image`, `code_user`) VALUES
    (1, 'Dr Queen', 'queen@allobobo.fr', '1','Médecin généraliste','images/m1.png','1'),
    (2, 'Dr Who', 'who@allobobo.fr', '1','Cardiologue','images/m2.png','2'),
    (3, 'Dr House', 'franck@allobobo.fr', '1','Anesthésiste','images/m3.png','3');

    INSERT INTO $ab_db->service_status (id, status) VALUES (1, 'inactive');
       
    "];
    return $insert_table;

}