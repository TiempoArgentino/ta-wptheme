/** Forms manager **/
const rbFormsManager = {
    initialize: function(){
        if( typeof this.isInitialized === "function" && this.isInitialized() )
            return;
        var forms = {};
        this.isInitialized = () => {return true;};
        this.newForm = (id, $form) => {
            if(forms[id])
                return false;
            forms[id] = new RB_Form_Validator($form);
            return forms[id];
        };
        this.formIsValid = (id) => {return forms[id].isValid;};
        this.updateForm = (id) => {return forms[id].updateStatus();};
    }
}
rbFormsManager.initialize();
Object.freeze(rbFormsManager);

// =========================================================================
// RB_Field_Validator
// =========================================================================
class RB_Field_Validator{
    options = {
        stopOnFirstError: true, //Wheter to continue checking for errors after one had been found
        checkEmpty: true, //Check if the value is ''
        emptyMessage: 'Es obligatorio completar este campo', //Error message for empty case
        updateOn: 'input',//Update the validator when this events runs on the $field
    };

    /**
    *   @param jQuery $field              jQuery object of the form
    *   @param Array settings            Array of options to overwrite the defaults
    */
    constructor($field, settings){
        this.$field = $field;
        this.checks = [];
        this.isValid = false;
        this.lastError = '';
        this.options = typeof settings === 'object' ? Object.assign({}, this.options, settings) : this.options;
        this.attachEvents();
        return this;
    }

    //Attach the events of 'updateOn' to the $field. Runs updateStatus when the events fire
    attachEvents(){
        var updateOn = this.getOption('updateOn');
        if( typeof updateOn != 'string' )
            return false;
        var validator = this;
        this.$field.on(updateOn, function(){
            validator.updateStatus();
        });
    }

    //Adds an error check with an error message. {check: function(value,this), message: ''}
    addCheck(checkData){
        if(checkData.hasOwnProperty('check') && typeof checkData.check === 'function' && checkData.hasOwnProperty('message'))
            this.checks.push(checkData);
        return this;
    }

    //Goes to every check added and sets de validity of the field accordingly
    updateStatus(){
        var value = this.$field.val();
        var result = true;
        var validator = this;

        if(this.getOption('checkEmpty') && value == ''){
            result = false;
            validator.lastError = this.getOption('emptyMessage');
        }
        if( result || this.getOption('stopOnFirstError') ){
            for(let i = 0; i < this.checks.length; i++){
                let checkData = this.checks[i];
                let hasError = checkData.check(value, validator);
                if(result && hasError){
                    result = false;
                    validator.lastError = checkData.message;
                    if(this.getOption('stopOnFirstError'))
                        break;
                }
            }
        }
        this.isValid = result;
        this.afterUpdate();
    }

    //Runs the onUpdate function, if it exists
    afterUpdate(){
        var afterUpdateFunction = this.getOption('onUpdate');
        if(typeof afterUpdateFunction === 'function')
            afterUpdateFunction(this);
    }

    //Checks every native validations from field.validity
    //Returns the code of the firt one it encounters
    getNativeError(){
        var validity = this.$field[0].validity;
        var errorCode = '';
        if(validity.valid)
            return errorCode;
        for(var error in validity){
            if(error){
                errorCode = error;
                break;
            }
        }
        return errorCode;
    }

    //Returns an options from this.options
    getOption(name){
        return this.options[name];
    }
}

// =========================================================================
// RB_Form_Validator
// =========================================================================
class RB_Form_Validator{

    constructor($form){
        if(!$form || !$form.length)
            return;

        this.$form = $form;
        this.fields = [];
        this.isValid = false;
        this.stopOnFirstError = false;
        return this;
    }

    updateStatus(){
        var result = true;
        for(let i = 0; i < this.fields.length; i++){
            let fieldValidator = this.fields[i];
            fieldValidator.updateStatus();
            if(!fieldValidator.isValid){
                result = false;
                if(this.stopOnFirstError)
                    break;
            }
        }
        this.isValid = result;
    }

    addField(field){
        //console.log(this);
        if(field instanceof RB_Field_Validator)
            this.fields.push(field);
        return this;
    }

}
