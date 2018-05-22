Vue.component('datepicker', {
  props: ['value','class','name','tabnext'],
  template: '<input type="text" v-bind:name="name" />',
  mounted: function () {
    var vm = this;
    var nextElement = this.tabnext;

    $(this.$el).datepicker({ dateFormat: 'yy-mm-dd',
      onClose : function() {
         $('#'+nextElement).focus();
    }});

    $(this.$el).addClass(this.class);
    $(this.$el).val(this.value);
    $(this.$el).change(function(){
    	vm.$emit('input',this.value);
    });
  },

  data:function(){
  	return {
  		name: this.name,
  		class: this.class
  	}
  },

  methods: {

  },
  watch: {
  },
  destroyed: function () {
    $(this.$el).off().datepicker('destroy');
  }
})
