<?php 

class AlloboboDatabase {

    public $prefix = '';

    // Attention à l'ordre des tables à cause des contraintes, classer dans l'ordre pour la suppression des tables
    // Prendre l'ordre inverser de la création des contraintes
    public $tables = array(	

        'rendez_vous',		
        'utilisateur',
        'medecin',
        'service_status',

    );

    // Les champs
    private $init_fields;
    private $fields;

    // Les noms des tables
    public $rendez_vous;
    public $utilisateur; 
    public $medecin; 
    public $service_status;


    public function __construct( ) {
        
        $this->set_prefix("ab_");
        require_once( 'database_fields.php' );
    }

    public function set_prefix( $prefix) {

        if ( preg_match( '|[^a-z0-9_]|i', $prefix ) ) {
            return throw new InvalidArgumentException('Le préfixe doit être une chaîne de caractères valide.');
        }

        $old_prefix = $prefix;

        $this->prefix = $prefix;

        foreach ( $this->tables() as $table => $prefixed_table ) {
            $this->$table = $prefixed_table;
        }

        // Réinit
        $this->fields =  null;
        
        return $old_prefix;
    }

    public function tables( $with_prefix = true ) {
        $tables = $this->tables;

        if ( $with_prefix ) {
            $prefix   = $this->prefix;
            foreach ( $tables as $k => $table ) {
                $tables[ $table ] = $prefix . $table;
                unset( $tables[ $k ] );
            }
        }

        return $tables;
    }

    public function fields(){
        // Calculer que si c'est non initialisé
        if (!isset($this->fields)) {
            $tables = $this->tables();
            $default_values = 
                array(
                    'autoinc' => false,
                    'key' => false,
                    'type' => 'string',
                    'mandatory' => true,
                    'in_select' => true,
                    'caption' => false,
                    'update' => true,
                    );
                    
            foreach($this->init_fields as $t => $cols)
            {
                foreach($cols as $col => $values) {
                    // On utilise le nom de la vrai table comme key
                    // On merge la valeur défaut
                    $this->fields[$tables[$t]][$col] = array_merge($default_values, $values);
                }
            }
        }
        return $this->fields;
    }

}