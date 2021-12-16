<?php do_action('before_account_page') ?>

<div class="tab-pane content-panel" id="account">
    <div class="account-info mt-4">
        <div class="container">
            <div class="title text-center">
                <h4>Tus datos son:</h4>
            </div>
            <div class="info-forms">
                <div class="personal-info">
                    <?php $address = get_user_meta(get_current_user_id(), '_user_address', false); ?>
                    <form method="post" id="edit-info-form">
                        <div class="form-container d-flex flex-wrap justify-content-md-between mx-auto mt-4">
                            <div class="input-container col-12 col-md-5 mx-1 d-flex align-items-center" id="">
                                <label for="Nombre">Nombre: </label>
                                <input type="text" placeholder="" class="input-account" name="first_name_account" id="first_name_account" value="<?php echo wp_get_current_user()->first_name ?>" required disabled>
                            </div>
                            <div class="input-container col-12 col-md-5 mx-1 d-flex align-items-center" id="">
                                <label for="Apellido">Apellido: </label>
                                <input type="text" placeholder=" " class="input-account" name="last_name_account" id="last_name_account" value="<?php echo wp_get_current_user()->last_name ?>" required disabled>
                            </div>
                            <div class="input-container col-12 col-md-5 mx-1 d-flex align-items-center" id="">
                                <label for="Contacto">Tel. Contacto: </label>
                                <input type="tel" placeholder=" " class="input-account" name="user_phone" id="user_phone" value="<?php echo user_panel_proccess()->get_user_phone(wp_get_current_user()->ID) ?>" disabled>
                            </div>
                            <div class="input-container col-12 col-md-5 mx-1 d-flex align-items-center">
                                <label for="email">E-mail: </label>
                                <input type="email" placeholder=" " name="user_email_account" id="user_email_account" value="<?php echo wp_get_current_user()->user_email ?>" disabled>
                            </div>
                            <!-- <div class="input-container col-12 col-md-5 mx-1 d-flex align-items-center"
                            id="">
                            <label for="pais">País: </label>
                            <input type="text" id="pais" placeholder=" " name="country_name" id="country_name" value="<?php //echo user_panel_proccess()->get_user_country(wp_get_current_user()->ID) 
                                                                                                                        ?>" disabled>
                        </div>
                        <div class="input-container col-12 col-md-5 mx-1 d-flex align-items-center"
                            id="">
                            <label for="provincia">Provincia: </label>
                            <input type="text" id="provincia" name="state" placeholder=" " value="<?php //echo $address[0]['state'] !== null ? $address[0]['state'] : ''; 
                                                                                                    ?>" disabled>
                        </div>-->
                            <div class="input-container col-12 col-md-5 mx-1 d-flex flex-column align-items-center" id="">
                                <div class="d-flex align-items-center w-100">
                                    <label for="Contrasena">Contraseña: </label>
                                    <input type="password" id="Contrasena" class="input-account" placeholder=" " value="" disabled>
                                </div>
                                <p><?php echo __('dejar en blanco si no se va a cambiar', 'gen-base-theme') ?></p>
                            </div>
                        </div>
                        <div class="btns-container text-center d-flex justify-content-center mt-4">
                            <input type="hidden" name="user_id" value="<?php echo wp_get_current_user()->ID ?>">
                            <button type="button" id="editPersonalInfo">Editar datos</button>
                            <input type="submit" id="editInfo" style="display: none;" name="update_profile" value="Guardar" />
                            <button type="button" id="finishEditingPersonalInfo" class="gray-btn-black-text">Cerrar</button>
                        </div>
                    </form>
                </div>
                <div class="delivery-info text-md-center mt-3">
                    <button class="delivery-info-dropdown collapsed" type="button" data-toggle="collapse" data-target="#deliveryInfo" aria-expanded="false" aria-controls="deliveryInfo">
                        <div class="d-flex">
                            <div>
                                <p>Datos para recibir la Edición Impresa</p>
                            </div>
                            <div class="dropdown-icon mr-2">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/arrow.svg" alt="" />
                            </div>
                        </div>
                    </button>
                    <div class="collapse" id="deliveryInfo">
                        <div class="card card-body p-0">
                            <div class="subtitle">
                                <p>Por favor, indicamos un domicilio donde se te enviará el diario.</p>
                            </div>
                            <div class="form-container d-flex flex-wrap justify-content-md-between mx-auto">
                                <div class="input-container col-12 col-md-5 mx-1 d-flex align-items-center d-flex align-items-center" id="">
                                    <label for="Provincia">Provincia: </label>
                                    <select name="state" id="state" required>
                                        <option value=""> -- seleccionar -- </option>
                                        <option value="CABA" <?php selected('CABA', $address[0]['state']) ?>>CABA</option>
                                        <option value="gba" <?php selected('gba', $address[0]['state']) ?>>Gran Buenos Aires</option>
                                        <option value="PBA" <?php selected('PBA', $address[0]['state']) ?>>Provincia de Buenos Aires</option>
                                    </select>
                                </div>
                                <div class="input-container  col-12 col-md-5 mx-1 d-flex align-items-center d-flex align-items-center" id="">
                                    <label for="Localidad">Localidad: </label>
                                    <select name="city" id="city" required>
                                        <option value=""> -- seleccionar --</option>
                                    </select>
                                    <input type="hidden" id="localidad" value="<?php echo $address[0]['city'] ?>">
                                </div>
                                <div class="input-container  col-12 col-md-5 mx-1 d-flex align-items-center d-flex align-items-center" id="">
                                    <label for="Calle">Calle: </label>
                                    <input type="text" id="address" class="input-account" name="address" required placeholder=" " value="<?php echo $address[0]['address'] !== null ? $address[0]['address'] : ''; ?>" required disabled>
                                </div>
                                <div class="input-container  col-12 col-md-5 mx-1 d-flex align-items-center d-flex align-items-center" id="">
                                    <label for="Numero">Número: </label>
                                    <input type="number" name="number" class="input-account" id="number" placeholder=" " value="<?php echo $address[0]['number'] !== null ? $address[0]['number'] : ''; ?>" required disabled>
                                </div>
                                <div class="input-container  col-12 col-md-5 mx-1 d-flex align-items-center d-flex align-items-center" id="">
                                    <label for="cp">CP: </label>
                                    <input type="text" id="zip" name="zip" placeholder=" " class="input-account" value="<?php echo $address[0]['zip'] !== null ? $address[0]['zip'] : ''; ?>" disabled>
                                </div>
                                <div class="input-container col-12 col-md-5 mx-1 d-flex align-items-center d-flex align-items-center" id="">
                                        <label for="cp">Piso: </label>
                                        <input type="text" placeholder=" " class="input-account" name="floor" id="floor" value="<?php echo $address[0]['floor'] !== null ? $address[0]['floor'] : ''; ?>"/>
                                </div>
                                <div class="input-container col-12 col-md-5 mx-1 d-flex align-items-center d-flex align-items-center" id="">
                                    <label for="cp">Departamento: </label>
                                    <input type="text" placeholder=" " class="input-account" name="apt" id="apt" value="<?php echo $address[0]['apt'] !== null ? $address[0]['apt'] : ''; ?>" />
                                </div>
                                <div class="input-container col-12 col-md-5 mx-1 d-flex align-items-center d-flex align-items-center" id="">
                                    <label for="">Entre calles</label>
                                    <input type="text" placeholder=" " class="input-account" name="bstreet" id="bstreet" value="<?php echo $address[0]['bstreet'] !== null ? $address[0]['bstreet'] : ''; ?>" />
                                </div>
                            </div>
                            <div class="btns-container text-center d-flex justify-content-center my-4">
                                <button type="button" id="editDeliveryInfo">Editar datos</button>
                                <button type="button" id="address-button-2" style="display: none;">Guardar</button>
                                <button type="button" id="finishEditingDeliveryInfo" class="gray-btn-black-text">Cerrar</button>
                            </div>
                        </div>
                    </div>
                    <div class="support text-center">
                        <p>Deseo <a href="mailto:pagostiempo@gmail.com"><b>contactar con soporte</b></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php do_action('account_extra_content') ?>
</div>