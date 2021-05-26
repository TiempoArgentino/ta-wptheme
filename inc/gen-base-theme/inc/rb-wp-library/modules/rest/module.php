<?php
// =============================================================================
// SCRIPTS
// =============================================================================
add_action ("wp_enqueue_scripts", "rb_rest_api_scripts");
function rb_rest_api_scripts() {
    wp_enqueue_script( 'wp-api' );
}

// =============================================================================
// CLASSES
// =============================================================================
class RB_Rest_Error{
    public $error_message = "There has been an error!";
    public $status = '';

    public function __construct( $error_message, $status = false ){
        $this->error_message = $error_message;
        $this->status = $status === false ? rest_authorization_required_code() : $status;
    }

    public function throw_self(){
        return new WP_Error( 'rest_auth_error', __( $this->error_message ),
            array( 'status' => $this->status ) );
    }

}

class RB_Rest_Error_Manager{
    // =============================================================================
    // SINGLETON CONFIGURATION
    // =============================================================================
	// Contenedor de la instancia del singleton
    private static $instancia;

    // Un constructor privado evita la creación de un nuevo objeto
    private function __construct(){
    }

    // método singleton
    public static function singleton(){
        if (!isset(self::$instancia)){
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

	// Evita que el objeto se pueda clonar
    public function __clone(){
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }

    // =========================================================================
    // BEGINS
    // =========================================================================
    public static $errors;

    //Cant assign array as value on $errors on initialization, neither on the constructor,
    //So I should establish the errors every time I want to use them, if the $errors is not set.
    //Should find a way to solve this...
    public static function establish_errors(){
        if (!self::$errors){
            self::$errors = array(
                'capability' => array(
                    'fallback'  => function($capability_name){
                        return new RB_Rest_Error("You need to have the following capability to access this endpoint: '$capability_name'");
                    },
                    'edit_themes'   => new RB_Rest_Error("You need to be able to edit themes to access this endpoint"),
                ),
                'role' => array(
                    'fallback'  => function($user_role){
                        return new RB_Rest_Error("Your user needs to be of the following role to access this endpoint: $user_role");
                    },
                    'administrator'   => new RB_Rest_Error("You need to be an administrator to access this endpoint"),
                ),
            );
        }
    }

    public static function get_error($type, $name){
        self::establish_errors();
        return self::$errors[$type][$name];
    }

    public static function throw_error($type, $name){
        //If the error exists
        if ($error = self::get_error($type, $name))
            return $error->throw_self();
        //If it doesnt, but there is a fallback, calls it
        if( $fallback = self::get_error($type,'fallback'))
            return call_user_func($fallback, $name)->throw_self();
    }

}

class RB_WP_Rest_API_Extended{
    // =============================================================================
    // SINGLETON CONFIGURATION
    // =============================================================================
	// Contenedor de la instancia del singleton
    private static $instancia;

    // Un constructor privado evita la creación de un nuevo objeto
    private function __construct() {
        $this->user = wp_get_current_user();
    }

    // método singleton
    public static function singleton(){
        if (!isset(self::$instancia)){
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

	// Evita que el objeto se pueda clonar
    public function __clone(){
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }

    // =============================================================================
    // BEGINS
    // =============================================================================
    private static $conditions = array();
    private static $user;
    private static $errorsLog = array();

    // =========================================================================
    // CONDITIONS
    // =========================================================================

    //Check if the user meets all the conditions necessaries to make the request
    //ARGS          (Array)$conditions: Conditions to validate
    //
    //RETURNS:      true: user meet conditions
    //              WP_Error or false: user doesnt meet conditions
    public static function check_conditions( $conditions ){
        self::$conditions = $conditions;
        //CHECK CAPABILITIES
        $capabilities = self::check_condition('capability', 'check_user_capability');
        if ( is_object($capabilities) )
            return $capabilities;
        //CHECK ROLES
        $roles = self::check_condition('role', 'check_user_role');
        if ( is_object($roles) )
            return $roles;
        return true;
    }

    //Checks if the user meets all the conditions of a certain type.
    //ARGS          $condition_name: key in the $conditions array to check for.
    //              (String)$validator: name of self function that will validate the conditions.
    //                  Takes one parameter (string) value of the condition.
    //
    //RETURNS:      true: user meet conditions
    //              WP_Error or false: user doesnt meet conditions
    public static function check_condition($condition_name, $validator){
        $result = true;
        $condition = isset(self::$conditions[$condition_name]) ? self::$conditions[$condition_name] : null;
        if ( $condition ){//Checks if the condition exists
            if ( is_array($condition) ){//if it exists and is an array, it checks all the conditions
                foreach ( $condition as $condition_value ){
                    $result = is_callable($validator) ? self::$validator($condition_value) : true;
                    if ( if_object($result) )
                        break;
                }
            }
            else if ( is_string($condition) )//if it is a string, it checks only one time
                $result = self::$validator($condition);
        }
        return $result;
    }

    //Checks if the user can to something
    //ARGS          (String)$capability_name: capability to check
    //RETURNS       true: meets capability
    //              WP_Error or false: fails current_user_can($capability_name)
    public static function check_user_capability($capability_name){
        if( current_user_can( self::$conditions[$capability_name] ) )
            return true;
        return RB_Rest_Error_Manager::throw_error('capability', $capability_name);
    }

    //Checks if the user is of a certain role
    //ARGS          (String)$role_name: role to check for
    //RETURNS       true: the user is of the given role
    //              WP_Error or false: the user doesn't have that role
    public static function check_user_role($role_name){
        $user = wp_get_current_user();
        if ( in_array( $role_name, (array) $user->roles ) )
            return true;
        return RB_Rest_Error_Manager::throw_error('role', $role_name);
    }
    // =============================================================================
    // ROUTES REGISTER
    // =============================================================================
    //Register the rest route, using the $data given
    private static function register_rest_route($data){
        register_rest_route( $data['namespace'], $data['route'], $data['args'] );
    }

    public static function register_route($methods, $namespace, $route, $callback){
        $data = array(
            'namespace' => $namespace,
            'route'     => $route,
            'args'      => array(
                'methods'               => $methods,
                'callback'              => $callback,
                'args'                  => array( 'conditions' => self::$conditions ),
                'permission_callback'   =>  function($request){
                    $args = $request->get_attributes()['args'];
                    if ( $args['conditions'] )
                        return self::check_conditions( $args['conditions'] );
                    return true;
                },
        ));
        add_action( 'rest_api_init', function() use ($data){
            self::register_rest_route($data);
        });
    }

    public static function get($namespace, $route, $callback){
        self::register_route("GET", $namespace, $route, $callback);
    }

    public static function post($namespace, $route, $callback){
        self::register_route("POST", $namespace, $route, $callback);
    }

    public static function group($conditions, $actions){
        self::$conditions = $conditions;
        $actions();
        self::$conditions = array();
    }
}



?>
