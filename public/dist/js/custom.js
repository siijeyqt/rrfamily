(function($){

    "use strict";

    $(".inputtags").tagsinput('items');

    $(document).ready(function() {
        $('#example1').DataTable();
    });

    $('.icp_demo').iconpicker();

    $(document).ready(function() {
        $('.snote').summernote();
    });

    $('.datepicker').datepicker({ 
        autoclose:true,
        format: "mm/dd/yyyy" 
    });
    
    $('.timepicker').timepicker({
        icons:
        {
            up: 'fa fa-angle-up',
            down: 'fa fa-angle-down'
        }
    });

    $('.datepicker2').datepicker({
        autoclose:true,
        format: "mm-yyyy",
        startView: "months", 
        minViewMode: "months"
    });
    

})(jQuery);
