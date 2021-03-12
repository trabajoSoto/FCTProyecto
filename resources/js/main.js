jQuery(document).ready(function($) {
	var day = null;
  var date = null;


	$('#calendar').fullCalendar({
      defaultView: 'agendaWeek',
      locale: 'es',
      events:{
         url: '/api.php',
         type: 'POST',
         data: {
            action: 'get-bookings'
         },
         error: function() {
            alert('there was an error while fetching events!');
         },
         color: '$background',   // a non-ajax option
         textColor: '$letter' // a non-ajax option
      },
     
      header: {
         left: 'prev,next today',
         center: 'title',
         right: 'agendaWeek,month'
      },

      eventRender: function(event, element, view) { 
        //element.find('.fc-title').append("<br/>" + event.lieu);
        //element.find('.fc-instalaciones').append("<br/>" + event.lieu); 
          return ['all', event.conferencier].indexOf($('#filter-conferencier').val()) >= 0;
      },

      dayClick: function(date, jsEvent, view) {
        day = date.format("YYYY-MM-DD HH:mm:ss");
//        instalaciones = ('calendario()');

        $('#modal-insert-time').modal('show');
   	  }
   });

  $('#modal-insert-time form').on( 'change', '.select-instalacion', function(){

    $.ajax({
      url: '/api.php',
      type: "POST",
      dataType: "json",
      data: { 
        action: 'get-bookings',

        day: day,
        instalacion: $(this).val(),
        usuario:[Nombre_Usuario],
      },
      success: function(){

      },
      error: function(){

      },
    }); 

  });
});




 