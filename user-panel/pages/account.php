<?php do_action('before_account_page') ?>

<div class="tab-pane content-panel" id="account">
<div class="account-info mt-4">
    <div class="container">
        <div class="title text-center">
            <h4>Tus datos son:</h4>
        </div>
        <div class="info-forms">
            <div class="personal-info">
            <?php $address = get_user_meta(get_current_user_id(), '_user_address', false);?>
                <form method="post">
                    <div class="form-container d-flex flex-wrap justify-content-md-between mx-auto mt-4">
                        <div class="input-container col-12 col-md-5 mx-1 d-flex align-items-center"
                            id="personalInfoInputContainer">
                            <label for="Nombre">Nombre: </label>
                            <input type="text" id="Nombre" placeholder=" " name="first_name_account" id="first_name_account" value="<?php echo wp_get_current_user()->first_name ?>" required disabled>
                        </div>
                        <div class="input-container col-12 col-md-5 mx-1 d-flex align-items-center"
                            id="personalInfoInputContainer">
                            <label for="Apellido">Apellido: </label>
                            <input type="text" id="Apellido" placeholder=" " name="last_name_account" id="last_name_account" value="<?php echo wp_get_current_user()->last_name ?>" required disabled>
                        </div>
                        <div class="input-container col-12 col-md-5 mx-1 d-flex align-items-center"
                            id="personalInfoInputContainer">
                            <label for="Contacto">Tel. Contacto: </label>
                            <input type="tel" id="Contacto" placeholder=" " name="user_phone" id="user_phone" value="<?php echo user_panel_proccess()->get_user_phone(wp_get_current_user()->ID) ?>" disabled>
                        </div>
                        <div class="input-container col-12 col-md-5 mx-1 d-flex align-items-center"
                            id="personalInfoInputContainer">
                            <label for="email">E-mail: </label>
                            <input type="email" placeholder=" " name="user_email_account" id="user_email_account" value="<?php echo wp_get_current_user()->user_email ?>" disabled>
                        </div>
                        <div class="input-container col-12 col-md-5 mx-1 d-flex align-items-center"
                            id="personalInfoInputContainer">
                            <label for="pais">País: </label>
                            <input type="text" id="pais" placeholder=" " name="country_name" id="country_name" value="<?php echo user_panel_proccess()->get_user_country(wp_get_current_user()->ID) ?>" disabled>
                        </div>
                        <div class="input-container col-12 col-md-5 mx-1 d-flex align-items-center"
                            id="personalInfoInputContainer">
                            <label for="provincia">Provincia: </label>
                            <input type="text" id="provincia" name="state" placeholder=" " value="<?php echo $address[0]['state'] !== null ? $address[0]['state'] : ''; ?>" disabled>
                        </div>
                        <div class="input-container col-12 col-md-5 mx-1 d-flex align-items-center"
                            id="personalInfoInputContainer">
                            <label for="Contrasena">Contraseña: </label>
                            <input type="password" id="Contrasena" placeholder=" " value="" disabled>
                            <p><?php echo __('dejar en blanco sino se va a cambiar','gen-theme-base')?></p>
                        </div>
                    </div>
                    <div class="btns-container text-center d-flex justify-content-center mt-4">
                        <button id="editPersonalInfo">Editar datos</button>
                        <button id="finishEditingPersonalInfo" class="gray-btn-black-text">Cerrar</button>
                    </div>
                </form>
            </div>
            <div class="delivery-info text-md-center mt-3">
                <button class="delivery-info-dropdown collapsed" type="button" data-toggle="collapse"
                    data-target="#deliveryInfo" aria-expanded="false" aria-controls="deliveryInfo">
                    <div class="d-flex">
                        <div>
                            <p>Datos para recibir la Edición Impresa</p>
                        </div>
                        <div class="dropdown-icon mr-2">
                            <img src="../../assets/images/arrow.svg" alt="" />
                        </div>
                    </div>
                </button>
                <div class="collapse" id="deliveryInfo">
                    <div class="card card-body p-0">
                        <div class="subtitle">
                            <p>Por favor, indicamos un domicilio donde se te enviará el diario.</p>
                        </div>
                        <div class="form-container d-flex flex-wrap justify-content-md-between mx-auto">
                            <div class="input-container col-12 col-md-5 mx-1 d-flex align-items-center d-flex align-items-center"
                                id="deliveryInputContainer">
                                <label for="Provincia">Provincia: </label>
                                <input type="text" id="Provincia" placeholder=" " name="state" id="state" value="<?php echo $address[0]['state'] !== null ? $address[0]['state'] : ''; ?>" required disabled>
                            </div>
                            <div class="input-container  col-12 col-md-5 mx-1 d-flex align-items-center d-flex align-items-center"
                                id="deliveryInputContainer">
                                <label for="Localidad">Localidad: </label>
                                <input type="text" id="Localidad" name="city" required placeholder=" " value="<?php echo $address[0]['city'] !== null ? $address[0]['city'] : ''; ?>" required disabled>
                            </div>
                            <div class="input-container  col-12 col-md-5 mx-1 d-flex align-items-center d-flex align-items-center"
                                id="deliveryInputContainer">
                                <label for="Calle">Calle: </label>
                                <input type="text" id="Calle" name="address" required placeholder=" " value="<?php echo $address[0]['address'] !== null ? $address[0]['address'] : ''; ?>" required disabled>
                            </div>
                            <div class="input-container  col-12 col-md-5 mx-1 d-flex align-items-center d-flex align-items-center"
                                id="deliveryInputContainer">
                                <label for="Numero">Número: </label>
                                <input type="number" name="number" id="Numero" placeholder=" " value="<?php echo $address[0]['number'] !== null ? $address[0]['number'] : ''; ?>" required disabled>
                            </div>
                            <div class="input-container  col-12 col-md-5 mx-1 d-flex align-items-center d-flex align-items-center"
                                id="deliveryInputContainer">
                                <label for="cp">CP: </label>
                                <input type="text" id="cp" placeholder=" " value="S2000" disabled>
                            </div>
                        </div>
                        <div class="btns-container text-center d-flex justify-content-center my-4">
                            <button id="editDeliveryInfo">Editar datos</button>
                            <button id="finishEditingDeliveryInfo" class="gray-btn-black-text">Cerrar</button>
                        </div>
                    </div>
                </div>
                <div class="support text-center">
                    <p>Deseo <a href=""><b>contactar con soporte</b></a></p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="content-panel" id="account">
    <div class="row mt-3">
        <div class="col-12">
            <h3 class="text-center"><?php echo __('Tus datos son:', 'gen-theme-base') ?></h3>
        </div>
    </div>
    <form method="post" class="row">
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for=""><?php echo __('Name', 'gen-theme-base') ?></label>
                <input type="text" class="form-control" name="first_name_account" id="first_name_account" value="<?php echo wp_get_current_user()->first_name ?>" required />
            </div>
            <div class="form-group">
                <label for=""><?php echo __('Last Name', 'gen-theme-base') ?></label>
                <input type="text" class="form-control" name="last_name_account" id="last_name_account" value="<?php echo wp_get_current_user()->last_name ?>" required />
            </div>
            <div class="form-group">
                <label for=""><?php echo __('Country', 'gen-theme-base') ?></label>
                <input type="text" class="form-control" name="country_name" id="country_name" value="<?php echo user_panel_proccess()->get_user_country(wp_get_current_user()->ID) ?>"  />
            </div>
            <div class="form-group">
                <label for=""><?php echo __('State', 'gen-theme-base') ?></label>
                <input type="text" class="form-control" name="state_name" id="state_name" value="<?php echo user_panel_proccess()->get_user_state(wp_get_current_user()->ID) ?>" />
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for=""><?php echo __('Phone', 'gen-theme-base') ?></label>
                <input type="text" class="form-control" name="user_phone" id="user_phone" value="<?php echo user_panel_proccess()->get_user_phone(wp_get_current_user()->ID) ?>"  />
            </div>
            <div class="form-group">
                <label for=""><?php echo __('Email', 'gen-theme-base') ?></label>
                <input type="email" disabled class="form-control" name="user_email_account" id="user_email_account" value="<?php echo wp_get_current_user()->user_email ?>" />
                <p class="small"><?php echo __('The email can\'t be change', 'gen-theme-base') ?></p>
            </div>
            <div class="form-group">
                <label for=""><?php echo __('Password', 'gen-theme-base') ?></label>
                <input type="text" class="form-control" name="user_password" id="user_password" value="" />
                <p class="small"><?php echo __('Leave blank to not change', 'gen-theme-base') ?></p>
            </div>
            <input type="hidden" name="user_id" value="<?php echo wp_get_current_user()->ID ?>">
        </div>
        <div class="col-12 text-center">
            <input type="submit" name="update_profile" name="update_profile" class="btn btn-primary" value="<?php echo __('Update data', 'user-update') ?>">
        </div>
    </form>
    <?php do_action('account_extra_content')?>
</div>