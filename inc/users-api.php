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
        $data = [$request->get_json_params()];
        if ($data) {

            foreach ($data as $d) {

                if(trim($d['email']) === null) {
                  // echo http_response_code(409).'\n No existe';
                    echo wp_send_json_error( 'No existe', 409 );
                    continue;
                }

                if(empty($d['email']) || $d['email'] === '' || $d['email'] === ' '){
                    echo wp_send_json_error( 'Falta el email', 409 );
                    continue;
                }

                if(!filter_var($d['email'], FILTER_SANITIZE_EMAIL)){
                    echo wp_send_json_error( 'Email incorrecto', 409 );
                    continue;
                }

                if(get_user_by('email', trim($d['email']))){
                    echo wp_send_json_error( 'El usuario ya existe', 409 );
                    continue;
                }
            
                if (!get_user_by('email', trim($d['email']))) {

                    $name = array_key_exists('name',$d) ? $d['name'] : '';
                    $lastname = array_key_exists('lastname',$d) ? $d['lastname'] : '';

                    $new = $this->new_user(trim($d['email']), $name, $lastname);
                  
                    
                    if (!$new) {
                        echo wp_send_json_error( 'No se creo el usuario', 400 );
                        /**
                         * sino se importo, reintentar
                         */
                    } else {
                        
                        if($d['category'] === 'SOCIO' || $d['category'] === 'SUSCRIPTOR') {
                            $dir = array_key_exists('address',$d) ? $d['address'] : '';
                            $dir_num = array_key_exists('address_number',$d) ? $d['address_number'] : '';
                            $floor = array_key_exists('floor',$d) ? $d['floor'] : '';
                            $number = array_key_exists('number',$d) ? $d['number'] : '';
                            $CPA = array_key_exists('CPA',$d) ? $d['CPA'] : '';
                            $between_streets = array_key_exists('between_streets',$d) ? $d['between_streets'] : '';

                            $address = [
                                'state' =>  '-',
                                'city' => '-',
                                'address' => $dir,
                                'number' => $dir_num,
                                'floor' => $floor,
                                'apt' => $number,
                                'zip' => $CPA,
                                'bstreet' => $between_streets,
                                'observations' => ''
                            ];
                            update_user_meta($new, '_user_address', $address);
                        }
                        $phone = array_key_exists('phone',$d) AND $d['phone'] !== null ? $d['phone'] : '';
                        update_user_meta($new, '_user_status', 'active'); //$user_status = 'active';'on-hold';
                        update_user_meta($new, '_user_phone', $phone);       

                        $order_reference = get_option('member_sku_prefix', 'TA-') . date('YmdHms');
                       

                        $create_order = [
                            'post_title' => $order_reference,
                            'post_status'   => 'publish',
                            'post_type'     => 'memberships',
                            'post_author'   => 1,
                        ];

                        $create = wp_insert_post($create_order);

                        $payment_type = $d['payment'];

                        $id_category = $d['id_category'];

                        if($id_category == '1'){
                            $category_id = 235;
                        } else if($id_category == '2') {
                            $category_id = 295;
                        } else if($id_category == '3' || $id_category == '5') {
                            $category_id = 237;
                        }

                        if($payment_type != 'DEBIT' && array_key_exists('infopago',$d)) { //sino es debito, arma mercadopago

                            $period = $d['infopago'][0]['auto_recurring']['frequency_type'] === 'months' ? 'month' : 'day';

                            $sumo_mes = date('Y-m-d H:i:s', strtotime($d['infopago'][0]['next_payment_date']));
                            $user = get_user_by('id',$new);
                            $order_data = [
                                '_member_order_reference' => $order_reference,
                                '_member_order_status' => 'completed',
                                '_member_payment_method' => 'mp',
                                '_member_payment_method_title' => 'Mercadopago',
                                '_member_user_id' => $new,
                                '_member_renewal_date' => $sumo_mes,
                                '_member_suscription_id' => $category_id, //segun id de categoria
                                '_member_suscription_name' => $d['infopago'][0]['reason'],
                                '_member_suscription_period' => $period,
                                '_member_suscription_period_number' => $d['infopago'][0]['auto_recurring']['frequency'],
                                '_member_suscription_cost' => $d['infopago'][0]['auto_recurring']['transaction_amount'],
                                '_member_suscription_user_email' => $user->user_email,
                                'payment_type' => 'subscription'
                            ];

                            foreach ($order_data as $key => $value) {
                                add_post_meta($create, $key, $value);
                            }

                            $payment_data = [
                                'ID Suscripción' => $d['infopago'][0]['id'],
                                'Referencia Externa' => 'create-by-api',
                                'ID Cliente' => $d['infopago'][0]['payer_id'],
                                'Estado MP' => $d['infopago'][0]['status'],
                                'Suscripción MP' => $d['infopago'][0]['reason'],
                                'Creada' => $d['infopago'][0]['date_created'],
                                'Init Point' => $d['infopago'][0]['init_point'],
                                'Sandbox Init Point' => $d['infopago'][0]['sandbox_init_point'],
                                'ID Plan' => $d['infopago'][0]['preapproval_plan_id'],
                                'ID Medio de Pago' => $d['infopago'][0]['payment_method_id'],
                                'Frecuencia' => $d['infopago'][0]['auto_recurring']['frequency'] . ' ' . $d['infopago'][0]['auto_recurring']['frequency_type'],
                                'Pago' => $d['infopago'][0]['auto_recurring']['transaction_amount'] . ' ' . $d['infopago'][0]['auto_recurring']['currency_id'],
                                'Inicio' => $d['infopago'][0]['auto_recurring']['start_date']
                            ];
                            $id_subscription = $d['infopago'][0]['id'];
                            $app_id = $d['infopago'][0]['application_id'];

                            add_post_meta($create, 'payment_data', $payment_data);
                            add_post_meta($create, 'payment_app_id', $app_id);
                            add_post_meta($create, 'id_subscription_data', $id_subscription);

                            update_user_meta($new, 'suscription',$category_id);
                            update_user_meta($new, 'suscription_name',$d['infopago'][0]['reason']);

                        } else {

                            $order_data = [
                                '_member_order_reference' => $order_reference,
                                '_member_order_status' => 'completed',
                                '_member_payment_method' => 'bank',
                                '_member_payment_method_title' =>'Automatic bank debit',
                                '_member_user_id' => $new,
                                '_member_suscription_id' => $category_id, //segun categoria
                                'payment_type' => 'subscription'
                            ];

                            foreach ($order_data as $key => $value) {
                                add_post_meta($create, $key, $value);
                            }

                            //$id_category = $d['id_category'] !== null ? $d['id_category'] : '';
                            $category = $d['category'] !== null ? $d['category'] : '';
                            update_user_meta($new, 'suscription',$category_id);
                            update_user_meta($new, 'suscription_name',$category);
                        }
 
                        echo wp_send_json_success( 'Creado', 200 );
                    }
                } else {
                    //echo http_response_code(404).'\n Dta vacio';
                    echo wp_send_json_error( 'No había datos para leer', 404 );
                }
            }
        } 
    }

    public function import_users() //wp-json/suscriptores/v1/suscriptores/
    {
        register_rest_route(
            'suscriptores/v1',
            '/suscriptores/',
            array(
                'methods' => 'POST',
                'callback' => [$this, 'importar_user'],
                'permission_callback'	=> '__return_true',
            )
        );
    }

    public function new_user($email, $first_name, $last_name)
    {
        $data = [
            'user_login' => $email,
            'user_email' => $email,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'display_name' => $first_name . ' ' . $last_name,
            'user_pass' => uniqid(),
            'use_ssl' => true,
            'show_admin_bar_front' => false,
            'role' => 'subscriber'
        ];

        $user_id = wp_insert_user($data);

        if (!is_wp_error($user_id)) {
            return $user_id;
        }

        return is_wp_error($user_id);
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
