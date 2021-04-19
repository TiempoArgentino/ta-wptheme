<?php

class Users_Api
{

    public function __construct()
    {
        add_action('rest_api_init', [$this, 'import_users']);
    }

    /**
     * users
     */

    public function importar_user(WP_REST_Request $request)
    {
        header("HTTP/1.1 200 OK");
        $data = $request->get_json_params();
        $data2 = $request->get_params();
        var_dump(gettype($data));
        echo '-------';
        var_dump(is_array($data));

        // foreach($data as $d){
        //     $new = $this->new_user($d['Email'],$d['Nombre'],$d['Apellido']);
        //     return $new;
        // }
        // //var_dump($data2);
        // foreach($data2 as $d){
        //     var_dump($d['Apelido']);


        //     // $new = $this->new_user($d['Email'],$d['Nombre'],$d['Apellido']);
        //     // return $new;
        //     // if($new){
        //     //     $address = [
        //     //         'state' =>  '-',
        //     //         'city' => '-',
        //     //         'address' => $d['street'],
        //     //         'number' => $d['streetnumber'],
        //     //         'floor' => $d['piso'],
        //     //         'apt' => $d['dpto'],
        //     //         'zip' => $d['postal'],
        //     //         'bstreet' => $d['betweenstreets'],
        //     //         'observations' => ''
        //     //     ];

        //     //     update_user_meta( $new, '_user_address', $address);
        //     //     update_user_meta($user_id,'_user_status','active');
        //     // } else {
        //     //     return $new;
        //     // }
        // }
    }

    public function import_users() //wp-json/suscriptores/v1/suscriptores/
    {
        register_rest_route(
            'suscriptores/v1',
            '/suscriptores/',
            array( 
                'methods' => 'POST',
                'callback' => [$this,'importar_user'],
                'permission_callback' => '__return_true'
            )
        );
    }

    public function new_user($email,$first_name,$last_name)
    {
        $data = [
            'user_login' => $email,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'display_name' => $first_name. ' ' .$last_name,
            'user_pass' => uniqid(),
            'use_ssl' => true,
            'show_admin_bar_front' => false,
            'role' => 'subscriber'
        ];

        $user_id = wp_insert_user($data);

        if(!is_wp_error( $user_id )){
            return $user_id;
        }

        return 'error';
    }

    public function create_user_meta($user_id)
    {

    }
}

function user_api()
{
    return new Users_Api();
}

user_api();
