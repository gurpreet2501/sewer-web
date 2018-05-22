

 Vue.component('agdropdown', {
  props: ['value','class','input_class', 'read_only','name','options','id','hidden_field_name','next_field_id','next_field_class'],
  template: '<div class="form-group form-inline ag_main_drop_down mousetrap">'+
                '<input type="text" v-bind:class="input__class" autocomplete="off" v-model="option_name" v-bind:name="this.name"  v-on:keyup="_option_name" v-bind:readonly="read_only">'+
                '<input type="hidden" v-bind:name="this.hidden_field_name" class="set_hidden_id" >'+
                '<ul class="ag-dropdown-menu list-group">'+ 
                    '<li v-on:click="selectedOptionVal(option.id)" v-model="list_item" class="list-group-item" v-for="option in this.filterOptions" v-bind:value="option.id">'+
                      '<a href="javascript:void(0);">{{option.name}}</a>'+
                    '</li>'+
                 '</ul>'+
            '</div>',

  mounted: function () {
    var vm = this;
    var dropdown = $(vm.$el).find('.ag-dropdown-menu');
    var dropdownItem = $(vm.$el).find('.ag-dropdown-menu li');

    dropdown.hide();

    this.setInputBoxValueOnLoad();

    var inputBox = $(this.$el).find('.ag-drop-down');

    var dropdown = $(vm.$el).find('.ag-dropdown-menu');
      
    inputBox.focus(function(){
      dropdown.show();
      dropdown.addClass('dropdown-open');
    }); //input box

    inputBox.blur(function(){

        setTimeout(function(){

          var d = 0;  
          
          if($('.ag-dropdown-menu a:focus')[0] == undefined){
            dropdown.hide();
            return;
          }

          var d = $('.ag-dropdown-menu a:focus')[0].text;
                         

         },100);

        var hiddenField = $(this.$el).find('.set_hidden_id');
        var valid = vm.checkIfValid($(this).val());
        if(!valid){
          $(this).val(null);
          hiddenField.val(0);
        }
    });

  },

  data:function(){
    return {
      list_item:'',
      filterOptions: jQuery.extend([], this.options), // Creating clone of original Options
      option_name:'',
      selected_acc:'',
      input__class:'ag-drop-down form-control '+this.input_class
    }
  },

  methods: {

    checkIfValid:function(text){
      var id=0;
      var hiddenField = $(this.$el).find('.set_hidden_id');
      id = hiddenField.val();

      var party_name = '';

      $(this.filterOptions).each(function(key, val){
            if(text == val.name && id==val.id)
              return true;
      });

      return false;
    },

    selectedOptionVal:function(selected_item_id){
        
        var vm = this;
        var nextFieldId = this.next_field_id;
        // var nextFieldClass = this.next_field_class;
        var dropdown = $(vm.$el).find('.ag-dropdown-menu');
        var option_name = this.getAccountName(selected_item_id);

        //Set value to input box
        this.option_name = option_name; 
        vm.set_field_val(selected_item_id, option_name);

        dropdown.hide();
        dropdown.removeClass('dropdown-open');

        if(nextFieldId)
          $('#'+nextFieldId).focus();

        // if(nextFieldClass)
        //   $(this).next().focus();

        vm.$emit('input', selected_item_id);
        
    },

    getAccountName: function(id){
          var party_name = '';

          $(this.filterOptions).each(function(key,val){
                if(id == val.id)
                 party_name = val.name;
          });

          return party_name;
    },

    setInputBoxValueOnLoad:function(){
      var vm = this;
      var option_name = this.getAccountName(this.value);
      this.option_name = option_name; 
      vm.set_field_val(this.value, option_name);
    },

    _option_name:function(){
       // console.log(this.option_name)
      this.filterPartyList(this.option_name)
    },

    set_field_val: function(id, val){
      var inputbox = $(this.$el).find('.ag-drop-down');
      var hiddenField = $(this.$el).find('.set_hidden_id');
      inputbox.val(val);
      hiddenField.val(id);
    },

    filterPartyList: function(option_name){
      
      var filtered = [];
      $(this.options).each(function(key,val){
          var currentObj = this; 
          var originalString = val.name.toLowerCase();
          var _name = option_name.toLowerCase()
          var result = originalString.search(_name); 
           if(result  >= 0)
             filtered.push(currentObj);
      });

      if(!option_name.length == 0)
        this.filterOptions = jQuery.extend([], filtered);
      else
        this.filterOptions = jQuery.extend([], this.options);
    }
    
  },
  watch: {
  value: function (value) {
      // update value
      console.log('value in agdropdown:'+value);
      this.selectedOptionVal(value);
    },
  options: function (value) {
      // update value
      console.log('options updated:');
      console.log(value);
      this.filterOptions = jQuery.extend([], value);
    },
  input_class: function (value) {
      // update value
      console.log('class_updated:');
      console.log(value);
    },

  },
  destroyed: function () {
    // $(this.$el).off().datepicker('destroy');
  }
})
