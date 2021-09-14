function Form(){
    this.id = 0;
    this.title = gf_vars.formTitle;
    this.description = gf_vars.formDescription;
    this.labelPlacement = "top_label";
    this.subLabelPlacement = "below";
    this.maxEntriesMessage = "";
    this.confirmation = new Confirmation();
    this.button = new Button();
    this.fields = new Array();
}

function Confirmation(){
    this.type = "message";
    this.message = gf_vars.formConfirmationMessage;
    this.url = "";
    this.pageId = "";
    this.queryString="";
}

function Button(){
    this.type = "text";
    this.text = gf_vars.buttonText;
    this.imageUrl = "";
}

function Field(id, type){
    this.id = id;
    this.formId = window.form.id;
    this.label = "";
    this.adminLabel = "";
    this.type = type;
    this.isRequired = false;
    this.size = "large";
    this.errorMessage = "";
    this.visibility = "visible";
    //NOTE: other properties will be added dynamically using associative array syntax
}

function Choice(text, value, price){
    this.text=text;
    this.value = value ? value : text;
    this.isSelected = false;
    this.price = price ? price : "";
}

/**
 * Create a form Input object.
 *
 * @since unknown
 * @since 2.5
 *
 * @param {string|int} id                      The input ID.
 * @param {string}     label                   The input label.
 * @param {string}     [autocompleteAttribute] The autocomplete attribute value.
 */
function Input( id, label, autocompleteAttribute ) {
    this.id = id;
    this.label = label;
    this.name = "";

    if ( typeof autocompleteAttribute !== "undefined" ) {
        this.autocompleteAttribute = autocompleteAttribute;
    }
}

function ConditionalLogic(){
    this.actionType = "show"; //show or hide
    this.logicType = "all"; //any or all
    this.rules = [new ConditionalRule()];
}

function ConditionalRule(){
    this.fieldId = 0;
    this.operator = "is"; //is or isnot
    this.value = "";
}

