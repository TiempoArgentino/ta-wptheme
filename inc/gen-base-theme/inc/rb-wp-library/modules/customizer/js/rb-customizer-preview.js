( function( $ ) {
    //Customizer settings => rbCustomizer.settings
    //WP Url => rbCustomizer.templateUrl

    class RB_FrontendSetting{
        constructor(rbBackendSetting){
            this.backendData = rbBackendSetting;
            var selectiveRefresh = this.selectiveRefreshData();

            if(typeof selectiveRefresh.selector === 'string' && !selectiveRefresh.has_user_callback){
                this.frontEdition = {
                    currentValue: '',
                    editionIcons: [],
                };
                this.makeEditable();
            }
        }

        //Returns the real backend setting id
        getID(){
            return this.backendData.id;
        }

        //Returns the backend selective refresh information
        selectiveRefreshData(){
            return this.backendData.selective_refresh;
        }

        //Checks if there is a user defined function to run when the setting changes
        //at selective refresh
        hasUserCallback(){
            let selectiveRefresh = this.selectiveRefreshData();
            return selectiveRefresh ? selectiveRefresh.has_user_callback : false;
        }

        //Gets the elements that changes with the control value
        getSelectiveRefreshElements(){
            let selectiveRefresh = this.selectiveRefreshData();
            return selectiveRefresh ? $(selectiveRefresh.selector) : null;
        }

        //Get the edition icon for all the elements this setting is related
        getAllEditionIcons(){
            return this.frontEdition.editionIcons;
        }

        //Pushes into the edition icons array a new icon information
        addEditionIcon(iconInfo){
            this.frontEdition.editionIcons.push(iconInfo);
        }

        //Moves an edition icon outside of the element to wich it is related
        moveEditionIconOut(iconInfo){
            iconInfo.$image.css({left: `auto`, top: `auto`});
            let elementLeft = iconInfo.$element.offset().left;
            let elementTop = iconInfo.$element.offset().top;
            iconInfo.$image.css({left: `${elementLeft - 32}px`, top: `${elementTop - 11}px`,});
            iconInfo.$image.appendTo("#rb-customizer-edition-icons");
        }

        //Moves an edition icon inside the element to wich it is related
        moveEditionIconInside(iconInfo){
            iconInfo.$image.css({left: `auto`, top: `auto`,});
            iconInfo.$image.prependTo(iconInfo.$element);
        }

        //Moves all the setting icons inside their element
        moveAllIconsInside(){
            var thisFrontendSetting = this;
            this.getAllEditionIcons().forEach((iconInfo) => {thisFrontendSetting.moveEditionIconInside(iconInfo);});
        }

        //Returns the current frontend value
        getValue(){
            return this.frontEdition.currentValue;
        }

        //Sets the current frontend value
        setValue(value){
            this.frontEdition.currentValue = value;
        }

        managePasteOnEditableElement(event){
            // Stop data actually being pasted into div
            const originalEvent = event.originalEvent;
            event.stopPropagation();
            event.preventDefault();

            // Get pasted data via clipboard API
            const clipboardData = originalEvent.clipboardData || window.clipboardData;
            const pastedData = clipboardData ? clipboardData.getData('text/plain') : '';
            document.execCommand('insertHTML', false, pastedData);
        }

        makeEditable(){
            var $elements = this.getSelectiveRefreshElements();
            if(!$elements)
                return false;
            var thisFrontendSetting = this;

            // =================================================================
            // MAKE SELECTIVE REFRESH ELEMENTS EDITABLE
            // =================================================================
            $elements.attr('contenteditable', '');
            $elements.on('paste', this.managePasteOnEditableElement);
            $elements.addClass('rb-customizer-editable-element');
            $elements.on('click', function(event){
                if(!event.ctrlKey)
                    return;
                event.preventDefault();
                event.stopPropagation();
            });

            // =============================================================
            // START EDITION
            // =============================================================
            $elements.on('focus', function(){
                //Move edition icon outside, so it wont be taken as part of the value
                thisFrontendSetting.getAllEditionIcons().forEach((iconInfo) => {thisFrontendSetting.moveEditionIconOut(iconInfo);});
                //Set current value
                thisFrontendSetting.setValue($(this).html());
                //console.log('focus', setting);
            });

            // =============================================================
            // EDITING
            // =============================================================
            $elements.on('input', function(){
                let currentElementText = $(this).html();
                //Change html in the other elements
                $elements.not(this).html(currentElementText);
                //console.log('input', setting);
            });

            // =============================================================
            // STAGE CHANGES
            // =============================================================
            $elements.on('blur', function(){
                let currentElementText = $(this).html();
                //Move icon back inside the elements
                thisFrontendSetting.getAllEditionIcons().forEach((iconInfo) => {thisFrontendSetting.moveEditionIconInside(iconInfo);});
                //Check for difference between old value and new
                //console.log(currentElementText,setting.frontEdition.currentValue);
                if( currentElementText != thisFrontendSetting.getValue() ){
                    thisFrontendSetting.setValue(currentElementText);
                    rbFrontendEditor.stageChange(thisFrontendSetting);//Stages the change to be commited
                    //updateSetting(setting);
                }
                //console.log('blur', setting);
            });

            // =============================================================================
            // EDITIONS ICONS SETUP
            // =============================================================================
            $(window).resize(() => {thisFrontendSetting.moveAllIconsInside();});

            $(document).ready(() => {
                RB_FrontendSetting.addAllSettingEditionIcons(this);
                thisFrontendSetting.moveAllIconsInside();}
            );
        }

        // =====================================================================
        // STATIC
        // =====================================================================
        static editorImageElements = [];

        static addAllSettingEditionIcons(rbFrontendSetting){
            var $elements = rbFrontendSetting.getSelectiveRefreshElements();
            if($elements && $('#rb-customizer-edition-icons').length){//If the container of icons exists
                $elements.each(function(){
                    let iconInfo = {
                        $image: $(`<img data-index="${RB_FrontendSetting.editorImageElements.length}" class="rb-customizer-edition-image" src="${rbCustomizer.assetsUrl}/img/edit--v1.png"/>`),
                        $element: $(this),
                    };
                    RB_FrontendSetting.editorImageElements.push(iconInfo);
                    rbFrontendSetting.addEditionIcon(iconInfo);
                    iconInfo.$image.appendTo("#rb-customizer-edition-icons");
                    //Link click in icon to element edition
                    iconInfo.$image.click(function(event){
                        event.stopPropagation();
                        event.preventDefault();
                        setTimeout(function() {
                            iconInfo.$element.focus();
                        }, 100);
                    });
                });
            }
        }
    }

    var editionHelpersManager = {
        setHelpers: function(){
            $("[rb-customization-helper]").each(function(){
                let $helper = $(rbCustomizer.helperPanel);
                $helper.insertBefore($(this));
            });
        },
        getPanel: ($elem) => {return $elem.length ? $elem.closest('.rb-customization-helper-placeholder') : null},
        getRelatedElement: ($panel) => {return $panel.length ? $panel.next('[rb-customization-helper]') : null},
        getCloseButton: ($panel) => {return $panel.length ? $panel.find('.toggle-controls .close-helper') : null},
        getOpenButton: ($panel) => {return $panel.length ? $panel.find('.toggle-controls .open-helper') : null},
        closeRelatedElement: function($panel){
            if(!$panel.length || $panel.hasClass('closed'))
                return;
            var $relatedElement = editionHelpersManager.getRelatedElement($panel);
            $relatedElement ? $relatedElement.stop().slideUp() : false;
            $panel.addClass('closed');
            editionHelpersManager.getCloseButton($panel).stop().fadeOut();
        },
        openRelatedElement: function($panel){
            if(!$panel.length || !$panel.hasClass('closed'))
                return;
            var $relatedElement = editionHelpersManager.getRelatedElement($panel);
            $relatedElement ? $relatedElement.stop().slideDown() : false;
            $panel.removeClass('closed');
            editionHelpersManager.getCloseButton($panel).stop().fadeIn();
        },
        initialize: function(){
            $(document).on('click', '.rb-customization-helper-placeholder .close-helper', function(){
                editionHelpersManager.closeRelatedElement(editionHelpersManager.getPanel($(this)));
            });
            $(document).on('click', '.rb-customization-helper-placeholder .open-helper', function(){
                editionHelpersManager.openRelatedElement(editionHelpersManager.getPanel($(this)));
            });
        },
    };

    var rbFrontendEditor = {
        status: {
            saving: false,//Saving status
        },
        isSaving: () => {return rbFrontendEditor.status.saving;},
        editorImageElements: [],
        settings: [],
        //Changes to save
        stagedChanges: {},
        //Amount of changes staged to save
        stagedChangesAmount: () => {return Object.keys(rbFrontendEditor.stagedChanges).length;},
        updateMarkup: function(){
            //console.log($('#rb-customizer-save-container'));
            if(this.stagedChangesAmount())
                $('#rb-customizer-save-container').fadeIn();
            else
                $('#rb-customizer-save-container').fadeOut();

            if(this.isSaving())
                $('#rb-customizer-save-container').addClass('saving');
            else
                $('#rb-customizer-save-container').removeClass('saving');
        },
        setSavingStatus: function(status){
            this.status.saving = status;
            this.updateMarkup();
        },
        //Saves a setting in stagedChanges for it to be updated later
        stageChange: function(rbFrontendSetting){
            this.stagedChanges[rbFrontendSetting.getID()] = rbFrontendSetting.getValue();
            this.updateMarkup();
            console.log(this.stagedChanges);
        },
        //Saves all settings changed
        saveStagedChanges: function(){
            this.setSavingStatus(true);//start saving
            this.updateSettings(this.stagedChanges)
            .done(function() {
                rbFrontendEditor.stagedChanges = {};
            })
            .fail(function() {
                console.log('error');
            })
            .always(function( msg ){
                rbFrontendEditor.setSavingStatus(false);//End saving
                console.log(msg);
            });
        },
        //REST call to update settings
        updateSettings: function(settings){
            console.log("Updating settings", settings);
            var config = {
                method: 'POST',
                url: rbCustomizer.templateUrl + '/wp-json/rb-customizer/v1/settings/update',
                beforeSend: function ( xhr ) {
                    xhr.setRequestHeader( 'X-WP-Nonce', wpApiSettings.nonce );
                },
                data: {
                    settings: settings
                },
            };
            return $.ajax(config);
        },
        //REST call to update a single setting
        updateSetting: function(rbFrontendSetting){
            console.log("Update", rbFrontendSetting.getID(), rbFrontendSetting.getValue());
            var config = {
                method: 'POST',
                url: rbCustomizer.templateUrl + `/wp-json/rb-customizer/v1/setting/${setting.id}update`,
                beforeSend: function ( xhr ) {
                    xhr.setRequestHeader( 'X-WP-Nonce', wpApiSettings.nonce );
                },
                data: {
                    settingID: rbFrontendSetting.getID(),
                    value: rbFrontendSetting.getValue(),
                },
            };
            $.ajax(config)
            .done(function( msg ) {
                console.log(msg);
            });
        },
        initialize: function(){
            console.log(rbCustomizer);
            $(document).ready(function(){
                //Create RB_FrontendSetting out of the data from the backend
                for(let i = 0; i < rbCustomizer.settings.length; i++){
                    rbFrontendEditor.settings.push(new RB_FrontendSetting(rbCustomizer.settings[i]));
                }

                $('#rb-customizer-settings-save-button').click(function(){
                    if(!rbFrontendEditor.isSaving())
                        rbFrontendEditor.saveStagedChanges();
                });

                editionHelpersManager.setHelpers();
                editionHelpersManager.initialize();
                $( ".rb-customization-helper-panel" ).draggable({
                    handle: '.draggable-handle',
                    delay: 0,
                });
            });

            // =========================================================================
            // BEFORE EXIT
            // =========================================================================
            window.onbeforeunload = function (e) {
                if(!rbFrontendEditor.stagedChangesAmount())
                    return;
                var message = "All unsaved content will be lost. Continue?",
                e = e || window.event;
                // For IE and Firefox
                if (e) {
                    e.returnValue = message;
                }
                // For Safari
                return message;
            };
        }
    };


    rbFrontendEditor.initialize();

} )( jQuery );
